<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request; // <-- THIS IS MISSING!
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,customer,manager',
            'status' => 'required|in:active,inactive'
        ]);

        // Hash the password
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        // Return JSON for API requests
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'data' => $user
            ], 201);
        }

        // Return view for web requests
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Check if user exists
        if (!$user) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            return redirect()->route('admin.users.index')
                ->with('error', 'User not found');
        }

        // Load relationships
        $user->load(['orders', 'wishlist']);

        // Return JSON for API requests
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        }

        // Return view for web requests
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'sometimes|in:admin,customer,manager',
            'status' => 'sometimes|in:active,inactive',
            'password' => 'nullable|min:8|confirmed'
        ]);

        // Remove password if not provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User updated successfully',
                'data' => $user
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(Request $request, User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete your own account'
                ], 403);
            }
            return back()->with('error', 'Cannot delete your own account');
        }

        $user->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user status.
     */
    public function toggleStatus(Request $request, User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User status updated successfully',
                'data' => $user
            ]);
        }

        return back()->with('success', 'User status updated!');
    }

    /**
     * Reset user password.
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed'
        ]);

        $user->password = bcrypt($request->password);
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully'
            ]);
        }

        return back()->with('success', 'Password reset successfully!');
    }

    /**
     * Assign role to user.
     */
    public function assignRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,customer,manager'
        ]);

        $user->role = $request->role;
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role assigned successfully',
                'data' => $user
            ]);
        }

        return back()->with('success', 'Role assigned successfully!');
    }

    /**
     * Block user.
     */
    public function block(Request $request, User $user)
    {
        $user->status = 'inactive';
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User blocked successfully'
            ]);
        }

        return back()->with('success', 'User blocked successfully!');
    }

    /**
     * Unblock user.
     */
    public function unblock(Request $request, User $user)
    {
        $user->status = 'active';
        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User unblocked successfully'
            ]);
        }

        return back()->with('success', 'User unblocked successfully!');
    }

    /**
     * Export users.
     */
    public function export(Request $request)
    {
        // You can implement CSV/Excel export here
        return response()->json([
            'message' => 'Export functionality'
        ]);
    }

    /**
     * Bulk delete users.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ]);

        // Prevent deleting yourself
        $ids = array_filter($request->ids, function($id) {
            return $id !== auth()->id();
        });

        User::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($ids) . ' users deleted successfully'
        ]);
    }
}
@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h4 mb-3">{{ $user->name }}</h1>
        <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
        <p class="mb-1"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p class="mb-1"><strong>Phone:</strong> {{ $user->phone ?? '-' }}</p>
        <p class="mb-0"><strong>Address:</strong> {{ $user->address ?? '-' }}</p>
    </div>
</div>
@endsection

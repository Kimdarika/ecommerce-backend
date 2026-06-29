@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
<div class="categories-page">
    <!-- Page Header -->
     <div class="bg-elements">
        <span class="bg-element">🌸</span>
        <span class="bg-element">🌷</span>
        <span class="bg-element">✨</span>
        <span class="bg-element">🌺</span>
        <span class="bg-element">💫</span>
        <span class="bg-element">🦋</span>
        <span class="bg-element">🌹</span>
        <span class="bg-element">💖</span>
        <span class="bg-element">🌟</span>
        <span class="bg-element">🌷</span>
        <span class="bg-element">🌻</span>
        <span class="bg-element">💎</span>
        <span class="bg-element">🌈</span>
        <span class="bg-element">🪷</span>
        <span class="bg-element">🌿</span>
        <span class="bg-element">🌸</span>
        <span class="bg-element">🌷</span>
        <span class="bg-element">✨</span>
        <span class="bg-element">🌺</span>
        <span class="bg-element">💫</span>
      </div>
    <div class="page-header">
        <div>
            <span class="section-tag">Management</span>
            <h2 class="section-title">
                <i class="fas fa-tags section-title-icon"></i> Categories
            </h2>
            <p class="section-subtitle">Manage product categories for your store</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i> Add Category
            <span class="btn-arrow">→</span>
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
        </div>
    @endif

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-header-left">
                <span class="table-count">Total: {{ $categories->total() }} categories</span>
            </div>
            <div class="table-header-right">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="tableSearch" class="search-input" placeholder="Search categories...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="custom-table" id="categoriesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr>
                        <td>
                            <span class="category-id">#{{ $category->id }}</span>
                        </td>
                        <td>
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="category-image">
                            @else
                                <div class="category-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="category-name">{{ $category->name }}</span>
                        </td>
                        <td>
                            <span class="category-slug">{{ $category->slug }}</span>
                        </td>
                        <td>
                            <span class="product-count">{{ $category->products_count ?? 0 }}</span>
                        </td>
                        <td>
                            <div class="date-info">
                                {{ $category->created_at->format('M d, Y') }}
                                <small class="date-time">{{ $category->created_at->format('h:i A') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn-action btn-edit" 
                                   title="Edit Category">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this category? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Delete Category">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">📁</div>
                                <h4>No categories found</h4>
                                <p class="empty-text">Start by creating your first category</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn-primary">
                                    <i class="fas fa-plus"></i> Add Category
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="table-footer">
            <div class="pagination-wrapper">
                {{ $categories->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .bg-elements {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}

.bg-element {
  position: absolute;
  font-size: 3rem;
  animation: floatBg 15s ease-in-out infinite;
  opacity: 0.06;
}

/* 20 Unique Positioned Elements */
.bg-element:nth-child(1) { 
  top: 3%; 
  left: 5%; 
  animation-delay: 0s; 
}

.bg-element:nth-child(2) { 
  top: 8%; 
  right: 8%; 
  animation-delay: 1.5s; 
  font-size: 3.5rem; 
}

.bg-element:nth-child(3) { 
  top: 15%; 
  left: 15%; 
  animation-delay: 3s; 
  font-size: 2.5rem; 
}

.bg-element:nth-child(4) { 
  top: 20%; 
  right: 20%; 
  animation-delay: 4.5s; 
  font-size: 4rem; 
}

.bg-element:nth-child(5) { 
  top: 30%; 
  left: 3%; 
  animation-delay: 6s; 
  font-size: 2.8rem; 
}

.bg-element:nth-child(6) { 
  top: 35%; 
  right: 3%; 
  animation-delay: 7.5s; 
  font-size: 3.2rem; 
}

.bg-element:nth-child(7) { 
  top: 45%; 
  left: 12%; 
  animation-delay: 9s; 
  font-size: 2.2rem; 
}

.bg-element:nth-child(8) { 
  top: 50%; 
  right: 12%; 
  animation-delay: 10.5s; 
  font-size: 3.8rem; 
}

.bg-element:nth-child(9) { 
  top: 58%; 
  left: 4%; 
  animation-delay: 12s; 
  font-size: 2.6rem; 
}

.bg-element:nth-child(10) { 
  top: 62%; 
  right: 4%; 
  animation-delay: 13.5s; 
  font-size: 3rem; 
}

.bg-element:nth-child(11) { 
  top: 70%; 
  left: 18%; 
  animation-delay: 1s; 
  font-size: 2.4rem; 
}

.bg-element:nth-child(12) { 
  top: 75%; 
  right: 18%; 
  animation-delay: 2.5s; 
  font-size: 3.6rem; 
}

.bg-element:nth-child(13) { 
  top: 82%; 
  left: 6%; 
  animation-delay: 4s; 
  font-size: 2.9rem; 
}

.bg-element:nth-child(14) { 
  top: 88%; 
  right: 6%; 
  animation-delay: 5.5s; 
  font-size: 3.3rem; 
}

.bg-element:nth-child(15) { 
  top: 93%; 
  left: 14%; 
  animation-delay: 7s; 
  font-size: 2.7rem; 
}

.bg-element:nth-child(16) { 
  top: 5%; 
  left: 50%; 
  animation-delay: 8.5s; 
  font-size: 2.1rem; 
}

.bg-element:nth-child(17) { 
  top: 25%; 
  right: 50%; 
  animation-delay: 10s; 
  font-size: 3.4rem; 
}

.bg-element:nth-child(18) { 
  top: 48%; 
  left: 50%; 
  animation-delay: 11.5s; 
  font-size: 2.3rem; 
}

.bg-element:nth-child(19) { 
  top: 68%; 
  right: 50%; 
  animation-delay: 13s; 
  font-size: 3.1rem; 
}

.bg-element:nth-child(20) { 
  top: 90%; 
  left: 50%; 
  animation-delay: 14.5s; 
  font-size: 2.5rem; 
}

/* Animation */
@keyframes floatBg {
  0%, 100% { 
    transform: translateY(0px) rotate(0deg) scale(1); 
  }
  25% { 
    transform: translateY(-40px) rotate(5deg) scale(1.1); 
  }
  75% { 
    transform: translateY(40px) rotate(-5deg) scale(0.9); 
  }
}
/* Different animation speeds for each element */
.bg-element:nth-child(1) { animation-duration: 18s; }
.bg-element:nth-child(2) { animation-duration: 14s; }
.bg-element:nth-child(3) { animation-duration: 20s; }
.bg-element:nth-child(4) { animation-duration: 16s; }
.bg-element:nth-child(5) { animation-duration: 22s; }
.bg-element:nth-child(6) { animation-duration: 13s; }
.bg-element:nth-child(7) { animation-duration: 19s; }
.bg-element:nth-child(8) { animation-duration: 17s; }
.bg-element:nth-child(9) { animation-duration: 21s; }
.bg-element:nth-child(10) { animation-duration: 15s; }
.bg-element:nth-child(11) { animation-duration: 23s; }
.bg-element:nth-child(12) { animation-duration: 12s; }
.bg-element:nth-child(13) { animation-duration: 20s; }
.bg-element:nth-child(14) { animation-duration: 18s; }
.bg-element:nth-child(15) { animation-duration: 16s; }
.bg-element:nth-child(16) { animation-duration: 14s; }
.bg-element:nth-child(17) { animation-duration: 22s; }
.bg-element:nth-child(18) { animation-duration: 19s; }
.bg-element:nth-child(19) { animation-duration: 15s; }
.bg-element:nth-child(20) { animation-duration: 17s; }

    /* ============================================
       CATEGORIES PAGE - PROFESSIONAL STYLE
       ============================================ */
    .categories-page {
        padding: 0;
    }

    /* ============================================
       PAGE HEADER
       ============================================ */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 1rem;
        background: linear-gradient(135deg, #fdf6f3 0%, #faf5f0 100%);
        padding: 24px 28px;
        border-radius: 16px;
        border-left: 4px solid #fd79a8;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '✦';
        position: absolute;
        right: 30px;
        top: -10px;
        font-size: 8rem;
        color: rgba(253, 121, 168, 0.05);
        font-family: Georgia, serif;
    }

    .section-tag {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #fd79a8;
        background: rgba(253, 121, 168, 0.1);
        padding: 0.2rem 1rem;
        border-radius: 50px;
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .section-title-icon {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-right: 8px;
    }

    .section-subtitle {
        color: #6c7a89;
        font-size: 0.95rem;
        margin: 0.25rem 0 0;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.7rem 2rem;
        background: linear-gradient(135deg, #fd79a8, #e17055);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(253, 121, 168, 0.25);
        cursor: pointer;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(253, 121, 168, 0.35);
        color: white;
    }

    .btn-arrow {
        transition: transform 0.3s ease;
    }

    .btn-primary:hover .btn-arrow {
        transform: translateX(5px);
    }

    /* ============================================
       ALERT MESSAGES
       ============================================ */
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        position: relative;
        animation: slideDown 0.3s ease;
    }

    .alert-success i {
        color: #10b981;
        font-size: 1.2rem;
    }

    .alert-success .btn-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        transition: opacity 0.3s ease;
        padding: 0 4px;
    }

    .alert-success .btn-close:hover {
        opacity: 1;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ============================================
       TABLE CONTAINER
       ============================================ */
    .table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-count {
        font-size: 13px;
        color: #6c7a89;
        font-weight: 500;
    }

    .table-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        color: #9aa5b5;
        font-size: 0.85rem;
    }

    .search-input {
        padding: 8px 16px 8px 38px;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        font-size: 0.85rem;
        background: white;
        transition: all 0.3s ease;
        width: 220px;
        color: #1a1a2e;
        outline: none;
    }

    .search-input:focus {
        border-color: #fd79a8;
        box-shadow: 0 0 0 4px rgba(253, 121, 168, 0.06);
    }

    .search-input::placeholder {
        color: #94a3b8;
    }

    /* ============================================
       CUSTOM TABLE
       ============================================ */
    .custom-table {
        width: 100%;
        margin: 0;
        font-size: 14px;
        border-collapse: collapse;
    }

    .custom-table thead th {
        background: #f8f9fa;
        font-weight: 600;
        color: #6c7a89;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 2px solid #f0f0f0;
    }

    .custom-table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .custom-table tbody tr:hover {
        background: #fafbfc;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Category ID */
    .category-id {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 13px;
    }

    /* Category Image */
    .category-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #f0f0f0;
    }

    .category-image-placeholder {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: #f8f9fa;
        border: 2px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 1.2rem;
    }

    /* Category Name */
    .category-name {
        font-weight: 500;
        color: #1a1a2e;
    }

    /* Category Slug */
    .category-slug {
        font-size: 13px;
        color: #6c7a89;
        background: #f1f3f5;
        padding: 2px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    /* Product Count */
    .product-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 600;
    }

    /* Date Info */
    .date-info {
        display: flex;
        flex-direction: column;
        font-size: 13px;
        color: #1a1a2e;
    }

    .date-time {
        font-size: 11px;
        color: #9aa5b5;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .btn-edit {
        background: rgba(253, 121, 168, 0.1);
        color: #fd79a8;
    }

    .btn-edit:hover {
        background: rgba(253, 121, 168, 0.2);
        transform: translateY(-2px);
        color: #fd79a8;
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.2);
        transform: translateY(-2px);
        color: #ef4444;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 16px;
    }

    .empty-state h4 {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .empty-text {
        color: #6c7a89;
        margin-bottom: 20px;
    }

    /* Table Footer */
    .table-footer {
        padding: 16px 24px;
        background: #fafafa;
        border-top: 1px solid #f0f0f0;
        display: flex;
        justify-content: center;
    }

    .pagination-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pagination-wrapper .pagination {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        border: none;
        border-radius: 8px;
        padding: 6px 14px;
        color: #1a1a2e;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .pagination-wrapper .page-link:hover {
        background: rgba(253, 121, 168, 0.1);
        color: #fd79a8;
    }

    .pagination-wrapper .page-item.active .page-link {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        color: white;
        box-shadow: 0 4px 12px rgba(253, 121, 168, 0.25);
    }

    .pagination-wrapper .page-item.disabled .page-link {
        color: #cbd5e1;
        cursor: not-allowed;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 992px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .table-header {
            flex-direction: column;
            align-items: stretch;
        }

        .table-header-right {
            width: 100%;
        }

        .search-wrapper {
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .custom-table {
            font-size: 13px;
        }

        .custom-table thead th,
        .custom-table tbody td {
            padding: 8px 12px;
        }
    }

    @media (max-width: 480px) {
        .section-title {
            font-size: 1.6rem;
        }

        .btn-primary {
            font-size: 0.85rem;
            padding: 0.6rem 1.5rem;
        }

        .action-buttons {
            gap: 4px;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }

        .category-image {
            width: 40px;
            height: 40px;
        }

        .category-image-placeholder {
            width: 40px;
            height: 40px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#categoriesTable').DataTable({
            order: [[0, 'desc']],
            pageLength: 25,
            responsive: true,
        });

        // Search functionality
        $('#tableSearch').on('keyup', function() {
            $('#categoriesTable').DataTable().search(this.value).draw();
        });
    });
</script>
@endpush
@endsection

@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="create-category-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <span class="section-tag">Category Management</span>
            <h2 class="section-title">
                <i class="fas fa-plus-circle section-title-icon"></i> Create Category
            </h2>
            <p class="section-subtitle">Add a new product category to your store</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Categories
        </a>
    </div>

    <!-- Form Container -->
    <div class="table-container">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-8">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag text-pink"></i> Category Name <span class="text-danger">*</span>
                        </label>
                        <div class="input-wrapper">
                            <input type="text" class="form-input @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="Enter category name" required>
                            <div class="input-focus"></div>
                        </div>
                        @error('name')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Slug -->
                    <div class="mb-3">
                        <label for="slug" class="form-label">
                            <i class="fas fa-link text-pink"></i> Slug
                        </label>
                        <div class="input-wrapper">
                            <input type="text" class="form-input @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}" 
                                   placeholder="auto-generated from name">
                            <div class="input-focus"></div>
                        </div>
                        <small class="text-muted form-hint"><i class="fas fa-info-circle"></i> Leave empty to auto-generate from name</small>
                        @error('slug')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="fas fa-align-left text-pink"></i> Description
                        </label>
                        <div class="input-wrapper">
                            <textarea class="form-textarea @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Describe the category...">{{ old('description') }}</textarea>
                            <div class="input-focus"></div>
                        </div>
                        @error('description')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-4">
                    <!-- Image Upload -->
                    <div class="mb-3">
                        <label for="image" class="form-label">
                            <i class="fas fa-image text-pink"></i> Category Image
                        </label>
                        <div class="upload-wrapper">
                            <div class="upload-area" id="uploadArea">
                                <input type="file" class="upload-input" id="image" name="image" accept="image/*">
                                <div class="upload-content">
                                    <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                    <p class="upload-text">Click or drag to upload</p>
                                    <span class="upload-hint">PNG, JPG, WebP • Max 2MB</span>
                                </div>
                                <div id="imagePreview" class="image-preview" style="display: none;"></div>
                            </div>
                        </div>
                        @error('image')
                            <div class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn-primary-submit">
                    <i class="fas fa-save"></i> Create Category
                    <span class="btn-arrow">→</span>
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary-cancel">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* ============================================
       CREATE CATEGORY PAGE - PROFESSIONAL STYLE
       ============================================ */
    .create-category-page {
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

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.5rem;
        background: white;
        color: #6c7a89;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #fd79a8;
        color: #fd79a8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(253, 121, 168, 0.08);
    }

    /* ============================================
       TABLE CONTAINER
       ============================================ */
    .table-container {
        background: white;
        border-radius: 16px;
        padding: 30px 32px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
    }

    /* ============================================
       FORM LABELS
       ============================================ */
    .form-label {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 6px;
    }

    .text-pink {
        color: #fd79a8;
        font-size: 0.85rem;
    }

    .text-danger {
        color: #ef4444;
    }

    /* ============================================
       INPUT WRAPPER
       ============================================ */
    .input-wrapper {
        position: relative;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #f8fafc;
        color: #1a1a2e;
        position: relative;
        z-index: 1;
        font-family: 'Inter', sans-serif;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        border-color: #fd79a8;
        background: white;
        box-shadow: 0 0 0 4px rgba(253, 121, 168, 0.06);
        transform: translateY(-1px);
    }

    .form-input:focus + .input-focus,
    .form-textarea:focus + .input-focus {
        transform: scaleX(1);
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .input-focus {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, #fd79a8, #e17055);
        transform: scaleX(0);
        transition: transform 0.3s ease;
        border-radius: 0 0 10px 10px;
        z-index: 2;
    }

    .form-input.is-invalid,
    .form-textarea.is-invalid {
        border-color: #ef4444;
    }

    .form-hint {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-hint i {
        color: #fd79a8;
        font-size: 0.7rem;
    }

    .error-message {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ============================================
       UPLOAD AREA
       ============================================ */
    .upload-wrapper {
        position: relative;
    }

    .upload-area {
        border: 2px dashed #e2e8f0;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #fafbfc;
        cursor: pointer;
        position: relative;
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-area:hover {
        border-color: #fd79a8;
        background: #f8fafc;
    }

    .upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .upload-content {
        pointer-events: none;
        z-index: 1;
    }

    .upload-icon {
        font-size: 3rem;
        color: #fd79a8;
        margin-bottom: 12px;
        display: block;
    }

    .upload-text {
        font-size: 0.95rem;
        color: #1a1a2e;
        font-weight: 500;
        margin: 0 0 4px;
    }

    .upload-hint {
        font-size: 0.75rem;
        color: #94a3b8;
    }

    .image-preview {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
        background: white;
        border-radius: 12px;
        z-index: 3;
    }

    .image-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        border-radius: 8px;
    }

    /* ============================================
       FORM ACTIONS
       ============================================ */
    .form-actions {
        display: flex;
        gap: 12px;
        margin-top: 8px;
        flex-wrap: wrap;
    }

    .btn-primary-submit {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 2rem;
        background: linear-gradient(135deg, #fd79a8, #e17055);
        color: white;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(253, 121, 168, 0.25);
        cursor: pointer;
    }

    .btn-primary-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(253, 121, 168, 0.35);
    }

    .btn-arrow {
        transition: transform 0.3s ease;
    }

    .btn-primary-submit:hover .btn-arrow {
        transform: translateX(5px);
    }

    .btn-secondary-cancel {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 2rem;
        background: transparent;
        color: #6c7a89;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-secondary-cancel:hover {
        border-color: #ef4444;
        color: #ef4444;
        transform: translateY(-2px);
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 992px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .table-container {
            padding: 20px 16px;
        }

        .section-title {
            font-size: 1.6rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary-submit,
        .btn-secondary-cancel {
            width: 100%;
            justify-content: center;
        }

        .upload-area {
            min-height: 140px;
            padding: 20px;
        }

        .upload-icon {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 480px) {
        .section-title {
            font-size: 1.3rem;
        }

        .section-tag {
            font-size: 0.65rem;
        }

        .table-container {
            padding: 16px 12px;
        }

        .form-input,
        .form-textarea {
            padding: 0.6rem 0.8rem;
            font-size: 0.85rem;
        }

        .upload-area {
            min-height: 120px;
            padding: 16px;
        }

        .upload-icon {
            font-size: 2rem;
        }

        .btn-primary-submit,
        .btn-secondary-cancel {
            font-size: 0.85rem;
            padding: 0.6rem 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-generate slug from name
    document.getElementById('name').addEventListener('keyup', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.dataset.auto === 'true') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/^-+|-+$/g, '');
            slugInput.value = slug;
            slugInput.dataset.auto = 'true';
        }
    });

    document.getElementById('slug').addEventListener('input', function() {
        this.dataset.auto = this.value ? 'false' : 'true';
    });

    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        const uploadContent = document.querySelector('.upload-content');
        const uploadArea = document.getElementById('uploadArea');

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Category Image">`;
                preview.style.display = 'flex';
                uploadContent.style.display = 'none';
                uploadArea.style.borderColor = '#10b981';
                uploadArea.style.background = 'rgba(16, 185, 129, 0.04)';
            }
            reader.readAsDataURL(e.target.files[0]);
        } else {
            preview.style.display = 'none';
            uploadContent.style.display = 'block';
            uploadArea.style.borderColor = '#e2e8f0';
            uploadArea.style.background = '#fafbfc';
        }
    });

    // Drag and drop
    const uploadArea = document.getElementById('uploadArea');

    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const input = document.getElementById('image');
        input.files = e.dataTransfer.files;
        input.dispatchEvent(new Event('change'));
    });
</script>
@endpush
@endsection
@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">Edit Category</h6>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('dashboard.categories.update', $category) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="name_ar" class="form-label">Category Name (Arabic) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                        id="name_ar" name="name_ar" value="{{ old('name_ar', $category->name_ar) }}"
                                        required>
                                    @error('name_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="name_en" class="form-label">Category Name (English)</label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" name="name_en" value="{{ old('name_en', $category->name_en) }}">
                                    @error('name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                                        placeholder="Auto-generated if left empty">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="is_active" class="form-label">Status</label>
                                    <div class="checkbox-theme-default custom-checkbox">
                                        <input class="checkbox" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                        <label for="is_active">
                                            <span class="checkbox-text">Active</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="description_ar" class="form-label">Description (Arabic)</label>
                                    <textarea class="form-control @error('description_ar') is-invalid @enderror"
                                        id="description_ar" name="description_ar" rows="4">{{ old('description_ar', $category->description_ar) }}</textarea>
                                    @error('description_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="description_en" class="form-label">Description (English)</label>
                                    <textarea class="form-control @error('description_en') is-invalid @enderror"
                                        id="description_en" name="description_en" rows="4">{{ old('description_en', $category->description_en) }}</textarea>
                                    @error('description_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="image" class="form-label">Category Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*" onchange="previewImage(this)">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Max size: 2MB. Allowed: jpeg, png, jpg, gif</small>
                                    <div class="mt-2">
                                        <img id="imagePreview" src="{{ $category->image }}" alt="Current Image"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i> Update Category
                            </button>
                            <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">
                                <i class="uil uil-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto-generate slug from name_en or name_ar
        document.getElementById('name_en').addEventListener('blur', function() {
            const slugInput = document.getElementById('slug');
            if (!slugInput.value && this.value) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }
        });

        document.getElementById('name_ar').addEventListener('blur', function() {
            const slugInput = document.getElementById('slug');
            const nameEn = document.getElementById('name_en').value;
            if (!slugInput.value && !nameEn && this.value) {
                slugInput.value = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
            }
        });
    </script>
@endsection


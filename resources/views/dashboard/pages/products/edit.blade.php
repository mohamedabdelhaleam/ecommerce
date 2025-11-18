@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('dashboard.edit_product') }} - Step 1 of 3: Basic Information</h6>
                </div>
                <div class="card-body">
                    <!-- Step Indicator -->
                    <div class="dm-steps-wrap mb-4">
                        <div class="dm-steps">
                            <ul class="nav">
                                <li class="dm-steps__item active" onclick="goToStep(1)" style="cursor: pointer;">
                                    <div class="dm-steps__line"></div>
                                    <div class="dm-steps__content">
                                        <span class="dm-steps__icon"><span class="dm-steps__count">1</span></span>
                                        <span class="dm-steps__text">Basic Information</span>
                                    </div>
                                </li>
                                <li class="dm-steps__item" onclick="goToStep(2)" style="cursor: pointer;">
                                    <div class="dm-steps__line"></div>
                                    <div class="dm-steps__content">
                                        <span class="dm-steps__icon"><span class="dm-steps__count">2</span></span>
                                        <span class="dm-steps__text">Edit Variants</span>
                                    </div>
                                </li>
                                <li class="dm-steps__item" onclick="goToStep(3)" style="cursor: pointer;">
                                    <div class="dm-steps__content">
                                        <span class="dm-steps__icon"><span class="dm-steps__count">3</span></span>
                                        <span class="dm-steps__text">Edit Images</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
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

                    <!-- Step 1: Basic Information -->
                    <div id="step1" class="step-content">
                        <form id="step1Form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="name_ar" class="form-label">{{ __('dashboard.product_name_arabic') }}
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                            id="name_ar" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}"
                                            required>
                                        @error('name_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="name_en"
                                            class="form-label">{{ __('dashboard.product_name_english') }}</label>
                                        <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                            id="name_en" name="name_en" value="{{ old('name_en', $product->name_en) }}">
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
                                            id="slug" name="slug" value="{{ old('slug', $product->slug) }}"
                                            placeholder="{{ __('dashboard.auto_generated_if_empty') }}">
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="category_id" class="form-label">{{ __('dashboard.category') }} <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control @error('category_id') is-invalid @enderror"
                                            id="category_id" name="category_id" required>
                                            <option value="">{{ __('dashboard.select_category') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="description_ar"
                                            class="form-label">{{ __('dashboard.description_arabic') }}</label>
                                        <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar" name="description_ar"
                                            rows="4">{{ old('description_ar', $product->description_ar) }}</textarea>
                                        @error('description_ar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="description_en"
                                            class="form-label">{{ __('dashboard.description_english') }}</label>
                                        <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en"
                                            name="description_en" rows="4">{{ old('description_en', $product->description_en) }}</textarea>
                                        @error('description_en')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="image"
                                            class="form-label">{{ __('dashboard.product_image') }}</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                                            id="image" name="image" accept="image/*"
                                            onchange="previewImage(this)">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">{{ __('dashboard.max_size') }}</small>
                                        <div class="mt-2">
                                            <img id="imagePreview" src="{{ $product->image }}" alt="Preview"
                                                class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-25">
                                        <label for="is_active" class="form-label">{{ __('dashboard.status') }}</label>
                                        <div class="checkbox-theme-default custom-checkbox">
                                            <input class="checkbox" type="checkbox" id="is_active" name="is_active"
                                                value="1"
                                                {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                            <label for="is_active">
                                                <span class="checkbox-text">{{ __('dashboard.active') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-0 d-flex gap-2 align-items-center justify-content-between">
                                <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary">
                                    <i class="uil uil-times"></i> {{ __('dashboard.cancel') }}
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Next: Edit Variants <i class="uil uil-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Step 2: Edit Variants -->
                    <div id="step2" class="step-content" style="display: none;">
                        <form id="step2Form">
                            @csrf
                            <div id="variantsContainer">
                                <!-- Existing variants will be loaded here -->
                            </div>

                            <div class="mb-3">
                                <button type="button" class="btn btn-info" id="addVariantBtn">
                                    <i class="uil uil-plus"></i> Add Variant
                                </button>
                            </div>

                            <div class="form-group mb-0 d-flex gap-2 align-items-center justify-content-between">
                                <button type="button" class="btn btn-secondary" onclick="goToStep(1)">
                                    <i class="uil uil-arrow-left"></i> Back
                                </button>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        Next: Edit Images <i class="uil uil-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Step 3: Edit Images -->
                    <div id="step3" class="step-content" style="display: none;">
                        <div class="mb-4">
                            <h6>Product Colors:</h6>
                            <div id="productColorsDisplay" class="d-flex gap-2 flex-wrap mb-3">
                                <!-- Colors will be displayed here -->
                            </div>
                            <p id="noColorsMessage" class="text-muted" style="display: none;">
                                No colors assigned to variants yet. Images can be added as "General" (no color).
                            </p>
                        </div>

                        <div id="imagesContainer">
                            <!-- Color-specific image sections will be added here -->
                        </div>

                        <!-- General Images (No Color) -->
                        <div class="card mb-3 color-image-section" data-color-id="general">
                            <div class="card-header">
                                <h6 class="mb-0">General Images (No Color)</h6>
                            </div>
                            <div class="card-body">
                                <form class="color-image-form" data-color-id="general">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Image File</label>
                                                <input type="file" class="form-control image-file" name="image"
                                                    accept="image/*" multiple>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Order</label>
                                                <input type="number" class="form-control image-order" name="order"
                                                    value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <div class="checkbox-theme-default custom-checkbox">
                                                    <input class="checkbox" type="checkbox" name="is_primary"
                                                        value="1" class="image-primary">
                                                    <label>
                                                        <span class="checkbox-text">Primary</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="uploaded-images-general mt-3 row">
                                    <!-- Existing general images will appear here -->
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 d-flex gap-2 align-items-center justify-content-between mt-4">
                            <button type="button" class="btn btn-secondary" onclick="goToStep(2)">
                                <i class="uil uil-arrow-left"></i> Back to Variants
                            </button>
                            <button type="button" class="btn btn-success" id="completeBtn">
                                <i class="uil uil-check"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @php
        $imagesData = $product->images
            ->map(function ($img) {
                return [
                    'id' => $img->id,
                    'image' => $img->getRawOriginal('image'),
                    'color_id' => $img->color_id,
                    'order' => $img->order,
                    'is_primary' => $img->is_primary,
                ];
            })
            ->values();
    @endphp
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const colors = @json($colors);
        const sizes = @json($sizes);
        const productId = {{ $product->id }};
        const existingVariants = @json($product->variants);
        const existingImages = @json($imagesData);
        const storageUrl = '{{ asset('storage/') }}';
        let currentStep = 1;
        let variantCount = 0;
        let savedColors = [];

        // Step Navigation Functions
        function updateStepIndicator(step) {
            const steps = document.querySelectorAll('.dm-steps__item');
            steps.forEach((item, index) => {
                item.classList.remove('active', 'finished');
                const icon = item.querySelector('.dm-steps__icon');
                const stepNum = index + 1;

                if (stepNum < step) {
                    item.classList.add('finished');
                    icon.innerHTML = '<i class="la la-check"></i>';
                    item.style.cursor = 'pointer';
                } else if (stepNum === step) {
                    item.classList.add('active');
                    icon.innerHTML = `<span class="dm-steps__count">${stepNum}</span>`;
                    item.style.cursor = 'pointer';
                } else {
                    icon.innerHTML = `<span class="dm-steps__count">${stepNum}</span>`;
                    item.style.cursor = 'pointer';
                }
            });
        }

        function showStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => {
                el.style.display = 'none';
            });

            // Show selected step
            document.getElementById(`step${step}`).style.display = 'block';
            currentStep = step;
            updateStepIndicator(step);

            // Load data when entering step
            if (step === 2 && variantCount === 0) {
                loadExistingVariants();
            }
            if (step === 3) {
                loadImagesStep();
            }
        }

        function goToStep(step) {
            showStep(step);
        }

        // Step 1: Update Product
        document.getElementById('step1Form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="uil uil-spinner uil-spin"></i> Saving...';

            fetch('{{ route('dashboard.products.update', $product) }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-HTTP-Method-Override': 'PUT',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            let errorMsg = 'Server error';
                            if (err.message) {
                                errorMsg = err.message;
                            } else if (err.errors) {
                                const errors = Object.values(err.errors).flat();
                                errorMsg = errors.join('\n');
                            }
                            throw new Error(errorMsg);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    showStep(2);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        });

        // Step 2: Load Existing Variants
        function loadExistingVariants() {
            const container = document.getElementById('variantsContainer');
            container.innerHTML = '';
            variantCount = 0;

            existingVariants.forEach(variant => {
                addVariantRow(
                    variant.color_id || '',
                    variant.size_id || '',
                    variant.price || '',
                    variant.stock || '',
                    variant.id
                );
            });

            // Extract colors from existing variants
            savedColors = [];
            existingVariants.forEach(variant => {
                if (variant.color_id && variant.color) {
                    const color = colors.find(c => c.id == variant.color_id);
                    if (color && !savedColors.find(c => c.id == color.id)) {
                        savedColors.push(color);
                    }
                }
            });
        }

        // Step 2: Variants Management
        function addVariantRow(colorId = '', sizeId = '', price = '', stock = '', variantId = null) {
            const container = document.getElementById('variantsContainer');
            const variantHtml = `
                <div class="card mb-3 variant-row" data-variant-index="${variantCount}" data-variant-id="${variantId || ''}">
                    <div class="card-body">
                        <div class="row align-items-end">
                            ${variantId ? `<input type="hidden" name="variants[${variantCount}][id]" value="${variantId}">` : ''}
                            <div class="col-md-3">
                                <label class="form-label">Color</label>
                                <select class="form-control variant-color" name="variants[${variantCount}][color_id]">
                                    <option value="">None</option>
                                    ${colors.map(color => `<option value="${color.id}" ${colorId == color.id ? 'selected' : ''}>${color.name_en}</option>`).join('')}
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Size</label>
                                <select class="form-control variant-size" name="variants[${variantCount}][size_id]">
                                    <option value="">None</option>
                                    ${sizes.map(size => `<option value="${size.id}" ${sizeId == size.id ? 'selected' : ''}>${size.name_en}</option>`).join('')}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control variant-price" name="variants[${variantCount}][price]" value="${price}" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Stock</label>
                                <input type="number" class="form-control variant-stock" name="variants[${variantCount}][stock]" value="${stock}" min="0" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm remove-variant" ${variantId ? `data-variant-id="${variantId}"` : ''}>
                                    <i class="uil uil-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', variantHtml);
            variantCount++;
        }

        document.getElementById('addVariantBtn').addEventListener('click', function() {
            addVariantRow();
        });

        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-variant')) {
                const btn = e.target.closest('.remove-variant');
                const variantId = btn.getAttribute('data-variant-id');
                const row = e.target.closest('.variant-row');

                if (variantId) {
                    if (confirm('Are you sure you want to delete this variant?')) {
                        fetch(`/dashboard/products/variants/${variantId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    row.remove();
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error deleting variant');
                            });
                    }
                } else {
                    row.remove();
                }
            }
        });

        // Step 2: Save Variants
        document.getElementById('step2Form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="uil uil-spinner uil-spin"></i> Saving...';

            fetch(`/dashboard/products/${productId}/store/variants`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            let errorMsg = 'Server error';
                            if (err.message) {
                                errorMsg = err.message;
                            } else if (err.errors) {
                                const errors = Object.values(err.errors).flat();
                                errorMsg = errors.join('\n');
                            }
                            throw new Error(errorMsg);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success || data.message) {
                        // Extract colors from variants
                        const variantRows = document.querySelectorAll('.variant-row');
                        savedColors = [];
                        variantRows.forEach(row => {
                            const colorSelect = row.querySelector('.variant-color');
                            const colorId = colorSelect.value;
                            if (colorId) {
                                const color = colors.find(c => c.id == colorId);
                                if (color && !savedColors.find(c => c.id == color.id)) {
                                    savedColors.push(color);
                                }
                            }
                        });
                        showStep(3);
                    } else {
                        alert('Error: ' + (data.message || 'Failed to save variants'));
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error: ' + error.message);
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                });
        });

        // Step 3: Load Images Step
        function loadImagesStep() {
            // Display colors
            const colorsDisplay = document.getElementById('productColorsDisplay');
            const noColorsMsg = document.getElementById('noColorsMessage');

            if (savedColors.length > 0) {
                colorsDisplay.innerHTML = savedColors.map(color =>
                    `<span class="badge bg-primary">${color.name_en}</span>`
                ).join('');
                noColorsMsg.style.display = 'none';

                // Add image sections for each color
                const imagesContainer = document.getElementById('imagesContainer');
                imagesContainer.innerHTML = savedColors.map(color => {
                    const colorImages = existingImages.filter(img => img.color_id == color.id);
                    const imagesHtml = colorImages.map(img => {
                        const imgPath = img.image ? storageUrl + '/' + img.image :
                            'https://placehold.co/100';
                        return `
                        <div class="col-md-2 mb-2">
                            <img src="${imgPath}" alt="Product Image" class="img-fluid rounded" style="max-height: 100px;">
                            <button type="button" class="btn btn-sm btn-danger mt-1 delete-existing-image" data-image-id="${img.id}">
                                <i class="uil uil-trash"></i>
                            </button>
                        </div>
                    `;
                    }).join('');

                    return `
                        <div class="card mb-3 color-image-section" data-color-id="${color.id}">
                            <div class="card-header">
                                <h6 class="mb-0">Images for: ${color.name_en}</h6>
                            </div>
                            <div class="card-body">
                                <form class="color-image-form" data-color-id="${color.id}">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Image File</label>
                                                <input type="file" class="form-control image-file" name="image" accept="image/*" multiple>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label">Order</label>
                                                <input type="number" class="form-control image-order" name="order" value="0" min="0">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <div class="checkbox-theme-default custom-checkbox">
                                                    <input class="checkbox" type="checkbox" name="is_primary" value="1" class="image-primary">
                                                    <label>
                                                        <span class="checkbox-text">Primary</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="uploaded-images-${color.id} mt-3 row">
                                    ${imagesHtml}
                                </div>
                            </div>
                        </div>
                    `;
                }).join('');
            } else {
                colorsDisplay.innerHTML = '';
                noColorsMsg.style.display = 'block';
            }

            // Load general images (no color)
            const generalImages = existingImages.filter(img => !img.color_id || img.color_id === null);
            const generalContainer = document.querySelector('.uploaded-images-general');
            if (generalContainer) {
                if (generalImages.length > 0) {
                    generalContainer.innerHTML = generalImages.map(img => {
                        const imgPath = img.image ? storageUrl + '/' + img.image : 'https://placehold.co/100';
                        return `
                        <div class="col-md-2 mb-2">
                            <img src="${imgPath}" alt="Product Image" class="img-fluid rounded" style="max-height: 100px;">
                            <button type="button" class="btn btn-sm btn-danger mt-1 delete-existing-image" data-image-id="${img.id}">
                                <i class="uil uil-trash"></i>
                            </button>
                        </div>
                    `;
                    }).join('');
                } else {
                    generalContainer.innerHTML = '';
                }
            }

            // Attach delete handlers
            document.querySelectorAll('.delete-existing-image').forEach(btn => {
                btn.addEventListener('click', function() {
                    const imageId = this.getAttribute('data-image-id');
                    if (confirm('Are you sure you want to delete this image?')) {
                        fetch(`/dashboard/products/images/${imageId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    this.closest('.col-md-2').remove();
                                } else {
                                    alert('Error: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Error deleting image');
                            });
                    }
                });
            });
        }

        // Complete Product Update
        document.getElementById('completeBtn').addEventListener('click', async function() {
            const completeBtn = this;
            const originalText = completeBtn.innerHTML;
            completeBtn.disabled = true;
            completeBtn.innerHTML = '<i class="uil uil-spinner uil-spin"></i> Uploading Images...';

            try {
                // Get all image forms (color-specific and general)
                const allImageForms = document.querySelectorAll('.color-image-form');
                let uploadPromises = [];

                // Process each form
                for (const form of allImageForms) {
                    const colorId = form.getAttribute('data-color-id');
                    const fileInput = form.querySelector('.image-file');
                    const orderInput = form.querySelector('.image-order');
                    const isPrimary = form.querySelector('.image-primary')?.checked || false;

                    const files = fileInput.files;
                    if (files.length > 0) {
                        // Upload each file
                        Array.from(files).forEach((file, index) => {
                            const formData = new FormData();
                            formData.append('image', file);
                            formData.append('color_id', colorId === 'general' ? '' : colorId);
                            formData.append('order', parseInt(orderInput?.value || 0) + index);
                            formData.append('is_primary', index === 0 && isPrimary ? 1 : 0);
                            formData.append('_token', csrfToken);

                            uploadPromises.push(
                                fetch(`/dashboard/products/${productId}/images`, {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        const container = document.querySelector(
                                            `.uploaded-images-${colorId}`);
                                        if (container) {
                                            const imageHtml = `
                                                <div class="col-md-2 mb-2">
                                                    <img src="${data.image.url}" alt="Product Image" class="img-fluid rounded" style="max-height: 100px;">
                                                    <button type="button" class="btn btn-sm btn-danger mt-1 delete-existing-image" data-image-id="${data.image.id}">
                                                        <i class="uil uil-trash"></i>
                                                    </button>
                                                </div>
                                            `;
                                            container.insertAdjacentHTML('beforeend',
                                                imageHtml);
                                        }
                                    } else {
                                        throw new Error('Error uploading image: ' + (data
                                            .message || 'Unknown error'));
                                    }
                                })
                            );
                        });
                    }
                }

                // Wait for all uploads to complete
                if (uploadPromises.length > 0) {
                    await Promise.all(uploadPromises);
                }

                // Redirect after successful uploads
                window.location.href = '{{ route('dashboard.products.index') }}';
            } catch (error) {
                console.error('Error:', error);
                alert('Error uploading images: ' + error.message);
                completeBtn.disabled = false;
                completeBtn.innerHTML = originalText;
            }
        });

        // Image Preview
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Auto-generate slug
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

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            updateStepIndicator(1);

            // Load general images on page load if they exist
            const generalImages = existingImages.filter(img => !img.color_id || img.color_id === null);
            const generalContainer = document.querySelector('.uploaded-images-general');
            if (generalContainer && generalImages.length > 0) {
                generalContainer.innerHTML = generalImages.map(img => {
                    const imgPath = img.image ? storageUrl + '/' + img.image : 'https://placehold.co/100';
                    return `
                    <div class="col-md-2 mb-2">
                        <img src="${imgPath}" alt="Product Image" class="img-fluid rounded" style="max-height: 100px;">
                        <button type="button" class="btn btn-sm btn-danger mt-1 delete-existing-image" data-image-id="${img.id}">
                            <i class="uil uil-trash"></i>
                        </button>
                    </div>
                `;
                }).join('');

                // Attach delete handlers for general images
                document.querySelectorAll('.delete-existing-image').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const imageId = this.getAttribute('data-image-id');
                        if (confirm('Are you sure you want to delete this image?')) {
                            fetch(`/dashboard/products/images/${imageId}`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'X-Requested-With': 'XMLHttpRequest',
                                    }
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        this.closest('.col-md-2').remove();
                                    } else {
                                        alert('Error: ' + data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    alert('Error deleting image');
                                });
                        }
                    });
                });
            }
        });
    </script>
@endsection

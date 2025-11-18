@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.product_details') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.products.edit', $product) }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="mb-3">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded"
                                    style="width: 500px; height: 280px; object-fit: cover; border-radius: 6px;  box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.product_name_arabic') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $product->name_ar }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.product_name_english') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $product->name_en ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.category') }}</label>
                                            <h6 class="mb-0">
                                                <span
                                                    class="badge bg-info fs-6 px-3 py-2">{{ $product->category->name }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.created_at') }}</label>
                                            <h6 class="mb-0 fw-600 small">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $product->created_at->locale('ar')->translatedFormat('d F Y H:i:s') }}
                                                @else
                                                    {{ $product->created_at->format('Y-m-d H:i:s') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.status') }}</label>
                                            <div class="mt-1">
                                                <x-dashboard.status-switcher
                                                    route="{{ route('dashboard.products.toggle-status', $product) }}"
                                                    item-id="{{ $product->id }}" is-active="{{ $product->is_active }}"
                                                    item-type="product" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($product->images && $product->images->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.additional_images') }}</h6>
                                <div class="d-flex gap-2">
                                    @foreach ($product->images as $image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Product Image"
                                                class="img-thumbnail"
                                                style="width: 100px; height: 100px;object-fit: cover; border-radius: 6px;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($product->variants && $product->variants->count() > 0)
                        <div id="variants" class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.product_variants') }}</h6>
                                <div class="userDatatable global-shadow border-light-0 w-100">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless">
                                            <thead>
                                                <tr class="userDatatable-header">
                                                    <th>
                                                        <span class="userDatatable-title">{{ __('dashboard.image') }}
                                                        </span>
                                                    </th>
                                                    <th>
                                                        <span class="userDatatable-title">{{ __('dashboard.size') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.color') }}</span>
                                                    </th>

                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.price') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.stock') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.status') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.actions') }}</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="variants-table-body">
                                                @include('dashboard.pages.products.partials.variants-table')
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Variant Image Modals -->
                        @php
                            $variantModals = [];
                            foreach ($product->variants as $variant) {
                                $variantImages = $variant->color_id
                                    ? $product
                                        ->images()
                                        ->where('color_id', $variant->color_id)
                                        ->orderBy('is_primary', 'desc')
                                        ->orderBy('order')
                                        ->get()
                                    : $product
                                        ->images()
                                        ->whereNull('color_id')
                                        ->orderBy('is_primary', 'desc')
                                        ->orderBy('order')
                                        ->get();

                                if ($variantImages->isEmpty() && $variant->color_id) {
                                    $variantImages = $product
                                        ->images()
                                        ->whereNull('color_id')
                                        ->orderBy('is_primary', 'desc')
                                        ->orderBy('order')
                                        ->get();
                                }

                                if ($variantImages->count() > 1) {
                                    $variantModals[] = [
                                        'variant' => $variant,
                                        'images' => $variantImages,
                                    ];
                                }
                            }
                        @endphp
                        @foreach ($variantModals as $modalData)
                            <div class="modal fade" id="imageModal{{ $modalData['variant']->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Images for
                                                {{ $modalData['variant']->size->name ?? 'N/A' }} -
                                                {{ $modalData['variant']->color->name ?? 'N/A' }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                @foreach ($modalData['images'] as $img)
                                                    @php
                                                        $imgPath =
                                                            $img->getRawOriginal('image') ?? ($img->image ?? null);
                                                        $imgUrl = $imgPath
                                                            ? asset('storage/' . $imgPath)
                                                            : 'https://placehold.co/400';
                                                    @endphp
                                                    <div class="col-md-3 mb-3 position-relative">
                                                        <div class="position-relative">
                                                            <img src="{{ $imgUrl }}" alt="Product Image"
                                                                class="img-thumbnail w-100"
                                                                style="height: 150px; object-fit: cover;">
                                                            @if (isset($img->is_primary) && $img->is_primary)
                                                                <small class="badge bg-primary mt-1">Primary</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if ($product->comments && $product->comments->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.comments') }}</h6>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body pb-10">
                                        @foreach ($product->comments as $comment)
                                            <div class="dm-comment-box media mb-4">
                                                <div class="dm-comment-box__author">
                                                    <figure>
                                                        <img src="http://45.33.34.15:8002/assets/img/author/1.jpg"
                                                            class="bg-opacity-primary d-flex rounded-circle"
                                                            alt="{{ $comment->user->name ?? ($comment->name ?? 'User') }}"
                                                            style="width: 50px; height: 50px; object-fit: cover;">
                                                    </figure>
                                                </div>
                                                <div class="dm-comment-box__content media-body ms-3">
                                                    <div class="comment-content-inner cci">
                                                        <span class="cci__author-info fw-bold">
                                                            {{ $comment->user->name ?? ($comment->name ?? 'Anonymous') }}
                                                            @if ($comment->rating)
                                                                <span class="badge bg-warning text-dark ms-2">
                                                                    {{ $comment->rating }} ⭐
                                                                </span>
                                                            @endif
                                                            @if (!$comment->is_approved)
                                                                <span class="badge bg-secondary ms-2">Pending
                                                                    Approval</span>
                                                            @endif
                                                        </span>
                                                        @if ($comment->email)
                                                            <small
                                                                class="text-muted d-block mb-1">{{ $comment->email }}</small>
                                                        @endif
                                                        <p class="cci__comment-text mt-2 mb-2">{{ $comment->comment }}</p>
                                                        <small class="text-muted d-block mb-2">
                                                            {{ $comment->created_at->format('Y-m-d H:i:s') }}
                                                        </small>
                                                        <div class="cci__comment-actions d-flex gap-2">
                                                            <a href="#" class="btn-like text-decoration-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="svg replaced-svg">
                                                                    <path
                                                                        d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                                                                    </path>
                                                                </svg>
                                                                <span class="line-count">0</span>
                                                            </a>
                                                            <a href="#" class="btn-dislike text-decoration-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="svg replaced-svg">
                                                                    <path
                                                                        d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17">
                                                                    </path>
                                                                </svg>
                                                                <span class="line-count">0</span>
                                                            </a>
                                                            <a href="#" class="btn-reply text-decoration-none">
                                                                <span>Reply</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if (!$loop->last)
                                                <hr>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <i class="uil uil-comment-alt"></i> {{ __('dashboard.no_comments_found') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // AJAX update for variant price and stock
        (function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                document.querySelector('input[name="_token"]')?.value;

            // Handle price updates
            document.querySelectorAll('.variant-price-input').forEach(function(input) {
                let timeout;
                input.addEventListener('blur', function() {
                    updateVariantField(this, 'price');
                });
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.blur();
                    }
                });
            });

            // Handle stock updates
            document.querySelectorAll('.variant-stock-input').forEach(function(input) {
                let timeout;
                input.addEventListener('blur', function() {
                    updateVariantField(this, 'stock');
                });
                input.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        this.blur();
                    }
                });
            });

            function updateVariantField(input, field) {
                const variantId = input.getAttribute('data-variant-id');
                const updateUrl = input.getAttribute('data-update-url');
                const value = field === 'price' ? parseFloat(input.value) : parseInt(input.value);
                const originalValue = input.getAttribute('data-original-value') || input.defaultValue;

                // Don't update if value hasn't changed
                if (value === (field === 'price' ? parseFloat(originalValue) : parseInt(originalValue))) {
                    return;
                }

                // Validate value
                if (isNaN(value) || value < 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Value',
                        text: `Please enter a valid ${field === 'price' ? 'price' : 'stock'} value.`,
                    });
                    input.value = originalValue;
                    return;
                }

                // Disable input during request
                input.disabled = true;
                const originalBorder = input.style.border;
                input.style.border = '2px solid #42b6f0';

                // Make AJAX request
                fetch(updateUrl, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            [field]: value,
                        }),
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            input.setAttribute('data-original-value', value);
                            input.style.border = '2px solid #28a745';
                            setTimeout(() => {
                                input.style.border = originalBorder;
                            }, 1000);

                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: data.message || `Variant ${field} updated successfully.`,
                                timer: 1500,
                                showConfirmButton: false,
                            });
                        } else {
                            throw new Error(data.message || 'Update failed');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        input.value = originalValue;
                        input.style.border = '2px solid #dc3545';
                        setTimeout(() => {
                            input.style.border = originalBorder;
                        }, 2000);

                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: error.message || 'Failed to update variant. Please try again.',
                        });
                    })
                    .finally(() => {
                        input.disabled = false;
                    });
            }

            // Store original values on page load
            document.querySelectorAll('.variant-price-input, .variant-stock-input').forEach(function(input) {
                input.setAttribute('data-original-value', input.value);
            });
        })();

        // Handle variant deletion
        document.addEventListener('click', function(e) {
            if (e.target.closest('.delete-variant-btn')) {
                const btn = e.target.closest('.delete-variant-btn');
                const variantId = btn.getAttribute('data-variant-id');
                const variantInfo = btn.getAttribute('data-variant-info');

                if (!variantId) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Variant ID not found.',
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to delete variant: ${variantInfo}? This action cannot be undone!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') ||
                            document.querySelector('input[name="_token"]')?.value;

                        btn.disabled = true;
                        btn.innerHTML = '<i class="uil uil-spinner uil-spin"></i>';

                        fetch(`/dashboard/products/variants/${variantId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Remove the variant row from the table
                                    const variantRow = document.getElementById(
                                        `variant-row-${variantId}`);
                                    if (variantRow) {
                                        variantRow.remove();
                                    }

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: data.message || 'Variant deleted successfully.',
                                        timer: 1500,
                                        showConfirmButton: false,
                                    });

                                    // Reload the page after a short delay to update everything
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                } else {
                                    throw new Error(data.message || 'Failed to delete variant');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                btn.disabled = false;
                                btn.innerHTML = '<i class="uil uil-trash"></i>';

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Delete Failed',
                                    text: error.message ||
                                        'Failed to delete variant. Please try again.',
                                });
                            });
                    }
                });
            }
        });
    </script>
@endsection

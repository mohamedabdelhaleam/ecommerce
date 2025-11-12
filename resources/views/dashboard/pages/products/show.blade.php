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
                                    style="width: 100%; height: auto; max-height: 300px;">
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
                                <div class="row">
                                    @foreach ($product->images as $image)
                                        <div class="col-md-2 mb-3">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Product Image"
                                                class="img-thumbnail" style="width: 100%; height: auto;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($product->variants && $product->variants->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.product_variants') }}</h6>
                                <div class="userDatatable global-shadow border-light-0 w-100">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless">
                                            <thead>
                                                <tr class="userDatatable-header">
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
    </script>
@endsection

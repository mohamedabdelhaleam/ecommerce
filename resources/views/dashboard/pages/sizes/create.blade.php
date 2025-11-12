@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('dashboard.create_new_size') }}</h6>
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

                    <form action="{{ route('dashboard.sizes.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="name_ar" class="form-label">{{ __('dashboard.size_name_arabic') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name_ar') is-invalid @enderror"
                                        id="name_ar" name="name_ar" value="{{ old('name_ar') }}" required>
                                    @error('name_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="name_en" class="form-label">{{ __('dashboard.size_name_english') }}</label>
                                    <input type="text" class="form-control @error('name_en') is-invalid @enderror"
                                        id="name_en" name="name_en" value="{{ old('name_en') }}">
                                    @error('name_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="slug" class="form-label">{{ __('dashboard.slug') }}</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                        id="slug" name="slug" value="{{ old('slug') }}"
                                        placeholder="{{ __('dashboard.auto_generated_if_empty') }}">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="value" class="form-label">{{ __('dashboard.value') }}</label>
                                    <input type="text" class="form-control @error('value') is-invalid @enderror"
                                        id="value" name="value" value="{{ old('value') }}"
                                        placeholder="e.g., 12, 18, 24">
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('dashboard.size_value_hint') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="order" class="form-label">{{ __('dashboard.order') }}</label>
                                    <input type="number" class="form-control @error('order') is-invalid @enderror"
                                        id="order" name="order" value="{{ old('order', 0) }}" min="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('dashboard.order_hint') }}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="is_active" class="form-label">{{ __('dashboard.status') }}</label>
                                    <div class="checkbox-theme-default custom-checkbox">
                                        <input class="checkbox" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label for="is_active">
                                            <span class="checkbox-text">{{ __('dashboard.active') }}</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 d-flex gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i> {{ __('dashboard.create') }} {{ __('dashboard.size') }}
                            </button>
                            <a href="{{ route('dashboard.sizes.index') }}" class="btn btn-secondary">
                                <i class="uil uil-times"></i> {{ __('dashboard.cancel') }}
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

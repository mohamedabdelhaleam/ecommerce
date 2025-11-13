@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('dashboard.create_new_coupon') }}</h6>
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

                    <form action="{{ route('dashboard.coupons.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="code" class="form-label">{{ __('dashboard.coupon_code') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror"
                                        id="code" name="code" value="{{ old('code') }}" required
                                        style="text-transform: uppercase;">
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="type" class="form-label">{{ __('dashboard.discount_type') }}
                                        <span class="text-danger">*</span></label>
                                    <select class="form-control @error('type') is-invalid @enderror" id="type"
                                        name="type" required>
                                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>
                                            {{ __('dashboard.percentage') }}</option>
                                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>
                                            {{ __('dashboard.fixed') }}</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="name_ar" class="form-label">{{ __('dashboard.name_ar') }}
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
                                    <label for="name_en" class="form-label">{{ __('dashboard.name_en') }}</label>
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
                                    <label for="value" class="form-label">{{ __('dashboard.discount_value') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('value') is-invalid @enderror" id="value"
                                        name="value" value="{{ old('value') }}" required>
                                    @error('value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('dashboard.discount_value_hint') }}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="minimum_amount"
                                        class="form-label">{{ __('dashboard.minimum_amount') }}</label>
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('minimum_amount') is-invalid @enderror"
                                        id="minimum_amount" name="minimum_amount" value="{{ old('minimum_amount') }}">
                                    @error('minimum_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="usage_limit" class="form-label">{{ __('dashboard.usage_limit') }}</label>
                                    <input type="number" min="1"
                                        class="form-control @error('usage_limit') is-invalid @enderror" id="usage_limit"
                                        name="usage_limit" value="{{ old('usage_limit') }}">
                                    @error('usage_limit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('dashboard.usage_limit_hint') }}</small>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="starts_at" class="form-label">{{ __('dashboard.starts_at') }}</label>
                                    <input type="date" class="form-control @error('starts_at') is-invalid @enderror"
                                        id="starts_at" name="starts_at" value="{{ old('starts_at') }}">
                                    @error('starts_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="expires_at" class="form-label">{{ __('dashboard.expires_at') }}</label>
                                    <input type="date" class="form-control @error('expires_at') is-invalid @enderror"
                                        id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="description_ar"
                                        class="form-label">{{ __('dashboard.description_ar') }}</label>
                                    <textarea class="form-control @error('description_ar') is-invalid @enderror" id="description_ar"
                                        name="description_ar" rows="3">{{ old('description_ar') }}</textarea>
                                    @error('description_ar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="description_en"
                                        class="form-label">{{ __('dashboard.description_en') }}</label>
                                    <textarea class="form-control @error('description_en') is-invalid @enderror" id="description_en"
                                        name="description_en" rows="3">{{ old('description_en') }}</textarea>
                                    @error('description_en')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 d-flex gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i> {{ __('dashboard.create') }} {{ __('dashboard.coupon') }}
                            </button>
                            <a href="{{ route('dashboard.coupons.index') }}" class="btn btn-secondary">
                                <i class="uil uil-times"></i> {{ __('dashboard.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

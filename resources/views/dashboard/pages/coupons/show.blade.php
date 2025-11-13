@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.coupon_details') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.coupons.edit', $coupon) }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <a href="{{ route('dashboard.coupons.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="mb-3">
                                <div class="rounded d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 200px; background-color: #10b981; color: white;">
                                    <span class="display-4 fw-bold">{{ strtoupper($coupon->code) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.coupon_code') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $coupon->code }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.name') }}</label>
                                            <h6 class="mb-0 fw-600">
                                                {{ app()->getLocale() == 'ar' ? $coupon->name_ar ?? $coupon->name_en : $coupon->name_en ?? $coupon->name_ar }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.discount_type') }}</label>
                                            <h6 class="mb-0">
                                                <span
                                                    class="badge bg-{{ $coupon->type == 'percentage' ? 'info' : 'warning' }} fs-6 px-3 py-2">
                                                    {{ $coupon->type == 'percentage' ? __('dashboard.percentage') : __('dashboard.fixed') }}
                                                </span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.discount_value') }}</label>
                                            <h6 class="mb-0 fw-600">
                                                {{ $coupon->type == 'percentage' ? $coupon->value . '%' : $coupon->value }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.minimum_amount') }}</label>
                                            <h6 class="mb-0 fw-600">
                                                {{ $coupon->minimum_amount ?? __('dashboard.no_minimum') }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.usage') }}</label>
                                            <h6 class="mb-0 fw-600">
                                                {{ $coupon->used_count }} /
                                                {{ $coupon->usage_limit ?? __('dashboard.unlimited') }}
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.starts_at') }}</label>
                                            <h6 class="mb-0 fw-600 small">
                                                @if ($coupon->starts_at)
                                                    @if (app()->getLocale() == 'ar')
                                                        {{ $coupon->starts_at->locale('ar')->translatedFormat('d F Y') }}
                                                    @else
                                                        {{ $coupon->starts_at->format('Y-m-d') }}
                                                    @endif
                                                @else
                                                    {{ __('dashboard.no_start_date') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.expires_at') }}</label>
                                            <h6 class="mb-0 fw-600 small">
                                                @if ($coupon->expires_at)
                                                    @if (app()->getLocale() == 'ar')
                                                        {{ $coupon->expires_at->locale('ar')->translatedFormat('d F Y') }}
                                                    @else
                                                        {{ $coupon->expires_at->format('Y-m-d') }}
                                                    @endif
                                                @else
                                                    {{ __('dashboard.no_expiry') }}
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
                                                    route="{{ route('dashboard.coupons.toggle-status', $coupon) }}"
                                                    item-id="{{ $coupon->id }}" is-active="{{ $coupon->is_active }}"
                                                    item-type="coupon" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($coupon->description_ar || $coupon->description_en)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.description') }}</h6>
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body">
                                        @if (app()->getLocale() == 'ar')
                                            <p>{{ $coupon->description_ar ?? $coupon->description_en }}</p>
                                        @else
                                            <p>{{ $coupon->description_en ?? $coupon->description_ar }}</p>
                                        @endif
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

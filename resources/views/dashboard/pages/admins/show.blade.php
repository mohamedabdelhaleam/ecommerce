@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.admin_details') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.admins.edit', $admin) }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <a href="{{ route('dashboard.admins.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="mb-3">
                                <div class="rounded d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 200px; background-color: #4f46e5; color: white;">
                                    <span class="display-4 fw-bold">{{ strtoupper(substr($admin->name, 0, 1)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.name') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $admin->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.email') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $admin->email }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.phone_number') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $admin->phone ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.roles') }}</label>
                                            <div class="mt-1">
                                                @if ($admin->roles && $admin->roles->count() > 0)
                                                    @foreach ($admin->roles as $role)
                                                        <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">{{ __('dashboard.no_roles_assigned') }}</span>
                                                @endif
                                            </div>
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
                                                    route="{{ route('dashboard.admins.toggle-status', $admin) }}"
                                                    item-id="{{ $admin->id }}" is-active="{{ $admin->is_active }}"
                                                    item-type="admin" />
                                            </div>
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
                                                    {{ $admin->created_at->locale('ar')->translatedFormat('d F Y H:i:s') }}
                                                @else
                                                    {{ $admin->created_at->format('Y-m-d H:i:s') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

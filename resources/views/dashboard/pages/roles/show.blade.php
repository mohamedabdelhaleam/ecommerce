@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.role_details') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.roles.edit', $role) }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <a href="{{ route('dashboard.roles.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="mb-3">
                                <div class="rounded d-flex align-items-center justify-content-center"
                                    style="width: 100%; height: 200px; background-color: #6366f1; color: white;">
                                    <span class="display-4 fw-bold">{{ strtoupper(substr($role->name, 0, 1)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.role_name') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $role->name }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.permissions_count') }}</label>
                                            <h6 class="mb-0">
                                                <span
                                                    class="badge bg-info fs-6 px-3 py-2">{{ $role->permissions->count() ?? 0 }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.users_count') }}</label>
                                            <h6 class="mb-0">
                                                <span class="badge bg-info fs-6 px-3 py-2">{{ $usersCount ?? 0 }}</span>
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
                                                    {{ $role->created_at->locale('ar')->translatedFormat('d F Y H:i:s') }}
                                                @else
                                                    {{ $role->created_at->format('Y-m-d H:i:s') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($role->permissions && $role->permissions->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.permissions') }}</h6>
                                <div class="row">
                                    @php
                                        $permissionGroups = [];
                                        foreach ($role->permissions as $permission) {
                                            $parts = explode(' ', $permission->name);
                                            $group = $parts[0] ?? 'other';
                                            if (!isset($permissionGroups[$group])) {
                                                $permissionGroups[$group] = [];
                                            }
                                            $permissionGroups[$group][] = $permission;
                                        }
                                    @endphp

                                    @foreach ($permissionGroups as $group => $groupPermissions)
                                        <div class="col-md-6 mb-3">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-header bg-light border-0">
                                                    <strong>{{ ucfirst($group) }}</strong>
                                                </div>
                                                <div class="card-body">
                                                    @foreach ($groupPermissions as $permission)
                                                        <span class="badge bg-secondary me-1 mb-1">
                                                            {{ str_replace($group . ' ', '', $permission->name) }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

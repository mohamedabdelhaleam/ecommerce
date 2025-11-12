@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('dashboard.create_new_role') }}</h6>
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

                    <form action="{{ route('dashboard.roles.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-25">
                                    <label for="name" class="form-label">{{ __('dashboard.role_name') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-25">
                                    <label class="form-label">{{ __('dashboard.permissions') }}</label>
                                    <div class="row">
                                        @php
                                            $permissionGroups = [];
                                            foreach ($permissions as $permission) {
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
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="permissions[]" value="{{ $permission->id }}"
                                                                    id="permission_{{ $permission->id }}"
                                                                    {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                                <label class="form-check-label"
                                                                    for="permission_{{ $permission->id }}">
                                                                    {{ str_replace($group . ' ', '', $permission->name) }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('permissions')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 d-flex gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i> {{ __('dashboard.create') }} {{ __('dashboard.role') }}
                            </button>
                            <a href="{{ route('dashboard.roles.index') }}" class="btn btn-secondary">
                                <i class="uil uil-times"></i> {{ __('dashboard.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

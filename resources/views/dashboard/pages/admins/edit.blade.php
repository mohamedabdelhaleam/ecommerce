@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ __('dashboard.edit_admin') }}</h6>
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

                    <form action="{{ route('dashboard.admins.update', $admin) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="name" class="form-label">{{ __('dashboard.name') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $admin->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="email" class="form-label">{{ __('dashboard.email') }}
                                        <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="phone" class="form-label">{{ __('dashboard.phone_number') }}</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" name="phone" value="{{ old('phone', $admin->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="roles" class="form-label">{{ __('dashboard.roles') }}</label>
                                    <select class="form-control @error('roles') is-invalid @enderror" id="roles"
                                        name="roles[]" multiple>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ in_array($role->id, old('roles', $admin->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('dashboard.select_roles_hint') }}</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="is_active" class="form-label">{{ __('dashboard.status') }}</label>
                                    <div class="checkbox-theme-default custom-checkbox">
                                        <input class="checkbox" type="checkbox" id="is_active" name="is_active"
                                            value="1" {{ old('is_active', $admin->is_active) ? 'checked' : '' }}>
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
                                    <label for="password" class="form-label">{{ __('dashboard.password') }}</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">{{ __('dashboard.password_leave_blank') }}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-25">
                                    <label for="password_confirmation"
                                        class="form-label">{{ __('dashboard.confirm_password') }}</label>
                                    <input type="password"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-0 d-flex gap-2 align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="uil uil-save"></i> {{ __('dashboard.update') }} {{ __('dashboard.admin') }}
                            </button>
                            <a href="{{ route('dashboard.admins.index') }}" class="btn btn-secondary">
                                <i class="uil uil-times"></i> {{ __('dashboard.cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

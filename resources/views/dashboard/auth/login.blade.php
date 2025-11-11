@extends('dashboard.layout.guest')
@section('content')
    <main class="main-content">
        <div class="admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-8">
                        <div class="edit-profile">
                            <div class="edit-profile__logos">
                            </div>
                            <div class="card border-0">
                                <div class="card-header">
                                    <div class="edit-profile__title">
                                        <h6>Login</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="edit-profile__body">
                                        <form method="POST" action="{{ route('dashboard.login') }}">
                                            @csrf
                                            <div class="form-group mb-25">
                                                <label for="phone">Phone Number</label>
                                                <input type="tel" class="form-control" id="phone" name="phone"
                                                    placeholder="0123456789" :value="old('phone')" required autofocus
                                                    autocomplete="phone">
                                                @if ($errors->has('phone'))
                                                    <span class="text-red-600 text-sm">{{ $errors->first('phone') }}</span>
                                                @endif
                                            </div>
                                            <div class="form-group mb-15">
                                                <label for="password-field">Password</label>
                                                <div class="position-relative">
                                                    <input id="password-field" type="password" class="form-control"
                                                        name="password" required autocomplete="current-password"
                                                        placeholder="Password">
                                                    <div
                                                        class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2">
                                                    </div>
                                                </div>
                                                @if ($errors->has('password'))
                                                    <span
                                                        class="text-red-600 text-sm">{{ $errors->first('password') }}</span>
                                                @endif
                                            </div>
                                            <div class="admin-condition">
                                                <div class="checkbox-theme-default custom-checkbox">
                                                    <input class="checkbox" type="checkbox" id="remember_me" name="remember"
                                                        value="1" {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember_me">
                                                        <span class="checkbox-text">Remember Me</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div
                                                class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                <button
                                                    class="btn btn-primary w-100 btn-squared text-capitalize lh-normal px-50 signIn-createBtn">
                                                    Login
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

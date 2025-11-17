@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.user_details') }} - {{ $user->name }}</h6>
                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- User Information -->
                        <div class="col-lg-4 mb-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-main-color">
                                    <h6 class="mb-0 text-white">{{ __('dashboard.account_information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">{{ __('dashboard.name') }}</label>
                                        <h6 class="mb-0 fw-600">{{ $user->name }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">{{ __('dashboard.email') }}</label>
                                        <h6 class="mb-0">{{ $user->email }}</h6>
                                        @if ($user->email_verified_at)
                                            <small class="text-success">
                                                <i class="uil uil-check-circle"></i> {{ __('dashboard.verified') }}
                                                ({{ $user->email_verified_at->format('M d, Y') }})
                                            </small>
                                        @else
                                            <small class="text-warning">
                                                <i class="uil uil-times-circle"></i> {{ __('dashboard.not_verified') }}
                                            </small>
                                        @endif
                                    </div>
                                    @if ($user->phone)
                                        <div class="mb-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.phone') }}</label>
                                            <h6 class="mb-0">{{ $user->phone }}</h6>
                                            @if ($user->phone_verified_at)
                                                <small class="text-success">
                                                    <i class="uil uil-check-circle"></i> {{ __('dashboard.verified') }}
                                                    ({{ $user->phone_verified_at->format('M d, Y') }})
                                                </small>
                                            @else
                                                <small class="text-warning">
                                                    <i class="uil uil-times-circle"></i> {{ __('dashboard.not_verified') }}
                                                </small>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.member_since') }}</label>
                                        <h6 class="mb-0">{{ $user->created_at->format('M d, Y h:i A') }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.total_orders') }}</label>
                                        <h6 class="mb-0 fw-600">
                                            <span class="badge bg-primary">{{ $user->orders()->count() }}</span>
                                        </h6>
                                    </div>
                                </div>
                            </div>

                            @if ($user->address || $user->city || $user->state || $user->zip || $user->country)
                                <div class="card border-0 shadow-sm">
                                    <div class="card-header bg-main-color text-white">
                                        <h6 class="mb-0 text-white">{{ __('dashboard.address_information') }}</h6>
                                    </div>
                                    <div class="card-body">
                                        @if ($user->address)
                                            <div class="mb-2">
                                                <label
                                                    class="form-label text-muted small mb-1">{{ __('dashboard.address') }}</label>
                                                <p class="mb-0">{{ $user->address }}</p>
                                            </div>
                                        @endif
                                        @if ($user->city || $user->state || $user->zip)
                                            <div class="mb-2">
                                                <p class="mb-0">
                                                    @if ($user->city)
                                                        {{ $user->city }}
                                                    @endif
                                                    @if ($user->state)
                                                        , {{ $user->state }}
                                                    @endif
                                                    @if ($user->zip)
                                                        {{ $user->zip }}
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                        @if ($user->country)
                                            <div class="mb-0">
                                                <p class="mb-0">{{ $user->country }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Recent Orders -->
                        <div class="col-lg-8">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-main-color">
                                    <h6 class="mb-0 text-white">{{ __('dashboard.recent_orders') }}</h6>
                                </div>
                                <div class="card-body">
                                    @if ($user->orders->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>{{ __('dashboard.order_number') }}</th>
                                                        <th>{{ __('dashboard.date') }}</th>
                                                        <th>{{ __('dashboard.total') }}</th>
                                                        <th>{{ __('dashboard.payment_status') }}</th>
                                                        <th>{{ __('dashboard.actions') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($user->orders as $order)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $order->order_number }}</strong>
                                                            </td>
                                                            <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                                            <td>${{ number_format($order->total, 2) }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge {{ $order->is_paid ? 'bg-success' : 'bg-warning' }}">
                                                                    {{ $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid') }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('dashboard.orders.show', $order) }}"
                                                                    class="btn btn-sm">
                                                                    <i class="uil uil-eye"></i> {{ __('dashboard.view') }}
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if ($user->orders()->count() > 10)
                                            <div class="mt-3 text-center">
                                                <a href="{{ route('dashboard.orders.index', ['search' => $user->email]) }}"
                                                    class="btn btn-primary">
                                                    {{ __('dashboard.view') }} {{ __('dashboard.all') }}
                                                    {{ __('dashboard.orders') }}
                                                </a>
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-muted mb-0 text-center py-4">
                                            {{ __('dashboard.no_orders_found') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

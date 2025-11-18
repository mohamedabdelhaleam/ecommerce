@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.order_details') }} - {{ $order->order_number }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('dashboard.orders.invoice', $order) }}" target="_blank" class="btn btn-info btn-sm">
                            <i class="uil uil-file-alt"></i> {{ __('dashboard.view_invoice') }}
                        </a>
                        <a href="{{ route('dashboard.orders.download-invoice', $order) }}" class="btn btn-primary btn-sm">
                            <i class="uil uil-download"></i> {{ __('dashboard.download_invoice') }}
                        </a>
                        <form method="POST" action="{{ route('dashboard.orders.toggle-paid', $order) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $order->is_paid ? 'warning' : 'success' }} btn-sm">
                                <i class="uil uil-{{ $order->is_paid ? 'times' : 'check' }}"></i>
                                {{ $order->is_paid ? __('dashboard.mark_as_unpaid') : __('dashboard.mark_as_paid') }}
                            </button>
                        </form>
                        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <!-- Order Information -->
                        <div class="col-lg-8 mb-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-main-color">
                                    <h6 class="mb-0 text-white">{{ __('dashboard.order_items') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('dashboard.product') }}</th>
                                                    <th>{{ __('dashboard.variant') }}</th>
                                                    <th>{{ __('dashboard.quantity') }}</th>
                                                    <th>{{ __('dashboard.price') }}</th>
                                                    <th>{{ __('dashboard.total') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->items as $item)
                                                    <tr>
                                                        <td>
                                                            <strong>{{ $item->product->name }}</strong>
                                                        </td>
                                                        <td>
                                                            @if ($item->variant)
                                                                {{ $item->variant->size->name ?? __('dashboard.na') }} /
                                                                {{ $item->variant->color->name ?? __('dashboard.na') }}
                                                            @else
                                                                <span class="text-muted">{{ __('dashboard.na') }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>${{ number_format($item->price, 2) }}</td>
                                                        <td><strong>${{ number_format($item->total, 2) }}</strong></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-end">
                                                        <strong>{{ __('dashboard.order_total') }}:</strong>
                                                    </td>
                                                    <td><strong>${{ number_format($order->total, 2) }}</strong></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="col-lg-4">
                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-main-color">
                                    <h6 class="mb-0 text-white">{{ __('dashboard.order_information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.order_number') }}</label>
                                        <h6 class="mb-0 fw-600">{{ $order->order_number }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.order_date') }}</label>
                                        <h6 class="mb-0">{{ $order->created_at->format('M d, Y h:i A') }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.payment_status') }}</label>
                                        <div>
                                            <span class="badge {{ $order->is_paid ? 'bg-success' : 'bg-warning' }}">
                                                {{ $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.payment_method') }}</label>
                                        <h6 class="mb-0">{{ ucfirst($order->payment_method) }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label
                                            class="form-label text-muted small mb-1">{{ __('dashboard.total_amount') }}</label>
                                        <h6 class="mb-0 fw-600">${{ number_format($order->total, 2) }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-main-color text-white">
                                    <h6 class="mb-0 text-white">{{ __('dashboard.customer_information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">{{ __('dashboard.name') }}</label>
                                        <h6 class="mb-0">{{ $order->shipping_name }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">{{ __('dashboard.email') }}</label>
                                        <h6 class="mb-0">{{ $order->shipping_email }}</h6>
                                    </div>
                                    @if ($order->shipping_phone)
                                        <div class="mb-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.phone') }}</label>
                                            <h6 class="mb-0">{{ $order->shipping_phone }}</h6>
                                        </div>
                                    @endif
                                    @if ($order->user)
                                        <div class="mb-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.registered_user') }}</label>
                                            <h6 class="mb-0">{{ $order->user->name }} ({{ $order->user->email }})</h6>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-main-color text-white">
                                    <h6 class="mb-0 text-white">{{ __('dashboard.shipping_address') }}</h6>
                                </div>
                                <div class="card-body">
                                    @if (
                                        $order->shipping_address ||
                                            $order->shipping_city ||
                                            $order->shipping_state ||
                                            $order->shipping_zip ||
                                            $order->shipping_country)
                                        <div class="mb-2">
                                            @if ($order->shipping_address)
                                                <p class="mb-1">{{ $order->shipping_address }}</p>
                                            @endif
                                            @if ($order->shipping_city || $order->shipping_state || $order->shipping_zip)
                                                <p class="mb-1">
                                                    @if ($order->shipping_city)
                                                        {{ $order->shipping_city }}
                                                    @endif
                                                    @if ($order->shipping_state)
                                                        , {{ $order->shipping_state }}
                                                    @endif
                                                    @if ($order->shipping_zip)
                                                        {{ $order->shipping_zip }}
                                                    @endif
                                                </p>
                                            @endif
                                            @if ($order->shipping_country)
                                                <p class="mb-0">{{ $order->shipping_country }}</p>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted mb-0">{{ __('dashboard.no_shipping_address') }}</p>
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

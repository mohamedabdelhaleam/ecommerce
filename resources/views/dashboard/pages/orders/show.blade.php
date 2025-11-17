@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Order Details - {{ $order->order_number }}</h6>
                    <div class="d-flex gap-2">
                        <form method="POST" action="{{ route('dashboard.orders.toggle-paid', $order) }}" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $order->is_paid ? 'warning' : 'success' }} btn-sm">
                                <i class="uil uil-{{ $order->is_paid ? 'times' : 'check' }}"></i>
                                Mark as {{ $order->is_paid ? 'Unpaid' : 'Paid' }}
                            </button>
                        </form>
                        <a href="{{ route('dashboard.orders.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> Back
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
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Order Items</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Variant</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
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
                                                                {{ $item->variant->size->name ?? 'N/A' }} /
                                                                {{ $item->variant->color->name ?? 'N/A' }}
                                                            @else
                                                                <span class="text-muted">N/A</span>
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
                                                    <td colspan="4" class="text-end"><strong>Order Total:</strong></td>
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
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Order Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Order Number</label>
                                        <h6 class="mb-0 fw-600">{{ $order->order_number }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Order Date</label>
                                        <h6 class="mb-0">{{ $order->created_at->format('M d, Y h:i A') }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Payment Status</label>
                                        <div>
                                            <span class="badge {{ $order->is_paid ? 'bg-success' : 'bg-warning' }}">
                                                {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Payment Method</label>
                                        <h6 class="mb-0">{{ ucfirst($order->payment_method) }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Total Amount</label>
                                        <h6 class="mb-0 fw-600">${{ number_format($order->total, 2) }}</h6>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Customer Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Name</label>
                                        <h6 class="mb-0">{{ $order->shipping_name }}</h6>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label text-muted small mb-1">Email</label>
                                        <h6 class="mb-0">{{ $order->shipping_email }}</h6>
                                    </div>
                                    @if ($order->shipping_phone)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small mb-1">Phone</label>
                                            <h6 class="mb-0">{{ $order->shipping_phone }}</h6>
                                        </div>
                                    @endif
                                    @if ($order->user)
                                        <div class="mb-3">
                                            <label class="form-label text-muted small mb-1">Registered User</label>
                                            <h6 class="mb-0">{{ $order->user->name }} ({{ $order->user->email }})</h6>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Shipping Address</h6>
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
                                        <p class="text-muted mb-0">No shipping address provided.</p>
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

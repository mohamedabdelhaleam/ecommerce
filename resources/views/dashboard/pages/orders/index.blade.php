@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>Orders</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form method="GET" action="{{ route('dashboard.orders.index') }}" class="row g-3">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search by order number, name, or email"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="is_paid">
                                        <option value="">All Payment Status</option>
                                        <option value="1" {{ request('is_paid') === '1' ? 'selected' : '' }}>Paid
                                        </option>
                                        <option value="0" {{ request('is_paid') === '0' ? 'selected' : '' }}>Unpaid
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('dashboard.orders.index') }}"
                                        class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Orders Table -->
                    <div class="userDatatable global-shadow border-light-0 w-100">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>Order Number</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($orders as $order)
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <div class="userDatatable-content">
                                                        <strong>{{ $order->order_number }}</strong>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ $order->shipping_name }}<br>
                                                    <small class="text-muted">{{ $order->shipping_email }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    ${{ number_format($order->total, 2) }}
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge {{ $order->is_paid ? 'bg-success' : 'bg-warning' }}">
                                                    {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ ucfirst($order->payment_method) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content">
                                                    {{ $order->created_at->format('M d, Y') }}<br>
                                                    <small
                                                        class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="userDatatable-content d-flex align-items-center">
                                                    <a href="{{ route('dashboard.orders.show', $order) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="uil uil-eye"></i> View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <p class="text-muted mb-0">No orders found.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="userDatatable global-shadow border-light-0 w-100">
    <div class="table-responsive">
        <table class="table mb-0 table-borderless">
            <thead>
                <tr class="userDatatable-header">
                    <th>{{ __('dashboard.order_number') }}</th>
                    <th>{{ __('dashboard.customer') }}</th>
                    <th>{{ __('dashboard.total') }}</th>
                    <th>{{ __('dashboard.payment_status') }}</th>
                    <th>{{ __('dashboard.payment_method') }}</th>
                    <th>{{ __('dashboard.date') }}</th>
                    <th>{{ __('dashboard.actions') }}</th>
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
                                {{ $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid') }}
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
                                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="userDatatable-content d-flex align-items-center">
                                <a href="{{ route('dashboard.orders.show', $order) }}" class="btn btn-sm">
                                    <i class="uil uil-eye"></i> {{ __('dashboard.view') }}
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <p class="text-muted mb-0">{{ __('dashboard.no_orders_found') }}</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

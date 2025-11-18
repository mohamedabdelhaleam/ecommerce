<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', 'Helvetica', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            background: #fff;
            padding: 20px;
        }

        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            border: 1px solid #ddd;
        }

        .invoice-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #333;
        }

        .company-info h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .company-info p {
            color: #666;
            margin: 5px 0;
        }

        .invoice-title {
            text-align: right;
        }

        .invoice-title h2 {
            font-size: 32px;
            color: #333;
            margin-bottom: 10px;
        }

        .invoice-title p {
            color: #666;
            font-size: 14px;
        }

        .invoice-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .detail-section h3 {
            font-size: 16px;
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }

        .detail-section p {
            margin: 8px 0;
            color: #555;
        }

        .detail-section strong {
            color: #333;
            display: inline-block;
            min-width: 120px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background-color: #333;
            color: #fff;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .items-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .items-table tfoot {
            background-color: #f5f5f5;
        }

        .items-table tfoot td {
            padding: 15px 12px;
            font-weight: 600;
            font-size: 16px;
            border-top: 2px solid #333;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #333;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 16px;
        }

        .total-row.final {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #333;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            color: #666;
            font-size: 12px;
        }

        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success {
            background-color: #28a745;
            color: #fff;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #333;
        }

        @media print {
            body {
                padding: 0;
            }

            .invoice-container {
                border: none;
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }

        @page {
            margin: 1cm;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>{{ config('app.name', 'E-Commerce Store') }}</h1>
                <p>{{ __('dashboard.invoice') }}</p>
                <p>{{ __('dashboard.order_number') }}: <strong>{{ $order->order_number }}</strong></p>
            </div>
            <div class="invoice-title">
                <h2>{{ __('dashboard.invoice') }}</h2>
                <p>{{ __('dashboard.date') }}: {{ $order->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <!-- Invoice Details -->
        <div class="invoice-details">
            <div class="detail-section">
                <h3>{{ __('dashboard.customer_information') }}</h3>
                <p><strong>{{ __('dashboard.name') }}:</strong> {{ $order->shipping_name }}</p>
                <p><strong>{{ __('dashboard.email') }}:</strong> {{ $order->shipping_email }}</p>
                @if ($order->shipping_phone)
                    <p><strong>{{ __('dashboard.phone') }}:</strong> {{ $order->shipping_phone }}</p>
                @endif
                @if ($order->user)
                    <p><strong>{{ __('dashboard.registered_user') }}:</strong> {{ $order->user->name }}</p>
                @endif
            </div>

            <div class="detail-section">
                <h3>{{ __('dashboard.order_information') }}</h3>
                <p><strong>{{ __('dashboard.order_number') }}:</strong> {{ $order->order_number }}</p>
                <p><strong>{{ __('dashboard.order_date') }}:</strong> {{ $order->created_at->format('M d, Y h:i A') }}
                </p>
                <p><strong>{{ __('dashboard.payment_status') }}:</strong>
                    <span class="badge {{ $order->is_paid ? 'badge-success' : 'badge-warning' }}">
                        {{ $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid') }}
                    </span>
                </p>
                <p><strong>{{ __('dashboard.payment_method') }}:</strong> {{ ucfirst($order->payment_method) }}</p>
            </div>
        </div>

        @if (
            $order->shipping_address ||
                $order->shipping_city ||
                $order->shipping_state ||
                $order->shipping_zip ||
                $order->shipping_country)
            <div class="detail-section" style="margin-bottom: 30px;">
                <h3>{{ __('dashboard.shipping_address') }}</h3>
                <p>
                    @if ($order->shipping_address)
                        {{ $order->shipping_address }}<br>
                    @endif
                    @if ($order->shipping_city || $order->shipping_state || $order->shipping_zip)
                        {{ $order->shipping_city }}{{ $order->shipping_state ? ', ' . $order->shipping_state : '' }}{{ $order->shipping_zip ? ' ' . $order->shipping_zip : '' }}<br>
                    @endif
                    @if ($order->shipping_country)
                        {{ $order->shipping_country }}
                    @endif
                </p>
            </div>
        @endif

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>{{ __('dashboard.product') }}</th>
                    <th>{{ __('dashboard.variant') }}</th>
                    <th class="text-center">{{ __('dashboard.quantity') }}</th>
                    <th class="text-right">{{ __('dashboard.price') }}</th>
                    <th class="text-right">{{ __('dashboard.total') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td><strong>{{ $item->product->name }}</strong></td>
                        <td>
                            @if ($item->variant)
                                {{ $item->variant->size->name ?? __('dashboard.na') }} /
                                {{ $item->variant->color->name ?? __('dashboard.na') }}
                            @else
                                <span class="text-muted">{{ __('dashboard.na') }}</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->quantity }}</td>
                        <td class="text-right">${{ number_format($item->price, 2) }}</td>
                        <td class="text-right"><strong>${{ number_format($item->total, 2) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right"><strong>{{ __('dashboard.order_total') }}:</strong></td>
                    <td class="text-right"><strong>${{ number_format($order->total, 2) }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer">
            <p>{{ __('dashboard.thank_you_for_your_order') }}</p>
            <p>{{ config('app.name', 'E-Commerce Store') }} - {{ __('dashboard.all_rights_reserved') }}</p>
        </div>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()"
            style="padding: 10px 20px; background: #333; color: #fff; border: none; cursor: pointer; font-size: 16px; border-radius: 4px;">
            {{ __('dashboard.print_invoice') }}
        </button>
    </div>
</body>

</html>

<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Collection;

class OrdersExport
{
    protected $orders;

    public function __construct($orders = null)
    {
        $this->orders = $orders ?? Order::with(['user', 'items.product', 'items.variant'])->get();
    }

    /**
     * Export orders to CSV format
     */
    public function exportToCsv()
    {
        $filename = 'orders-export-' . date('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Headers
            fputcsv($file, [
                __('dashboard.order_number'),
                __('dashboard.order_date'),
                __('dashboard.customer'),
                __('dashboard.email'),
                __('dashboard.phone'),
                __('dashboard.payment_status'),
                __('dashboard.payment_method'),
                __('dashboard.total'),
                __('dashboard.shipping_address'),
                __('dashboard.shipping_city'),
                __('dashboard.shipping_state'),
                __('dashboard.shipping_zip'),
                __('dashboard.shipping_country'),
                __('dashboard.registered_user'),
            ]);

            // Data rows
            foreach ($this->orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->shipping_name,
                    $order->shipping_email,
                    $order->shipping_phone ?? '',
                    $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid'),
                    ucfirst($order->payment_method),
                    number_format($order->total, 2),
                    $order->shipping_address ?? '',
                    $order->shipping_city ?? '',
                    $order->shipping_state ?? '',
                    $order->shipping_zip ?? '',
                    $order->shipping_country ?? '',
                    $order->user ? $order->user->name . ' (' . $order->user->email . ')' : '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export orders with items to CSV format
     */
    public function exportWithItemsToCsv()
    {
        $filename = 'orders-with-items-export-' . date('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Headers
            fputcsv($file, [
                __('dashboard.order_number'),
                __('dashboard.order_date'),
                __('dashboard.customer'),
                __('dashboard.email'),
                __('dashboard.product'),
                __('dashboard.variant'),
                __('dashboard.quantity'),
                __('dashboard.price'),
                __('dashboard.total'),
                __('dashboard.payment_status'),
                __('dashboard.payment_method'),
            ]);

            // Data rows - one row per order item
            foreach ($this->orders as $order) {
                $order->load(['items.product', 'items.variant.size', 'items.variant.color']);

                if ($order->items->count() > 0) {
                    foreach ($order->items as $item) {
                        $variant = '';
                        if ($item->variant) {
                            $variantParts = [];
                            if ($item->variant->size) {
                                $variantParts[] = $item->variant->size->name;
                            }
                            if ($item->variant->color) {
                                $variantParts[] = $item->variant->color->name;
                            }
                            $variant = implode(' / ', $variantParts);
                        }

                        fputcsv($file, [
                            $order->order_number,
                            $order->created_at->format('Y-m-d H:i:s'),
                            $order->shipping_name,
                            $order->shipping_email,
                            $item->product->name,
                            $variant ?: __('dashboard.na'),
                            $item->quantity,
                            number_format($item->price, 2),
                            number_format($item->total, 2),
                            $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid'),
                            ucfirst($order->payment_method),
                        ]);
                    }
                } else {
                    // Order with no items
                    fputcsv($file, [
                        $order->order_number,
                        $order->created_at->format('Y-m-d H:i:s'),
                        $order->shipping_name,
                        $order->shipping_email,
                        '',
                        '',
                        '',
                        '',
                        '',
                        $order->is_paid ? __('dashboard.paid') : __('dashboard.unpaid'),
                        ucfirst($order->payment_method),
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <x-dashboard.statics-card title="{{ __('dashboard.total_products') }}"
            value="{{ $totalProducts >= 100 ? $totalProducts . '+' : $totalProducts }}" percentage="{{ $productsPercentage }}"
            percentageText="{{ __('dashboard.since_last_month') }}" icon="<i class='uil uil-box'></i>" />
        <x-dashboard.statics-card title="{{ __('dashboard.total_orders') }}"
            value="{{ $totalOrders >= 100 ? $totalOrders . '+' : $totalOrders }}" percentage="{{ $ordersPercentage }}"
            percentageText="{{ __('dashboard.since_last_month') }}" icon="<i class='uil uil-shopping-cart'></i>" />
        <x-dashboard.statics-card title="{{ __('dashboard.total_customers') }}"
            value="{{ $totalCustomers >= 100 ? $totalCustomers . '+' : $totalCustomers }}"
            percentage="{{ $customersPercentage }}" percentageText="{{ __('dashboard.since_last_month') }}"
            icon="<i class='uil uil-users-alt'></i>" />
        <x-dashboard.statics-card title="{{ __('dashboard.total_revenue') }}"
            value="${{ number_format($totalRevenue, 2) }}" percentage="{{ $revenuePercentage }}"
            percentageText="{{ __('dashboard.since_last_month') }}" icon="<i class='uil uil-money-bill'></i>" />

    </div>
    <div class="row">
        <div class="col-xxl-6 mb-4">
            <div class="card">
                <div class="card-header">
                    {{ __('dashboard.products_chart') }}
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="productsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="card">
                <div class="card-header">
                    {{ __('dashboard.orders_chart') }}
                </div>
                <div class="card-body">
                    <div>
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="card border-0 px-25" style="height: 100% !important ;">
                <div class="card-header px-0 border-0">
                    <h6>{{ __('dashboard.new_product') }}</h6>

                </div>
                <div class="card-body p-0">
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="t_selling-month" role="tabpanel"
                            aria-labelledby="t_selling-month-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                            <tr class="userDatatable-header font-semibold">
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.product_name') }}</th>
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.price') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($productsMonth as $product)
                                                <tr>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                        <a href="{{ route('dashboard.products.show', $product['id']) }}"
                                                            class="text-decoration-none">
                                                            <div
                                                                class="selling-product-img  px-3 d-flex align-items-center {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                                                <img class="{{ app()->getLocale() == 'ar' ? 'ms-15' : 'me-15' }} wh-34 img-fluid order-bg-opacity-primary"
                                                                    src="{{ $product['image'] }}"
                                                                    alt="{{ $product['name'] }}">
                                                                <span>{{ $product['name'] }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}  px-3">
                                                        ${{ $product['price'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-4">
                                                        {{ __('dashboard.no_products_this_month') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="card border-0 px-25" style="height: 100% !important ;">
                <div class="card-header px-0 border-0">
                    <h6>{{ __('dashboard.new_customers') }}</h6>

                </div>
                <div class="card-body p-0">
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="t_customers-month" role="tabpanel"
                            aria-labelledby="t_customers-month-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                            <tr class="userDatatable-header font-semibold">
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.customer_name') }}</th>
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.phone') }}</th>
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.member_since') }}</th>
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.email') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($usersMonth as $user)
                                                <tr>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                        <a href="{{ route('dashboard.users.show', $user['id']) }}"
                                                            class="text-decoration-none">
                                                            <div class="selling-product-img  px-3 d-flex align-items-center">
                                                                <span>{{ $user['name'] }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}  px-3">
                                                        {{ $user['phone'] }}</td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}  px-3">
                                                        {{ $user['created_at']->format('d M Y') }}</td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}  px-3">
                                                        {{ $user['email'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">
                                                        {{ __('dashboard.no_customers_this_month') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="card border-0 px-25" style="height: 100% !important ;">
                <div class="card-header px-0 border-0">
                    <h6>{{ __('dashboard.top_customers') }}</h6>

                </div>
                <div class="card-body p-0">
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="t_top-customers" role="tabpanel"
                            aria-labelledby="t_top-customers-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                            <tr class="userDatatable-header font-semibold">
                                                <th
                                                    class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.customer_name') }}</th>
                                                <th
                                                    class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.phone') }}</th>
                                                <th
                                                    class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.member_since') }}</th>
                                                <th
                                                    class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.orders_count') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topCustomers as $customer)
                                                <tr>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                        <a href="{{ route('dashboard.users.show', $customer['id']) }}"
                                                            class="text-decoration-none">
                                                            <div
                                                                class="selling-product-img d-flex align-items-center px-3">
                                                                <span>{{ $customer['name'] }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }} px-3">
                                                        {{ $customer['phone'] }}</td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }} px-3">
                                                        {{ $customer['created_at']->format('d M Y') }}</td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }} px-3">
                                                        {{ $customer['orders_count'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="4" class="text-center text-muted py-4">
                                                        {{ __('dashboard.no_customers_found') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-6 mb-4">
            <div class="card border-0 px-25" style="height: 100% !important ;">
                <div class="card-header px-0 border-0">
                    <h6>{{ __('dashboard.top_products') }}</h6>

                </div>
                <div class="card-body p-0">
                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="t_top-products" role="tabpanel"
                            aria-labelledby="t_top-products-tab">
                            <div class="selling-table-wrap">
                                <div class="table-responsive">
                                    <table class="table mb-0 table-borderless">
                                        <thead>
                                            <tr class="userDatatable-header font-semibold">
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.product_name') }}</th>
                                                <th class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                    {{ __('dashboard.orders_count') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($topProducts as $product)
                                                <tr>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}">
                                                        <a href="{{ route('dashboard.products.show', $product['id']) }}"
                                                            class="text-decoration-none">
                                                            <div
                                                                class="selling-product-img d-flex  px-3 align-items-center {{ app()->getLocale() == 'ar' ? 'flex-row-reverse' : '' }}">
                                                                <img class="{{ app()->getLocale() == 'ar' ? 'ms-15' : 'me-15' }} wh-34 img-fluid order-bg-opacity-primary"
                                                                    src="{{ $product['image'] }}"
                                                                    alt="{{ $product['name'] }}">
                                                                <span>{{ $product['name'] }}</span>
                                                            </div>
                                                        </a>
                                                    </td>
                                                    <td
                                                        class="{{ app()->getLocale() == 'ar' ? 'text-end' : 'text-start' }}  px-3">
                                                        {{ $product['orders_count'] }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center text-muted py-4">
                                                        {{ __('dashboard.no_products_found') }}
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        exampleAreaChart("productsChart", "105",
            @json($productsChartData['data']),
            @json($productsChartData['labels']),
            "{{ __('dashboard.products') }}",
            true);
        exampleAreaChart("ordersChart", "105",
            @json($ordersChartData['data']),
            @json($ordersChartData['labels']),
            "{{ __('dashboard.orders') }}",
            true);
    </script>
@endsection

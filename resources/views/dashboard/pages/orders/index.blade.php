@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>{{ __('dashboard.orders') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="row g-3" id="orders-filter-form">
                                <div class="col-md-3">
                                    <input type="text" class="form-control filter-input" name="search" id="search-input"
                                        placeholder="{{ __('dashboard.search_by_order_number_name_email') }}"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control filter-input" name="is_paid" id="is_paid-select">
                                        <option value="">{{ __('dashboard.all_payment_status') }}</option>
                                        <option value="1" {{ request('is_paid') === '1' ? 'selected' : '' }}>
                                            {{ __('dashboard.paid') }}
                                        </option>
                                        <option value="0" {{ request('is_paid') === '0' ? 'selected' : '' }}>
                                            {{ __('dashboard.unpaid') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control filter-input" name="from_date"
                                        id="from_date-input" value="{{ request('from_date') }}"
                                        placeholder="{{ __('dashboard.from_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control filter-input" name="to_date"
                                        id="to_date-input" value="{{ request('to_date') }}"
                                        placeholder="{{ __('dashboard.to_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" id="reset-filters"
                                        class="btn btn-secondary w-100">{{ __('dashboard.reset') }}</button>
                                </div>
                            </div>
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
                    <div id="orders-table-container">
                        @include('dashboard.pages.orders.partials.table')
                    </div>

                    <!-- Pagination -->
                    <div id="orders-pagination-container">
                        @include('dashboard.pages.orders.partials.pagination')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let filterTimeout;
            const filterInputs = $('.filter-input');
            const ordersTableContainer = $('#orders-table-container');
            const ordersPaginationContainer = $('#orders-pagination-container');

            // Function to load orders via AJAX
            function loadOrders() {
                const formData = {
                    search: $('#search-input').val(),
                    is_paid: $('#is_paid-select').val(),
                    from_date: $('#from_date-input').val(),
                    to_date: $('#to_date-input').val(),
                };

                // Show loading indicator
                ordersTableContainer.html(
                    '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
                ordersPaginationContainer.html('');

                $.ajax({
                    url: '{{ route('dashboard.orders.index') }}',
                    type: 'GET',
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        ordersTableContainer.html(response.table);
                        ordersPaginationContainer.html(response.pagination);
                        // Update URL without reload
                        const newUrl = new URL(window.location.href);
                        Object.keys(formData).forEach(key => {
                            if (formData[key]) {
                                newUrl.searchParams.set(key, formData[key]);
                            } else {
                                newUrl.searchParams.delete(key);
                            }
                        });
                        newUrl.searchParams.delete('page'); // Reset to page 1 when filtering
                        window.history.pushState({}, '', newUrl);
                    },
                    error: function(xhr) {
                        console.error('Error loading orders:', xhr);
                        ordersTableContainer.html(
                            '<div class="alert alert-danger">Error loading orders. Please try again.</div>'
                        );
                    }
                });
            }

            // Debounced filter function (wait 500ms after user stops typing)
            function debouncedLoadOrders() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(function() {
                    loadOrders();
                }, 500);
            }

            // Attach event listeners to filter inputs
            filterInputs.on('input change', function() {
                debouncedLoadOrders();
            });

            // Reset filters button
            $('#reset-filters').on('click', function() {
                $('#search-input').val('');
                $('#is_paid-select').val('');
                $('#from_date-input').val('');
                $('#to_date-input').val('');
                loadOrders();
            });

            // Handle pagination links (they will be dynamically added)
            $(document).on('click', '#orders-pagination-container a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) {
                    // Extract page number from URL
                    try {
                        const urlObj = new URL(url);
                        const page = urlObj.searchParams.get('page');

                        const formData = {
                            search: $('#search-input').val(),
                            is_paid: $('#is_paid-select').val(),
                            from_date: $('#from_date-input').val(),
                            to_date: $('#to_date-input').val(),
                        };

                        if (page) {
                            formData.page = page;
                        }

                        ordersTableContainer.html(
                            '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                        ordersPaginationContainer.html('');

                        $.ajax({
                            url: '{{ route('dashboard.orders.index') }}',
                            type: 'GET',
                            data: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                ordersTableContainer.html(response.table);
                                ordersPaginationContainer.html(response.pagination);
                                // Update URL without reload
                                const newUrl = new URL(window.location.href);
                                Object.keys(formData).forEach(key => {
                                    if (formData[key]) {
                                        newUrl.searchParams.set(key, formData[key]);
                                    } else {
                                        newUrl.searchParams.delete(key);
                                    }
                                });
                                window.history.pushState({}, '', newUrl);
                                // Scroll to top of table
                                $('html, body').animate({
                                    scrollTop: ordersTableContainer.offset().top - 100
                                }, 300);
                            },
                            error: function(xhr) {
                                console.error('Error loading orders:', xhr);
                                ordersTableContainer.html(
                                    '<div class="alert alert-danger">Error loading orders. Please try again.</div>'
                                );
                            }
                        });
                    } catch (error) {
                        console.error('Error parsing URL:', error);
                    }
                }
            });
        });
    </script>
@endsection

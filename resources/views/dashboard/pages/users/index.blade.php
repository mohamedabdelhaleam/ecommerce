@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>{{ __('dashboard.users') }}</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="row g-3" id="users-filter-form">
                                <div class="col-md-4">
                                    <input type="text" class="form-control filter-input" name="search" id="search-input"
                                        placeholder="{{ __('dashboard.search_by_name_email_phone') }}"
                                        value="{{ request('search') }}">
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

                    <!-- Users Table -->
                    <div id="users-table-container">
                        @include('dashboard.pages.users.partials.table')
                    </div>

                    <!-- Pagination -->
                    <div id="users-pagination-container">
                        @include('dashboard.pages.users.partials.pagination')
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
            const usersTableContainer = $('#users-table-container');
            const usersPaginationContainer = $('#users-pagination-container');

            // Function to load users via AJAX
            function loadUsers() {
                const formData = {
                    search: $('#search-input').val(),
                    from_date: $('#from_date-input').val(),
                    to_date: $('#to_date-input').val(),
                };

                // Show loading indicator
                usersTableContainer.html(
                    '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                );
                usersPaginationContainer.html('');

                $.ajax({
                    url: '{{ route('dashboard.users.index') }}',
                    type: 'GET',
                    data: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        usersTableContainer.html(response.table);
                        usersPaginationContainer.html(response.pagination);
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
                        console.error('Error loading users:', xhr);
                        usersTableContainer.html(
                            '<div class="alert alert-danger">Error loading users. Please try again.</div>'
                        );
                    }
                });
            }

            // Debounced filter function (wait 500ms after user stops typing)
            function debouncedLoadUsers() {
                clearTimeout(filterTimeout);
                filterTimeout = setTimeout(function() {
                    loadUsers();
                }, 500);
            }

            // Attach event listeners to filter inputs
            filterInputs.on('input change', function() {
                debouncedLoadUsers();
            });

            // Reset filters button
            $('#reset-filters').on('click', function() {
                $('#search-input').val('');
                $('#from_date-input').val('');
                $('#to_date-input').val('');
                loadUsers();
            });

            // Handle pagination links
            $(document).on('click', '#users-pagination-container a', function(e) {
                e.preventDefault();
                const url = $(this).attr('href');
                if (url) {
                    try {
                        const urlObj = new URL(url);
                        const page = urlObj.searchParams.get('page');

                        const formData = {
                            search: $('#search-input').val(),
                            from_date: $('#from_date-input').val(),
                            to_date: $('#to_date-input').val(),
                        };

                        if (page) {
                            formData.page = page;
                        }

                        usersTableContainer.html(
                            '<div class="text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>'
                        );
                        usersPaginationContainer.html('');

                        $.ajax({
                            url: '{{ route('dashboard.users.index') }}',
                            type: 'GET',
                            data: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            success: function(response) {
                                usersTableContainer.html(response.table);
                                usersPaginationContainer.html(response.pagination);
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
                                    scrollTop: usersTableContainer.offset().top - 100
                                }, 300);
                            },
                            error: function(xhr) {
                                console.error('Error loading users:', xhr);
                                usersTableContainer.html(
                                    '<div class="alert alert-danger">Error loading users. Please try again.</div>'
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

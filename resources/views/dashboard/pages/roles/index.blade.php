@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>{{ __('dashboard.role_list') }}</span>
                    <a href="{{ route('dashboard.roles.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> {{ __('dashboard.add_new_role') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form id="role-search-form" class="row g-3"
                                data-search-url="{{ route('dashboard.roles.index') }}">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="{{ __('dashboard.search_by_name') }}" value="{{ request('search') }}">
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

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Roles Table -->
                    <div class="userDatatable global-shadow border-light-0 w-100">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="custom-checkbox check-all">
                                                    <input class="checkbox" type="checkbox" id="check-all-roles">
                                                    <label for="check-all-roles">
                                                        <span
                                                            class="checkbox-text userDatatable-title">{{ __('dashboard.role') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.permissions_count') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.users_count') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.created_date') }}</span>
                                        </th>
                                        <th>
                                            <span
                                                class="userDatatable-title float-end">{{ __('dashboard.actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="roles-table-body">
                                    @include('dashboard.pages.roles.partials.table')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="roles-pagination">
                        @if (method_exists($roles, 'links'))
                            <div class="mt-4">
                                {{ $roles->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('dashboard/assets/js/ajax-search.js') }}"></script>
@endsection

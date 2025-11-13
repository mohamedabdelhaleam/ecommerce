@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>{{ __('dashboard.coupon_list') }}</span>
                    <a href="{{ route('dashboard.coupons.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> {{ __('dashboard.add_new_coupon') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form id="coupon-search-form" class="row g-3"
                                data-search-url="{{ route('dashboard.coupons.index') }}">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="{{ __('dashboard.search_by_code_name') }}"
                                        value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="type" name="type">
                                        <option value="">{{ __('dashboard.all_types') }}</option>
                                        <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>
                                            {{ __('dashboard.percentage') }}</option>
                                        <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>
                                            {{ __('dashboard.fixed') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select class="form-control" id="is_active" name="is_active">
                                        <option value="">{{ __('dashboard.all_statuses') }}</option>
                                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>
                                            {{ __('dashboard.active') }}</option>
                                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>
                                            {{ __('dashboard.inactive') }}</option>
                                    </select>
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

                    <!-- Coupons Table -->
                    <div class="userDatatable global-shadow border-light-0 w-100">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="custom-checkbox check-all">
                                                    <input class="checkbox" type="checkbox" id="check-all-coupons">
                                                    <label for="check-all-coupons">
                                                        <span
                                                            class="checkbox-text userDatatable-title">{{ __('dashboard.coupon') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.discount') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.usage') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.expires_at') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.status') }}</span>
                                        </th>
                                        <th>
                                            <span
                                                class="userDatatable-title float-end">{{ __('dashboard.actions') }}</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="coupons-table-body">
                                    @include('dashboard.pages.coupons.partials.table')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="coupons-pagination">
                        @if (method_exists($coupons, 'links'))
                            <div class="mt-4">
                                {{ $coupons->links('pagination::bootstrap-5') }}
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

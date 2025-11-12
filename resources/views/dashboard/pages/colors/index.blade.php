@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>{{ __('dashboard.color_list') }}</span>
                    <a href="{{ route('dashboard.colors.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> {{ __('dashboard.add_new_color') }}
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form id="color-search-form" class="row g-3"
                                data-search-url="{{ route('dashboard.colors.index') }}">
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="{{ __('dashboard.search_by_name') }}" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="is_active" name="is_active">
                                        <option value="">{{ __('dashboard.all_status') }}</option>
                                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>
                                            {{ __('dashboard.active') }}
                                        </option>
                                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>
                                            {{ __('dashboard.inactive') }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" id="from_date" name="from_date"
                                        placeholder="{{ __('dashboard.from_date') }}" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="to_date" name="to_date"
                                        placeholder="{{ __('dashboard.to_date') }}" value="{{ request('to_date') }}">
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

                    <!-- Colors Table -->
                    <div class="userDatatable global-shadow border-light-0 w-100">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="custom-checkbox check-all">
                                                    <input class="checkbox" type="checkbox" id="check-all-colors">
                                                    <label for="check-all-colors">
                                                        <span
                                                            class="checkbox-text userDatatable-title">{{ __('dashboard.color') }}</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.hex_code') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.variants_count') }}</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">{{ __('dashboard.created_date') }}</span>
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
                                <tbody id="colors-table-body">
                                    @include('dashboard.pages.colors.partials.table')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="colors-pagination">
                        @if (method_exists($colors, 'links'))
                            <div class="mt-4">
                                {{ $colors->links('pagination::bootstrap-5') }}
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

@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>Product List</span>
                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> Add New Product
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <form id="product-search-form" class="row g-3"
                                data-search-url="{{ route('dashboard.products.index') }}">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" id="search" name="search"
                                        placeholder="Search by name (Arabic or English)" value="{{ request('search') }}">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" id="category_id" name="category_id">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name_ar ?? $category->name_en }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="is_active" name="is_active">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" id="from_date" name="from_date"
                                        placeholder="From Date" value="{{ request('from_date') }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" id="to_date" name="to_date"
                                        placeholder="To Date" value="{{ request('to_date') }}">
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

                    <!-- Products Table -->
                    <div class="userDatatable global-shadow border-light-0 w-100">
                        <div class="table-responsive">
                            <table class="table mb-0 table-borderless">
                                <thead>
                                    <tr class="userDatatable-header">
                                        <th>
                                            <div class="d-flex align-items-center">
                                                <div class="custom-checkbox check-all">
                                                    <input class="checkbox" type="checkbox" id="check-all-products">
                                                    <label for="check-all-products">
                                                        <span class="checkbox-text userDatatable-title">product</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">category</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">English Name</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">Stocks</span>
                                        </th>

                                        <th>
                                            <span class="userDatatable-title">created date</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title">status</span>
                                        </th>
                                        <th>
                                            <span class="userDatatable-title float-end">action</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="products-table-body">
                                    @include('dashboard.pages.products.partials.table')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div id="products-pagination">
                        @if (method_exists($products, 'links'))
                            <div class="mt-4">
                                {{ $products->links('pagination::bootstrap-5') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('dashboard/assets/js/ajax-product-search.js') }}"></script>
@endsection

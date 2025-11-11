@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">

        </div>
        <div class="col-lg-12 mb-30">
            <div class="card">
                <div class="card-header color-dark fw-500 d-flex justify-content-between align-items-center">
                    <span>Product List</span>
                    <a href="{{ route('dashboard.products.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> Add New Product
                    </a>
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
                                            <span class="userDatatable-title">Arabic Name</span>
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
                                <tbody>
                                    @include('dashboard.pages.products.partials.table')
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if (method_exists($products, 'links'))
                        <div class="mt-4">
                            {{ $products->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

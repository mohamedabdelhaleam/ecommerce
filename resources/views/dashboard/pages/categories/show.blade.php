@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Category Details</h6>
                    <div>
                        <a href="{{ route('dashboard.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                            <i class="uil uil-edit"></i> Edit
                        </a>
                        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <img src="{{ $category->image }}" alt="{{ $category->name_ar }}" class="img-fluid rounded"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="200">ID</th>
                                        <td>{{ $category->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name (Arabic)</th>
                                        <td>{{ $category->name_ar }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name (English)</th>
                                        <td>{{ $category->name_en ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>{{ $category->slug ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description (Arabic)</th>
                                        <td>{{ $category->description_ar ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description (English)</th>
                                        <td>{{ $category->description_en ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Products Count</th>
                                        <td>
                                            <span class="badge bg-info">{{ $category->products->count() ?? 0 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $category->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $category->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($category->products && $category->products->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6>Products in this Category</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Name (AR)</th>
                                                <th>Name (EN)</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($category->products as $product)
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td>
                                                        <img src="{{ $product->image }}" alt="{{ $product->name_ar }}"
                                                            class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                                    </td>
                                                    <td>{{ $product->name_ar }}</td>
                                                    <td>{{ $product->name_en ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($product->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


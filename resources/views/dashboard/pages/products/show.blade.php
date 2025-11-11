@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Product Details</h6>
                    <div>
                        <a href="{{ route('dashboard.products.edit', $product) }}" class="btn btn-warning btn-sm">
                            <i class="uil uil-edit"></i> Edit
                        </a>
                        <a href="{{ route('dashboard.products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-4">
                                <img src="{{ $product->image }}" alt="{{ $product->name_ar }}" class="img-fluid rounded"
                                    style="max-width: 100%; height: auto;">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th width="200">ID</th>
                                        <td>{{ $product->id }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name (Arabic)</th>
                                        <td>{{ $product->name_ar }}</td>
                                    </tr>
                                    <tr>
                                        <th>Name (English)</th>
                                        <td>{{ $product->name_en ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td>{{ $product->slug ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $product->category->name_ar ?? ($product->category->name_en ?? 'N/A') }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description (Arabic)</th>
                                        <td>{{ $product->description_ar ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description (English)</th>
                                        <td>{{ $product->description_en ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Created At</th>
                                        <td>{{ $product->created_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Updated At</th>
                                        <td>{{ $product->updated_at->format('Y-m-d H:i:s') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    @if ($product->images && $product->images->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6>Additional Images</h6>
                                <div class="row">
                                    @foreach ($product->images as $image)
                                        <div class="col-md-2 mb-3">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="Product Image"
                                                class="img-thumbnail" style="width: 100%; height: auto;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($product->variants && $product->variants->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6>Product Variants</h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Size</th>
                                                <th>Color</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->variants as $variant)
                                                <tr>
                                                    <td>{{ $variant->size->name ?? 'N/A' }}</td>
                                                    <td>{{ $variant->color->name ?? 'N/A' }}</td>
                                                    <td>{{ $variant->price ?? 'N/A' }}</td>
                                                    <td>{{ $variant->stock ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($variant->is_active)
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

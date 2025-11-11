@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Categories</h6>
                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> Add New Category
                    </a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('dashboard.categories.index') }}" class="mb-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}" placeholder="Search by name or description...">
                            </div>
                            <div class="col-md-4">
                                <label for="is_active" class="form-label">Status</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="">All</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="uil uil-search"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Categories Table -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name (AR)</th>
                                    <th>Name (EN)</th>
                                    <th>Products Count</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr id="category-row-{{ $category->id }}">
                                        <td>{{ $category->id }}</td>
                                        <td>
                                            <img src="{{ $category->image }}" alt="{{ $category->name_ar }}"
                                                class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        </td>
                                        <td>{{ $category->name_ar }}</td>
                                        <td>{{ $category->name_en ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $category->products->count() ?? 0 }}</span>
                                        </td>
                                        <td>
                                            @if ($category->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('dashboard.categories.show', $category) }}"
                                                    class="btn btn-sm btn-info" title="View">
                                                    <i class="uil uil-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.categories.edit', $category) }}"
                                                    class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="uil uil-edit"></i>
                                                </a>
                                                <x-dashboard.delete-button
                                                    route="{{ route('dashboard.categories.destroy', $category) }}"
                                                    item-id="{{ $category->id }}" item-name="{{ $category->name_ar }}"
                                                    item-type="category" table-row-id="category-row-{{ $category->id }}" />
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if (method_exists($categories, 'links'))
                        <div class="mt-4">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

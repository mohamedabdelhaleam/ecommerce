@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.category_list') }}</h6>
                    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="uil uil-plus"></i> {{ __('dashboard.add_new_category') }}
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
                                <label for="search" class="form-label">{{ __('dashboard.search') }}</label>
                                <input type="text" class="form-control" id="search" name="search"
                                    value="{{ request('search') }}"
                                    placeholder="{{ __('dashboard.search_by_name_or_description') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="is_active" class="form-label">{{ __('dashboard.status') }}</label>
                                <select class="form-control" id="is_active" name="is_active">
                                    <option value="">{{ __('dashboard.all') }}</option>
                                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>
                                        {{ __('dashboard.active') }}
                                    </option>
                                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>
                                        {{ __('dashboard.inactive') }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="uil uil-search"></i> {{ __('dashboard.filter') }}
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
                                    <th>{{ __('dashboard.product_image') }}</th>
                                    <th>{{ __('dashboard.name_arabic') }}</th>
                                    <th>{{ __('dashboard.name_english') }}</th>
                                    <th>{{ __('dashboard.products_count') }}</th>
                                    <th>{{ __('dashboard.status') }}</th>
                                    <th>{{ __('dashboard.created_at') }}</th>
                                    <th>{{ __('dashboard.actions') }}</th>
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
                                                <span class="badge bg-success">{{ __('dashboard.active') }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ __('dashboard.inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('dashboard.categories.show', $category) }}"
                                                    class="btn btn-sm btn-info" title="{{ __('dashboard.view') }}">
                                                    <i class="uil uil-eye"></i>
                                                </a>
                                                <a href="{{ route('dashboard.categories.edit', $category) }}"
                                                    class="btn btn-sm btn-warning" title="{{ __('dashboard.edit') }}">
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
                                        <td colspan="8" class="text-center">{{ __('dashboard.no_categories_found') }}
                                        </td>
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

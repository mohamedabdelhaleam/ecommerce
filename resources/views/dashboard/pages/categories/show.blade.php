@extends('dashboard.layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">{{ __('dashboard.category_details') }}</h6>
                    <div>
                        <a href="{{ route('dashboard.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                            <i class="uil uil-edit"></i> {{ __('dashboard.edit') }}
                        </a>
                        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary btn-sm">
                            <i class="uil uil-arrow-left"></i> {{ __('dashboard.back') }}
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 mb-4 mb-lg-0">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <div class="mb-3">
                                        <img src="{{ $category->image }}" alt="{{ $category->name }}"
                                            class="img-fluid rounded"
                                            style="max-width: 100%; height: auto; max-height: 300px;">
                                    </div>
                                    <h5 class="mb-2">{{ $category->name }}</h5>
                                    <p class="text-muted mb-0">CAT-{{ $category->id }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.name_arabic') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $category->name_ar }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.name_english') }}</label>
                                            <h6 class="mb-0 fw-600">{{ $category->name_en ?? 'N/A' }}</h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.status') }}</label>
                                            <div class="mt-1">
                                                <x-dashboard.status-switcher
                                                    route="{{ route('dashboard.categories.toggle-status', $category) }}"
                                                    item-id="{{ $category->id }}" is-active="{{ $category->is_active }}"
                                                    item-type="category" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.products_count') }}</label>
                                            <h6 class="mb-0">
                                                <span
                                                    class="badge bg-info fs-6 px-3 py-2">{{ $category->products->count() ?? 0 }}</span>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body p-3">
                                            <label
                                                class="form-label text-muted small mb-1">{{ __('dashboard.created_at') }}</label>
                                            <h6 class="mb-0 fw-600 small">
                                                @if (app()->getLocale() == 'ar')
                                                    {{ $category->created_at->locale('ar')->translatedFormat('d F Y H:i:s') }}
                                                @else
                                                    {{ $category->created_at->format('Y-m-d H:i:s') }}
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                                @if ($category->description_ar)
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <label
                                                    class="form-label text-muted small mb-2">{{ __('dashboard.description_arabic') }}</label>
                                                <p class="mb-0">{{ $category->description_ar }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if ($category->description_en)
                                    <div class="col-12">
                                        <div class="card border-0 shadow-sm">
                                            <div class="card-body p-3">
                                                <label
                                                    class="form-label text-muted small mb-2">{{ __('dashboard.description_english') }}</label>
                                                <p class="mb-0">{{ $category->description_en }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if ($category->products && $category->products->count() > 0)
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6 class="mb-3">{{ __('dashboard.products_in_category') }}</h6>
                                <div class="userDatatable global-shadow border-light-0 w-100">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless">
                                            <thead>
                                                <tr class="userDatatable-header">
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.product') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.stocks') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title">{{ __('dashboard.status') }}</span>
                                                    </th>
                                                    <th>
                                                        <span
                                                            class="userDatatable-title float-end">{{ __('dashboard.actions') }}</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($category->products as $product)
                                                    <tr id="product-row-{{ $product->id }}">
                                                        <td>
                                                            <div class="d-flex">
                                                                <div
                                                                    class="userDatatable__imgWrapper d-flex align-items-center">
                                                                    <a href="{{ route('dashboard.products.show', $product) }}"
                                                                        class="profile-image rounded-circle d-block m-0 wh-38"
                                                                        style="background-image:url({{ $product->image }}); background-size: cover;"></a>
                                                                </div>
                                                                <div class="userDatatable-inline-title">
                                                                    <a href="{{ route('dashboard.products.show', $product) }}"
                                                                        class="text-dark fw-500">
                                                                        <h6>{{ $product->name }}</h6>
                                                                    </a>
                                                                    <p class="d-block mb-0">
                                                                        PROD-{{ $product->id }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="userDatatable-content">
                                                                {{ $product->variants->sum('stock') }}
                                                            </div>
                                                        </td>
                                                        <td class="status-cell">
                                                            <div class="userDatatable-content d-inline-block">
                                                                <x-dashboard.status-switcher
                                                                    route="{{ route('dashboard.products.toggle-status', $product) }}"
                                                                    item-id="{{ $product->id }}"
                                                                    is-active="{{ $product->is_active }}"
                                                                    item-type="product" />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <ul
                                                                class="orderDatatable_actions mb-0 d-flex flex-wrap align-items-center">
                                                                <li>
                                                                    <a href="{{ route('dashboard.products.show', $product) }}"
                                                                        class="view">
                                                                        <i class="uil uil-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="{{ route('dashboard.products.edit', $product) }}"
                                                                        class="edit">
                                                                        <i class="uil uil-edit"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <x-dashboard.delete-button
                                                                        route="{{ route('dashboard.products.destroy', $product) }}"
                                                                        item-id="{{ $product->id }}"
                                                                        item-name="{{ $product->name }}"
                                                                        item-type="product"
                                                                        table-row-id="product-row-{{ $product->id }}" />
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

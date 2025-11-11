{{--
    Reusable AJAX Status Switcher Component
    
    Usage:
    <x-dashboard.status-switcher 
        route="{{ route('dashboard.products.toggle-status', $product) }}"
        item-id="{{ $product->id }}"
        is-active="{{ $product->is_active }}"
        item-type="product" />
    
    Parameters:
    - route: The toggle status route URL (required)
    - item-id: The ID of the item (required)
    - is-active: The current status (true/false) (required)
    - item-type: The type of item (e.g., 'product', 'category') - defaults to 'item' (optional)
    
    Requirements:
    - SweetAlert2 must be included
    - ajax-status-switcher.js must be included (already in dashboard scripts)
    - Controller must return JSON response for AJAX requests
--}}
@props(['route', 'itemId', 'isActive', 'itemType' => 'item'])

<div class="status-switcher-wrapper" data-toggle-url="{{ $route }}" data-item-id="{{ $itemId }}"
    data-item-type="{{ $itemType }}" data-csrf-token="{{ csrf_token() }}">
    <div class="form-check form-switch">
        <input class="form-check-input status-switcher-toggle" type="checkbox" id="status-switcher-{{ $itemId }}"
            {{ $isActive ? 'checked' : '' }} style="cursor: pointer;">
    </div>
</div>

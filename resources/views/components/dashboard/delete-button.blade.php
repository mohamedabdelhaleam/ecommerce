{{--
    Reusable AJAX Delete Button Component
    
    Usage:
    <x-dashboard.delete-button 
        route="{{ route('dashboard.items.destroy', $item) }}"
        item-id="{{ $item->id }}"
        item-name="{{ $item->name }}"
        item-type="item"
        table-row-id="row-{{ $item->id }}" />
    
    Parameters:
    - route: The delete route URL (required)
    - item-id: The ID of the item to delete (required)
    - item-name: The name/title of the item for confirmation message (required)
    - item-type: The type of item (e.g., 'product', 'category') - defaults to 'item' (optional)
    - table-row-id: The ID of the table row to remove after deletion - defaults to 'row-{itemId}' (optional)
    
    Requirements:
    - SweetAlert2 must be included
    - ajax-delete.js must be included (already in dashboard scripts)
    - Controller must return JSON response for AJAX requests
--}}
@props(['route', 'itemId', 'itemName', 'itemType' => 'item', 'tableRowId' => null])

<button type="button" class="remove border-0 bg-transparent ajax-delete-btn" style="cursor: pointer;"
    data-delete-url="{{ $route }}" data-item-id="{{ $itemId }}" data-item-name="{{ $itemName }}"
    data-item-type="{{ $itemType }}" data-table-row-id="{{ $tableRowId ?? 'row-' . $itemId }}"
    data-csrf-token="{{ csrf_token() }}">
    <i class="uil uil-trash-alt"></i>
</button>

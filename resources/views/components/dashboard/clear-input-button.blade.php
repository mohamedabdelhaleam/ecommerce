{{--
    Reusable Clear Input Button Component
    
    Usage:
    <x-dashboard.clear-input-button target-id="search" />
    
    Parameters:
    - target-id: The ID of the input/select element to clear (required)
    - trigger-search: Whether to trigger search after clearing (default: true) (optional)
    
    Requirements:
    - The target input/select must have an ID
    - If trigger-search is true, the search form must have a performSearch function or trigger change event
--}}
@props(['targetId', 'triggerSearch' => true])

<button type="button" class="clear-input-btn" data-target-id="{{ $targetId }}"
    data-trigger-search="{{ $triggerSearch ? 'true' : 'false' }}"
    style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); background: white; border: 1px solid #ddd; border-radius: 4px; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; cursor: pointer; padding: 0; z-index: 10;"
    title="Clear">
    <i class="uil uil-times" style="font-size: 14px; color: #666;"></i>
</button>

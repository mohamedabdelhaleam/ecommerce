<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\sizes\StoreSizeRequest;
use App\Http\Requests\Dashboard\sizes\UpdateSizeRequest;
use App\Repositories\Interfaces\SizeRepositoryInterface;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SizeController extends Controller
{
    protected SizeRepositoryInterface $sizeRepository;

    public function __construct(SizeRepositoryInterface $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    /**
     * Display a listing of the sizes.
     *
     * @param Request $request
     * @return View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'is_active' => $request->get('is_active'),
            'paginate' => true,
            'per_page' => 15,
            'order_by' => $request->get('order_by', 'order'),
            'order_direction' => $request->get('order_direction', 'asc'),
        ];

        $sizes = $this->sizeRepository->all($filters);

        // If AJAX request, return JSON with table HTML
        if ($request->ajax() || $request->wantsJson()) {
            $tableHtml = view('dashboard.pages.sizes.partials.table', compact('sizes'))->render();
            $paginationHtml = '';

            if ($sizes instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && method_exists($sizes, 'links')) {
                try {
                    $paginationView = call_user_func([$sizes, 'links'], 'pagination::bootstrap-5');
                    $paginationHtml = $paginationView ? $paginationView->render() : '';
                } catch (\Exception $e) {
                    $paginationHtml = '';
                }
            }

            return response()->json([
                'success' => true,
                'table' => $tableHtml,
                'pagination' => $paginationHtml,
            ]);
        }

        return view('dashboard.pages.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new size.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.sizes.create');
    }

    /**
     * Store a newly created size in storage.
     *
     * @param StoreSizeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreSizeRequest $request): RedirectResponse
    {
        $size = $this->sizeRepository->create($request->validated());

        return redirect()
            ->route('dashboard.sizes.index')
            ->with('success', 'Size created successfully.');
    }

    /**
     * Display the specified size.
     *
     * @param Size $size
     * @return View
     */
    public function show(Size $size): View
    {
        $size = $this->sizeRepository->findOrFail($size->id);
        return view('dashboard.pages.sizes.show', compact('size'));
    }

    /**
     * Show the form for editing the specified size.
     *
     * @param Size $size
     * @return View
     */
    public function edit(Size $size): View
    {
        $size = $this->sizeRepository->findOrFail($size->id);
        return view('dashboard.pages.sizes.edit', compact('size'));
    }

    /**
     * Update the specified size in storage.
     *
     * @param UpdateSizeRequest $request
     * @param Size $size
     * @return RedirectResponse
     */
    public function update(UpdateSizeRequest $request, Size $size): RedirectResponse
    {
        $size = $this->sizeRepository->findOrFail($size->id);

        $this->sizeRepository->update($size->id, $request->validated());

        return redirect()
            ->route('dashboard.sizes.index')
            ->with('success', 'Size updated successfully.');
    }

    /**
     * Toggle the status of the specified size.
     *
     * @param Request $request
     * @param Size $size
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, Size $size)
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $updatedSize = $this->sizeRepository->toggleStatus(
                $size->id,
                $validated['is_active']
            );

            return response()->json([
                'success' => true,
                'message' => 'Size status updated successfully.',
                'is_active' => $updatedSize->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update size status. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified size from storage.
     *
     * @param Size $size
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Size $size)
    {
        try {
            $this->sizeRepository->delete($size->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Size deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.sizes.index')
                ->with('success', 'Size deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete size. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.sizes.index')
                ->with('error', 'Failed to delete size. Please try again.');
        }
    }
}

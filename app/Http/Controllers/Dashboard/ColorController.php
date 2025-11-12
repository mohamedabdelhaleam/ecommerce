<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\colors\StoreColorRequest;
use App\Http\Requests\Dashboard\colors\UpdateColorRequest;
use App\Repositories\Interfaces\ColorRepositoryInterface;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ColorController extends Controller
{
    protected ColorRepositoryInterface $colorRepository;

    public function __construct(ColorRepositoryInterface $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    /**
     * Display a listing of the colors.
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
            'order_by' => $request->get('order_by', 'created_at'),
            'order_direction' => $request->get('order_direction', 'desc'),
        ];

        $colors = $this->colorRepository->all($filters);

        // If AJAX request, return JSON with table HTML
        if ($request->ajax() || $request->wantsJson()) {
            $tableHtml = view('dashboard.pages.colors.partials.table', compact('colors'))->render();
            $paginationHtml = '';

            if ($colors instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && method_exists($colors, 'links')) {
                try {
                    $paginationView = call_user_func([$colors, 'links'], 'pagination::bootstrap-5');
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

        return view('dashboard.pages.colors.index', compact('colors'));
    }

    /**
     * Show the form for creating a new color.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.colors.create');
    }

    /**
     * Store a newly created color in storage.
     *
     * @param StoreColorRequest $request
     * @return RedirectResponse
     */
    public function store(StoreColorRequest $request): RedirectResponse
    {
        $color = $this->colorRepository->create($request->validated());

        return redirect()
            ->route('dashboard.colors.index')
            ->with('success', 'Color created successfully.');
    }

    /**
     * Display the specified color.
     *
     * @param Color $color
     * @return View
     */
    public function show(Color $color): View
    {
        $color = $this->colorRepository->findOrFail($color->id);
        return view('dashboard.pages.colors.show', compact('color'));
    }

    /**
     * Show the form for editing the specified color.
     *
     * @param Color $color
     * @return View
     */
    public function edit(Color $color): View
    {
        $color = $this->colorRepository->findOrFail($color->id);
        return view('dashboard.pages.colors.edit', compact('color'));
    }

    /**
     * Update the specified color in storage.
     *
     * @param UpdateColorRequest $request
     * @param Color $color
     * @return RedirectResponse
     */
    public function update(UpdateColorRequest $request, Color $color): RedirectResponse
    {
        $color = $this->colorRepository->findOrFail($color->id);

        $this->colorRepository->update($color->id, $request->validated());

        return redirect()
            ->route('dashboard.colors.index')
            ->with('success', 'Color updated successfully.');
    }

    /**
     * Toggle the status of the specified color.
     *
     * @param Request $request
     * @param Color $color
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, Color $color)
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $updatedColor = $this->colorRepository->toggleStatus(
                $color->id,
                $validated['is_active']
            );

            return response()->json([
                'success' => true,
                'message' => 'Color status updated successfully.',
                'is_active' => $updatedColor->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update color status. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified color from storage.
     *
     * @param Color $color
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Color $color)
    {
        try {
            $this->colorRepository->delete($color->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Color deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.colors.index')
                ->with('success', 'Color deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete color. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.colors.index')
                ->with('error', 'Failed to delete color. Please try again.');
        }
    }
}

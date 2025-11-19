<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreCategoryRequest;
use App\Http\Requests\Dashboard\UpdateCategoryRequest;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;

        $this->middleware('permission:view categories')->only(['index', 'show']);
        $this->middleware('permission:create categories')->only(['create', 'store']);
        $this->middleware('permission:edit categories')->only(['edit', 'update']);
        $this->middleware('permission:delete categories')->only(['destroy']);
        $this->middleware('permission:toggle categories status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the categories.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'is_active' => $request->get('is_active'),
            'paginate' => true,
            'per_page' => 15,
            'order_by' => $request->get('order_by', 'created_at'),
            'order_direction' => $request->get('order_direction', 'desc'),
        ];

        $categories = $this->categoryRepository->all($filters);

        return view('dashboard.pages.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.categories.create');
    }

    /**
     * Store a newly created category in storage.
     *
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $this->categoryRepository->create($request->validated());

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function show(Category $category): View
    {
        $products = $category->products()
            ->with(['images'])
            ->withSum('variants as total_stock', 'stock')
            ->latest()
            ->paginate(10);

        return view('dashboard.pages.categories.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified category.
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        $category = $this->categoryRepository->findOrFail($category->id);
        return view('dashboard.pages.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $category = $this->categoryRepository->findOrFail($category->id);

        $this->categoryRepository->update($category->id, $request->validated());

        return redirect()
            ->route('dashboard.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Toggle the status of the specified category.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $updatedCategory = $this->categoryRepository->toggleStatus(
                $category->id,
                $validated['is_active']
            );

            return response()->json([
                'success' => true,
                'message' => 'Category status updated successfully.',
                'is_active' => $updatedCategory->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update category status. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified category from storage.
     *
     * @param Category $category
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        try {
            $this->categoryRepository->delete($category->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.categories.index')
                ->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete category. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.categories.index')
                ->with('error', 'Failed to delete category. Please try again.');
        }
    }
}

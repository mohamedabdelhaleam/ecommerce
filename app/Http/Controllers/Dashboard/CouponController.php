<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\coupons\StoreCouponRequest;
use App\Http\Requests\Dashboard\coupons\UpdateCouponRequest;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CouponController extends Controller
{
    protected CouponRepositoryInterface $couponRepository;

    public function __construct(CouponRepositoryInterface $couponRepository)
    {
        $this->couponRepository = $couponRepository;

        $this->middleware('permission:view coupons')->only(['index', 'show']);
        $this->middleware('permission:create coupons')->only(['create', 'store']);
        $this->middleware('permission:edit coupons')->only(['edit', 'update']);
        $this->middleware('permission:delete coupons')->only(['destroy']);
        $this->middleware('permission:toggle coupons status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the coupons.
     *
     * @param Request $request
     * @return View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'is_active' => $request->get('is_active'),
            'type' => $request->get('type'),
            'paginate' => true,
            'per_page' => 15,
            'order_by' => $request->get('order_by', 'created_at'),
            'order_direction' => $request->get('order_direction', 'desc'),
        ];

        $coupons = $this->couponRepository->all($filters);

        // If AJAX request, return JSON with table HTML
        if ($request->ajax() || $request->wantsJson()) {
            $tableHtml = view('dashboard.pages.coupons.partials.table', compact('coupons'))->render();
            $paginationHtml = '';

            if ($coupons instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && method_exists($coupons, 'links')) {
                try {
                    $paginationView = call_user_func([$coupons, 'links'], 'pagination::bootstrap-5');
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

        return view('dashboard.pages.coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new coupon.
     *
     * @return View
     */
    public function create(): View
    {
        return view('dashboard.pages.coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     *
     * @param StoreCouponRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCouponRequest $request): RedirectResponse
    {
        $coupon = $this->couponRepository->create($request->validated());

        return redirect()
            ->route('dashboard.coupons.index')
            ->with('success', 'Coupon created successfully.');
    }

    /**
     * Display the specified coupon.
     *
     * @param Coupon $coupon
     * @return View
     */
    public function show(Coupon $coupon): View
    {
        $coupon = $this->couponRepository->findOrFail($coupon->id);
        return view('dashboard.pages.coupons.show', compact('coupon'));
    }

    /**
     * Show the form for editing the specified coupon.
     *
     * @param Coupon $coupon
     * @return View
     */
    public function edit(Coupon $coupon): View
    {
        $coupon = $this->couponRepository->findOrFail($coupon->id);
        return view('dashboard.pages.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified coupon in storage.
     *
     * @param UpdateCouponRequest $request
     * @param Coupon $coupon
     * @return RedirectResponse
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        $coupon = $this->couponRepository->findOrFail($coupon->id);

        $this->couponRepository->update($coupon->id, $request->validated());

        return redirect()
            ->route('dashboard.coupons.index')
            ->with('success', 'Coupon updated successfully.');
    }

    /**
     * Toggle coupon status
     *
     * @param Coupon $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Coupon $coupon)
    {
        try {
            $coupon = $this->couponRepository->toggleStatus($coupon->id);

            return response()->json([
                'success' => true,
                'is_active' => $coupon->is_active,
                'message' => 'Coupon status updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update coupon status. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified coupon from storage.
     *
     * @param Coupon $coupon
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Coupon $coupon)
    {
        try {
            $this->couponRepository->delete($coupon->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.coupons.index')
                ->with('success', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete coupon. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.coupons.index')
                ->with('error', 'Failed to delete coupon. Please try again.');
        }
    }
}

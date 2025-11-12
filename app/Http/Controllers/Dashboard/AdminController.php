<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\admins\StoreAdminRequest;
use App\Http\Requests\Dashboard\admins\UpdateAdminRequest;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;

        $this->middleware('permission:view admins')->only(['index', 'show']);
        $this->middleware('permission:create admins')->only(['create', 'store']);
        $this->middleware('permission:edit admins')->only(['edit', 'update']);
        $this->middleware('permission:delete admins')->only(['destroy']);
        $this->middleware('permission:toggle admins status')->only(['toggleStatus']);
    }

    /**
     * Display a listing of the admins.
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

        $admins = $this->adminRepository->all($filters);

        // If AJAX request, return JSON with table HTML
        if ($request->ajax() || $request->wantsJson()) {
            $tableHtml = view('dashboard.pages.admins.partials.table', compact('admins'))->render();
            $paginationHtml = '';

            if ($admins instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && method_exists($admins, 'links')) {
                try {
                    $paginationView = call_user_func([$admins, 'links'], 'pagination::bootstrap-5');
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

        return view('dashboard.pages.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return View
     */
    public function create(): View
    {
        $roles = \Spatie\Permission\Models\Role::where('guard_name', 'admin')->orderBy('name')->get();
        return view('dashboard.pages.admins.create', compact('roles'));
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param StoreAdminRequest $request
     * @return RedirectResponse
     */
    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $admin = $this->adminRepository->create($request->validated());

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin created successfully.');
    }

    /**
     * Display the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function show(Admin $admin): View
    {
        $admin = $this->adminRepository->findOrFail($admin->id);
        $admin->load('roles');
        return view('dashboard.pages.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param Admin $admin
     * @return View
     */
    public function edit(Admin $admin): View
    {
        $admin = $this->adminRepository->findOrFail($admin->id);
        $admin->load('roles');
        $roles = \Spatie\Permission\Models\Role::where('guard_name', 'admin')->orderBy('name')->get();
        return view('dashboard.pages.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified admin in storage.
     *
     * @param UpdateAdminRequest $request
     * @param Admin $admin
     * @return RedirectResponse
     */
    public function update(UpdateAdminRequest $request, Admin $admin): RedirectResponse
    {
        $admin = $this->adminRepository->findOrFail($admin->id);

        $data = $request->validated();
        // Remove password_confirmation if present
        unset($data['password_confirmation']);

        $this->adminRepository->update($admin->id, $data);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin updated successfully.');
    }

    /**
     * Toggle the status of the specified admin.
     *
     * @param Request $request
     * @param Admin $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, Admin $admin)
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $updatedAdmin = $this->adminRepository->toggleStatus(
                $admin->id,
                $validated['is_active']
            );

            return response()->json([
                'success' => true,
                'message' => 'Admin status updated successfully.',
                'is_active' => $updatedAdmin->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update admin status. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param Admin $admin
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Admin $admin)
    {
        try {
            // Prevent deleting yourself
            if ($admin->id === auth('admin')->id()) {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'You cannot delete your own account.'
                    ], 403);
                }

                return redirect()
                    ->route('dashboard.admins.index')
                    ->with('error', 'You cannot delete your own account.');
            }

            $this->adminRepository->delete($admin->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Admin deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.admins.index')
                ->with('success', 'Admin deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete admin. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.admins.index')
                ->with('error', 'Failed to delete admin. Please try again.');
        }
    }
}

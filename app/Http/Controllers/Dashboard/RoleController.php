<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\roles\StoreRoleRequest;
use App\Http\Requests\Dashboard\roles\UpdateRoleRequest;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RoleController extends Controller
{
    protected RoleRepositoryInterface $roleRepository;

    public function __construct(RoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;

        $this->middleware('permission:view roles')->only(['index', 'show']);
        $this->middleware('permission:create roles')->only(['create', 'store']);
        $this->middleware('permission:edit roles')->only(['edit', 'update']);
        $this->middleware('permission:delete roles')->only(['destroy']);
    }

    /**
     * Display a listing of the roles.
     *
     * @param Request $request
     * @return View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'paginate' => true,
            'per_page' => 15,
            'order_by' => $request->get('order_by', 'created_at'),
            'order_direction' => $request->get('order_direction', 'desc'),
        ];

        $roles = $this->roleRepository->all($filters);

        // If AJAX request, return JSON with table HTML
        if ($request->ajax() || $request->wantsJson()) {
            $tableHtml = view('dashboard.pages.roles.partials.table', compact('roles'))->render();
            $paginationHtml = '';

            if ($roles instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && method_exists($roles, 'links')) {
                try {
                    $paginationView = call_user_func([$roles, 'links'], 'pagination::bootstrap-5');
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

        return view('dashboard.pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     *
     * @return View
     */
    public function create(): View
    {
        $permissions = Permission::where('guard_name', 'admin')->orderBy('name')->get();
        return view('dashboard.pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role in storage.
     *
     * @param StoreRoleRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        $role = $this->roleRepository->create($request->validated());

        return redirect()
            ->route('dashboard.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified role.
     *
     * @param Role $role
     * @return View
     */
    public function show(Role $role): View
    {
        $role = $this->roleRepository->findOrFail($role->id);
        $role->load('permissions');
        // Get users with this role
        $usersCount = \App\Models\Admin::role($role->name)->count();
        return view('dashboard.pages.roles.show', compact('role', 'usersCount'));
    }

    /**
     * Show the form for editing the specified role.
     *
     * @param Role $role
     * @return View
     */
    public function edit(Role $role): View
    {
        $role = $this->roleRepository->findOrFail($role->id);
        $role->load('permissions');
        $permissions = Permission::where('guard_name', 'admin')->orderBy('name')->get();
        return view('dashboard.pages.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified role in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return RedirectResponse
     */
    public function update(UpdateRoleRequest $request, Role $role): RedirectResponse
    {
        $role = $this->roleRepository->findOrFail($role->id);

        $this->roleRepository->update($role->id, $request->validated());

        return redirect()
            ->route('dashboard.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role from storage.
     *
     * @param Role $role
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        try {
            // Prevent deleting Super Admin role
            if ($role->name === 'Super Admin') {
                if (request()->ajax() || request()->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Cannot delete Super Admin role.'
                    ], 403);
                }

                return redirect()
                    ->route('dashboard.roles.index')
                    ->with('error', 'Cannot delete Super Admin role.');
            }

            $this->roleRepository->delete($role->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.roles.index')
                ->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete role. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.roles.index')
                ->with('error', 'Failed to delete role. Please try again.');
        }
    }
}

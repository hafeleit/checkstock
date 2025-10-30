<?php

namespace  App\Http\Controllers;

use App\Events\RoleCreated;
use App\Events\RoleDeleted;
use App\Events\RolePermissionsUpdated;
use App\Events\RoleUpdated;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role view', ['only' => ['index']]);
        $this->middleware('permission:role create', ['only' => ['create', 'store', 'addPermissionToRole', 'givePermissionToRole']]);
        $this->middleware('permission:role update', ['only' => ['update', 'edit']]);
        $this->middleware('permission:role delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $roles = Role::orderBy('name', 'asc')->get();
        return view('role-permission.role.index', ['roles' => $roles]);
    }

    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'unique:roles,name']
            ]);

            Role::create(['name' => $request->name]);

            event(new RoleCreated(auth()->id(), $role->id, 'pass', $request->name));
            return redirect('roles')->with('status', 'Role Created Successfully');
        } catch (ValidationException $e) {
            event(new RoleCreated(auth()->id(), null, 'fail', $request->name, $e->getMessage()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            event(new RoleCreated(auth()->id(), null, 'fail', $request->name, $th->getMessage()));
            return redirect('roles')->with('error', $th->getMessage());
        }
    }

    public function edit(Role $role)
    {
        return view('role-permission.role.edit', [
            'role' => $role
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $oldRoleName = $role->name;

        try {
            $request->validate([
                'name' => ['required', 'string', 'unique:roles,name,' . $role->id]
            ]);

            $role->update(['name' => $request->name]);

            event(new RoleUpdated(auth()->id(), 'pass', $role->id, $oldRoleName, $request->name));
            return redirect('roles')->with('status', 'Role Updated Successfully');
        } catch (ValidationException $e) {
            event(new RoleUpdated(auth()->id(), 'fail', $role->id, $oldRoleName, $request->name, $e->getMessage()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            event(new RoleUpdated(auth()->id(), 'fail', $role->id, $oldRoleName, $request->name, $th->getMessage()));
            return redirect('roles')->with('error', $th->getMessage());
        }
    }

    public function destroy($roleId)
    {
        try {
            $role = Role::findOrFail($roleId);
            $roleName = $role->name;
            $role->delete();

            event(new RoleDeleted(auth()->id(), 'pass', $roleId, $roleName));
            return redirect('roles')->with('status', 'Role Deleted Successfully');
        } catch (\Throwable $th) {
            $roleName = null;
            event(new RoleDeleted(auth()->id(), 'fail', $roleId, $roleName, $th->getMessage()));
            return redirect('roles')->with('error', 'Role Delete Failed');
        }
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        $role = Role::findOrFail($roleId);
        $rolePermissions =  DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        try {
            $request->validate([
                'permission' => 'required'
            ]);

            $role = Role::findOrFail($roleId);
            $oldPermissions = $role->permissions->pluck('name')->toArray();
            $newPermissions = $request->permission;

            $role->syncPermissions($request->permission);

            event(new RolePermissionsUpdated(auth()->id(), 'pass', $role->id, $oldPermissions, $newPermissions));
            return redirect()->back()->with('status', 'Permissions added to role');
        } catch (\Throwable $th) {
            $role = Role::find($roleId);
            $roleId = $role ? $role->id : null;
            $oldPermissions = $role ? $role->permissions->pluck('name')->toArray() : [];
            $newPermissions = $request->permission ?? [];

            event(new RolePermissionsUpdated(auth()->id(), 'fail', $roleId, $oldPermissions, $newPermissions, $th->getMessage()));
            return redirect()->back()->with('error', 'Failed to add permissions to role.');
        }
    }
}

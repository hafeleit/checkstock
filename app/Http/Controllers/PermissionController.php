<?php

namespace  App\Http\Controllers;

use App\Events\PermissionCreated;
use App\Events\PermissionDeleted;
use App\Events\PermissionUpdated;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use  Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:permission view', ['only' => ['index']]);
        $this->middleware('permission:permission create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission update', ['only' => ['update', 'edit']]);
        $this->middleware('permission:permission delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::orderBy('name', 'asc')->get();
        return view('role-permission.permission.index', ['permissions' => $permissions]);
    }

    public function create()
    {
        return view('role-permission.permission.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'unique:permissions,name']
            ]);

            $permission = Permission::create(['name' => $request->name]);

            event(new PermissionCreated(auth()->id(), $permission->id, 'pass', $request->name));
            return redirect('permissions')->with('status', 'Permission Created Successfully');
        } catch (ValidationException $e) {
            event(new PermissionCreated(auth()->id(), null, 'fail', $request->name, $e->getMessage()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            event(new PermissionCreated(auth()->id(), null, 'fail', $request->name, $th->getMessage()));
            return redirect('permissions')->with('error', $th->getMessage());
        }
    }

    public function edit(Permission $permission)
    {
        return view('role-permission.permission.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $oldPermissionName = $permission->name;

        try {
            $request->validate([
                'name' => ['required', 'string', 'unique:permissions,name,' . $permission->id]
            ]);

            $permission->update(['name' => $request->name]);

            event(new PermissionUpdated(auth()->id(), 'pass', $permission->id, $oldPermissionName, $request->name));
            return redirect('permissions')->with('status', 'Permission Updated Successfully');
        } catch (ValidationException $e) {
            event(new PermissionUpdated(auth()->id(), 'fail', $permission->id, $oldPermissionName, $request->name, $e->getMessage()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            event(new PermissionUpdated(auth()->id(), 'fail', $permission->id, $oldPermissionName, $request->name, $th->getMessage()));
            return redirect('permissions')->with('error', $th->getMessage());
        }
    }

    public function destroy($permissionId)
    {
        try {
            $permission = Permission::findOrFail($permissionId);
            $permissionName = $permission->name;
            $permission->delete();

            event(new PermissionDeleted(auth()->id(), 'pass', $permissionId, $permissionName));
            return redirect('permissions')->with('status', 'Permission Deleted Successfully');
        } catch (\Throwable $th) {
            $permissionName = null;
            event(new PermissionDeleted(auth()->id(), 'fail', $permissionId, $permissionName, $th->getMessage()));
            return redirect('permissions')->with('error', 'Permission Delete Failed');
        }
    }
}

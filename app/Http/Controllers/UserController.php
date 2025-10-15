<?php

namespace  App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:user view', ['only' => ['index']]);
        $this->middleware('permission:user create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user update', ['only' => ['update', 'edit']]);
        $this->middleware('permission:user delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::get();
        return view('role-permission.user.index', ['users' => $users]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            'roles' => 'required',
            'type' => 'required|string|in:employee,customer',
            'emp_code' => 'nullable|string|max:5',
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'supp_code' => $request->supp_code,
            'is_active' => $request->is_active ? true : false,
            'type' => $request->type,
            'emp_code' => $request->emp_code,
        ]);

        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User created successfully with roles');
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();

        return view('role-permission.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required',
            'type' => 'required|string|in:employee,customer',
            'emp_code' => 'nullable|string|max:5',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'supp_code' => $request->supp_code,
            'is_active' => $request->is_active ? true : false,
            'type' => $request->type,
            'emp_code' => $request->emp_code,
        ];

        if (!empty($request->password)) {
            $data += [
                'password' => $request->password,
            ];
        }

        $user->update($data);
        $user->syncRoles($request->roles);

        return redirect('/users')->with('status', 'User Updated Successfully with roles');
    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect('/users')->with('status', 'User Delete Successfully');
    }

    public function importUser()
    {

        $file = request()->file('user_file');

        if (!file_exists($file)) {
            return back()->withErrors('File not found: ' . $file->getClientOriginalName());
        }

        try {
            $rows = Excel::toArray([], $file)[0];
            $header = collect(array_shift($rows))->map('strtolower')->toArray();

            $importedCount = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                if (empty(array_filter($row))) {
                    continue;
                }

                $data = array_combine($header, $row);

                if (empty($data['role name'])) {
                    $errors[] = "Row " . ($index + 2) . " has no role name";
                    continue;
                }

                $roleName = trim($data['role name']);

                try {
                    $role = Role::where('name', $roleName)->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    $errors[] = "Role not found: {$roleName} (row " . ($index + 2) . ")";
                    continue;
                }

                $userData = [
                    'username' => $data['name'],
                    'supp_code' => $data['supp_code'],
                    'type' => $data['type'],
                ];

                if (!empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }

                $user = User::updateOrCreate(
                    ['email' => $data['email']],
                    $userData
                );

                if (!$user->hasRole($roleName)) {
                    $user->assignRole($role);
                }
                // ** uat ยังไม่ assign role ให้ customer user ที่ import เข้าไปใหม่ **
                // if (env("CUSTOMER_PROD")) {
                    // $user->assignRole($role);
                // }

                $importedCount++;
            }

            $successMessage = "Successfully imported {$importedCount} users";
            return redirect('/users')->with('status', $successMessage);
        } catch (\Throwable $th) {
            return back()->withErrors('An error occurred while processing the file: ' . $th->getMessage());
        }
    }
}

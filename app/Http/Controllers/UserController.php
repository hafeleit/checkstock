<?php

namespace  App\Http\Controllers;

use App\Events\FileImported;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        $users = User::query()
            ->when(request()->search, function ($q) {
                $q->where('email', 'LIKE', '%' . request()->search . '%')
                    ->orWhere('username', 'LIKE', '%' . request()->search . '%')
                    ->orWhere('firstname', 'LIKE', '%' . request()->search . '%')
                    ->orWhere('lastname', 'LIKE', '%' . request()->search . '%')
                    ->orWhere('emp_code', 'LIKE', '%' . request()->search . '%');
            })
            ->when(request()->sort && request()->direction, function ($q) {
                $q->orderBy('id', request()->direction);
            })
            ->paginate(50);

        return view('role-permission.user.index', [
            'users' => $users,
            'params' => request()->all()
        ]);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('role-permission.user.create', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        try {
            $messages = [
                'password.min' => 'password must be at least 15 characters long.',
                'password.regex' => 'password must include lowercase, uppercase, numbers, and special characters.',
            ];

            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|max:255|unique:users,email',
                'password' => [
                    'required',
                    'string',
                    'min:15',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[^a-zA-Z0-9]/',
                ],
                'roles' => 'required',
                'type' => 'required|string|in:employee,customer',
                'emp_code' => 'nullable|string|max:5',
            ], $messages);

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

            event(new UserCreated(auth()->user()->id, $user, 'pass'));
            return redirect('/users')->with('status', 'User created successfully with roles');
        } catch (ValidationException $e) {
            event(new UserCreated(auth()->user()->id, request()->all(), 'fail', $e->getMessage()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            event(new UserCreated(auth()->user()->id, request()->all(), 'fail', $th->getMessage()));
            return  back()->with('error', $th->getMessage());
        }
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
        $oldUser = $user;
        try {
            $messages = [
                'password.min' => 'password must be at least 15 characters long.',
                'password.regex' => 'password must include lowercase, uppercase, numbers, and special characters.',
            ];

            $request->validate([
                'username' => 'required|string|max:255',
                'password' => [
                    'nullable',
                    'string',
                    'min:15',
                    'regex:/[a-z]/',
                    'regex:/[A-Z]/',
                    'regex:/[0-9]/',
                    'regex:/[^a-zA-Z0-9]/',
                ],
                'roles' => 'required',
                'type' => 'required|string|in:employee,customer',
                'emp_code' => 'nullable|string|max:5',
                'supp_code' => 'nullable|string',
            ], $messages);

            $data = [
                'username' => $request->username,
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

            event(new UserUpdated(auth()->user()->id, $user->id, $data, $oldUser, 'pass'));
            return redirect('/users')->with('status', 'User Updated Successfully with roles');
        } catch (ValidationException $e) {
            event(new UserUpdated(auth()->user()->id, $user->id, request()->all(), $oldUser, 'fail', $e->getMessage()));
            return back()->withErrors($e->errors())->withInput();
        } catch (\Throwable $th) {
            event(new UserUpdated(auth()->user()->id, $user->id, request()->all(), $oldUser, 'fail', $th->getMessage()));
            return  back()->with('error', $th->getMessage());
        }
    }

    public function importUser()
    {
        $file = request()->file('user_file');
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();

        if (!file_exists($file)) {
            return back()->withErrors('File not found: ' . $file->getClientOriginalName());
        }

        try {
            request()->validate([
                'user_file' => 'required|file|mimes:csv,xls,xlsx'
            ]);

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

                $importedCount++;
            }

            event(new FileImported('App\Models\User', auth()->id(), 'import', 'pass', $fileName, $fileSize));
            $successMessage = "Successfully imported {$importedCount} users";
            return redirect('/users')->with('status', $successMessage);
        } catch (\Throwable $th) {
            event(new FileImported('App\Models\User', auth()->id(), 'import', 'fail', $fileName, $fileSize, $th->getMessage()));
            return back()->withErrors('An error occurred while processing the file: ' . $th->getMessage());
        }
    }
}

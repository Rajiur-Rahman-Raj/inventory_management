<?php

namespace App\Http\Controllers;

use App\Http\Traits\Upload;
use App\Models\Admin;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class RolesPermissionController extends Controller
{
    use Upload;
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function roleList(Request $request)
    {
        $admin = $this->user;
        $search = $request->all();

        $data['allRoles'] = Role::where('company_id', $admin->active_company_id)->get();


        $data['roles'] = Role::where('company_id', $admin->active_company_id)
            ->when(isset($search['role_id']), function ($q2) use ($search) {
                return $q2->where('id', $search['role_id']);
            })
            ->when(isset($search['status']) && $search['status'] == 'active', function ($q2) use ($search) {
                return $q2->where('status', 1);
            })
            ->when(isset($search['status']) && $search['status'] == 'deactive', function ($q2) use ($search) {
                return $q2->where('status', 0);
            })
            ->orderBy('id', 'asc')->paginate(config('basic.paginate'));
        return view($this->theme . 'user.role_permission.roleList', $data);
    }

    public function createRole()
    {
        return view($this->theme . 'user.role_permission.createRole');
    }

    public function roleStore(Request $request)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'name' => ['required'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required'],
        ];

        $message = [
            'name.required' => 'Role name field must be required',
            'permissions.required' => 'At least one menu permission is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $role = new Role();
        $role->company_id = $admin->active_company_id;
        $role->name = $request->name;
        $role->permission = (isset($request->permissions)) ? explode(',', join(',', $request->permissions)) : [];
        $role->status = $request->status;
        $role->save();

        return back()->with('success', 'New role created successfully!');
    }

    public function editRole($id)
    {
        $admin = $this->user;
        $data['singleRole'] = Role::where('company_id', $admin->active_company_id)->findOrFail($id);
        return view($this->theme . 'user.role_permission.editRole', $data);
    }

    public function roleUpdate(Request $request, $id)
    {
        $admin = $this->user;
        $purifiedData = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'name' => ['required'],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required'],
        ];

        $message = [
            'name.required' => 'Role name field must be required',
            'permissions.required' => 'At least one menu permission is required',
        ];

        $validate = Validator::make($purifiedData, $rules, $message);

        if ($validate->fails()) {
            return back()->withInput()->withErrors($validate);
        }

        $role = Role::where('company_id', $admin->active_company_id)->findOrFail($id);
        $role->company_id = $admin->active_company_id;
        $role->name = $request->name;
        $role->permission = (isset($request->permissions)) ? explode(',', join(',', $request->permissions)) : [];
        $role->status = $request->status;
        $role->save();

        return back()->with('success', 'Role updated successfully!');
    }

    public function deleteRole($id)
    {
        $role = Role::with(['roleUsers'])->find($id);
        if (count($role->roleUsers) > 0) {
            return back()->with('alert', 'This role has many users');
        }
        $role->delete();
        return back()->with('success', 'Delete successfully');
    }


    public function staffList()
    {
        $data['roleUsers'] = User::with('role')->whereNotNull('role_id')->where('role_id', '!=', 0)->orderBy('role_id', 'asc')->paginate(config('basic.paginate'));
        $data['roles'] = Role::where('status', 1)->orderBy('name', 'asc')->get();
        return view($this->theme . 'user.role_permission.staffList', $data);
    }

    public function staffCreate(Request $request)
    {
        $data['roles'] = Role::where('status', 1)->orderBy('name', 'asc')->get();
        return view($this->theme . 'user.role_permission.staffCreate', $data);
    }

    public function staffStore(Request $request)
    {
        $admin = $this->user;
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:50', 'unique:users,username'],
            'password' => ['required', 'string', 'min:6'],
            'role_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role_id;
        $user->user_type = 1;
        $user->active_company_id = $admin->active_company_id;
        $user->status = $request->status;


        if ($request->hasFile('image')) {
            try {
                $image = $this->fileUpload($request->image, config('location.user.path'), null, null, 'avif', null, null, null);
                if ($image) {
                    $user->image = $image['path'];
                    $user->driver = $image['driver'];
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $user->save();
        return back()->with('success', 'Staff Created Successfully!');
    }

    public function staffEdit($id){
        $data['singleStaff'] = User::findOrFail($id);
        $data['roles'] = Role::where('status', 1)->orderBy('name', 'asc')->get();
        return view($this->theme . 'user.role_permission.staffEdit', $data);
    }

    public function staffUpdate(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'username' => ['required', 'string', 'max:50'],
            'role_id' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->username = $request->username;
        $user->role_id = $request->role_id;
        $user->status = $request->status;

        if ($request->hasFile('image')) {
            try {
                $image = $this->fileUpload($request->image, config('location.user.path'), null, null, 'avif', null, $user->image, $user->driver);
                if ($image) {
                    $user->image = $image['path'];
                    $user->driver = $image['driver'];
                }
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }

        $user->save();
        return back()->with('success', 'Staff Updated Successfully!');
    }

}

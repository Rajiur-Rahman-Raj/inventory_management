<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stevebauman\Purify\Facades\Purify;

class RolesPermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function roleList(Request $request){
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

    public function createRole(){
        return view($this->theme . 'user.role_permission.createRole');
    }

    public function roleStore(Request $request){

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

    public function editRole($id){
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

}

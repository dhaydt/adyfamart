<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\AdminRole;
use App\Model\AdminWallet;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResellerController extends Controller
{
    public function add_new()
    {
        $rls = AdminRole::whereNotIn('id', [1])->get();

        return view('admin-views.reseller.add-new', compact('rls'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'image' => 'required',
            'address' => 'required',
            'password' => 'required|min:8',
            'email' => 'required|email|unique:users',
        ], [
            'name.required' => 'name is required!',
            'address.required' => 'Address Resller is required!',
            'email.required' => 'Email id is Required',
            'image.required' => 'Image is Required',
        ]);

        if ($request->role_id == 1) {
            Toastr::warning('Access Denied!');

            return back();
        }

        $role_id = AdminRole::where('name', 'reseller')->first('id');
        if (!$role_id) {
            $newRole = new AdminRole();
            $newRole->name = 'reseller';
            $newRole->module_access = json_encode(['order_management', 'user_section']);
            $newRole->save();

            $roles = $newRole->id;
        } else {
            $roles = $role_id['id'];
        }

        $code = Helpers::resellerCode();

        DB::table('admins')->insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'code_admin' => $code,
            'admin_type' => 'reseller',
            'admin_role_id' => $roles,
            'password' => bcrypt($request->password),
            'image' => ImageManager::upload('admin/', 'png', $request->file('image')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = Admin::where('code_admin', $code)->first();

        $saldo = new AdminWallet();
        $saldo->admin_id = $admin['id'];
        $saldo->saldo = 0;
        $saldo->save();

        Toastr::success('Reseller added successfully!');

        return redirect()->route('admin.reseller.list');
    }

    public function list()
    {
        $em = Admin::with(['role'])->where('admin_type', 'reseller')->paginate(Helpers::pagination_limit());

        return view('admin-views.reseller.list', compact('em'));
    }

    public function edit($id)
    {
        $e = Admin::where(['id' => $id])->first();
        $rls = AdminRole::whereNotIn('id', [1])->get();

        return view('admin-views.reseller.edit', compact('rls', 'e'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Mitra name is required!',
        ]);

        $e = Admin::find($id);
        if ($request['password'] == null) {
            $pass = $e['password'];
        } else {
            if (strlen($request['password']) < 7) {
                Toastr::warning('Password length must be 8 character.');

                return back();
            }
            $pass = bcrypt($request['password']);
        }

        if ($request->has('image')) {
            $e['image'] = ImageManager::update('admin/', $e['image'], 'png', $request->file('image'));
        }

        DB::table('admins')->where(['id' => $id])->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $pass,
            'image' => $e['image'],
            'updated_at' => now(),
        ]);

        Toastr::success('Reseller updated successfully!');

        return back();
    }
}

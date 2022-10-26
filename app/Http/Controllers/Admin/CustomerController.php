<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function customer_add()
    {
        return view('admin-views.customer.add');
    }

    public function post_customer_add(Request $request)
    {
        $numb = strval((int) $request['phone']);
        $user = User::where('email', $request->email)->orWhere('phone', $request->phone)->first();
        if (isset($user) && $user->is_phone_verified == 0 && $user->is_email_verified == 0) {
            return redirect(route('customer.auth.check', [$user->id]));
        }

        // dd($request);

        $request->validate([
            'name' => 'required',
            'phone' => 'required|unique:users',
        ],
            [
                'name.required' => 'Nama Kostumer diperlukan!',
                'phone.required' => 'Nomor HP Kostumer diperlukan!',
            ]);

        $id_reseller = session()->get('id_reseller');
        $id_member = Helpers::memberId();

        // dd($id_reseller, $id_member);

        $user = User::create([
            'f_name' => $request['name'],
            'email' => $request['email'],
            'phone' => $numb,
            'reseller_id' => $id_reseller,
            'id_member' => $id_member,
            'added_by' => 'reseller',
            'is_active' => 1,
            'is_email_verified' => 1,
            'password' => bcrypt(env('CUSTOMER_PASS')),
        ]);
        session()->put('pass', $request['password']);

        // $phone_verification = Helpers::get_business_settings('phone_verification');
        // $email_verification = Helpers::get_business_settings('email_verification');
        // if ($phone_verification && !$user->is_phone_verified) {
        //     return redirect(route('customer.auth.check', [$user->id]));
        // }
        // if ($email_verification && !$user->is_email_verified) {
        //     return redirect(route('customer.auth.check', [$user->id]));
        // }

        Toastr::success(translate('customer_added_successfully'));

        return redirect(route('admin.customer.list'));
    }

    public function customer_list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if (session()->get('admin_type') == 'reseller') {
            if ($request->has('search')) {
                $key = explode(' ', $request['search']);
                $customers = User::with(['orders'])->where(['added_by' => 'reseller', 'reseller_id' => session()->get('id_reseller')])
                    ->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('f_name', 'like', "%{$value}%")
                                ->orWhere('l_name', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%");
                        }
                    });
                $query_param = ['search' => $request['search']];
            } else {
                $customers = User::with(['orders'])->where(['added_by' => 'reseller', 'reseller_id' => session()->get('id_reseller')]);
            }
        } else {
            if ($request->has('search')) {
                $key = explode(' ', $request['search']);
                $customers = User::with(['orders'])
                    ->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('f_name', 'like', "%{$value}%")
                                ->orWhere('l_name', 'like', "%{$value}%")
                                ->orWhere('phone', 'like', "%{$value}%")
                                ->orWhere('email', 'like', "%{$value}%");
                        }
                    });
                $query_param = ['search' => $request['search']];
            } else {
                $customers = User::with(['orders']);
            }
        }
        $customers = $customers->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.customer.list', compact('customers', 'search'));
    }

    public function status_update(Request $request)
    {
        User::where(['id' => $request['id']])->update([
            'is_active' => $request['status'],
        ]);

        DB::table('oauth_access_tokens')
            ->where('user_id', $request['id'])
            ->delete();

        return response()->json([], 200);
    }

    public function view(Request $request, $id)
    {
        $customer = User::find($id);
        if (isset($customer)) {
            $query_param = [];
            $search = $request['search'];
            $orders = Order::where(['customer_id' => $id]);
            if ($request->has('search')) {
                $orders = $orders->where('id', 'like', "%{$search}%");
                $query_param = ['search' => $request['search']];
            }
            $orders = $orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

            return view('admin-views.customer.customer-view', compact('customer', 'orders', 'search'));
        }
        Toastr::error('Customer not found!');

        return back();
    }
}

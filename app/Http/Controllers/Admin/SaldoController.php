<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\AdminWallet;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function list(Request $request)
    {
        $query_param = [];
        $search = $request['search'];
        if ($request->has('search')) {
            $key = explode(' ', $request['search']);
            $sellers = Admin::with(['wallet'])->whereNotIn('id', [1])
                ->where(function ($q) use ($key) {
                    foreach ($key as $value) {
                        $q->orWhere('f_name', 'like', "%{$value}%")
                            ->orWhere('phone', 'like', "%{$value}%")
                            ->orWhere('code_admin', 'like', "%{$value}%")
                            ->orWhere('email', 'like', "%{$value}%");
                    }
                });
            $query_param = ['search' => $request['search']];
        } else {
            $sellers = Admin::with(['wallet'])->whereNotIn('id', [1]);
        }
        $sellers = $sellers->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.saldo.index', compact('sellers', 'search'));
    }

    public function saldoPost(Request $request)
    {
        $wallet = AdminWallet::where('admin_id', $request['id_admin'])->first();
        if (!$wallet) {
            $wallet = new AdminWallet();
            $wallet->admin_id = $request['id_admin'];
            $wallet->saldo = $request['saldo'];
        } else {
            $wallet->saldo = $request['saldo'];
        }
        $wallet->save();
        Toastr::success('Mitra saldo added successfully');

        return redirect()->back();
    }
}

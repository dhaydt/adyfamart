<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Periode;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class PeriodeController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Periode name is required!',
        ]);

        $check = Periode::where('name', $request->name)->first();

        if ($check) {
            Toastr::warning('Nama periode sudah digunakan!');

            return redirect()->back();
        } else {
            if ($request['status'] == 1) {
                $stat = Periode::where('status', 1)->get();
                foreach ($stat as $s) {
                    $s->status = 0;
                    $s->save();
                }
            }

            $per = new Periode();
            $per->name = $request['name'];
            $per->status = $request['status'];
            $per->save();

            Toastr::success('Periode berhasil ditambahkan');

            return redirect()->back();
        }
    }

    public function status(Request $request)
    {
        $id = $request->id;
        $val = $request->val;
        if ($val == 0) {
            $val = 1;
        } else {
            $val = 0;
        }

        if ($val == 1) {
            $stat = Periode::where('status', 1)->get();
            foreach ($stat as $s) {
                $s->status = 0;
                $s->save();
            }
        } else {
            return response()->json('fail');
        }

        $per = Periode::find($id);
        $per->status = $val;
        $per->save();

        return response()->json('success');
    }
}

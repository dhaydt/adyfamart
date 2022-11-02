<?php

namespace App\Http\Controllers\api\v1;

use App\Country;
use App\Http\Controllers\Controller;
use App\Model\Attribute;
use App\Model\BusinessSetting;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function term_and_condition()
    {
        $term = BusinessSetting::where('type', 'terms_condition')->first();
        $resp = [
            'status' => 'success',
            'data' => $term->value,
        ];

        return response()->json($resp, 200);
    }

    public function about_us()
    {
        $about_us = BusinessSetting::where('type', 'about_us')->first();
        $resp = [
            'status' => 'success',
            'data' => $about_us->value,
        ];

        return response()->json($resp, 200);
    }

    public function privacy_policy()
    {
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy')->first();
        $resp = [
            'status' => 'success',
            'data' => $privacy_policy->value,
        ];

        return response()->json($resp, 200);
    }

    public function contact_us()
    {
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy')->first();
        $resp = [
            'status' => 'success',
            'data' => $privacy_policy->value,
        ];

        return response()->json($resp, 200);
    }

    public function get_attributes()
    {
        $attributes = Attribute::all();

        return response()->json($attributes, 200);
    }

    public function short_country()
    {
        $country = Country::with('product')->has('product')->get();
        $count = $country->map(function ($country) {
            return ['country' => $country->country, 'country_name' => $country->country_name];
        });

        return response()->json($count, 200);
    }

    public function country()
    {
        $country = DB::table('country')->get();
        $count = $country->map(function ($country) {
            return ['country' => $country->country, 'country_name' => $country->country_name, 'phone' => $country->phonecode];
        });
        // $country['country'] = Helpers::product_data_formatting($country['country'], true);
        $response = [
            'title' => 'location store',
            'country_list' => $count,
        ];

        return response()->json($response, 200);
    }
}

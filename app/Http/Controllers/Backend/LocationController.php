<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Ward;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function district(Request $request)
    {

        $districts = District::whereRaw(1);

        if ($request->province_id)
            $districts->where('province_id', $request->province_id);

        $districts = $districts->get();

        if ($request->ajax()) {
            return response()->json($districts);
        }

        return  $districts;
    }

    public function ward(Request $request)
    {
        $wards = Ward::whereRaw(1);
        if ($request->district_id)
            $wards->where('district_id', $request->district_id);

        $wards = $wards->get();
        if ($request->ajax()) {
            return response()->json($wards);
        }

        return  $wards;
    }
}

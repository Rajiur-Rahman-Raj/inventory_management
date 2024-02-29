<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Union;
use App\Models\Upazila;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getSelectedDivisionDistrict(Request $request){
        $results = District::where('division_id', $request->id)->where('status', 1)->get();
        return response($results);
    }

    public function getSelectedDistrictUpazila(Request $request){
        $results = Upazila::where('district_id', $request->id)->where('status', 1)->get();
        return response($results);
    }

    public function getSelectedUpazilaUnion(Request $request){
        $results = Union::where('upazilla_id', $request->id)->where('status', 1)->get();
        return response($results);
    }
}

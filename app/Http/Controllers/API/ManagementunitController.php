<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Province;
use App\District;
use App\Village;
use App\Business;
Use App\Network;

class ManagementunitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getProvinces()
    {
        //
        $data = Province::get();

        return response()->json($data);
    }
    public function loadDistricts(){
        $data = District::get();

        return response()->json($data);

    }
    public function loadVillages(){
        $data = Village::get();

        return response()->json($data);
        
    }
    public function getDistricts(Request $request)
    {
       // dd($request->province_id);
       
        /* if($request->province_id < 10){
            $province_id = '0'. $request->province_id;
            //dd($request->province_id);
        }else{
            $province_id = $request->province_id;
        } */
        $province_id = $request->province_id;
        $data = District::where('ProID', $province_id)->get();
        return response()->json($data); 
    }
    public function getVillages(Request $request)
    {
        //
        //dd($request->district_id);
        /* if($request->district_id < 1000){
            $district_id = '0'. $request->district_id;
            //dd($request->province_id);
        }else{
            $district_id = $request->district_id;
        } */
        $data = Village::where('district_id', $request->district_id)->get();
        return response()->json($data);
    }

    //----------------------- business -------------------
    public function getBusinesses()
    {
        $businesses = DB::table('businesses')->get();
        return $businesses;
    }

    //--------------- network ----------------------
    public function getNetworks(Request $request)
    {
        //
        $networks = DB::table('networks')->get();
        return $networks;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

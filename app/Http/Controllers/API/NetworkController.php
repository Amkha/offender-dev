<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Network;
use App\Offender;

class NetworkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Network::latest()->paginate(10);
    }
    public function getNetworks($id){
        
        //dd($id);
        //$network_id = Offender::where('MainNetwork', $request->offender_id);
        //dd($network_id);
        $network = Network::where('id', $id)->get();
        //dd($network);
        //return response()->json($network);
        return $network;
    }
    public function getNetworkTrafficking(){
        return Network::all();
    }
        
    public function getNetworktypes(){
        $networktypes = DB::table('networktypes')->get();
        return $networktypes;
   }
   public function getNetworkCrimelevels(){
    $networkcrimelevels = DB::table('networkcrimelevel')->get();
    return $networkcrimelevels;
    }

    public function search()
    {
        if($search = \Request::get('q')){
            $networks = Network::where(function($query) use ($search){
                $query->where('MobName','LIKE',"%$search%")
                ->orWhere('NetworkActivity','LIKE',"%$search%")
                ->orWhere('NetworkType','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $networks = Network::latest()->paginate(10);
        }
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
        //dd($request->Photo);
        $this->validate($request, [
            'MobName' => 'required|string|max:100',
            'NetworkType' => 'required'
        ]);
        $User_id = auth()->user()->id;
        if($request->MobLogo){
            $name = time().'.' . explode('/', explode(':', substr($request->MobLogo, 0, strpos($request->MobLogo, ';')))[1])[1];          
            \Image::make($request->MobLogo)->save(public_path('storage/images/').$name);
            $request->merge(['MobLogo' => $name]);
           // dd($request->Photo);
        }
        return Network::create([
            'MobName' => $request['MobName'],
            'NetworkType' => $request['NetworkType'],
            'NetworkActivity' => $request['NetworkActivity'],
            'Country' => $request['Country'],
            'MainAddress' => $request['MainAddress'],
            'MemberNumber' => $request['MemberNumber'],
            'CrimeLevel' => $request['CrimeLevel'],
            'MobLogo' => $request['MobLogo'],
            'user_id' => $User_id,
        ]); 
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
    public function update(Request $request)
    {
        $id = $request->id;
        $network = Network::findOrFail($id);
       
       $this->validate($request, [
            'MobName' => 'required|string|max:100',
            'NetworkType' => 'required'
        ]);
        
        if(strlen($request->MobLogo) > 100 ){
            //dd('load..');
            $name = time().'.' . explode('/', explode(':', substr($request->MobLogo, 0, strpos($request->MobLogo, ';')))[1])[1];
           
            \Image::make($request->MobLogo)->save(public_path('storage/images/').$name);
            $request->merge(['MobLogo' => $name]);

            /* $offenderPhoto = public_path('storage/images/').$currentPhoto;
            dd($offenderPhoto);

            if(file_exists($offenderPhoto)){
                @unlink($offenderPhoto);
            } */
            
        }
        //dd('not loaded..');      
        $network->update($request->all());
       
        return ['message' => "Success"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $network = Network::findOrFail($id);
        $network->delete();
        return ['message' => 'Network deteleted..' ];
    }
}

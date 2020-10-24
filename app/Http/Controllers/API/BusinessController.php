<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Business;
use App\Offender;

class BusinessController extends Controller
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

   public function getCountries(){
        $countries = DB::table('countries')->get();
        return $countries;
   }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $posts=Post::all();
        return $posts; */
        $businesses = Business::latest()->paginate(10);
        return $businesses;
       /*  $business = Business::latest()->paginate(10);
        return response()->json($business); */
    }

    public function search()
    {
        if($search = \Request::get('q')){
            $businesses = Business::where(function($query) use ($search){
                $query->where('CompanyName','LIKE',"%$search%")->orWhere('Owner','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $businesses = Business::latest()->paginate(10);
        }
        return $businesses;
    }
    public function getAllBusinesses(){
        return Business::all();
    }
    public function getBusinesses($id){
        //dd($id);
        //$business_id = Offender::where('MainBusiness', $request->offender_id);
        //dd($business_id);
        $business = Business::where('id', $id)->get();
        //dd($business);
        return response()->json($business);
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
            'CompanyName' => 'required|string|max:100',
            'Owner' => 'required|string|max:100',
            'Email' => 'required|string|email|max:191|unique:users',
        ]);
        $User_id = auth()->user()->id;
        if($request->CompanyLogo){
            $name = time().'.' . explode('/', explode(':', substr($request->CompanyLogo, 0, strpos($request->CompanyLogo, ';')))[1])[1];          
            \Image::make($request->CompanyLogo)->save(public_path('storage/images/').$name);
            $request->merge(['CompanyLogo' => $name]);
           // dd($request->Photo);
        }
        return Business::create([
            'CompanyName' => $request['CompanyName'],
            'Owner' => $request['Owner'],
            'Activity' => $request['Activity'],
            'Country' => $request['Country'],
            'Address' => $request['Address'],
            'latitude' => $request['latitude'],
            'longtitude' => $request['longtitude'],
            'Phone' => $request['Phone'],
            'Email' => $request['Email'],
            'SocialNetwork' => $request['SocialNetwork'],
            'CompanyLogo' => $request['CompanyLogo'],
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
        $business = Business::findOrFail($id);
       
       $this->validate($request, [
            'CompanyName' => 'required|string|max:100',
            'Owner' => 'required|string|max:100',
        ]);
        
        if(strlen($request->CompanyLogo) > 100 ){
            //dd('load..');
            $name = time().'.' . explode('/', explode(':', substr($request->CompanyLogo, 0, strpos($request->CompanyLogo, ';')))[1])[1];
           
            \Image::make($request->CompanyLogo)->save(public_path('storage/images/').$name);
            $request->merge(['CompanyLogo' => $name]);

            /* $offenderPhoto = public_path('storage/images/').$currentPhoto;
            dd($offenderPhoto);

            if(file_exists($offenderPhoto)){
                @unlink($offenderPhoto);
            } */
            
        }
        //dd('not loaded..');      
        $business->update($request->all());
       
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
        $user = User::findOrFail($id);
        $user->delete();
        return ['message' => 'User deteleted..' ];
    }
}

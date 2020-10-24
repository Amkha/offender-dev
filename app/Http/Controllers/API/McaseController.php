<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\MCase;

class McaseController extends Controller
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
        //dd('MCase index..');
    }
    public function getAllCases(){
        return MCase::all();
    }
    public function getCases(Request $request){
        //dd($request->id);

        //$id = $request->id;
        //$cases = Mcase::findOrFail($id);
        $cases = MCase::where('offender_id', $request->offender_id)->orderBy('DetectedDate', 'DESC')->get();
        return response()->json($cases);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $offender_id)
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
       //dd($request);
       $User_id = auth()->user()->id;
       //dd($User_id);
       $this->validate($request, [
        'Type' => 'required',
        'DetectedDate' => 'required',
        ]);
    
        if($request->Evidence){
            $name = time().'.' . explode('/', explode(':', substr($request->Evidence, 0, strpos($request->Evidence, ';')))[1])[1];          
            \Image::make($request->Evidence)->save(public_path('/storage/images/').$name);
            $request->merge(['Evidence' => $name]);
           // dd($request->Photo);
        }
        return MCase::create([
            'offender_id' => $request['offender_id'],
            'DetectedDate' => $request['DetectedDate'],
            'Type' => $request['Type'],
            'ItemNumber' => $request['ItemNumber'],
            'Unit' => $request['Unit'],
            'Amount' => $request['Amount'],
            'CaseDescription' => $request['CaseDescription'],
            'Evidence' => $request['Evidence'],
            'Status' => $request['Status'],
            'Location' => $request['Location'],
            'Participant1' => $request['Participant1'],
            'Participant2' => $request['Participant2'],
            'Participant3' => $request['Participant3'],
            'Participant4' => $request['Participant4'],
            'Participant5' => $request['Participant5'],
            'Participant6' => $request['Participant6'],
            'User_id' => $User_id,
        ]); 
    }

    public function getCaseTypes()
    {
        $types = DB::table('casetype')->get();
        return $types;
    }
    public function getUnits()
    {
        $units = DB::table('units')->get();
        return $units;
    }
    public function getCaseStatus()
    {
        $statuses = DB::table('casestatus')->get();
        return $statuses;
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
        $case = MCase::findOrFail($id);
       
        $this->validate($request, [
            'Type' => 'required',
            'DetectedDate' => 'required',
            ]);
        /* 
        $currentPhoto = DB::table('offenders')
                    ->select('Photo')
                    ->where('id', $request->id)
                    ->get(); */
        
        // if select new photo then base64 image size is about > 6000, if not, length of image name in DB about < 100
        if(strlen($request->Evidence) > 100 ){
            //dd('load..');
            $name = time().'.' . explode('/', explode(':', substr($request->Evidence, 0, strpos($request->Evidence, ';')))[1])[1];
           
            \Image::make($request->Evidence)->save(public_path('storage/images/').$name);
            $request->merge(['Evidence' => $name]);

            /* $offenderPhoto = public_path('storage/images/').$currentPhoto;
            dd($offenderPhoto);

            if(file_exists($offenderPhoto)){
                @unlink($offenderPhoto);
            } */
            
        }
        //dd('not loaded..');      
        $case->update($request->all());
       
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
        $case = MCase::findOrFail($id);
        $case->delete();
        return ['message' => 'Case deteleted..' ];
    }
}

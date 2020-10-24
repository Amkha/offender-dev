<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\DB;
use App\Offender;

class OffenderController extends Controller
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
        /* $nationalities = DB::table('nationalities')->get();
        $Offender = Offender::latest()->paginate(10); */
        
        return Offender::latest()->paginate(10);
        /* retrun {
            $Offender,
            $nationalities
        }; */
    }
    public function getAlloffenders(){
        return Offender::all();
    }
    //----- search -------
    public function search()
    {
        if($search = \Request::get('q')){
            $offenders = Offender::where(function($query) use ($search){
                $query->where('FirstName','LIKE',"%$search%")
                        ->orWhere('LastName','LIKE',"%$search%")
                        ->orWhere('Gender','LIKE',"%$search%")
                        ->orWhere('Age','LIKE',"%$search%")
                        ->orWhere('Nationality','LIKE',"%$search%")
                        ->orWhere('IDCardNumber','LIKE',"%$search%");
            })->paginate(10);
        }else{
            $offenders = Offender::latest()->paginate(10);
        }
        return $offenders;
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
            'FirstName' => 'required|string|max:100',
            'LastName' => 'required|string|max:100',
        ]);
        
       // $currentPhoto = $request->Photo;
        $User_id = auth()->user()->id;
//dd('Usr..:' . $User_id);
        if($request->Photo){
            $name = time().'.' . explode('/', explode(':', substr($request->Photo, 0, strpos($request->Photo, ';')))[1])[1];
           
            \Image::make($request->Photo)->save(public_path('storage/images/').$name);
            $request->merge(['Photo' => $name]);

           // dd($request->Photo);

        //    $userPhoto = public_path('/images/').$currentPhoto;
        //    if(file_exists($userPhoto)){
        //        @unlink($userPhoto);
        //    }

        }

     /*    if($request->hasFile('Photo')){
            //Get file name with extension getClientOriginalName()
            $fileNameWithExtension = $request->file('Photo')->getClientOriginalName();
            // get just file name
            $fileName = pathinfo($fileNameWithExtension, PATHINFO_FILENAME);
            // get just ext
            $extension = $request->file('Photo')->getClientOriginalExtension();
            // file name to stor
            $fileNameToStore = $fileName . '_'. Time(). '.'. $extension;
            // Upload image
            $path = $request->file('Photo')->storeAs('/public/images/', $fileNameToStore);
        }else{
            $fileNameToStore = 'noimage.jpg';
        }*/
        return Offender::create([
            'FirstName' => $request['FirstName'],
            'LastName' => $request['LastName'],
            'Age' => $request['Age'],
            'Gender' => $request['Gender'],
            'IDCardNumber' => $request['IDCardNumber'],
            'Occupation' => $request['Occupation'],
            'Nationality' => $request['Nationality'],
            'Address' => $request['Address'],
            'Province' => $request['Province'],
            'District' => $request['District'],
            'Village' => $request['Village'],
            'MainBusiness' => $request['MainBusiness'],
            'MainNetwork' => $request['MainNetwork'],
            'Photo' => $request['Photo'],
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $id = $request->id;
        $offender = Offender::findOrFail($id);
       
       $this->validate($request, [
        'FirstName' => 'required|string|max:100',
        'LastName' => 'required|string|max:100',
        ]);
        //$offender = new Offender;
        $currentPhoto = DB::table('offenders')
                    ->select('Photo')
                    ->where('id', $request->id)
                    ->get();
        //$l = strlen($request->Photo);
        //dd(strlen($request->Photo)); 
        // if select new photo then base64 image size is about > 6000, if not, length of image name in DB about < 100
        if(strlen($request->Photo) > 100 ){
            //dd('load..');
            $name = time().'.' . explode('/', explode(':', substr($request->Photo, 0, strpos($request->Photo, ';')))[1])[1];
           
            \Image::make($request->Photo)->save(public_path('storage/images/').$name);
            $request->merge(['Photo' => $name]);

            /* $offenderPhoto = public_path('storage/images/').$currentPhoto;
            dd($offenderPhoto);

            if(file_exists($offenderPhoto)){
                @unlink($offenderPhoto);
            } */
            
        }
        //dd('not loaded..');      
        $offender->update($request->all());
       
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
        $offender = Offender::findOrFail($id);
        $offender->delete();
        return ['message' => 'Offender deteleted..' ];
    }
}

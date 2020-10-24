<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;


class UsermanageController extends Controller
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
        return User::latest()->paginate(10);
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'sometimes|required|min:6',
            'type' => 'required'
        ]);
        /* $User_id = auth()->user()->id;
        if($request->MobLogo){
            $name = time().'.' . explode('/', explode(':', substr($request->MobLogo, 0, strpos($request->MobLogo, ';')))[1])[1];          
            \Image::make($request->MobLogo)->save(public_path('storage/images/').$name);
            $request->merge(['MobLogo' => $name]);
           // dd($request->Photo);
        } */
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            //'password' => $request['password'],
            'password' => Hash::make($request['password']),
            'type' => $request['type'],
        ]); 
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|email',
            'password' => 'sometimes|required|min:6'
        ]);


        // $currentPhoto = $user->photo;


        // if($request->photo != $currentPhoto){
        //     $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];

        //     \Image::make($request->photo)->save(public_path('img/profile/').$name);
        //     $request->merge(['photo' => $name]);

        //     $userPhoto = public_path('img/profile/').$currentPhoto;
        //     if(file_exists($userPhoto)){
        //         @unlink($userPhoto);
        //     }

        // }


        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }


        $user->update($request->all());
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

    public function getUser($id){
        
        //dd($id);
        //$network_id = Offender::where('MainNetwork', $request->offender_id);
        //dd($network_id);
        $network = Network::where('id', $id)->get();
        //dd($network);
        //return response()->json($network);
        return $network;
    }
}
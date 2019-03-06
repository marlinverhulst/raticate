<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UsersController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->json([
            'users' => $users
        ],200);
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
        $request->validate([
            'name' =>'required',
            'email' => 'required',
            'password' =>'required',
            'role_id'=> 'required']);
            
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'User been added'
        ],200);
        
        
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
        $request->validate([
            'name' =>'required',
            'email' => 'required',
            
            'role_id'=> 'required']);
            if($request->password){
                
                $user = User::findOrFail($id)->update(['name' => $request->name,'email' => $request->email,
            
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id,]);
                
                return response()->json([
                    'user' => $user,
                    'message' => 'user has been updated'
                ]);

            } 
            else {
                $user = User::findOrFail($id);
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role_id = $request->role_id;
                $user->save();
                return response()->json([
                    'user' => $user,
                    'message' => 'user has been updated'
                ]);
            }


            

            
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $user->delete();
        return response()->json([
            'user' => $user,
            'message' => 'User has been deleted'
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       return  User::paginate(10);
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
    
    public function search(Request $request){
     
     $findUser = User::where('email','LIKE',"%$request->q%")->orWhere('name','LIKE',"%$request->q")->paginate(10);
     return $findUser;

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
        $request->validate([
            'email' => 'required|unique:users|max:255|email',
            'name' => 'required',
        ]);
        $createUser = User::create(['email' => $request->email,
                                   'name' => $request->name,
                                   'password' => bcrypt('rahasia'),
                                   'konfirmasi_admin' => 1]);
        if($createUser){
          return response(200);    
        } else {
          return response(500);    
        }
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
        
        $user = User::find($id);

        return $user;
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
        $request->validate([
            'email' => 'required|unique:users,email,'.$id.'|max:255|email',
            'name' => 'required',
        ]);

        $updateUser = User::find($id)->update(['email' => $request->email,'name' => $request->name]);
        if($updateUser){
         return response(200);    
        } else {
         return response(500);    
        }

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
       $deleteUser =  User::destroy($id);
       if($deleteUser){
         return response(200);    
       } else {
         return response(500);    
       }
    }

    public function konfirmasiUser($id){
        
       $konfirmasiUser = User::find($id)->update(['konfirmasi_admin' => 1]);
       if($konfirmasiUser) {
          return response(200);    
       } else {
          return response(500);    
       }
    }
}

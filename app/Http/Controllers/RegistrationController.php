<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Validator;
use Hash;
use Session;


class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view("auth.login");
    }
    public function Registration()
    {
        return view("auth.registration");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createuser(Request $request)
    {
      
        $this->validate(
            $request,[
            'name' => 'required||regex:/^[a-zA-ZÑñ\s]+$/',
            'email' => 'required|email|unique:registrations',
            'password' => 'required|max:8|',
          
        ],[
            'name.regex'=>"name contain only letters",
            'password.max'=>'password lenght must be 8'
        ]
    );
        
        $user =new Registration;
        $user->name=$request->name;
        $user->email =$request->email;
        $user->password =Hash::make($request->password);
        $res=$user->save();
        if($res)
        {
            return back()->with('success','You have registered successfully');
        }else{
            return back()->with('fail','something went wrong');
        }
    }

    public function loginUser(Request $request)
    {
        $this->validate(
            $request,[
            'email' => 'required|email',
            'password' => 'required|max:8|',
          
        ],[
            'name.regex'=>"name contain only letters",
            'password.max'=>'password lenght must be 8'
        ]
    );

        $user=Registration::where('email','=',$request->email)->first();
        if($user)
        {
            if(Hash::check($request->password,$user->password)){
            $request->session()->put('loginId',$user->id);
            return view('dashboard',compact('user'));
            }else
            {
                return back()->with('fail','Password not matches');
            }
        }else
        {
            return back()->with('fail','The email is not registred');

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = array();
        if(Session::has('loginId'))
    {
        $user= Registration::where('id','=', Session::get('loginId'))->first();
        return view('dashboard',compact('user'));

    }
    return view('login');
    }  

    
    public function logout(Registration $registration)
    {
        if(Session::has('loginId')){
            Session::pull('loginId');
            return redirect ('login');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    // public function login_check(Request $request)
    // {
    //     if(Session::has('loginId')){

    
            
    //         return redirect ('login');
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        //
    }
}

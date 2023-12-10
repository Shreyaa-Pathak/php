<?php

namespace App\Http\Controllers;
// use App\Http\Middleware;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }
    public function login(){
        return view('login');
    }
    public function register(){
       
        return view('register');
    }
    public function store(){
        request()->validate(['email'=>'required| unique:users,email|email','name'=>'required|min:5']);
        $user = new User;

        $user->name = request('name');
        $user->email = request('email');
        $user->password= request('password');
        $user->save();
        return redirect('login');
    }
    public function users(){
        $users = User::all();
        return view('users',compact('users'));
    }
    public function edit($id){
        $user = User::find($id);
     
        //return request()->all();
        //return $user;
        return view('edit',compact('user'));
    }
    public function update($id){
        request()->validate(['email'=>'required| unique:users,email|email','name'=>'required|min:5']);
        $user = User::find($id);
        $user->name = request('name');
        $user->email = request('email');
        $user->save();
        return redirect('users');
    }
    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return redirect('users');
    }
    public function verify(){
        //return request()->all();
        request()->validate(['email'=>'required|email','password'=>'required']);
        if(auth()->attempt(['email'=>request('email'),'password'=>request('password')])){
           // return auth()->user();
           return redirect('home');
        }
        return redirect('login')->withErrors('Wrong email or password!');
    }
}

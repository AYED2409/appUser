<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    
    function __construct() {
        $this-> middleware(\App\Http\Middleware\AdminMiddleware::class);
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $users = $this->getData();
        return view('admin.index',['users'=>$users,'myUser'=>auth()->user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $types=['normal','advanced','admin'];
        return view ('admin.create',['types'=>$types,'myUser'=>auth()->user()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
        $request->validate([
            'name' => 'required',
            'email'=> 'required|unique:users,email|email',
            'type'=>'required|in:normal,advanced,admin',
            'password'=> 'required',
            'passwordActual'=> 'required',
        ]);
        $myUser = auth()->user();
        if(Hash::check($request->passwordActual,$myUser->password) ) {
                // return back()->with('message','contraseña coincide');
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('admin')->with('message','Usuario '.$user->name. ' creado Correctamente');
        }else {
            return back()->with('error','contraseña Actual incorrecta')->withInput();
        }
        
        // $user = new User($request->all());
        // $user->password = Hash::make($request->password);
        // $user->save();
        // return redirect('admin')->with('message','Usuario '.$user->name. ' creado Correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
        $myUser = auth()->user();
        $user = User::findOrFail($id);
        if($user->type == 'admin' && $user->id !== $myUser->id) {
            return redirect('/admin');
        }else {
            return view('admin.show',['user'=>$user,'myUser'=>auth()->user()]);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
        $myUser = auth()->user();
        $types=['normal','advanced','admin'];
        $user = User::findOrFail($id);
        if($user->type == 'admin' && $user->id !== $myUser->id) {
             return redirect('/admin');
        }else {
            return view('admin.edit',['user'=>$user,'types'=>$types,'myUser'=>auth()->user()]);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
        $request->validate([
                'name' => 'required',
                'email'=> 'required',
                'type'=>'required|in:normal,advanced,admin',
                'passwordActual'=>'required',
        ]);
        $user = User::findOrFail($id);
        $myUser = auth()->user();

        if(Hash::check($request->passwordActual,$myUser->password) ) {
            $message;
            if( !empty($request->password)) {
                $password = Hash::make($request->password);
            }else {
                $password= $user->password;
            }
            $user->update([
                'name' => $request->name,
                'type'=>$request->type,
                'email' => $request->email,
                'password'=>$password,
            ]);
            return back()->with('message','usuario actualizado Correctamente');
        }else {
            return back()->with('error','contraseña Actual incorrecta');
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
        $user = User::findOrFail($id);
        $myUser = auth()->user();
        if($user->type == 'admin' && $user->id !== $myUser->id) {
            return redirect ('admin');
        }else{
            $user->delete();
            return redirect('admin')->with('message','usuario '.$user->name.' borrado correctamente');
        }
        
    }
    
    public function getData() {
        $users= User::all();
        $res=[];
        foreach($users as $user){
            // if($user->type !== 'admin' && $myUser->id !== $user->id && $user->type !=='advanced'){
             if($user->type !== 'admin') {
                array_push($res,$user);
            }
        }
        return $res;
    }
}

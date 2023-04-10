<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Auth;

class AdvancedController extends Controller
{
    
    function __construct() {
        $this-> middleware(\App\Http\Middleware\AdvancedMiddleware::class);
       
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $users = $this->getData();
        return view ('advanced.index',['users'=>$users,'myUser'=>auth()->user()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
        $types=['normal','advanced'];
        return view ('advanced.create',['types'=>$types,'myUser'=>auth()->user()]);
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
            'name' => 'required',
            'email'=> 'required|unique:users,email|email',
            'type'=>'required|in:normal,advanced',
            'password'=> 'required',
            'passwordActual'=> 'required',
        ]);
        $myUser = auth()->user();
        if(Hash::check($request->passwordActual,$myUser->password) ) {
                // return back()->with('message','contraseña coincide');
            $user = new User($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect('advanced')->with('message','Usuario '.$user->name. ' creado Correctamente');
        }else {
            return back()->with('error','contraseña Actual incorrecta');
        }
        
        
        
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
        if( !$this->isAdmin($user) && ($user->type !== 'advanced' || $user->id == $myUser->id ) ) {
            return view('advanced.show',['user'=>$user,'myUser'=>auth()->user()]);
        }else {
            return redirect('advanced');
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
        $user = User::findOrFail($id);
        $myUser = auth()->user();
        $types=['normal','advanced'];
        if(!$this->isAdmin($user) && ($user->type !== 'advanced' || $user->id == $myUser->id ) ) {
            return view('advanced.edit',['user'=>$user,'types'=>$types,'myUser'=>auth()->user()]);
        }else {
            return redirect('advanced');
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
                'name'=>'required',
                'email'=>'required',
                'type'=>'required|in:normal,advanced',
                'passwordActual'=>'required',
            ]);
        $user = User::findOrFail($id);
        $myUser = auth()->user();
        if(!$this->isAdmin($user) ) {
            if(Hash::check($request->passwordActual,$myUser->password) ) {
                // return back()->with('message','contraseña coincide');
                if($request->password == null){
                    $user->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'type'=>$request->type,
                        'password'=>$user->password,
                    ]);
                    return back()->with('message','Datos actualizados Correctamente');
                }else {
                    //  return back()->with('message','contraseña nueva no nula');
                    $user->update([
                        'name'=>$request->name,
                        'email'=>$request->email,
                        'type'=>$request->type,
                        'password'=>Hash::make($request->password),
                    ]);
                    Auth::logout();
                    return redirect('login');
                }
            }else {
                 return back()->with('error','contraseña Actual incorrecta');
            }
        }else {
            //return back()->with('message','usuario no admin');
             return redirect('advanced');
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
        if(!$this->isAdmin($user) && $user->type !== 'advanced' ) {
            $user->delete();
            return redirect('advanced')->with('message','usuario '.$user->name.' borrado correctamente');
        }else {
            return redirect('advanced');
        }
        
    }
    
    public function getData() {
        $users= User::all();
        $myUser= auth()->user();
        $res=[];
        foreach($users as $user) {
            // if($user->type !== 'admin' && $myUser->id !== $user->id && $user->type !=='advanced'){
             if($user->type == 'normal') {
                array_push($res,$user);
            }
        }
        return $res;
    }
    
    public function isAdmin($user) {
        if($user->type == 'admin') {
            return true;
        }
        return false;
    }
    
    
}

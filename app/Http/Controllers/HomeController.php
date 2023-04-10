<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\AuthController;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
         $this->middleware('verified', ['except' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('home');
    }
    
    public function show() {
        return view ('user.show',['user'=>auth()->user()]);
    }
    
    public function edit() {
        return view ('user.edit',['user'=>auth()->user()]);
    }
    
    public function update(Request $request) {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'passwordActual'=>'required',
        ]);
        $message= 'datos actualizados correctamente';
        $user = auth()->user();
        // 
        
        if(Hash::check($request->passwordActual,$user->password) ) {
            if($request->password ==null) {
                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>$user->password,
                ]);
            }else {
                $user->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                ]);
                Auth::logout();
                return redirect('login');
            }
               
        }else {
            $message = 'contraseña Actual incorrecta';
            return back()->with(['error'=>$message]);
        }
        return back()->with('message',$message);
        
        
        
        
        // if($request->password == null && $request->passwordActual == null){
        //     $user->update([
        //             'name'=>$request->name,
        //             'email'=>$request->email,
        //         ]);
        // }else{
        //     if(Hash::check($request->passwordActual, $user->password)) {
        //     //   $message='contraseña correcta';
        //       $user->update([
        //             'name'=>$request->name,
        //             'email'=>$request->email,
        //             'password'=>Hash::make($request->password),
        //         ]);
        //         Auth::logout();
        //         return redirect('login');
        //     }else{
        //         $message='Contraseña actual erronea';   
        //         return back()->with(['error'=>$message]);
        //     }
            
        // }
        // return back()->with('message',$message);
    }
    
}

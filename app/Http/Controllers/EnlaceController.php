<?php

namespace App\Http\Controllers;

use App\Models\Enlace;
use App\Models\Etiqueta;
use App\Models\EnlaceEtiqueta;
use Carbon\Carbon;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;

class EnlaceController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        $enlaces = DB::table('enlace')
            ->select( DB::raw(' SUBSTR(descripcion,1,100) as extracto'),'enlace.*','users.name as uname')
            ->join('users','users.id','=','enlace.iduser')
            ->orderBy('enlace.created_at','desc')
            ->paginate(3);
        // $enlaces = Enlace::all()->sortDesc()->paginate(3);
        // $enlaces = Enlace::paginate(3);
        return view ('enlace.index',['enlaces' => $enlaces]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view ('enlace.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $reglas = [
            'titulo' => 'required|string|max:60',
            'descripcion' => 'required|string|max:500|min:30',
            'enlace' => 'required|url',
            'imagen' => 'required|image|mimes:jpg,png,jpeg,gif',
            'etiqueta' => 'required|string',
        ];
        
        $mensajes = [
            'titulo.required' => 'titulo requerido',
            'tiulo.string' => 'el titulo debe ser tipo string',
            'titulo.max' => 'el titulo debe tener como maximo 60 caracteres',
            'descripcion.required' => 'la descripcion es requerida',
            'descripcion.string' => 'la descripcion debe ser tipo string',
            'descripcion.max' => 'la descripcion debe tener como maximo 500 caracteres',
            'descripcion.min' => 'la descripcion debe tener como minimo 30 caracteres',
            'enlace.required' => 'el enlace es requerido',
            'enlace.url' => 'formato url incorrecta',
            'imagen.required' => 'la imagen es requerida',
            'imagen.image' => 'la imagen debe ser tipo imagen',
            'imagen.mimes' => 'la imagen debe ser en formto JPG,PNG,JPEG O GIF',
            'etiqueta.required' => 'debe tener minimo una etiqueta',
            'etiqueta.string' => 'la etiqueta debe ser tipo string',
        ];
        $validator = Validator::make($request->all(), $reglas, $mensajes);
        
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else {
            $path = $request->imagen->getRealPath();
            $filecontent = file_get_contents($path);
            
            $enlace = new Enlace($request->except('etiqueta') + ['userid' => auth()->user()->id,'visitas' => 1]);
            $enlace->imagen = base64_encode($filecontent);
            $enlace->save();
            
            $etiquetas = explode(" ",trim($request->etiqueta));
            foreach($etiquetas as $etiqueta) {
                $newEtiqueta = new Etiqueta([
                    'etiqueta' => $etiqueta,
                ]);
                try{
                    $newEtiqueta->save();
                }catch(\Exception) {
                    $newEtiqueta =  Etiqueta::select('id')->where('etiqueta', $etiqueta)->first();
                }
                $enlaceEtiqueta = new EnlaceEtiqueta([
                    'idenlace' => $enlace->id,
                    'idetiqueta' => $newEtiqueta->id,
                ]);
                $enlaceEtiqueta->save();
            }
            return redirect ('enlace');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\enlace  $enlace
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $enlace = Enlace::findOrFail($id);
        if($enlace) {
            $etiquetas = DB::table('etiqueta')
                ->select('etiqueta')
                ->join('enlaceEtiqueta','etiqueta.id','=','enlaceEtiqueta.idetiqueta')
                ->join('enlace','enlace.id','=','enlaceEtiqueta.idenlace')
                ->where('enlace.id',$id)
                ->get();
        }
        $min = $this->getDiffMinutes($enlace->created_at);
        return view ('enlace.show',['enlace' => $enlace, 'etiquetas' => $etiquetas, 'minutos' => $min]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\enlace  $enlace
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $enlace = Enlace::findOrFail($id);
        if($enlace) {
            $etiquetas = DB::table('etiqueta')
                ->select('etiqueta','enlaceEtiqueta.id')
                ->join('enlaceEtiqueta','etiqueta.id','=','enlaceEtiqueta.idetiqueta')
                ->join('enlace','enlace.id','=','enlaceEtiqueta.idenlace')
                ->where('enlace.id',$id)
                ->get();
        }
        return view('enlace.edit',['enlace'=>$enlace,'etiquetas'=>$etiquetas]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\enlace  $enlace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $validator = Validator::make($request->all(),[
            'titulo' => 'required|string|max:60',
            'descripcion' => 'required|string|max:500|min:30',
            'enlace' => 'required',
            'imagen' => 'image|mimes:jpg,png,jpeg,gif',
            // 'etiqueta'=>'string',
        ]);
        
        if($validator->fails()) {
            return back()->withInput()->withErrors($validator);
        }else {
            $fechaActual = Carbon::now();
            $enlace = Enlace::findOrFail($id);
            $minutosDiff = $enlace->created_at->DiffInMinutes($fechaActual);
            if($minutosDiff < 2) {
                $enlace->update([
                    'titulo' => $request->titulo,
                    'descripcion' => $request->descripcion,
                    'enlace' => $request->enlace,
                // 'imagen' => $request->imagen,
                ]);
                if($request->imagen) {
                    $path = $request->imagen->getRealPath();
                    $filecontent = file_get_contents($path);
                    
                    $enlace->update([
                        'imagen'=> base64_encode($filecontent),
                    ]);
                }
                if($request->etiqueta) {
                    $etiquetas = explode(" ",trim($request->etiqueta));
                    foreach($etiquetas as $etiqueta) {
                        $newEtiqueta = new Etiqueta([
                            'etiqueta' => $etiqueta,
                        ]);
                        try{
                            $newEtiqueta->save();
                        }catch(\Exception) {
                            $newEtiqueta =  Etiqueta::select('id')->where('etiqueta', $etiqueta)->first();
                        }
                        $enlaceEtiqueta = new EnlaceEtiqueta([
                            'idenlace' => $enlace->id,
                            'idetiqueta' => $newEtiqueta->id,
                        ]);
                        $enlaceEtiqueta->save();
                    }
                }
                return redirect('enlace')->with('message','enlace modificado correctamente');
            }else {
                return redirect('enlace')->with('messageError','tiempo de modificacion expirado para el enlace '.$enlace->titulo);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\enlace  $enlace
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enlace $enlace)
    {
        //
    }
    
    public function visita($idEnlace) {
        $enlace = Enlace::findOrFail($idEnlace);
        $enlace->update([
            'visitas' => $enlace->visitas+1,
        ]);
        $link = 'enlace/'.$idEnlace;
        return redirect ($link);
    }
    
    public function getDiffMinutes($date) {
        $fechaActual = Carbon::now();
        $minutosDiff = $date->DiffInMinutes($fechaActual);
        return $minutosDiff;
    }
}

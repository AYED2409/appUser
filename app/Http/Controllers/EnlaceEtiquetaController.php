<?php

namespace App\Http\Controllers;

use App\Models\EnlaceEtiqueta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnlaceEtiquetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index()
    {
        //
        
        // $enlaceEtiquetas = EnlaceEtiqueta::all()->sortDesc();
        // return view('enlaceEtiqueta.indexes',['enlaceEtiquetas'=>$enlaceEtiquetas]);
        // $enlaces = DB::table('enlace')
        //                 ->select('enlace.*','etiqueta.etiqueta','users.name as username')
        //                 ->join('users','users.id','=','enlace.iduser')
        //                 ->join('enlaceEtiqueta', 'enlace.id','=','enlaceEtiqueta.idenlace')
        //                 ->join('etiqueta','etiqueta.id','=','enlaceEtiqueta.idetiqueta')
        //                 ->orderBy('enlace.created_at', 'desc')
        //                 ->get();
        // return view('enlaceEtiqueta.index',['enlaces'=>$enlaces]);
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\enlace_etiqueta  $enlace_etiqueta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\enlace_etiqueta  $enlace_etiqueta
     * @return \Illuminate\Http\Response
     */
    public function edit(EnlaceEtiqueta $enlaceEtiqueta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\enlace_etiqueta  $enlace_etiqueta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnlaceEtiqueta $enlaceEtiqueta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\enlace_etiqueta  $enlace_etiqueta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $enlaceEtiqueta = EnlaceEtiqueta::findOrFail($id);
        $fechaActual = Carbon::now();
        $minutosDiff = $enlaceEtiqueta->enlace->created_at->DiffInMinutes($fechaActual);
        $link = 'enlace/'.$enlaceEtiqueta->idenlace.'/edit';
        if($minutosDiff < 2) {
            $link = 'enlace/'.$enlaceEtiqueta->idenlace.'/edit';
            $enlaceEtiqueta->delete();
            return redirect($link);   
        }
        return redirect($link)->with('message','no se puede borrar la etiqueta tiempo de edicion superado '.$enlaceEtiqueta->etiqueta->etiqueta);
    }
}

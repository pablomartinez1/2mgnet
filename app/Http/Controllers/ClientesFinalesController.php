<?php

namespace App\Http\Controllers;

use App\ClienteFinal;
use App\EmpresaRubro;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ClientesFinalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function clientesfinales()
    {
        $clientesfinales = DB::table('clientefinal')->orderBy('CD_ClienteFinal', 'asc')->whereNull('FechaBaja')->get();
        $empresarubro = DB::table('empresarubro')->orderBy('CD_EmpresaRubro', 'asc')->get();

        return view('/clientesfinales')
                ->with('clientesfinales', $clientesfinales)
                ->with('empresarubro', $empresarubro);
    }

    public function nuevoclientefinal()
    {
        $clientesfinales = DB::table('clientefinal')->orderBy('CD_ClienteFinal', 'asc')->get();
        $empresarubro = DB::table('empresarubro')->orderBy('CD_EmpresaRubro', 'asc')->get();

        $listaempresarubro = DB::table('clientefinal')
            ->join('empresarubro', 'clientefinal.CD_EmpresaRubro', '=', 'empresarubro.CD_EmpresaRubro')
            ->select('clientefinal.CD_ClienteFinal', 'empresarubro.CD_EmpresaRubro', 'empresarubro.Descripcion')
            ->get();

        return view('/abm_acciones/nuevoclientefinal')
                ->with('clientesfinales', $clientesfinales)
                ->with('empresarubro', $empresarubro)
                ->with('listaempresarubro', $listaempresarubro);
    }

    public function crearclientefinal(Request $request)
    {
        $clientefinal = new \App\ClienteFinal;

        $clientefinal = DB::table('clientefinal')->insert([
                'Nombre' => Input::get('nombre'),
                'CD_EmpresaRubro' => Input::get('empresarubro')
            ]
        );

        return redirect('abm/clientesfinales');
    }

    public function mostrarclientefinal($id)
    {
        $clientefinal = ClienteFinal::findOrFail($id);

        $empresarubro = DB::table('clientefinal')
            ->join('empresarubro', 'clientefinal.CD_EmpresaRubro', '=', 'empresarubro.CD_EmpresaRubro')
            ->select('empresarubro.CD_EmpresaRubro', 'empresarubro.Descripcion')
            ->where('clientefinal.CD_ClienteFinal', $id)
            ->get();

        return view('abm_acciones/mostrarclientefinal')
        ->with('clientefinal', $clientefinal)
        ->with('empresarubro', $empresarubro);
    }

    public function editarclientefinal($id)
    {
        $clientefinal = ClienteFinal::findOrFail($id);

        $empresarubro = DB::table('clientefinal')
            ->join('empresarubro', 'clientefinal.CD_EmpresaRubro', '=', 'empresarubro.CD_EmpresaRubro')
            ->select('empresarubro.CD_EmpresaRubro', 'empresarubro.Descripcion')
            ->where('clientefinal.CD_ClienteFinal', $id)
            ->get();

        $listaempresarubro = DB::table('empresarubro')->orderBy('CD_EmpresaRubro', 'asc')->get();

        // show the edit form and pass the nerd
        return view('abm_acciones/editarclientefinal')
        ->with('clientefinal', $clientefinal)
        ->with('empresarubro', $empresarubro)
        ->with('listaempresarubro', $listaempresarubro);
    }

    public function actualizarclientefinal($id, Request $request)
    {
        $clientefinal = ClienteFinal::find($id);

        $clientefinal = $clientefinal->update([
                'Nombre' => Input::get('nombre'),
                'CD_EmpresaRubro' => Input::get('empresarubro')
            ]
        );

        return redirect('/abm/clientesfinales');
    }

    public function eliminarclientefinal($id, Request $request)
    {
        $clientefinal = ClienteFinal::findOrFail($id);

        $clientefinal->FechaBaja = Carbon::now();

        $clientefinal->save();

        return redirect('/abm/clientesfinales');
    }

    public function filtrarclientesfinales(Request $request)
    {
        if(isset($_POST['filtrar']))
        {
            $filtro = Input::get('filtro');
            $estado = Input::get('opcionesfiltro');

            if($estado == "activo")
                $clientesfinales = DB::table('clientefinal')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNull('FechaBaja')->paginate(15);
            else
                $clientesfinales = DB::table('clientefinal')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNotNull('FechaBaja')->paginate(15);

            $empresarubro = DB::table('empresarubro')->orderBy('CD_EmpresaRubro', 'asc')->get();

            return view('clientesfinales')->with('clientesfinales', $clientesfinales)->with('empresarubro', $empresarubro);
        }
        else
        {
            $clientesfinales = DB::table('clientefinal')->orderBy('CD_ClienteFinal','asc')->paginate(15);
            $empresarubro = DB::table('empresarubro')->orderBy('CD_EmpresaRubro', 'asc')->get();

            return redirect('abm/clientesfinales')->with('clientesfinales', $clientesfinales)->with('empresarubro', $empresarubro);
        }
    }
}

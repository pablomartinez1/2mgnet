<?php

namespace App\Http\Controllers;

use App\EventoContratacion;
use App\Evento;
use App\Proveedor;
use App\CondPago;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ContratacionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contrataciones()
    {
      $eventos = Evento::all();
      $proveedores = Proveedor::all();
      $condpago = CondPago::all();
      return view("/contrataciones")
        ->with("eventos", $eventos)
        ->with("proveedores", $proveedores)
        ->with("condpago", $condpago);
    }

    public function crearcontratacion(Request $request)
    {
      $contratacion = new \App\EventoContratacion;
      $anteriorContratacion = EventoContratacion::find(Input::get("evento"));

      $arrayProveedor = Input::get("proveedor");
      $arrayCondPago = Input::get("condpago");
      $arrayTotal = Input::get("total");

      $contador = 0;

      if($anteriorContratacion != NULL)
      {
        $anteriorContratacion->delete();

        if($arrayProveedor == NULL)
        {
          return redirect('abm/contrataciones');
        }
        else
        {
          foreach($arrayProveedor as $proveedor)
          {
              $contratacion = DB::table('eventoscontrataciones')->insert([
                'CD_Evento' => Input::get("evento"),
                'CD_Proveedor' => $proveedor,
                'CD_CondPago' => $arrayCondPago[$contador],
                'Total' => $arrayTotal[$contador]
              ]);

              $contador++;
          }

          $contador = 0;
        }
      }
      else
      {
        foreach($arrayProveedor as $proveedor)
        {
            $contratacion = DB::table('eventoscontrataciones')->insert([
              'CD_Evento' => Input::get("evento"),
              'CD_Proveedor' => $proveedor,
              'CD_CondPago' => $arrayCondPago[$contador],
              'Total' => $arrayTotal[$contador]
            ]);

            $contador++;
        }

        $contador = 0;
      }

      return redirect('abm/contrataciones');
    }

    public function filtrarcontrataciones(Request $request)
    {
        $buscar = Input::get('evento');

        $eventoSeleccionado = Evento::find($buscar);
        $eventoContrataciones = EventoContratacion::where('CD_Evento', $buscar)->get();
        $eventos = Evento::all();
        $proveedores = Proveedor::whereNull('FechaBaja')->get();
        $condpago = CondPago::all();

        return view('/contrataciones')
          ->with('eventoSeleccionado', $eventoSeleccionado)
          ->with('eventoContrataciones', $eventoContrataciones)
          ->with('eventos', $eventos)
          ->with('proveedores', $proveedores)
          ->with('condpago', $condpago);
    }
}

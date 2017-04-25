<?php

namespace App\Http\Controllers;

use App\EventoServicio;
use App\Evento;
use App\VenueSala;
use App\ServicioTipo;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ServiciosController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function servicios()
  {
    $eventos = Evento::all();
    $serviciostipo = ServicioTipo::all();
    $eventosalas = DB::table('eventossala')
        ->join('venuessalas', 'eventossala.CD_VenueSala', '=', 'venuessalas.CD_VenueSala')
        ->select('venuessalas.Nombre', 'eventossala.CD_VenueSala', 'eventossala.Asistentes')
        ->where('eventossala.CD_Evento', $eventos->first())
        ->get();

    return view("/servicios")
      ->with("eventos", $eventos)
      ->with("eventosalas", $eventosalas)
      ->with("serviciostipo", $serviciostipo);
  }

  public function crearservicio(Request $request)
  {
    $servicio = new \App\EventoServicio;
    $anteriorServicio = EventoServicio::find(Input::get("evento"));

    $arrayVenueSalas = Input::get("venuesalas");
    $arrayServiciosTipo = Input::get("serviciostipo");
    $arrayTotal = Input::get("total");

    $contador = 0;

    if($anteriorServicio != NULL)
    {
      $anteriorServicio->delete();

      if($arrayVenueSalas == NULL)
      {
        return redirect('abm/servicios');
      }
      else
      {
        foreach($arrayVenueSalas as $venuesalas)
        {
            $servicio = DB::table('eventosservicios')->insert([
              'CD_Evento' => Input::get("evento"),
              'CD_VenueSala' => $venuesalas,
              'CD_Servicio' => $arrayServiciosTipo[$contador],
              'Total' => $arrayTotal[$contador]
            ]);

            $contador++;
        }

        $contador = 0;
      }
    }
    else
    {
      foreach($arrayVenueSalas as $venuesalas)
      {
          $servicio = DB::table('eventosservicios')->insert([
            'CD_Evento' => Input::get("evento"),
            'CD_VenueSala' => $venuesalas,
            'CD_Servicio' => $arrayServiciosTipo[$contador],
            'Total' => $arrayTotal[$contador]
          ]);

          $contador++;
      }

      $contador = 0;
    }

    return redirect('abm/servicios');
  }

  public function filtrarservicios(Request $request)
  {
      $buscar = Input::get('evento');

      $eventoSeleccionado = Evento::find($buscar);
      $eventoServicios = EventoServicio::where('CD_Evento', $buscar)->get();
      $eventos = Evento::all();
      //$venuesalas = VenueSala::all();
      $serviciostipo = ServicioTipo::all();
      $eventosalas = DB::table('eventossala')
          ->join('venuessalas', 'eventossala.CD_VenueSala', '=', 'venuessalas.CD_VenueSala')
          ->select('venuessalas.Nombre', 'eventossala.CD_VenueSala', 'eventossala.Asistentes')
          ->where('eventossala.CD_Evento', $buscar)
          ->get();

      return view('/servicios')
        ->with('eventoSeleccionado', $eventoSeleccionado)
        ->with('eventoServicios', $eventoServicios)
        ->with('eventos', $eventos)
        ->with('eventosalas', $eventosalas)
        ->with('serviciostipo', $serviciostipo);
  }
}

<?php

namespace App\Http\Controllers;

use App\Venue;
use App\VenueSala;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class VenueSalasController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function venuesalas()
  {
    $venues = Venue::whereNull('FechaBaja')->get();
    return view("/venuesalas")
      ->with("venues", $venues);
  }

  public function nuevasala($id)
  {
    $venueSeleccionado = Venue::find($id);
    return view("abm_acciones/nuevasala")
        ->with('venueSeleccionado', $venueSeleccionado);
  }

  public function mostrarsala($id)
  {
    $salaSeleccionada = VenueSala::find($id);
    return view("abm_acciones/mostrarsala")
        ->with('salaSeleccionada', $salaSeleccionada);
  }

  public function editarsala($id)
  {
    $salaSeleccionada = VenueSala::find($id);
    return view("abm_acciones/editarsala")
        ->with('salaSeleccionada', $salaSeleccionada);
  }

  public function crearsalas(Request $request)
  {
    $venuesalas = new \App\VenueSala;
    $anteriorVenueSalas = VenueSala::find(Input::get("venue"));

    $nombre = Input::get("nombre");
    $capacidad = Input::get("capacidad");
    $alturaMax = Input::get("alturamax");
    $puntosColgado = Input::get("puntoscolgado");
    $usoEnergia = Input::get("usoenergia");
    $notas = Input::get("notas");

    $venuesalas = DB::table('venuessalas')->insert([
        'CD_Venue' => Input::get("venue"),
        'Nombre' => Input::get("nombre"),
        'Capacidad' => (Input::get("capacidad") == "" ? 0 : Input::get("capacidad")),
        'AlturaMax' => (Input::get("alturamax") == "" ? 0 : Input::get("alturamax")),
        'PuntosColgado' => (Input::get("puntoscolgado") == "" ? NULL : Input::get("puntoscolgado")),
        'UsoEnergia' => (Input::get("usoenergia") == "" ? NULL : Input::get("usoenergia")),
        'Notas' => (Input::get("notas") == "" ? NULL : Input::get("notas"))
    ]);

    return redirect('abm/venuesalas');
  }

  public function actualizarsala($id, Request $request)
  {
    $venuesalas = VenueSala::find($id);

    $nombre = Input::get("nombre");
    $capacidad = Input::get("capacidad");
    $alturaMax = Input::get("alturamax");
    $puntosColgado = Input::get("puntoscolgado");
    $usoEnergia = Input::get("usoenergia");
    $notas = Input::get("notas");

    $venuesalas = $venuesalas->update([
        'Nombre' => Input::get("nombre"),
        'Capacidad' => (Input::get("capacidad") == "" ? 0 : Input::get("capacidad")),
        'AlturaMax' => (Input::get("alturamax") == "" ? 0 : Input::get("alturamax")),
        'PuntosColgado' => (Input::get("puntoscolgado") == "" ? NULL : Input::get("puntoscolgado")),
        'UsoEnergia' => (Input::get("usoenergia") == "" ? NULL : Input::get("usoenergia")),
        'Notas' => (Input::get("notas") == "" ? NULL : Input::get("notas"))
    ]);

    return redirect('abm/venuesalas');
  }

  public function eliminarsalas($id, Request $request)
  {
      $venueSeleccionado = VenueSala::findOrFail($id);

      $venueSeleccionado->FechaBaja = Carbon::now();

      $venueSeleccionado->save();

      return redirect('/abm/venuesalas');
  }

  public function filtrarvenuesalas(Request $request)
  {
      $buscar = Input::get('venue');

      $venueSeleccionado = Venue::find($buscar);
      $venueSalas = VenueSala::where('CD_Venue', $buscar)->whereNull('FechaBaja')->get();
      $venues = Venue::whereNull('FechaBaja')->get();

      return view('/venuesalas')
        ->with('venueSeleccionado', $venueSeleccionado)
        ->with('venueSalas', $venueSalas)
        ->with('venues', $venues);
  }
}

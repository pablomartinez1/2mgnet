<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ClienteFinal;
use App\Evento;
use App\EventoTipo;
use App\EventoFrecuencia;
use App\Venues;
use App\VenueSala;
use App\EventoEstado;
use App\EventoSala;
use App\User;
use App\EventoCodificacion;
use App\EventoServicio;
use App\EventoContratacion;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class EventosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function eventos()
    {
        $eventos = DB::table('eventos')->orderBy('Nombre', 'asc')->get();
        $users = DB::table('users')->orderBy('name', 'asc')->get();

        foreach($eventos as $dato)
        {
          $fechaCarbon = Carbon::parse($dato->FechaHasta);

          $fechaCarbon = $fechaCarbon->formatLocalized('%d-%m-%Y');

          $dato->FechaHasta = $fechaCarbon;
        }

        foreach($eventos as $dato)
        {
          $fechaCarbon = Carbon::parse($dato->FechaDesde);

          $fechaCarbon = $fechaCarbon->formatLocalized('%d-%m-%Y');

          $dato->FechaDesde = $fechaCarbon;
        }

        return view('/eventos')
                ->with('eventos', $eventos)
                ->with('users', $users);
    }

    public function nuevoevento()
    {
        $eventos = DB::table('eventos')->orderBy('Nombre', 'asc')->get();
        $clientes  = DB::table('clientes')->orderBy('Nombre', 'asc')->get();
        $eventotipo = DB::table('eventotipo')->orderBy('Descripcion', 'asc')->get();
        $eventofrecuencia = DB::table('eventofrecuencia')->orderBy('Descripcion', 'asc')->get();
        $venues = DB::table('venues')->orderBy('Nombre', 'asc')->whereNull('FechaBaja')->get();
        $eventoestado = DB::table('eventoestado')->orderBy('Descripcion', 'asc')->get();
        $users = DB::table('users')->orderBy('name', 'asc')->get();
        $condpago = DB::table('condpago')->orderBy('Descripcion', 'asc')->get();
        $eventocodificacion = DB::table('eventocodificacion')->orderBy('Descripcion', 'asc')->get();
        $venuesalas = VenueSala::whereNull('FechaBaja')->get();

        return view('/abm_acciones/nuevoevento')
                ->with('eventos', $eventos)
                ->with('clientes', $clientes)
                ->with('eventotipo', $eventotipo)
                ->with('eventofrecuencia', $eventofrecuencia)
                ->with('venues', $venues)
                ->with('eventoestado', $eventoestado)
                ->with('users', $users)
                ->with('condpago', $condpago)
                ->with('eventocodificacion', $eventocodificacion)
                ->with('venuesalas', $venuesalas);
    }

    public function crearevento(Request $request)
    {
        $evento = new \App\Evento;
        $venuesalas = new \App\VenueSala;

        $evento = DB::table('eventos')->insert([
                'Nombre' => Input::get('nombre'),
                'CD_Cliente' => Input::get('cliente'),
                'CD_ClienteFinal' => (Input::get('clientefinal') == "" ? NULL : Input::get('clientefinal')),
                'CD_EventoTipo' => Input::get('eventotipo'),
                'CD_EventoFrecuencia' => Input::get('eventofrecuencia'),
                'CD_Venue' => Input::get('venue'),
                'FechaDesde' => Input::get('fechadesde'),
                'FechaHasta' => Input::get('fechahasta'),
                'CD_EventoEstado' => Input::get('eventoestado'),
                'CD_Usuario' => Input::get('usuario'),
                'CD_CondPago' => (Input::get('condpago') == "" ? NULL : Input::get('condpago')),
                'Notas' => Input::get('notas'),
                'FechaConfirmada' => (Input::get('fechaconfirmada') == "" ? "0" : "1"),
                'NumeroPresupuesto' => (Input::get('presupuesto') == "" ? NULL : Input::get('presupuesto')),
                'CD_EventoCodificacion' => Input::get('eventocodificacion'),
                'Licitacion' => (Input::get('licitacion') == "" ? "0" : "1"),
                'FechaArmadoDesde' => (Input::get('fechaarmadodesde') == "" ? NULL : Input::get('fechaarmadodesde')),
                'FechaArmadoHasta' => (Input::get('fechaarmadohasta') == "" ? NULL : Input::get('fechaarmadohasta')),
                'FechaArmadoConfirmada' => (Input::get('fechaarmadoconfirmada') == "" ? "0" : "1")
            ]
        );

        $ultimoEventoCreado = DB::table('eventos')->orderBy('CD_Evento','desc')->first();
        $arraySalas = Input::get("sala");
        $arrayAsistentes = Input::get("asistentes");
        $indexArray = 0;

        if(!empty($arraySalas))
        {
          foreach($arraySalas as $salas)
          {
            $venuesalas = DB::table('eventossala')->insert([
              'CD_Evento' => $ultimoEventoCreado->CD_Evento,
              'CD_VenueSala' => $salas,
              'Asistentes' => $arrayAsistentes[$indexArray]
            ]);

            $indexArray++;
          }

          $indexArray = 0;
        }

        return redirect('abm/eventos');
    }

    public function mostrarevento($id)
    {
        $evento = Evento::findOrFail($id);
        /*$eventoServicios = EventoServicio::findOrFail($id);
        $eventoContrataciones = EventoContratacion::findOrFail($id);*/

        $cliente = DB::table('eventos')
            ->join('clientes', 'eventos.CD_Cliente', '=', 'clientes.CD_Cliente')
            ->select('eventos.CD_Cliente', 'clientes.CD_Cliente', 'clientes.Nombre', 'clientes.CD_ClienteTipo')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $clientefinal = DB::table('eventos')
            ->join('clientes', 'eventos.CD_ClienteFinal', '=', 'clientes.CD_Cliente')
            ->select('eventos.CD_Cliente', 'clientes.CD_Cliente', 'clientes.Nombre', 'clientes.CD_ClienteTipo')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventotipo = DB::table('eventos')
            ->join('eventotipo', 'eventos.CD_EventoTipo', '=', 'eventotipo.CD_EventoTipo')
            ->select('eventos.CD_EventoTipo', 'eventotipo.CD_EventoTipo', 'eventotipo.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventofrecuencia = DB::table('eventos')
            ->join('eventofrecuencia', 'eventos.CD_EventoFrecuencia', '=', 'eventofrecuencia.CD_EventoFrecuencia')
            ->select('eventos.CD_EventoFrecuencia', 'eventofrecuencia.CD_EventoFrecuencia', 'eventofrecuencia.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $venue = DB::table('eventos')
            ->join('venues', 'eventos.CD_Venue', '=', 'venues.CD_Venue')
            ->select('eventos.CD_Venue', 'venues.CD_Venue', 'venues.Nombre')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventoestado = DB::table('eventos')
            ->join('eventoestado', 'eventos.CD_EventoEstado', '=', 'eventoestado.CD_EventoEstado')
            ->select('eventos.CD_Venue', 'eventoestado.CD_EventoEstado', 'eventoestado.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $user = DB::table('eventos')
            ->join('users', 'eventos.CD_Usuario', '=', 'users.id')
            ->select('eventos.CD_Venue', 'users.id', 'users.name')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $condpago = DB::table('eventos')
            ->join('condpago', 'eventos.CD_CondPago', '=', 'condpago.CD_CondPago')
            ->select('eventos.CD_CondPago', 'condpago.CD_CondPago', 'condpago.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventocodificacion = DB::table('eventos')
            ->join('eventocodificacion', 'eventos.CD_EventoCodificacion', '=', 'eventocodificacion.CD_EventoCodificacion')
            ->select('eventos.CD_EventoCodificacion', 'eventocodificacion.CD_EventoCodificacion', 'eventocodificacion.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventosalas = DB::table('eventossala')
            ->join('venuessalas', 'eventossala.CD_VenueSala', '=', 'venuessalas.CD_VenueSala')
            ->select('venuessalas.Nombre', 'eventossala.Asistentes')
            ->where('eventossala.CD_Evento', $id)
            ->get();

        return view('abm_acciones/mostrarevento')
        ->with('evento', $evento)
        ->with('cliente', $cliente)
        ->with('clientefinal', $clientefinal)
        ->with('eventotipo', $eventotipo)
        ->with('eventofrecuencia', $eventofrecuencia)
        ->with('venue', $venue)
        ->with('eventoestado', $eventoestado)
        ->with('user', $user)
        ->with('condpago', $condpago)
        ->with('eventocodificacion', $eventocodificacion)
        ->with('eventosalas', $eventosalas);
        /*->with('eventoservicios', $eventoServicios)
        ->with('eventocontrataciones', $eventoContrataciones);*/
    }

    public function editarevento($id)
    {
        $evento = Evento::findOrFail($id);

        $cliente = DB::table('eventos')
            ->join('clientes', 'eventos.CD_Cliente', '=', 'clientes.CD_Cliente')
            ->select('eventos.CD_Cliente', 'clientes.CD_Cliente', 'clientes.Nombre', 'clientes.CD_ClienteTipo')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $clientefinal = DB::table('eventos')
            ->join('clientes', 'eventos.CD_ClienteFinal', '=', 'clientes.CD_Cliente')
            ->select('eventos.CD_Cliente', 'clientes.CD_Cliente', 'clientes.Nombre', 'clientes.CD_ClienteTipo')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventotipo = DB::table('eventos')
            ->join('eventotipo', 'eventos.CD_EventoTipo', '=', 'eventotipo.CD_EventoTipo')
            ->select('eventos.CD_EventoTipo', 'eventotipo.CD_EventoTipo', 'eventotipo.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventofrecuencia = DB::table('eventos')
            ->join('eventofrecuencia', 'eventos.CD_EventoFrecuencia', '=', 'eventofrecuencia.CD_EventoFrecuencia')
            ->select('eventos.CD_EventoFrecuencia', 'eventofrecuencia.CD_EventoFrecuencia', 'eventofrecuencia.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $venue = DB::table('eventos')
            ->join('venues', 'eventos.CD_Venue', '=', 'venues.CD_Venue')
            ->select('eventos.CD_Venue', 'venues.CD_Venue', 'venues.Nombre')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventoestado = DB::table('eventos')
            ->join('eventoestado', 'eventos.CD_EventoEstado', '=', 'eventoestado.CD_EventoEstado')
            ->select('eventos.CD_Venue', 'eventoestado.CD_EventoEstado', 'eventoestado.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $user = DB::table('eventos')
            ->join('users', 'eventos.CD_Usuario', '=', 'users.id')
            ->select('eventos.CD_Venue', 'users.id', 'users.name')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $condpago = DB::table('eventos')
            ->join('condpago', 'eventos.CD_CondPago', '=', 'condpago.CD_CondPago')
            ->select('eventos.CD_CondPago', 'condpago.CD_CondPago', 'condpago.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventocodificacion = DB::table('eventos')
            ->join('eventocodificacion', 'eventos.CD_EventoCodificacion', '=', 'eventocodificacion.CD_EventoCodificacion')
            ->select('eventos.CD_EventoCodificacion', 'eventocodificacion.CD_EventoCodificacion', 'eventocodificacion.Descripcion')
            ->where('eventos.CD_Evento', $id)
            ->get();

        $eventosalas = DB::table('eventossala')
            ->join('venuessalas', 'eventossala.CD_VenueSala', '=', 'venuessalas.CD_VenueSala')
            ->select('venuessalas.Nombre', 'eventossala.CD_VenueSala', 'eventossala.Asistentes')
            ->where('eventossala.CD_Evento', $id)
            ->get();

        $listaclientes = DB::table('clientes')->orderBy('Nombre', 'asc')->WhereNull('FechaBaja')->get();
        $listatipoeventos = DB::table('eventotipo')->orderBy('Descripcion', 'asc')->get();
        $listafrecuenciaevento = DB::table('eventofrecuencia')->orderBy('Descripcion', 'asc')->get();
        $listavenues = DB::table('venues')->orderBy('Nombre', 'asc')->get();
        $listaestadoeventos = DB::table('eventoestado')->orderBy('Descripcion', 'asc')->get();
        $listausuarios = DB::table('users')->orderBy('name', 'asc')->get();
        $listacondpagos = DB::table('condpago')->orderBy('Descripcion', 'asc')->get();
        $listacodificacioneventos = DB::table('eventocodificacion')->orderBy('Descripcion', 'asc')->get();
        $venuesalas = VenueSala::all();

        // show the edit form and pass the nerd
        return view('abm_acciones/editarevento')
        ->with('evento', $evento)
        ->with('cliente', $cliente)
        ->with('clientefinal', $clientefinal)
        ->with('eventotipo', $eventotipo)
        ->with('eventofrecuencia', $eventofrecuencia)
        ->with('venue', $venue)
        ->with('eventoestado', $eventoestado)
        ->with('user', $user)
        ->with('condpago', $condpago)
        ->with('eventocodificacion', $eventocodificacion)
        ->with('listaclientes', $listaclientes)
        ->with('listatipoeventos', $listatipoeventos)
        ->with('listafrecuenciaevento', $listafrecuenciaevento)
        ->with('listavenues', $listavenues)
        ->with('listaestadoeventos', $listaestadoeventos)
        ->with('listausuarios', $listausuarios)
        ->with('listacondpagos', $listacondpagos)
        ->with('listacodificacioneventos', $listacodificacioneventos)
        ->with('venuesalas', $venuesalas)
        ->with('eventosalas', $eventosalas);
    }

    public function actualizarevento($id, Request $request)
    {
        $evento = Evento::find($id);

        $evento = $evento->update([
                'Nombre' => Input::get('nombre'),
                'CD_Cliente' => Input::get('cliente'),
                'CD_ClienteFinal' => (Input::get('clientefinal') == "" ? NULL : Input::get('clientefinal')),
                'CD_EventoTipo' => Input::get('eventotipo'),
                'CD_EventoFrecuencia' => Input::get('eventofrecuencia'),
                'CD_Venue' => Input::get('venue'),
                'FechaDesde' => Input::get('fechadesde'),
                'FechaHasta' => Input::get('fechahasta'),
                'CD_EventoEstado' => Input::get('eventoestado'),
                'CD_Usuario' => Input::get('usuario'),
                'CD_CondPago' => (Input::get('condpago') == "" ? NULL : Input::get('condpago')),
                'Notas' => Input::get('notas'),
                'FechaConfirmada' => (Input::get('fechaconfirmada') == '' ? "0" : "1"),
                'NumeroPresupuesto' => (Input::get('presupuesto') == "" ? NULL : Input::get('presupuesto')),
                'CD_EventoCodificacion' => Input::get('eventocodificacion'),
                'Licitacion' => (Input::get('licitacion') == '' ? "0" : "1"),
                'FechaArmadoDesde' => (Input::get('fechaarmadodesde') == "" ? NULL : Input::get('fechaarmadodesde')),
                'FechaArmadoHasta' => (Input::get('fechaarmadohasta') == "" ? NULL : Input::get('fechaarmadohasta')),
                'FechaArmadoConfirmada' => (Input::get('fechaarmadoconfirmada') == '' ? "0" : "1"),
            ]
        );

        $anteriorEventoSala = EventoSala::find($id);
        $eventosala = new \App\EventoSala;
        $indexArray = 0;

        if($anteriorEventoSala != NULL)
        {
            $anteriorEventoSala->delete();

            $arraySalas = Input::get("sala");
            $arrayAsistentes = Input::get("asistentes");

            if($arraySalas != NULL)
            {
                $indexArray = 0;

                foreach($arraySalas as $array)
                {
                    $eventosala = DB::table('eventossala')->insert([
                            'CD_Evento' => $id,
                            'CD_VenueSala' => $array,
                            'Asistentes' => $arrayAsistentes[$indexArray]
                        ]
                    );

                    $indexArray++;
                }
            }
        }
        else
        {
            $arraySalas = Input::get("sala");
            $arrayAsistentes = Input::get("asistentes");

            if($arraySalas != NULL)
            {
                $indexArray = 0;

                foreach($arraySalas as $array)
                {
                    $eventosala = DB::table('eventossala')->insert([
                          'CD_Evento' => $id,
                          'CD_VenueSala' => $array,
                          'Asistentes' => $arrayAsistentes[$indexArray]
                        ]
                    );

                    $indexArray++;
                }
            }
        }

        return redirect('/abm/eventos');
    }

    public function eliminarevento($id, Request $request)
    {
        $evento = Evento::findOrFail($id);

        $evento->delete();

        return redirect('/abm/eventos');
    }

    public function filtrareventos(Request $request)
    {
        if(isset($_POST['filtrar']))
        {
            $filtro = Input::get('filtro');

            $eventos = DB::table('eventos')->where('Nombre', 'LIKE', '%' . $filtro . '%')->paginate(15);
            $users = DB::table('users')->orderBy('id', 'asc')->get();

            return view('/eventos')->with('eventos', $eventos)->with('users', $users);
        }
        else
        {
            $eventos = DB::table('eventos')->orderBy('Nombre','asc')->paginate(15);
            $users = DB::table('users')->orderBy('name', 'asc')->get();

            return redirect('/abm/eventos')->with('eventos', $eventos)->with('users', $users);
        }
    }
}

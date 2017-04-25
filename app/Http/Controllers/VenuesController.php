<?php

namespace App\Http\Controllers;

use App\Venue;
use App\Pais;
use App\Provincia;
use App\VenueTelefono;
use App\SituacionIva;
use App\VenueTipo;
use App\VenueContacto;
use App\Contacto;
use App\TelefonoTipo;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class VenuesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function venues()
    {
      $venues = Venue::whereNull('FechaBaja')->paginate(15);

      return view('/venues')->with('venues', $venues);
    }

    public function nuevovenue(Request $request)
    {
            $venuetipo = VenueTipo::all();
            $paises = Pais::all();
            $provincia = Provincia::all();
            $situacioniva = SituacionIva::all();
            $telefonotipo = TelefonoTipo::all();
            $contactos = Contacto::where('CD_ContactoTipo', 3)->get();

            return view('abm_acciones/nuevovenue')
                    ->with('venuetipo', $venuetipo)
                    ->with('paises', $paises)
                    ->with('provincias', $provincia)
                    ->with('situacioniva', $situacioniva)
                    ->with('telefonotipo', $telefonotipo)
                    ->with('contactos', $contactos);
    }

    public function crearvenue(Request $request)
    {
        $venue = new \App\Venue;
        $telefono = new \App\VenueTelefono;
        $contacto = new \App\VenueContacto;

        $venue = DB::table('venues')->insert([
            'Nombre' => Input::get('nombre'),
            'CD_Pais' => Input::get('pais'),
            'CD_Provincia' => (Input::get('provincia') == "" ? 0 : Input::get('provincia')),
            'Localidad' => Input::get('localidad'),
            'Calle' => Input::get('calle'),
            'CodPostal' => (Input::get('codpostal') == "" ? NULL : Input::get('codpostal')),
            'CUIT' => Input::get('cuit'),
            'CD_SituacionIva' => (Input::get('situacioniva') == "" ? 0 : Input::get('situacioniva')),
            'Web' => Input::get('web'),
            'Comisión' => (Input::get('comision') == "" ? NULL : Input::get('comision')),
            'CD_VenueTipo' => (Input::get('venuetipo') == "" ? 1 : Input::get('venuetipo')),
            'Notas' => (Input::get('notas') == "" ? NULL : Input::get('notas'))
            ]
        );

        $ultimoVenueCreado = DB::table('venues')->orderBy('CD_Venue','desc')->first();
        $arrayTelefonos = Input::get('telefono');
        $arrayTipoTelefonos = Input::get('tipotelefono');
        $indexArray = 0;

        if(!empty($arrayTelefonos))
        {
          foreach($arrayTelefonos as $telefonos)
          {
              $telefono = DB::table('venuestelefono')->insert([
                  'CD_Venue' => $ultimoVenueCreado->CD_Venue,
                  'CD_TelefonoTipo' => $arrayTipoTelefonos[$indexArray],
                  'Telefono' => $telefonos
                  ]
              );

              $indexArray++;
          }
        }

        $indexArray = 0;

        $arrayContactos = Input::get('contacto');

        if(!empty($arrayContactos))
        {
          foreach($arrayContactos as $contactos)
          {
              $contacto = DB::table('venuescontacto')->insert([
                  'CD_Venue' => $ultimoVenueCreado->CD_Venue,
                  'CD_Contacto' => $contactos
                  ]
              );

              $indexArray++;
          }
        }

        $indexArray = 0;

        return redirect('abm/venues');
    }

    public function mostrarvenue($id)
    {
        $venue = Venue::findOrFail($id);

        $paises = DB::table('venues')
            ->join('pais', 'venues.CD_Pais', '=', 'pais.CD_Pais')
            ->select('venues.Nombre', 'pais.Descripcion', 'pais.CD_Pais')
            ->where('venues.CD_Venue', $id)
            ->get();

        $provincias = DB::table('venues')
            ->join('provincia', 'venues.CD_Provincia', '=', 'provincia.CD_Provincia')
            ->select('venues.Nombre', 'provincia.Descripcion', 'provincia.CD_Provincia')
            ->where('venues.CD_Venue', $id)
            ->get();

        $telefonos = DB::table('venuestelefono')
            ->join('telefonotipo', 'venuestelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
            ->join('venues', 'venuestelefono.CD_Venue', '=', 'venues.CD_Venue')
            ->select('venues.Nombre', 'venuestelefono.CD_TelefonoTipo', 'venuestelefono.Telefono', 'telefonotipo.Descripcion')
            ->where('venuestelefono.CD_Venue', $id)
            ->get();

        $situacioniva = DB::table('venues')
            ->join('situacioniva', 'venues.CD_SituacionIVA', '=', 'situacioniva.CD_SituacionIVA')
            ->select('venues.Nombre', 'situacioniva.Descripcion', 'situacioniva.CD_SituacionIVA')
            ->where('venues.CD_Venue', $id)
            ->get();

        $venuetipo = DB::table('venues')
            ->join('venuetipo', 'venues.CD_VenueTipo', '=', 'venuetipo.CD_VenueTipo')
            ->select('venues.Nombre', 'venuetipo.Descripcion', 'venuetipo.CD_VenueTipo')
            ->where('venues.CD_Venue', $id)
            ->get();

        $contactos = DB::table('venuescontacto')
            ->join('contactos', 'venuescontacto.CD_Contacto', '=', 'contactos.CD_Contacto')
            ->join('venues', 'venuescontacto.CD_Venue', '=', 'venues.CD_Venue')
            ->select('venues.Nombre', 'venues.CD_Venue', 'contactos.Nombre', 'contactos.CD_Contacto')
            ->where('venuescontacto.CD_Venue', $id)
            ->get();

        return view('abm_acciones/mostrarvenue')
        ->with('venue', $venue)
        ->with('paises', $paises)
        ->with('provincias', $provincias)
        ->with('telefonos', $telefonos)
        ->with('situacioniva', $situacioniva)
        ->with('venuetipo', $venuetipo)
        ->with('contactos', $contactos);
    }

    public function editarvenue($id)
    {
        $venue = Venue::findOrFail($id);

        $paises = DB::table('venues')
            ->join('pais', 'venues.CD_Pais', '=', 'pais.CD_Pais')
            ->select('venues.Nombre', 'pais.Descripcion', 'pais.CD_Pais')
            ->where('venues.CD_Venue', $id)
            ->get();

        $provincias = DB::table('venues')
            ->join('provincia', 'venues.CD_Provincia', '=', 'provincia.CD_Provincia')
            ->select('venues.Nombre', 'provincia.Descripcion', 'provincia.CD_Provincia')
            ->where('venues.CD_Venue', $id)
            ->get();

        $telefonos = DB::table('venuestelefono')
            ->join('telefonotipo', 'venuestelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
            ->join('venues', 'venuestelefono.CD_Venue', '=', 'venues.CD_Venue')
            ->select('venues.Nombre', 'venuestelefono.CD_TelefonoTipo', 'venuestelefono.Telefono', 'telefonotipo.Descripcion')
            ->where('venuestelefono.CD_Venue', $id)
            ->get();

        $situacioniva = DB::table('venues')
            ->join('situacioniva', 'venues.CD_SituacionIVA', '=', 'situacioniva.CD_SituacionIVA')
            ->select('venues.Nombre', 'situacioniva.Descripcion', 'situacioniva.CD_SituacionIVA')
            ->where('venues.CD_Venue', $id)
            ->get();

        $tipovenue = DB::table('venues')
            ->join('venuetipo', 'venues.CD_VenueTipo', '=', 'venuetipo.CD_VenueTipo')
            ->select('venues.Nombre', 'venuetipo.Descripcion', 'venuetipo.CD_VenueTipo')
            ->where('venues.CD_Venue', $id)
            ->get();

        $contactos = DB::table('venuescontacto')
            ->join('contactos', 'venuescontacto.CD_Contacto', '=', 'contactos.CD_Contacto')
            ->join('venues', 'venuescontacto.CD_Venue', '=', 'venues.CD_Venue')
            ->select('venues.Nombre', 'venues.CD_Venue', 'contactos.Nombre', 'contactos.CD_Contacto', 'venuescontacto.CD_Venue')
            ->where('venuescontacto.CD_Venue', $id)
            ->get();

        $listapaises = DB::table('pais')->orderBy('Descripcion', 'asc')->get();
        $listaprovincias = DB::table('provincia')->orderBy('Descripcion', 'asc')->get();
        $listatelefonos = DB::table('venuestelefono')->orderBy('CD_Venue', 'asc')->get();
        $listatelefonostipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();
        $listasituacionesiva = DB::table('situacioniva')->orderBy('Descripcion', 'asc')->get();
        $listavenuestipo = DB::table('venuetipo')->orderBy('Descripcion', 'asc')->get();
        $listacontactos = Contacto::where('CD_ContactoTipo', '3')->get();

        // show the edit form and pass the nerd
        return view('abm_acciones/editarvenue')
        ->with('venue', $venue)
        ->with('paises', $paises)
        ->with('provincias', $provincias)
        ->with('telefonos', $telefonos)
        ->with('situacioniva', $situacioniva)
        ->with('tipovenue', $tipovenue)
        ->with('contactos', $contactos)
        ->with('listapaises', $listapaises)
        ->with('listaprovincias', $listaprovincias)
        ->with('listatelefonos', $listatelefonos)
        ->with('listatelefonostipo', $listatelefonostipo)
        ->with('listasituacionesiva', $listasituacionesiva)
        ->with('listavenuestipo', $listavenuestipo)
        ->with('listacontactos', $listacontactos);
    }

    public function actualizarvenue($id, Request $request)
    {
        $venue = Venue::find($id);
        $telefonos = VenueTelefono::find($id);
        $contactos = VenueContacto::find($id);

        $venue = $venue->update([
                'Nombre' => Input::get('nombre'),
                'RazonSocial' => Input::get('razonsocial'),
                'CD_Pais' => Input::get('pais'),
                'CD_Provincia' => (Input::get('provincia') == "" ? 0 : Input::get('provincia')),
                'Localidad' => Input::get('localidad'),
                'Calle' => Input::get('calle'),
                'CodPostal' => (Input::get('codpostal') == "" ? NULL : Input::get('codpostal')),
                'CUIT' => Input::get('cuit'),
                'CD_SituacionIva' => (Input::get('situacioniva') == "" ? 0 : Input::get('situacioniva')),
                'Web' => Input::get('web'),
                'Comisión' => (Input::get('comision') == "" ? NULL : Input::get('comision')),
                'CD_VenueTipo' => (Input::get('venuetipo') == "" ? NULL : Input::get('venuetipo')),
                'CD_Canal' => (Input::get('canal') == "" ? NULL : Input::get('canal')),
                'CD_EmpresaRubro' => (Input::get('rubroempresa') == "" ? NULL : Input::get('rubroempresa')),
                'Notas' => (Input::get('notas') == "" ? NULL : Input::get('notas')),
                'CD_CondPago' => (Input::get('condpago') == "" ? NULL : Input::get('condpago')),
                'CD_VenueClasificacion'  => (Input::get('venueclasificacion') == "" ? NULL : Input::get('venueclasificacion'))
            ]
        );

        $venuetelefono = new \App\VenueTelefono;

        if($telefonos != NULL)
        {
            $telefonos->delete();

            $arrayTelefonos = Input::get("telefono");
            $arrayTipoTelefono = Input::get("tipotelefono");

            if($arrayTelefonos != NULL)
            {
                $indexArray = 0;

                foreach($arrayTelefonos as $arrTel)
                {
                    $venuetelefono = DB::table('venuestelefono')->insert([
                            'CD_Venue' => $id,
                            'CD_TelefonoTipo' => $arrayTipoTelefono[$indexArray],
                            'Telefono' => $arrTel
                        ]
                    );

                    $indexArray++;
                }
            }
        }
        else
        {
            $arrayTelefonos = Input::get("telefono");
            $arrayTipoTelefono = Input::get("tipotelefono");

            if($arrayTelefonos != NULL)
            {
                $indexArray = 0;

                foreach($arrayTelefonos as $arrTel)
                {
                    $venuetelefono = DB::table('venuestelefono')->insert([
                            'CD_Venue' => $id,
                            'CD_TelefonoTipo' => $arrayTipoTelefono[$indexArray],
                            'Telefono' => $arrTel
                        ]
                    );

                    $indexArray++;
                }
            }
        }

        $venuecontacto = new \App\VenueContacto;

        if($contactos != NULL)
        {
            /*
            $contactos = $contactos->update([
                'CD_Contacto' => Input::get('contacto'),
                'CargoArea' => Input::get('cargoarea')
                ]
            );
            */
            $contactos->delete();

            $arrayContactos = Input::get("contacto");

            if($arrayContactos != NULL)
            {
                $indexArray = 0;

                foreach($arrayContactos as $arrCon)
                {
                    $venuecontacto = DB::table('venuescontacto')->insert([
                            'CD_Venue' => $id,
                            'CD_Contacto' => $arrCon
                        ]
                    );

                    $indexArray++;
                }
            }
        }
        else
        {
            $arrayContactos = Input::get("contacto");

            if($arrayContactos != NULL)
            {
                $indexArray = 0;

                foreach($arrayContactos as $arrCon)
                {
                    $venuecontacto = DB::table('venuescontacto')->insert([
                            'CD_Venue' => $id,
                            'CD_Contacto' => $arrCon
                        ]
                    );

                    $indexArray++;
                }
            }
        }

        return redirect('/abm/venues');
    }

    public function eliminarvenue($id, Request $request)
    {
        $venue = Venue::findOrFail($id);

        $venue->FechaBaja = Carbon::now();

        $venue->save();

        return redirect('/abm/venues');
    }

    public function filtrarvenues(Request $request)
    {
        if(isset($_POST['filtrar']))
        {
            $filtro = Input::get('filtro');
            $estado = Input::get('opcionesfiltro');

            if($estado == "activo")
                $venues = Venue::where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNull('FechaBaja')->paginate(15);
            else
                $venues = Venue::where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNotNull('FechaBaja')->paginate(15);

            //$venuestipo = DB::table('venuetipo')->orderBy('CD_VenueTipo','asc')->get();

            return view('/venues')->with('venues', $venues);//->with('venuestipo', $venuestipo);
        }
        else
        {
            $venues = Venue::paginate(15);

            return redirect('abm/venues')->with('venues', $venues);
        }
    }
}

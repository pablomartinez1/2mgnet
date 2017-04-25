<?php

namespace App\Http\Controllers;

use App\Contacto;
use App\ContactoTipo;
use App\ContactoTelefono;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ContactosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contactos()
    {
        $contactos = DB::table('contactos')->orderBy('Nombre', 'asc')->whereNull('FechaBaja')->paginate(15);

        $descripciontipo = DB::table('contactos')
            ->join('contactotipo', 'contactos.CD_ContactoTipo', '=', 'contactotipo.CD_ContactoTipo')
            ->select('contactos.CD_Contacto', 'contactotipo.Descripcion', 'contactotipo.CD_ContactoTipo')
            ->get();

        return view('/contactos')
                ->with('contactos', $contactos)
                ->with('descripciontipo', $descripciontipo);
    }

    public function nuevocontacto()
    {
        $contactos = DB::table('contactos')->orderBy('Nombre', 'asc');
        $contactotipo  = DB::table('contactotipo')->orderBy('Descripcion', 'asc')->get();
        $telefonotipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();

        $descripciontipo = DB::table('contactos')
            ->join('contactotipo', 'contactos.CD_ContactoTipo', '=', 'contactotipo.CD_ContactoTipo')
            ->select('contactos.CD_Contacto', 'contactotipo.Descripcion', 'contactotipo.CD_ContactoTipo')
            ->get();

        return view('/abm_acciones/nuevocontacto')
                ->with('contactos', $contactos)
                ->with('contactotipo', $contactotipo)
                ->with('descripciontipo', $descripciontipo)
                ->with('telefonotipo', $telefonotipo);
    }

    public function crearcontacto(Request $request)
    {
        $contacto = new \App\Contacto;
        $telefono = new \App\ContactoTelefono;

        $contacto = DB::table('contactos')->insert([
                'Nombre' => Input::get('nombre'),
                'CD_ContactoTipo' => Input::get('contactotipo'),
                'CorreoCorporativo' => Input::get('correocorporativo'),
                'CorreoPersonal' => Input::get('correopersonal'),
                'Skype' => Input::get('skype'),
                'Notas' => Input::get('notas')
            ]
        );

        $ultimoContactoCreado = DB::table('contactos')->orderBy('CD_Contacto','desc')->first();
        $arrayTelefonos = Input::get('telefono');
        $arrayTipoTelefonos = Input::get('tipotelefono');
        $indexArray = 0;

        if(!empty($arrayTelefonos))
        {
          foreach($arrayTelefonos as $telefonos)
          {
              $telefono = DB::table('contactostelefono')->insert([
                  'CD_Contacto' => $ultimoContactoCreado->CD_Contacto,
                  'CD_TelefonoTipo' => $arrayTipoTelefonos[$indexArray],
                  'Telefono' => $telefonos
                  ]
              );

              $indexArray++;
          }

          $indexArray = 0;
        }

        return redirect('abm/contactos');
    }

    public function mostrarcontacto($id)
    {
        $contacto = Contacto::findOrFail($id);

        $contactotipo = DB::table('contactos')
            ->join('contactotipo', 'contactos.CD_ContactoTipo', '=', 'contactotipo.CD_ContactoTipo')
            ->select('contactotipo.CD_ContactoTipo', 'contactotipo.Descripcion')
            ->where('contactos.CD_Contacto', $id)
            ->get();

        $telefonos = DB::table('contactostelefono')
            ->join('telefonotipo', 'contactostelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
            ->join('contactos', 'contactostelefono.CD_Contacto', '=', 'contactos.CD_Contacto')
            ->select('contactos.Nombre', 'contactostelefono.CD_TelefonoTipo', 'contactostelefono.Telefono', 'telefonotipo.Descripcion')
            ->where('contactostelefono.CD_Contacto', $id)
            ->get();

        return view('abm_acciones/mostrarcontacto')
        ->with('contacto', $contacto)
        ->with('contactotipo', $contactotipo)
        ->with('telefonos', $telefonos);
    }

    public function editarcontacto($id)
    {
        $contacto = Contacto::findOrFail($id);

        $contactotipo = DB::table('contactos')
            ->join('contactotipo', 'contactos.CD_ContactoTipo', '=', 'contactotipo.CD_ContactoTipo')
            ->select('contactotipo.CD_ContactoTipo', 'contactotipo.Descripcion')
            ->where('contactos.CD_Contacto', $id)
            ->get();

        $telefonos = DB::table('contactostelefono')
            ->join('telefonotipo', 'contactostelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
            ->join('contactos', 'contactostelefono.CD_Contacto', '=', 'contactos.CD_Contacto')
            ->select('contactos.Nombre', 'contactostelefono.CD_TelefonoTipo', 'contactostelefono.Telefono', 'telefonotipo.Descripcion')
            ->where('contactostelefono.CD_Contacto', $id)
            ->get();

        $listacontactotipo = DB::table('contactotipo')->orderBy('Descripcion', 'asc')->get();
        $listatelefonos = DB::table('contactostelefono')->orderBy('CD_Contacto', 'asc')->get();
        $listatelefonostipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();

        // show the edit form and pass the nerd
        return view('abm_acciones/editarcontacto')
        ->with('contacto', $contacto)
        ->with('contactotipo', $contactotipo)
        ->with('telefonos', $telefonos)
        ->with('listatelefonos', $listatelefonos)
        ->with('listatelefonostipo', $listatelefonostipo)
        ->with('listacontactotipo', $listacontactotipo);
    }

    public function actualizarcontacto($id, Request $request)
    {
        $contacto = Contacto::find($id);
        $telefonos = ContactoTelefono::find($id);

        $contacto = $contacto->update([
                'Nombre' => Input::get('nombre'),
                'CD_ContactoTipo' => Input::get('contactotipo'),
                'CorreoCorporativo' => Input::get('correocorporativo'),
                'CorreoPersonal' => Input::get('correopersonal'),
                'Skype' => Input::get('skype'),
                'Notas' => Input::get('notas'),
            ]
        );

        $contactotelefono = new \App\ContactoTelefono;

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
                    $contactotelefono = DB::table('contactostelefono')->insert([
                            'CD_Contacto' => $id,
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
                    $contactotelefono = DB::table('contactostelefono')->insert([
                            'CD_Contacto' => $id,
                            'CD_TelefonoTipo' => $arrayTipoTelefono[$indexArray],
                            'Telefono' => $arrTel
                        ]
                    );

                    $indexArray++;
                }
            }
        }

        return redirect('/abm/contactos');
    }

    public function eliminarcontacto($id, Request $request)
    {
        $contacto = Contacto::findOrFail($id);

        $contacto->FechaBaja = Carbon::now();

        $contacto->save();

        return redirect('/abm/contactos');
    }

    public function filtrarcontactos(Request $request)
    {
        if(isset($_POST['filtrar']))
        {
            $filtro = Input::get('filtro');
            $estado = Input::get('opcionesfiltro');

            if($estado == "activo")
                $contactos = DB::table('contactos')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNull('FechaBaja')->paginate(15);
            else
                $contactos = DB::table('contactos')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNotNull('FechaBaja')->paginate(15);

            $descripciontipo = DB::table('contactos')
            ->join('contactotipo', 'contactos.CD_ContactoTipo', '=', 'contactotipo.CD_ContactoTipo')
            ->select('contactos.CD_Contacto', 'contactotipo.Descripcion', 'contactotipo.CD_ContactoTipo')
            ->get();

            return view('/contactos')->with('contactos', $contactos)->with('descripciontipo', $descripciontipo);
        }
        else
        {
            $contactos = DB::table('contactos')->orderBy('Nombre','asc')->paginate(15);

            $descripciontipo = DB::table('contactos')
            ->join('contactotipo', 'contactos.CD_ContactoTipo', '=', 'contactotipo.CD_ContactoTipo')
            ->select('contactos.CD_Contacto', 'contactotipo.Descripcion', 'contactotipo.CD_ContactoTipo')
            ->get();

            return redirect('abm/contactos')->with('contactos', $contactos)->with('descripciontipo', $descripciontipo);
        }
    }
}

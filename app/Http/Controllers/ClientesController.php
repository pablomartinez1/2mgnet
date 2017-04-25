<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Pais;
use App\Provincia;
use App\ClienteTelefono;
use App\SituacionIva;
use App\ClienteTipo;
use App\Canal;
use App\EmpresaRubro;
use App\CondPago;
use App\ClienteContacto;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ClientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function clientes()
    {
      $clientes = DB::table('clientes')->orderBy('Nombre','asc')->whereNull('FechaBaja')->paginate(15);
      $clientestipo = DB::table('clientetipo')->orderBy('CD_ClienteTipo','asc')->get();

      return view('/clientes')->with('clientes', $clientes)->with('clientestipo', $clientestipo);
    }

    public function nuevocliente(Request $request)
    {
            $clientes = DB::table('clientes')->orderBy('Nombre','asc');
            $paises = DB::table('pais')->orderBy('Descripcion', 'asc')->get();
            $provincia = DB::table('provincia')->orderBy('Descripcion', 'asc')->get();
            $situacioniva = DB::table('situacioniva')->orderBy('Descripcion', 'asc')->get();
            $clientetipo = DB::table('clientetipo')->orderBy('Descripcion', 'asc')->get();
            $canal = DB::table('canal')->orderBy('Descripcion', 'asc')->get();
            $empresarubro = DB::table('empresarubro')->orderBy('Descripcion', 'asc')->get();
            $condpago = DB::table('condpago')->orderBy('Descripcion', 'asc')->get();
            $clienteclasificacion = DB::table('clienteclasificacion')->orderBy('Descripcion', 'asc')->get();
            $telefonotipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();
            $contactos = DB::table('contactos')->orderBy('Nombre', 'asc')->whereNull('FechaBaja')->get();

            return view('abm_acciones/nuevocliente')
                    ->with('clientes', $clientes)
                    ->with('paises', $paises)
                    ->with('provincias', $provincia)
                    ->with('situacioniva', $situacioniva)
                    ->with('clientetipo', $clientetipo)
                    ->with('canal', $canal)
                    ->with('empresarubro', $empresarubro)
                    ->with('condpago', $condpago)
                    ->with('clienteclasificacion', $clienteclasificacion)
                    ->with('telefonotipo', $telefonotipo)
                    ->with('contactos', $contactos);
    }

    public function crearcliente(Request $request)
    {
      $cliente = new \App\Cliente;
        $telefono = new \App\ClienteTelefono;
        $contacto = new \App\ClienteContacto;

        $cliente = DB::table('clientes')->insert([
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
        'CD_ClienteTipo' => (Input::get('clientetipo') == "" ? 1 : Input::get('clientetipo')),
        'CD_Canal' => (Input::get('canal') == "" ? NULL : Input::get('canal')),
        'CD_EmpresaRubro' => (Input::get('rubroempresa') == "" ? NULL : Input::get('rubroempresa')),
        'Notas' => (Input::get('notas') == "" ? NULL : Input::get('notas')),
        'CD_CondPago' => (Input::get('condpago') == "" ? NULL : Input::get('condpago')),
        'CD_ClienteClasificacion'  => (Input::get('clienteclasificacion') == "" ? NULL : Input::get('clienteclasificacion'))
            ]
        );

        $ultimoClienteCreado = DB::table('clientes')->orderBy('CD_Cliente','desc')->first();
        $arrayTelefonos = Input::get('telefono');
        $arrayTipoTelefonos = Input::get('tipotelefono');
        $indexArray = 0;

        if(!empty($arrayTelefonos))
        {
          foreach($arrayTelefonos as $telefonos)
          {
            /*
              if($telefonos == NULL)
                  continue;*/

              $telefono = DB::table('clientestelefono')->insert([
                  'CD_Cliente' => $ultimoClienteCreado->CD_Cliente,
                  'CD_TelefonoTipo' => $arrayTipoTelefonos[$indexArray],
                  'Telefono' => $telefonos
                  ]
              );

              $indexArray++;
          }
          $indexArray = 0;
        }

        $arrayContactos = Input::get('contacto');
        $arrayCargoArea = Input::get('cargoarea');

        if(!empty($arrayContactos))
        {
          foreach($arrayContactos as $contactos)
          {
              if($contactos == NULL)
                  continue;

              $contacto = DB::table('clientescontacto')->insert([
                  'CD_Cliente' => $ultimoClienteCreado->CD_Cliente,
                  'CD_Contacto' => $contactos,
                  'CargoArea' => $arrayCargoArea[$indexArray]
                  ]
              );

              $indexArray++;
          }
          $indexArray = 0;
        }

        return redirect('abm/clientes');
    }

    public function mostrarcliente($id)
    {
        $cliente = Cliente::findOrFail($id);

        $paises = DB::table('clientes')
            ->join('pais', 'clientes.CD_Pais', '=', 'pais.CD_Pais')
            ->select('clientes.Nombre', 'pais.Descripcion', 'pais.CD_Pais')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $provincias = DB::table('clientes')
            ->join('provincia', 'clientes.CD_Provincia', '=', 'provincia.CD_Provincia')
            ->select('clientes.Nombre', 'provincia.Descripcion', 'provincia.CD_Provincia')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $telefonos = DB::table('clientestelefono')
            ->join('telefonotipo', 'clientestelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
            ->join('clientes', 'clientestelefono.CD_Cliente', '=', 'clientes.CD_Cliente')
            ->select('clientes.Nombre', 'clientestelefono.CD_TelefonoTipo', 'clientestelefono.Telefono', 'telefonotipo.Descripcion')
            ->where('clientestelefono.CD_Cliente', $id)
            ->get();

        $situacioniva = DB::table('clientes')
            ->join('situacioniva', 'clientes.CD_SituacionIVA', '=', 'situacioniva.CD_SituacionIVA')
            ->select('clientes.Nombre', 'situacioniva.Descripcion', 'situacioniva.CD_SituacionIVA')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $tipocliente = DB::table('clientes')
            ->join('clientetipo', 'clientes.CD_ClienteTipo', '=', 'clientetipo.CD_ClienteTipo')
            ->select('clientes.Nombre', 'clientetipo.Descripcion', 'clientetipo.CD_ClienteTipo')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $canales = DB::table('clientes')
            ->join('canal', 'clientes.CD_Canal', '=', 'canal.CD_Canal')
            ->select('clientes.Nombre', 'canal.Descripcion', 'canal.CD_Canal')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $rubroempresa = DB::table('clientes')
            ->join('empresarubro', 'clientes.CD_EmpresaRubro', '=', 'empresarubro.CD_EmpresaRubro')
            ->select('clientes.Nombre', 'empresarubro.Descripcion', 'empresarubro.CD_EmpresaRubro')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $condicionespago = DB::table('clientes')
            ->join('condpago', 'clientes.CD_CondPago', '=', 'condpago.CD_CondPago')
            ->select('clientes.Nombre', 'condpago.Descripcion', 'condpago.CD_CondPago')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $clasificacionescliente = DB::table('clientes')
            ->join('clienteclasificacion', 'clientes.CD_ClienteClasificacion', '=', 'clienteclasificacion.CD_ClienteClasificacion')
            ->select('clientes.Nombre', 'clienteclasificacion.Descripcion', 'clienteclasificacion.CD_ClienteClasificacion')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $contactos = DB::table('clientescontacto')
            ->join('contactos', 'clientescontacto.CD_Contacto', '=', 'contactos.CD_Contacto')
            ->join('clientes', 'clientescontacto.CD_Cliente', '=', 'clientes.CD_Cliente')
            ->select('clientes.Nombre', 'clientes.CD_Cliente', 'contactos.Nombre', 'contactos.CD_Contacto', 'clientescontacto.CargoArea')
            ->where('clientescontacto.CD_Cliente', $id)
            ->get();

        return view('abm_acciones/mostrarcliente')
        ->with('cliente', $cliente)
        ->with('paises', $paises)
        ->with('provincias', $provincias)
        ->with('telefonos', $telefonos)
        ->with('situacioniva', $situacioniva)
        ->with('tipocliente', $tipocliente)
        ->with('canales', $canales)
        ->with('rubroempresa', $rubroempresa)
        ->with('condicionespago', $condicionespago)
        ->with('clasificacionescliente', $clasificacionescliente)
        ->with('contactos', $contactos);
    }

    public function editarcliente($id)
    {
        $cliente = Cliente::findOrFail($id);

        $paises = DB::table('clientes')
            ->join('pais', 'clientes.CD_Pais', '=', 'pais.CD_Pais')
            ->select('clientes.Nombre', 'pais.Descripcion', 'pais.CD_Pais')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $provincias = DB::table('clientes')
            ->join('provincia', 'clientes.CD_Provincia', '=', 'provincia.CD_Provincia')
            ->select('clientes.Nombre', 'provincia.Descripcion', 'provincia.CD_Provincia')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $telefonos = DB::table('clientestelefono')
            ->join('telefonotipo', 'clientestelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
            ->join('clientes', 'clientestelefono.CD_Cliente', '=', 'clientes.CD_Cliente')
            ->select('clientes.Nombre', 'clientestelefono.CD_TelefonoTipo', 'clientestelefono.Telefono', 'telefonotipo.Descripcion')
            ->where('clientestelefono.CD_Cliente', $id)
            ->get();

        $situacioniva = DB::table('clientes')
            ->join('situacioniva', 'clientes.CD_SituacionIVA', '=', 'situacioniva.CD_SituacionIVA')
            ->select('clientes.Nombre', 'situacioniva.Descripcion', 'situacioniva.CD_SituacionIVA')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $tipocliente = DB::table('clientes')
            ->join('clientetipo', 'clientes.CD_ClienteTipo', '=', 'clientetipo.CD_ClienteTipo')
            ->select('clientes.Nombre', 'clientetipo.Descripcion', 'clientetipo.CD_ClienteTipo')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $canales = DB::table('clientes')
            ->join('canal', 'clientes.CD_Canal', '=', 'canal.CD_Canal')
            ->select('clientes.Nombre', 'canal.Descripcion', 'canal.CD_Canal')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $rubroempresa = DB::table('clientes')
            ->join('empresarubro', 'clientes.CD_EmpresaRubro', '=', 'empresarubro.CD_EmpresaRubro')
            ->select('clientes.Nombre', 'empresarubro.Descripcion', 'empresarubro.CD_EmpresaRubro')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $condicionespago = DB::table('clientes')
            ->join('condpago', 'clientes.CD_CondPago', '=', 'condpago.CD_CondPago')
            ->select('clientes.Nombre', 'condpago.Descripcion', 'condpago.CD_CondPago')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $clasificacionescliente = DB::table('clientes')
            ->join('clienteclasificacion', 'clientes.CD_ClienteClasificacion', '=', 'clienteclasificacion.CD_ClienteClasificacion')
            ->select('clientes.Nombre', 'clienteclasificacion.Descripcion', 'clienteclasificacion.CD_ClienteClasificacion')
            ->where('clientes.CD_Cliente', $id)
            ->get();

        $contactos = DB::table('clientescontacto')
            ->join('contactos', 'clientescontacto.CD_Contacto', '=', 'contactos.CD_Contacto')
            ->join('clientes', 'clientescontacto.CD_Cliente', '=', 'clientes.CD_Cliente')
            ->select('clientes.Nombre', 'clientes.CD_Cliente', 'contactos.Nombre', 'contactos.CD_Contacto', 'clientescontacto.CargoArea', 'clientescontacto.CD_Cliente')
            ->where('clientescontacto.CD_Cliente', $id)
            ->get();

        $listapaises = DB::table('pais')->orderBy('Descripcion', 'asc')->get();
        $listaprovincias = DB::table('provincia')->orderBy('Descripcion', 'asc')->get();
        $listatelefonos = DB::table('clientestelefono')->orderBy('CD_Cliente', 'asc')->get();
        $listatelefonostipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();
        $listasituacionesiva = DB::table('situacioniva')->orderBy('Descripcion', 'asc')->get();
        $listaclientestipo = DB::table('clientetipo')->orderBy('Descripcion', 'asc')->get();
        $listacanales = DB::table('canal')->orderBy('Descripcion', 'asc')->get();
        $listarubrosempresa = DB::table('empresarubro')->orderBy('Descripcion', 'asc')->get();
        $listacondicionespago = DB::table('condpago')->orderBy('Descripcion', 'asc')->get();
        $listaclasificacionescliente = DB::table('clienteclasificacion')->orderBy('Descripcion', 'asc')->get();
        $listacontactos = DB::table('contactos')->orderBy('Nombre', 'asc')->whereNull('FechaBaja')->get();

        // show the edit form and pass the nerd
        return view('abm_acciones/editarcliente')
        ->with('cliente', $cliente)
        ->with('paises', $paises)
        ->with('provincias', $provincias)
        ->with('telefonos', $telefonos)
        ->with('situacioniva', $situacioniva)
        ->with('tipocliente', $tipocliente)
        ->with('canales', $canales)
        ->with('rubroempresa', $rubroempresa)
        ->with('condicionespago', $condicionespago)
        ->with('clasificacionescliente', $clasificacionescliente)
        ->with('contactos', $contactos)
        ->with('listapaises', $listapaises)
        ->with('listaprovincias', $listaprovincias)
        ->with('listatelefonos', $listatelefonos)
        ->with('listatelefonostipo', $listatelefonostipo)
        ->with('listasituacionesiva', $listasituacionesiva)
        ->with('listaclientestipo', $listaclientestipo)
        ->with('listacanales', $listacanales)
        ->with('listarubrosempresa', $listarubrosempresa)
        ->with('listacondicionespago', $listacondicionespago)
        ->with('listaclasificacionescliente', $listaclasificacionescliente)
        ->with('listacontactos', $listacontactos);
    }

    public function actualizarcliente($id, Request $request)
    {
        $cliente = Cliente::find($id);
        $telefonos = ClienteTelefono::find($id);
        $contactos = ClienteContacto::find($id);

        $cliente = $cliente->update([
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
                'CD_ClienteTipo' => (Input::get('clientetipo') == "" ? NULL : Input::get('clientetipo')),
                'CD_Canal' => (Input::get('canal') == "" ? NULL : Input::get('canal')),
                'CD_EmpresaRubro' => (Input::get('rubroempresa') == "" ? NULL : Input::get('rubroempresa')),
                'Notas' => (Input::get('notas') == "" ? NULL : Input::get('notas')),
                'CD_CondPago' => (Input::get('condpago') == "" ? NULL : Input::get('condpago')),
                'CD_ClienteClasificacion'  => (Input::get('clienteclasificacion') == "" ? NULL : Input::get('clienteclasificacion'))
            ]
        );

        $clientetelefono = new \App\ClienteTelefono;

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
                    $clientetelefono = DB::table('clientestelefono')->insert([
                            'CD_Cliente' => $id,
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
                    $clientetelefono = DB::table('clientestelefono')->insert([
                            'CD_Cliente' => $id,
                            'CD_TelefonoTipo' => $arrayTipoTelefono[$indexArray],
                            'Telefono' => $arrTel
                        ]
                    );

                    $indexArray++;
                }
            }
        }

        $clientecontacto = new \App\ClienteContacto;

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
            $arrayCargoArea = Input::get("cargoarea");

            if($arrayContactos != NULL)
            {
                $indexArray = 0;

                foreach($arrayContactos as $arrCon)
                {
                    $clientecontacto = DB::table('clientescontacto')->insert([
                            'CD_Cliente' => $id,
                            'CD_Contacto' => $arrCon,
                            'CargoArea' => $arrayCargoArea[$indexArray]
                        ]
                    );

                    $indexArray++;
                }
            }
        }
        else
        {
            $arrayContactos = Input::get("contacto");
            $arrayCargoArea = Input::get("cargoarea");

            if($arrayContactos != NULL)
            {
                $indexArray = 0;

                foreach($arrayContactos as $arrCon)
                {
                    $clientecontacto = DB::table('clientescontacto')->insert([
                            'CD_Cliente' => $id,
                            'CD_Contacto' => $arrCon,
                            'CargoArea' => $arrayCargoArea[$indexArray]
                        ]
                    );

                    $indexArray++;
                }
            }
        }

        return redirect('/abm/clientes');
    }

    public function eliminarcliente($id, Request $request)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->FechaBaja = Carbon::now();

        $cliente->save();

        return redirect('/abm/clientes');
    }

    public function filtrarclientes(Request $request)
    {
        if(isset($_POST['filtrar']))
        {
            $filtro = Input::get('filtro');
            $estado = Input::get('opcionesfiltro');

            if($estado == "activo")
                $clientes = DB::table('clientes')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNull('FechaBaja')->paginate(15);
            else
                $clientes = DB::table('clientes')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNotNull('FechaBaja')->paginate(15);

            $clientestipo = DB::table('clientetipo')->orderBy('CD_ClienteTipo','asc')->get();

            return view('/clientes')->with('clientes', $clientes)->with('clientestipo', $clientestipo);
        }
        else
        {
            $clientes = DB::table('clientes')->orderBy('Nombre','asc')->paginate(15);

            return redirect('abm/clientes')->with('clientes', $clientes);
        }
    }
}

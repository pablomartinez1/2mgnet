<?php

namespace App\Http\Controllers;

use App\Proveedor;
use App\ProveedorTelefono;
use App\ProveedorContacto;
use App\Pais;
use App\Provincia;
use App\SituacionIva;
use App\EmpresaRubro;
use App\TelefonoTipo;
use App\Contacto;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ProveedoresController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function proveedores()
  {
    $proveedores = Proveedor::whereNull('FechaBaja')->paginate(15);

    return view('/proveedores')->with('proveedores', $proveedores);
  }

  public function nuevoproveedor()
  {
    $paises = Pais::all();
    $provincia = Provincia::all();
    $situacioniva = SituacionIva::all();
    $empresarubro = EmpresaRubro::all();
    $telefonotipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();
    $contactos = DB::table('contactos')->Where('CD_ContactoTipo', '=', '2')->orderBy('Nombre', 'asc')->whereNull('FechaBaja')->get();

    return view('abm_acciones/nuevoproveedor')
      ->with('paises', $paises)
      ->with('provincias', $provincia)
      ->with('situacioniva', $situacioniva)
      ->with('empresarubro', $empresarubro)
      ->with('telefonotipo', $telefonotipo)
      ->with('contactos', $contactos);
  }

  public function crearproveedor(Request $request)
  {
      $proveedor = new \App\Proveedor;
      $telefono = new \App\ProveedorTelefono;
      $contacto = new \App\ProveedorContacto;

      $proveedor = DB::table('proveedores')->insert([
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
            'Horario' => Input::get('horario'),
            'Comisión' => (Input::get('comision') == "" ? NULL : Input::get('comision')),
            'CD_EmpresaRubro' => (Input::get('rubroempresa') == "" ? NULL : Input::get('rubroempresa')),
            'Notas' => (Input::get('notas') == "" ? NULL : Input::get('notas'))
          ]
      );

      $ultimoProveedorCreado = DB::table('proveedores')->orderBy('CD_Proveedor','desc')->first();
      $arrayTelefonos = Input::get('telefono');
      $arrayTipoTelefonos = Input::get('tipotelefono');
      $indexArray = 0;

      if(!empty($arrayTelefonos))
      {
        foreach($arrayTelefonos as $telefonos)
        {
            $telefono = DB::table('proveedorestelefono')->insert([
                'CD_Proveedor' => $ultimoProveedorCreado->CD_Proveedor,
                'CD_TelefonoTipo' => $arrayTipoTelefonos[$indexArray],
                'Telefono' => $telefonos
                ]
            );

            $indexArray++;
        }
        $indexArray = 0;
      }

      $arrayContactos = Input::get('contacto');

      if(!empty($arrayContactos))
      {
        foreach($arrayContactos as $contactos)
        {
            $contacto = DB::table('proveedorescontacto')->insert([
                'CD_Proveedor' => $ultimoProveedorCreado->CD_Proveedor,
                'CD_Contacto' => $contactos
              ]
            );

            $indexArray++;
        }
        $indexArray = 0;
      }

      return redirect('abm/proveedores');
  }

  public function mostrarproveedor($id)
  {
      $proveedor = Proveedor::findOrFail($id);

      $telefonos = DB::table('proveedorestelefono')
          ->join('telefonotipo', 'proveedorestelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
          ->join('proveedores', 'proveedorestelefono.CD_Proveedor', '=', 'proveedores.CD_Proveedor')
          ->select('proveedores.Nombre', 'proveedorestelefono.CD_TelefonoTipo', 'proveedorestelefono.Telefono', 'telefonotipo.Descripcion')
          ->where('proveedorestelefono.CD_Proveedor', $id)
          ->get();

      $contactos = DB::table('proveedorescontacto')
          ->join('contactos', 'proveedorescontacto.CD_Contacto', '=', 'contactos.CD_Contacto')
          ->join('proveedores', 'proveedorescontacto.CD_Proveedor', '=', 'proveedores.CD_Proveedor')
          ->select('proveedores.Nombre', 'proveedores.CD_Proveedor', 'contactos.Nombre', 'contactos.CD_Contacto')
          ->where('proveedorescontacto.CD_Proveedor', $id)
          ->get();

      return view('abm_acciones/mostrarproveedor')
      ->with('proveedor', $proveedor)
      ->with('telefonos', $telefonos)
      ->with('contactos', $contactos);
  }

  public function editarproveedor($id)
  {
      $proveedor = Proveedor::findOrFail($id);

      $telefonos = DB::table('proveedorestelefono')
          ->join('telefonotipo', 'proveedorestelefono.CD_TelefonoTipo', '=', 'telefonotipo.CD_TelefonoTipo')
          ->join('proveedores', 'proveedorestelefono.CD_Proveedor', '=', 'proveedores.CD_Proveedor')
          ->select('proveedores.Nombre', 'proveedorestelefono.CD_TelefonoTipo', 'proveedorestelefono.Telefono', 'telefonotipo.Descripcion')
          ->where('proveedorestelefono.CD_Proveedor', $id)
          ->get();

      $contactos = DB::table('proveedorescontacto')
          ->join('contactos', 'proveedorescontacto.CD_Contacto', '=', 'contactos.CD_Contacto')
          ->join('proveedores', 'proveedorescontacto.CD_Proveedor', '=', 'proveedores.CD_Proveedor')
          ->select('proveedores.Nombre', 'proveedores.CD_Proveedor', 'contactos.Nombre', 'contactos.CD_Contacto', 'proveedorescontacto.CD_Proveedor')
          ->where('proveedorescontacto.CD_Proveedor', $id)
          ->get();

      $listapaises = DB::table('pais')->orderBy('Descripcion', 'asc')->get();
      $listaprovincias = DB::table('provincia')->orderBy('Descripcion', 'asc')->get();
      $listatelefonos = DB::table('proveedorestelefono')->orderBy('CD_Proveedor', 'asc')->get();
      $listatelefonostipo = DB::table('telefonotipo')->orderBy('Descripcion', 'asc')->get();
      $listasituacionesiva = DB::table('situacioniva')->orderBy('Descripcion', 'asc')->get();
      $listarubrosempresa = DB::table('empresarubro')->orderBy('Descripcion', 'asc')->get();
      $listacontactos = DB::table('contactos')->Where('CD_ContactoTipo', '=', '2')->orderBy('Nombre', 'asc')->whereNull('FechaBaja')->get();

      // show the edit form and pass the nerd
      return view('abm_acciones/editarproveedor')
      ->with('proveedor', $proveedor)
      ->with('telefonos', $telefonos)
      ->with('contactos', $contactos)
      ->with('listapaises', $listapaises)
      ->with('listaprovincias', $listaprovincias)
      ->with('listatelefonos', $listatelefonos)
      ->with('listatelefonostipo', $listatelefonostipo)
      ->with('listasituacionesiva', $listasituacionesiva)
      ->with('listarubrosempresa', $listarubrosempresa)
      ->with('listacontactos', $listacontactos);
  }

  public function actualizarproveedor($id, Request $request)
  {
      $proveedor = Proveedor::find($id);
      $telefonos = ProveedorTelefono::find($id);
      $contactos = ProveedorContacto::find($id);

      $proveedor = $proveedor->update([
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
              'Horario' => Input::get('horario'),
              'Comisión' => (Input::get('comision') == "" ? NULL : Input::get('comision')),
              'CD_EmpresaRubro' => (Input::get('rubroempresa') == "" ? NULL : Input::get('rubroempresa')),
              'Notas' => (Input::get('notas') == "" ? NULL : Input::get('notas'))
          ]
      );

      $proveedortelefono = new \App\ProveedorTelefono;

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
                  $proveedortelefono = DB::table('proveedorestelefono')->insert([
                          'CD_Proveedor' => $id,
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
                  $proveedortelefono = DB::table('proveedorestelefono')->insert([
                          'CD_Proveedor' => $id,
                          'CD_TelefonoTipo' => $arrayTipoTelefono[$indexArray],
                          'Telefono' => $arrTel
                      ]
                  );

                  $indexArray++;
              }
          }
      }

      $proveedorcontacto = new \App\ProveedorContacto;

      if($contactos != NULL)
      {
          $contactos->delete();

          $arrayContactos = Input::get("contacto");

          if($arrayContactos != NULL)
          {
              $indexArray = 0;

              foreach($arrayContactos as $arrCon)
              {
                  $proveedorcontacto = DB::table('proveedorescontacto')->insert([
                          'CD_Proveedor' => $id,
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
                  $proveedorcontacto = DB::table('proveedorescontacto')->insert([
                          'CD_Proveedor' => $id,
                          'CD_Contacto' => $arrCon
                      ]
                  );

                  $indexArray++;
              }
          }
      }

      return redirect('/abm/proveedores');
  }

  public function eliminarproveedor($id, Request $request)
  {
      $proveedor = Proveedor::findOrFail($id);

      $proveedor->FechaBaja = Carbon::now();

      $proveedor->save();

      return redirect('/abm/proveedores');
  }

  public function filtrarproveedores(Request $request)
  {
      if(isset($_POST['filtrar']))
      {
          $filtro = Input::get('filtro');
          $estado = Input::get('opcionesfiltro');

          if($estado == "activo")
              $proveedores = DB::table('proveedores')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNull('FechaBaja')->paginate(15);
          else
              $proveedores = DB::table('proveedores')->where('Nombre', 'LIKE', '%' . $filtro . '%')->whereNotNull('FechaBaja')->paginate(15);

          return view('/proveedores')->with('proveedores', $proveedores);
      }
      else
      {
          $proveedores = DB::table('proveedores')->orderBy('Nombre','asc')->paginate(15);

          return redirect('abm/proveedores')->with('proveedores', $proveedores);
      }
  }
}

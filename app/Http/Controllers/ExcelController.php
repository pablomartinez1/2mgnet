<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Contacto;
use App\Evento;
use App\Venue;
use App\Proveedor;

use App\Http\Requests;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
  public function clientes()
  {
    Excel::create('BD_Clientes', function($excel)
    {
      $excel->sheet('Clientes', function($sheet) {

          $clientes = Cliente::all();
          $sheet->fromArray($clientes);

      });
    })->export('xls');
  }

  public function contactos()
  {
    Excel::create('BD_Contactos', function($excel)
    {
      $excel->sheet('Contactos', function($sheet) {

          $contactos = Contacto::all();
          $sheet->fromArray($contactos);

      });
    })->export('xls');
  }

  public function eventos()
  {
    Excel::create('BD_Eventos', function($excel)
    {
      $excel->sheet('Eventos', function($sheet) {

          $eventos = Evento::all();
          $sheet->fromArray($eventos);

      });
    })->export('xls');
  }

  public function venues()
  {
    Excel::create('BD_Venues', function($excel)
    {
      $excel->sheet('Venues', function($sheet) {

          $venues = Venue::all();
          $sheet->fromArray($venues);

      });
    })->export('xls');
  }

  public function proveedores()
  {
    Excel::create('BD_Proveedores', function($excel)
    {
      $excel->sheet('Proveedores', function($sheet) {

          $proveedores = Proveedor::all();
          $sheet->fromArray($proveedores);

      });
    })->export('xls');
  }
}

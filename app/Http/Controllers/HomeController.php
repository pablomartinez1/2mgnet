<?php

namespace App\Http\Controllers;

use App\Pais;
use App\Cliente;
use App\Evento;
use App\User;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
      if(Auth::check())
      {
        return redirect('home');
      }
      else {
        $users = DB::table('users')->orderBy('id', 'asc')->get();

        return view('welcome')->with('users', $users);
      }
    }

    public function test()
    {
      return view('test');
    }

    public function index()
    {
        $eventos = DB::table('eventos')->orderBy('CD_Evento', 'asc')->get();

        foreach($eventos as $dato)
        {
          $fechaCarbon = Carbon::parse($dato->FechaHasta);

          $fechaCarbon = $fechaCarbon->addDay();

          $dato->FechaHasta = $fechaCarbon;
        }

        return view('home')->with('eventos', $eventos);
    }

    public function cambiarpassword()
    {
      return view('cambiarpassword');
    }

    public function actualizarpassword(Request $request)
    {
      $user = User::find(Auth::user()->id);
      /*
      print_r(bcrypt(Input::get('password_actual')));
      dd($user);*/

      if(Hash::check(Input::get('password_actual'), $user->password))
      {
        if(Input::get('password') == Input::get('password_confirmacion'))
        {
          $user = $user->update([
            'password' => Hash::make(Input::get('password'))
          ]);
        }
        else
          return redirect('/cambiarpassword');
      }
      else
        return redirect('/cambiarpassword');

      return redirect('/home');
    }
}

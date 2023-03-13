<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use App\User;
use App\Models\Evento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class EventoController extends Controller
{
    protected $breadcrumb;

    public function __construct()
    {
        $this->middleware('auth');
        $this->breadcrumb['icone'] = 'fa-ticket-alt';
        $this->breadcrumb['titulo'] = 'Eventos';
        \Session::put('menu_pai','eventos');
    }

    public function index(Request $request)
    {
         /* Marcação de Menus */
         Session::put('menu_item','eventos');

         $this->breadcrumb['itens'] = array(
             array('descricao' => 'Dashboard', 'url' => '/'),
             array('descricao' => 'Eventos', 'url' => '#')
         );        
        $breadcrumb = $this->breadcrumb;

        $eventos = Evento::all();
            
        return view('evento/index', compact('breadcrumb','eventos'));
    }

    public function listar()
    {
        $eventos = Evento::all();

        return response()->json($eventos);
    }

    public function alterar(Request $request)
    {
        $evento = Evento::find($request->evento);
        \Session::put('evento_id', $evento->cd_evento_eef);
        \Session::put('evento_cod', $evento->cd_evento_eve);
        \Session::put('evento_nome', $evento->nm_evento_eef);
    }

    public function create()
    {
        /* Marcação de Menus */
        Session::put('menu_item','eventos');

        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Eventos', 'url' => '#')
        );        
        $breadcrumb = $this->breadcrumb;

        return view('evento/create', compact('breadcrumb'));
    }
}
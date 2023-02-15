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

        if($request->ajax()) {
            return DataTables::of($eventos)
                ->addColumn('codigo', function ($evento) {
                    return $evento->cd_evento_eve;
                })
                ->addColumn('ano-ingresso', function ($evento) {
                    return $evento->nu_ano_ingresso_eve;
                })
                ->addColumn('evento', function ($evento) {
                    return $evento->nm_evento_eve;
                })
                ->addColumn('mes-ano', function ($evento) {
                    return $evento->nu_mes_eve.'/'.$evento->nu_ano_eve;
                })
                ->addColumn('dt_inicio', function ($evento) {
                    return date('d/m/Y H:i', strtotime($evento->dt_inicio_inscricao_eve));
                })
                ->addColumn('dt_termino', function ($evento) {
                    return date('d/m/Y H:i', strtotime($evento->dt_fim_inscricao_eve));
                })
                ->addColumn('acoes', function ($evento) {
                    return '<button class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['acoes'])
                ->make(true);
        }
            
        return view('evento/index', compact('breadcrumb'));
    }

    public function listar()
    {
        $eventos = Evento::all();
        return response()->json($eventos);
    }

    public function alterar(Request $request)
    {
        $evento = Evento::find($request->evento);
        \Session::put('evento_id', $evento->cd_evento_eve);
        \Session::put('evento_nome', $evento->nm_evento_eve);
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
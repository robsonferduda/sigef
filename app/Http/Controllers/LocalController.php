<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class LocalController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-map-marker';
        $this->breadcrumb['titulo'] = 'Local';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','local');

        $this->evento = Session::get('evento_id');
    }

    public function listar(Request $request)
    {
        Session::put('menu_item','locais');
        $breadcrumb = $this->breadcrumb;



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



        return view('home', compact('breadcrumb'));
    }

}

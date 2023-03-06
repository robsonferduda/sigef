<?php

namespace App\Http\Controllers;

use App\Models\Local;
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

            $locais = Local::orderBy('nm_local_prova_lop')->get();

            return DataTables::of($locais)
                ->addColumn('codigo', function ($local) {
                    return $local->cd_local_prova_lop;
                })
                ->addColumn('local', function ($local) {
                    return $local->nm_local_prova_lop;
                })
                ->addColumn('acoes', function ($local) {
                    return '<button class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['acoes'])
                ->make(true);
        }

        return view('local.locais', compact('breadcrumb'));
    }

    public function novo(Request $request)
    {
        /* Marcação de Menus */
        Session::put('menu_item','locais');

        $breadcrumb = $this->breadcrumb;

        return view('local.novo', compact('breadcrumb'));
    }

}

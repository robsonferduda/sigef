<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
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
                ->addColumn('estado', function ($local) {
                    return $local->estado->nm_estado_est;
                })
                ->addColumn('local', function ($local) {
                    return $local->nm_local_prova_lop;
                })
                ->addColumn('acoes', function ($local) {
                    return '<button class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-clean btn-icon btn-excluir" title="Excluir" id="'.$local->cd_local_prova_lop.'"><i class="fas fa-trash"></i></button>';
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

    public function destroy($id)
    {
        $local = Local::find($id);

        if($local->setores->isEmpty()){
            $local->delete();
            Flash::success('<i class="fas fa-check text-white mr-2"></i> Local excluído com sucesso.');
        }else{
            Flash::warning('<i class="fas fa-exclamation text-white mr-2"></i> Não é possível excluir este local, ele possui setores vinculados.');
        }
        
        return redirect('locais')->withInput();
    }

}
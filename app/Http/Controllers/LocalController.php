<?php

namespace App\Http\Controllers;

use App\Utils;
use App\Models\Estado;
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
                    return '<a class="btn btn-sm btn-clean btn-icon" title="Editar" href="local/'.$local->cd_local_prova_lop.'/editar"><i class="fas fa-edit"></i></a>
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

        $estados = Estado::all();
        return view('local.novo', compact('breadcrumb','estados'));
    }

    public function editar($id)
    {
        Session::put('menu_item','locais');

        $breadcrumb = $this->breadcrumb;

        $estados = Estado::all();
        $local = Local::find($id);

        return view('local.editar', compact('breadcrumb','estados','local'));
    }

    public function store(Request $request)
    {
        $local = Local::find($request->cd_local_prova_lop);

        if($local){
            Flash::warning("Código de local já cadastrado");
            return redirect('local/novo')->withInput();
        }

        try {
            
            $local = Local::create($request->all());
            Flash::success("Dados inseridos com sucesso");
            return redirect('locais')->withInput();

        } catch (\Illuminate\Database\QueryException $e) {

            Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (Exception $e) {

            Flash::error("Ocorreu um erro ao inserir o registro");
        }
            
        return redirect('local/novo')->withInput();
    }

    public function update(Request $request, Local $local)
    {
        
        try {
            
            $local->update($request->all());
            Flash::success("Dados atualizados com sucesso");
            return redirect('locais')->withInput();

        } catch (\Illuminate\Database\QueryException $e) {

            Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (Exception $e) {

            Flash::error("Ocorreu um erro ao inserir o registro");
        }
            
        return redirect()->back()->withInput();
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
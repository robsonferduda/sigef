<?php

namespace App\Http\Controllers;

use App\Models\Ala;
use App\Models\Local;
use App\Models\Setor;
use App\Models\SetorEvento;
use App\Models\Bloco;
use App\Models\Pavimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\DataTables;

class AlaController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-list-alt';
        $this->breadcrumb['titulo'] = 'Alas';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','ala');

        $this->evento = Session::get('evento_id');
    }

    public function index(Request $request)
    {
        $breadcrumb = $this->breadcrumb;

        $locais = Local::orderBy('nm_local_prova_lop')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();
        
        if($request->ajax()) {

            $local = $request->local;
            $setor  = $request->setor;

            $setor_evento = SetorEvento::where('cd_evento_eef', $this->evento)->where('cd_setor_set', $setor)->first();

            $alas = Ala::with(['SetorEvento'])
                ->when($setor, function ($query) use ($setor_evento) {
                    return $query->where('cd_setor_evento_see', $setor_evento->cd_setor_evento_see);
                })
                ->orderBy('nm_ala_ala')->get();

            return DataTables::of($alas)
                ->addColumn('local', function ($ala) {
                    return ($ala->setorEvento) ? $ala->setorEvento->setor->local->nm_local_prova_lop : 'Não Informado';
                })
                ->addColumn('setor', function ($ala) {
                    return ($ala->setorEvento) ? $ala->setorEvento->setor->nm_abrev_setor_set : 'Não Informado';
                })
                ->addColumn('ala', function ($ala) {
                    return $ala->nm_ala_ala;
                })
                ->addColumn('acoes', function ($ala) {

                    return '<a href="setor/'.$ala->cd_ala_ala.'/editar" class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['acoes'])
                ->make(true);
        }

        return view('ala.index', compact('breadcrumb','setores','locais'));

    }

    public function create()
    {
        $breadcrumb = $this->breadcrumb;

        return view('ala.create', compact('breadcrumb'));
    }

    public function listar(Request $request)
    {
        
    }

    public function novo(Request $request)
    {
    
    }

    public function editar(Request $request, $pavimento)
    {
        
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Sala;
use App\Models\TipoCarteira;
use App\Models\TipoSala;
use App\Models\Bloco;
use App\Models\Pavimento;
use App\Models\Setor;
use App\Models\Local;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\DataTables;

class GrupoController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        $this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-users';
        $this->breadcrumb['titulo'] = 'Grupos';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','grupo');

        $this->evento = Session::get('evento_id');
    }

    public function index()
    {
        $breadcrumb = $this->breadcrumb;

        $locais = Local::orderBy('nm_local_prova_lop')->get();
        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();
        $pavimentos = Pavimento::orderBy('nm_pavimento_pav')->get();
        $tiposSala = TipoSala::orderBy('nm_tipo_tis')->get();
        $tiposCarteira = TipoCarteira::orderBy('nm_tipo_tic')->get();

        return view('grupo.index', compact('breadcrumb','blocos', 'setores', 'pavimentos','locais'));
    }

    public function alocar(Request $request)
    {
        $sala = Sala::where('cd_sala_sal', $request->id_grupo)->first();

        $chave = array('cd_evento_eef' =>$this->evento,
                        'cd_sala_sal' => $request->id_grupo);

        $dados = array('tipo_sala_tis_id' => 1,
                       'nu_carteiras_evs' => round($sala->nu_carteiras_sal * 0.8));

        Grupo::updateOrCreate($chave, $dados);
    }

    public function desalocar(Request $request)
    {
        $sala = Grupo::where('cd_evento_eef', $this->evento)->where('cd_sala_sal', $request->id_grupo)->first();
        $sala->delete();
    }

    public function create()
    {
        $breadcrumb = $this->breadcrumb;

        return view('grupo.create', compact('breadcrumb'));
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
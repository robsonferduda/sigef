<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BlocoController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-building';
        $this->breadcrumb['titulo'] = 'Setor';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','setor');

        $this->evento = Session::get('evento_id');
    }

    public function listar(Request $request)
    {
        Session::put('menu_item','blocos');
        $breadcrumb = $this->breadcrumb;

        $setores = Setor::orderBy('nm_abrev_setor_set')->get();

        if($request->ajax()) {

            $nome  = $request->nome;
            $setor = $request->setor;

            $blocos = Bloco::with(['setor'])
                ->when($nome, function ($query) use ($nome) {
                   return $query->where('nm_bloco_bls', 'ilike', "%$nome%");
                })
                ->when($setor, function ($query) use ($setor) {
                    return $query->where('cd_setor_set', $setor);
                })
                ->orderBy('nm_bloco_bls')->get();

            return DataTables::of($blocos)
                ->addColumn('codigo', function ($bloco) {
                    return $bloco->cd_bloco_setor_bls;
                })
                ->addColumn('bloco', function ($bloco) {
                    return $bloco->nm_bloco_bls;
                })
                ->addColumn('setor', function ($bloco) {
                    return $bloco->setor->nm_abrev_setor_set;
                })
                ->addColumn('endereco', function ($bloco) {
                    return $bloco->nm_endereco_acesso_bls;
                })
                ->addColumn('muro', function ($bloco) {
                    return $bloco->fl_muro_bls ? 'Sim' : 'Não';
                })
                ->addColumn('guarita', function ($bloco) {
                    return $bloco->fl_guarita_bls ? 'Sim' : 'Não';
                })
                ->addColumn('elevador', function ($bloco) {
                    return $bloco->fl_elevador_bls ? 'Sim' : 'Não';
                })
                ->addColumn('portao', function ($bloco) {
                    return $bloco->fl_portao_bls ? 'Sim' : 'Não';
                })
                ->addColumn('rampa', function ($bloco) {
                    return $bloco->fl_rampa_bls ? 'Sim' : 'Não';
                })
                ->addColumn('vigilancia', function ($bloco) {
                    return $bloco->fl_vigilancia_bls ? 'Sim' : 'Não';
                })
                ->addColumn('monitoramento', function ($bloco) {
                    return $bloco->fl_monitoramento_bls ? 'Sim' : 'Não';
                })
                ->addColumn('estacionamento', function ($bloco) {
                    return $bloco->fl_estacionamento_bls ? 'Sim' : 'Não';
                })
                ->addColumn('wifi', function ($bloco) {
                    return $bloco->fl_wifi_bls ? 'Sim' : 'Não';
                })
                ->addColumn('acoes', function ($bloco) {

                    return '<a href="bloco/'.$bloco->cd_bloco_setor_bls.'/editar" class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['setor_abrev','acoes'])
                ->make(true);
        }

        return view('bloco.blocos', compact('breadcrumb', 'setores'));
    }

    public function novo(Request $request)
    {
        /* Marcação de Menus */
        Session::put('menu_item','locais');

        $setores = Setor::orderBy('nm_abrev_setor_set')->get();

        $breadcrumb = $this->breadcrumb;

        return view('bloco.novo', compact('breadcrumb', 'setores'));
    }

    public function salvar(Request $request)
    {
        Bloco::create([
            'cd_setor_set' => $request->setor,
            'nm_endereco_acesso_bls' => $request->endereco,
            'fl_muro_bls' => isset($request->muro),
            'fl_guarita_bls' => isset($request->guarita),
            'fl_elevador_bls' => isset($request->elevador),
            'fl_portao_bls' => isset($request->portao),
            'fl_rampa_bls' => isset($request->rampa),
            'fl_vigilancia_bls' => isset($request->vigilancia),
            'fl_monitoramento_bls' => isset($request->monitoramento),
            'fl_estacionamento_bls' => isset($request->estacionamento),
            'fl_wifi_bls' => isset($request->wifi),
            'nm_bloco_bls' => $request->nome
        ]);

        return redirect('blocos');
    }

    public function editar(Request $request, $bloco) {

        /* Marcação de Menus */
        Session::put('menu_item','locais');
        $breadcrumb = $this->breadcrumb;

        $bloco = Bloco::find($bloco);

        if($request->post()) {
            $bloco->update([
                'cd_setor_set' => $request->setor,
                'nm_endereco_acesso_bls' => $request->endereco,
                'fl_muro_bls' => isset($request->muro),
                'fl_guarita_bls' => isset($request->guarita),
                'fl_elevador_bls' => isset($request->elevador),
                'fl_portao_bls' => isset($request->portao),
                'fl_rampa_bls' => isset($request->rampa),
                'fl_vigilancia_bls' => isset($request->vigilancia),
                'fl_monitoramento_bls' => isset($request->monitoramento),
                'fl_estacionamento_bls' => isset($request->estacionamento),
                'fl_wifi_bls' => isset($request->wifi),
                'nm_bloco_bls' => $request->nome
            ]);

            return redirect('blocos');
        }

        $setores = Setor::orderBy('nm_abrev_setor_set')->get();

        return view('bloco.editar', compact('breadcrumb', 'bloco', 'setores'));
    }
}

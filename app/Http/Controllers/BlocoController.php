<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\DataTables;

class BlocoController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-building';
        $this->breadcrumb['titulo'] = 'Bloco';
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
            $muro =  filter_var($request->muro, FILTER_VALIDATE_BOOLEAN);
            $guarita =  filter_var($request->guarita, FILTER_VALIDATE_BOOLEAN);
            $elevador =  filter_var($request->elevador, FILTER_VALIDATE_BOOLEAN);
            $portao =  filter_var($request->portao, FILTER_VALIDATE_BOOLEAN);
            $rampa =  filter_var($request->rampa, FILTER_VALIDATE_BOOLEAN);
            $vigilancia =  filter_var($request->vigilancia, FILTER_VALIDATE_BOOLEAN);
            $monitoramento =  filter_var($request->monitoramento, FILTER_VALIDATE_BOOLEAN);
            $estacionamento =  filter_var($request->estacionamento, FILTER_VALIDATE_BOOLEAN);
            $wifi = filter_var($request->wifi, FILTER_VALIDATE_BOOLEAN);

            $blocos = Bloco::with(['setor'])
                ->when($nome, function ($query) use ($nome) {
                   return $query->where('nm_bloco_bls', 'ilike', "%$nome%");
                })
                ->when($setor, function ($query) use ($setor) {
                    return $query->where('cd_setor_set', $setor);
                })
                ->when($muro, function ($query) use ($muro) {
                    return $query->where('fl_muro_bls', $muro);
                })
                ->when($guarita, function ($query) use ($guarita) {
                    return $query->where('fl_guarita_bls', $guarita);
                })
                ->when($elevador, function ($query) use ($elevador) {
                    return $query->where('fl_elevador_bls', $elevador);
                })
                ->when($portao, function ($query) use ($portao) {
                    return $query->where('fl_portao_bls', $portao);
                })
                ->when($rampa, function ($query) use ($rampa) {
                    return $query->where('fl_rampa_bls', $rampa);
                })
                ->when($vigilancia, function ($query) use ($vigilancia) {
                    return $query->where('fl_vigilancia_bls', $vigilancia);
                })
                ->when($monitoramento, function ($query) use ($monitoramento) {
                    return $query->where('fl_monitoramento_bls', $monitoramento);
                })
                ->when($estacionamento, function ($query) use ($estacionamento) {
                    return $query->where('fl_estacionamento_bls', $estacionamento);
                })
                ->when($wifi, function ($query) use ($wifi) {
                    return $query->where('fl_wifi_bls', $wifi);
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
                    return $bloco->fl_muro_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('guarita', function ($bloco) {
                    return $bloco->fl_guarita_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('elevador', function ($bloco) {
                    return $bloco->fl_elevador_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('portao', function ($bloco) {
                    return $bloco->fl_portao_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('rampa', function ($bloco) {
                    return $bloco->fl_rampa_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('vigilancia', function ($bloco) {
                    return $bloco->fl_vigilancia_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('monitoramento', function ($bloco) {
                    return $bloco->fl_monitoramento_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('estacionamento', function ($bloco) {
                    return $bloco->fl_estacionamento_bls ? 'Sim' : 'N??o';
                })
                ->addColumn('wifi', function ($bloco) {
                    return $bloco->fl_wifi_bls ? 'Sim' : 'N??o';
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
        /* Marca????o de Menus */
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

        /* Marca????o de Menus */
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

    public function buscarBlocosPorSetor($setor)
    {
        $blocos = Bloco::where('cd_setor_set', $setor)->orderBy('nm_bloco_bls')->get();

        return json_encode($blocos);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use App\Models\Pavimento;
use App\Models\Sala;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\DataTables;

class SalaController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-building';
        $this->breadcrumb['titulo'] = 'Sala';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','setor');

        $this->evento = Session::get('evento_id');
    }

    public function listar(Request $request)
    {
        Session::put('menu_item','salas');
        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();
        $pavimentos = Pavimento::orderBy('nm_pavimento_pav')->get();

        if($request->ajax()) {

            $nome  = $request->nome;
            $setor = $request->setor;
            $bloco = $request->bloco;
            $pavimento = $request->pavimento;

            $salas = Sala::with(['tipoSala', 'tipoCarteira'])->when($nome, function ($query) use ($nome) {
                return $query->where('nm_sala_sal', 'ilike', "%$nome%");
            })
                ->when($pavimento, function ($query) use ($pavimento) {
                    return $query->where('cd_pavimento_pav', $pavimento);
                })
                ->when($bloco, function ($query) use ($bloco) {
                    $query->whereHas('pavimento', function ($query) use ($bloco){
                       $query->where('cd_bloco_setor_bls', $bloco);
                    });
                })
                ->when($setor, function ($query) use ($setor) {
                    $query->whereHas('pavimento', function ($query) use ($setor){
                        $query->whereHas('bloco', function ($query) use ($setor){
                            $query->where('cd_setor_set', $setor);
                        });
                    });
                })
                ->orderBy('nm_sala_sal')->get();

            return DataTables::of($salas)
                ->addColumn('codigo', function ($sala) {
                    return $sala->cd_sala_sal;
                })
                ->addColumn('pavimento', function ($sala) {
                    return $sala->pavimento->nm_pavimento_pav;
                })
                ->addColumn('bloco', function ($sala) {
                    return $sala->pavimento->bloco->nm_bloco_bls;
                })
                ->addColumn('setor', function ($sala) {
                    return $sala->pavimento->bloco->setor->nm_setor_set;
                })
                ->addColumn('sala', function ($sala) {
                    return $sala->nm_sala_sal;
                })
                ->addColumn('tipo_sala', function ($sala) {
                    return $sala->tipoSala->nm_tipo_tis;
                })
                ->addColumn('tipo_carteira', function ($sala) {
                    return $sala->tipoCarteira->nm_tipo_tic;
                })
                ->addColumn('acoes', function ($sala) {

                    return '<a href="pavimento/'.$sala->cd_sala_sal.'/editar" class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['setor_abrev','acoes'])
                ->make(true);
        }

        return view('sala.salas', compact('breadcrumb', 'blocos', 'setores', 'pavimentos'));
    }

    public function novo(Request $request)
    {
        /* Marcação de Menus */
        Session::put('menu_item','pavimentos');

        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();

        return view('pavimento.novo', compact('breadcrumb', 'blocos', 'setores'));
    }

    public function salvar(Request $request)
    {
        $pavimento = Pavimento::create([
            'cd_bloco_setor_bls' => $request->bloco,
            'nm_pavimento_pav' => $request->nome
        ]);

        return redirect('pavimentos');
    }

    public function editar(Request $request, $pavimento)
    {
        /* Marcação de Menus */
        Session::put('menu_item','setores');

        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();

        $pavimento = Pavimento::find($pavimento);

        if($request->post()) {
            $pavimento->update([
                'cd_bloco_setor_bls' => $request->bloco,
                'nm_pavimento_pav' => $request->nome
            ]);

            return redirect('pavimentos');
        }

        return view('pavimento.editar', compact('breadcrumb', 'blocos', 'setores', 'pavimento'));
    }
}

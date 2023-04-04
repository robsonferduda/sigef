<?php

namespace App\Http\Controllers;

use App\Models\Bloco;
use App\Models\Pavimento;
use App\Models\Sala;
use App\Models\Setor;
use App\Models\TipoCarteira;
use App\Models\TipoSala;
use App\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laracasts\Flash\Flash;
use phpDocumentor\Reflection\Types\Boolean;
use Yajra\DataTables\DataTables;
use App\Enums\TipoCarteira as EnumTipoCarteira;

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
        $tiposCarteira = TipoCarteira::orderBy('nm_tipo_tic')->get();

        if($request->ajax()) {

            $nome  = $request->nome;
            $setor = $request->setor;
            $bloco = $request->bloco;
            $pavimento = $request->pavimento;
            $tipoCarteira = $request->tipo_carteira;

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
                ->when($tipoCarteira, function ($query) use ($tipoCarteira) {
                    return $query->where('cd_tipo_carteira_tic', $tipoCarteira);
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
                ->addColumn('tipo_carteira', function ($sala) {
                    return $sala->tipoCarteira->nm_tipo_tic;
                })
                ->addColumn('numero_carteiras', function ($sala) {
                    return $sala->nu_carteiras_sal;
                })
                ->addColumn('acoes', function ($sala) {

                    return '<a href="sala/'.$sala->cd_sala_sal.'/editar" class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['setor_abrev','acoes'])
                ->make(true);
        }

        return view('sala.salas', compact('breadcrumb', 'blocos', 'setores', 'pavimentos', 'tiposCarteira'));
    }

    public function novo(Request $request)
    {
        /* Marcação de Menus */
        Session::put('menu_item','pavimentos');

        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();
        $tiposCarteira = TipoCarteira::orderBy('nm_tipo_tic')->get();

        return view('sala.novo', compact('breadcrumb', 'blocos', 'setores', 'tiposCarteira'));
    }

    public function salvar(Request $request)
    {
        try{
            $sala = Sala::create([
                'nu_carteiras_sal' => $request->qtd_cardeiras,
                'cd_tipo_carteira_tic' => $request->tipo_carteira,
                'nm_sala_sal' => $request->nome,
                'cd_pavimento_pav' => $request->pavimento,
            ]);
            Flash::success("Dados inseridos com sucesso");

        } catch (\Illuminate\Database\QueryException $e) {

            Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (Exception $e) {

            Flash::error("Ocorreu um erro ao inserir o registro");
        }

        return redirect('salas');
    }

    public function editar(Request $request, $sala)
    {
        /* Marcação de Menus */
        Session::put('menu_item','salas');

        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();
        $tiposCarteira = TipoCarteira::orderBy('nm_tipo_tic')->get();

        $sala = Sala::find($sala);

        if($request->post()) {

            try{

                $sala->update([
                    'nu_carteiras_sal' => $request->qtd_cardeiras,
                    'cd_tipo_carteira_tic' => $request->tipo_carteira,
                    'nm_sala_sal' => $request->nome,
                    'cd_pavimento_pav' => $request->pavimento,
                ]);

                Flash::success("Dados inseridos com sucesso");
                return redirect('salas');

            } catch (\Illuminate\Database\QueryException $e) {

                Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

            } catch (Exception $e) {

                Flash::error("Ocorreu um erro ao inserir o registro");
            }
        }

        return view('sala.editar', compact('breadcrumb', 'blocos', 'setores', 'sala', 'tiposCarteira'));
    }

    public function getSalas($setor, $local)
    {
        $flag_canhoto = false;
        $salas = array();

        $setor = Setor::with('blocos')->where('cd_local_prova_lop', $local)->where('cd_setor_set', $setor)->get();
        
        foreach($setor->first()->blocos as $bloco){
            foreach($bloco->pavimentos as $pavimento){

                foreach($pavimento->salas as $sala){

                    $flag_canhoto = ($sala->cd_tipo_carteira_tic == EnumTipoCarteira::ACADEMICA) ? true : false;

                    $salas[] = array('id' => $sala->cd_sala_sal,
                                     'nome' =>  $sala->nm_sala_sal,
                                     'pavimento' => $pavimento->nm_pavimento_pav ,
                                     'bloco' => $bloco->nm_bloco_bls,
                                     'flag_canhoto' => $flag_canhoto);
                }
            }
        }

        return json_encode($salas);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Banheiro;
use App\Models\Bloco;
use App\Models\Pavimento;
use App\Models\Setor;
use App\Utils;
use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class BanheiroController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        //$this->middleware('auth');
        $this->breadcrumb['icone'] = 'fas fa-toilet';
        $this->breadcrumb['titulo'] = 'Banheiro';
        $this->breadcrumb['itens'] = array();

        \Session::put('menu_pai','setor');

        $this->evento = Session::get('evento_id');
    }

    public function listar(Request $request)
    {
        Session::put('menu_item','banheiros');
        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();
        $pavimentos = Pavimento::orderBy('nm_pavimento_pav')->get();

        if($request->ajax()) {

            $nome  = $request->nome;
            $setor = $request->setor;
            $bloco = $request->bloco;
            $pavimento = $request->pavimento;

            $banheiros = Banheiro::orderBy('nm_banheiro_ban')
                ->when($nome, function ($query) use ($nome) {
                    return $query->where('nm_banheiro_ban', 'ilike', "%$nome%");
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
                })->get();

            return DataTables::of($banheiros)
                ->addColumn('codigo', function ($banheiro) {
                    return $banheiro->cd_banheiro_ban;
                })
                ->addColumn('pavimento', function ($banheiro) {
                    return $banheiro->pavimento->nm_pavimento_pav;
                })
                ->addColumn('bloco', function ($banheiro) {
                    return $banheiro->pavimento->bloco->nm_bloco_bls;
                })
                ->addColumn('setor', function ($banheiro) {
                    return $banheiro->pavimento->bloco->setor->nm_setor_set;
                })
                ->addColumn('banheiro', function ($banheiro) {
                    return $banheiro->nm_banheiro_ban;
                })
                ->addColumn('numero_cabines', function ($banheiro) {
                    return $banheiro->nu_cabines_ban;
                })
                ->addColumn('adaptado', function ($banheiro) {
                    return $banheiro->fl_adaptado_ban ? 'Sim' : 'Não';
                })
                ->addColumn('acoes', function ($banheiro) {
                    return '<a class="btn btn-sm btn-clean btn-icon" title="Editar" href="banheiro/'.$banheiro->cd_banheiro_ban.'/editar"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-clean btn-icon btn-excluir" title="Excluir" id="'.$banheiro->cd_banheiro_ban.'"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['acoes'])
                ->make(true);
        }

        return view('banheiro.banheiros', compact('breadcrumb', 'blocos', 'setores', 'pavimentos'));
    }

    public function novo(Request $request)
    {
        /* Marcação de Menus */
        Session::put('menu_item','banheiros');

        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();

        return view('banheiro.novo', compact('breadcrumb', 'blocos', 'setores'));
    }

    public function salvar(Request $request)
    {
        try{

            $banheiro = Banheiro::create([
                'nm_banheiro_ban' => $request->nome,
                'fl_adaptado_ban' => isset($request->adaptado),
                'cd_pavimento_pav' => $request->pavimento,
                'nu_cabines_ban' => $request->qtd_cabines
            ]);

            Flash::success("Dados inseridos com sucesso");

        } catch (\Illuminate\Database\QueryException $e) {

            Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

        } catch (Exception $e) {

            Flash::error("Ocorreu um erro ao inserir o registro");
        }

        return redirect('banheiros');
    }

    public function editar(Request $request, $banheiro)
    {
        /* Marcação de Menus */
        Session::put('menu_item','banheiros');

        $breadcrumb = $this->breadcrumb;

        $blocos = Bloco::orderBy('nm_bloco_bls')->get();
        $setores = Setor::orderBy('nm_setor_set')->get();

        $banheiro = Banheiro::find($banheiro);

        if($request->post()) {

            try{

                $banheiro->update([
                    'nm_banheiro_ban' => $request->nome,
                    'fl_adaptado_ban' => isset($request->adaptado),
                    'cd_pavimento_pav' => $request->pavimento,
                    'nu_cabines_ban' => $request->qtd_cabines
                ]);

                Flash::success("Dados inseridos com sucesso");
                return redirect('banheiros');

            } catch (\Illuminate\Database\QueryException $e) {

                Flash::warning(Utils::getDatabaseMessageByCode($e->getCode()));

            } catch (Exception $e) {

                Flash::error("Ocorreu um erro ao inserir o registro");
            }


        }

        return view('banheiro.editar', compact('breadcrumb', 'blocos', 'setores', 'banheiro'));
    }


}

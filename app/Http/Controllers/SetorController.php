<?php

namespace App\Http\Controllers;

use App\Models\Contato;
use App\Models\Local;
use App\Models\RedeEnsino;
use App\Models\Setor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\DataTables;

class SetorController extends Controller
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
        Session::put('menu_item','setores');
        $breadcrumb = $this->breadcrumb;

        if($request->ajax()) {

            $setores = Setor::with(['local', 'redeEnsino', 'contatos'])->orderBy('nm_setor_set')->get();

            return DataTables::of($setores)
                ->addColumn('codigo', function ($setor) {
                    return $setor->cd_setor_set;
                })
                ->addColumn('local', function ($setor) {
                    return $setor->local->nm_local_prova_lop;
                })
                ->addColumn('setor_abrev', function ($setor) {
                    return $setor->nm_abrev_setor_set;
                })
                ->addColumn('setor', function ($setor) {
                    return $setor->nm_setor_set;
                })
                ->addColumn('rede_ensino', function ($setor) {
                    return $setor->redeEnsino->nm_rede_ensino_ree;
                })
                ->addColumn('acoes', function ($setor) {

                    $contatos = '';
                    foreach ($setor->contatos as $contato) {
                        $contatos .= "<strong>".$contato->nm_contato_con."</strong><br/>".$contato->dc_email_con."<br/>".$contato->nu_fone_con."<br/><br/>";
                    }

                    return '<button type="button" class="btn btn-sm btn-clean btn-icon" data-html="true" data-toggle="popover" data-placement="left" data-content="'.$contatos.'">
                             <i class="fa fa-phone"></i></button>
                    <a href="setor/'.$setor->cd_setor_set.'/editar" class="btn btn-sm btn-clean btn-icon" title="Editar"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-sm btn-clean btn-icon" title="Excluir"><i class="fas fa-trash"></i></button>';
                })
                ->rawColumns(['setor_abrev','acoes'])
                ->make(true);
        }

        return view('setor.setores', compact('breadcrumb'));
    }

    public function novo(Request $request)
    {
        /* Marcação de Menus */
        Session::put('menu_item','setores');

        $breadcrumb = $this->breadcrumb;

        $locais = Local::orderBy('nm_local_prova_lop')->get();
        $redes  = RedeEnsino::orderBy('nm_rede_ensino_ree')->get();

        return view('setor.novo', compact('breadcrumb', 'locais', 'redes'));
    }

    public function salvar(Request $request)
    {
        $setor = Setor::create([
            'cd_local_prova_lop' => $request->local,
            'cd_rede_ensino_ree' => $request->rede,
            'nm_abrev_setor_set' => $request->nome,
            'nm_setor_set' => $request->nome_abrev
        ]);

        if($setor) {
            if(isset($request->contato)) {
                foreach ($request->contato as $contato) {
                    Contato::create([
                        'nm_contato_con' => $contato['nome_contato'],
                        'dc_email_con' => $contato['email_contato'],
                        'nu_fone_con' => $contato['telefone_contato'],
                        'cd_setor_set' => $setor->cd_setor_set
                    ]);
                }
            }
        }
        return redirect('setores');
    }

    public function editar(Request $request, $setor)
    {
        /* Marcação de Menus */
        Session::put('menu_item','setores');

        $breadcrumb = $this->breadcrumb;

        $locais = Local::orderBy('nm_local_prova_lop')->get();
        $redes  = RedeEnsino::orderBy('nm_rede_ensino_ree')->get();

        $setor = Setor::with(['contatos'])->find($setor);

        if($request->post()) {
            $setor->update([
                'cd_local_prova_lop' => $request->local,
                'cd_rede_ensino_ree' => $request->rede,
                'nm_abrev_setor_set' => $request->nome_abrev,
                'nm_setor_set' => $request->nome
            ]);

            if(isset($setor->contatos)) {
                $setor->contatos()->delete();
            }

            if(isset($request->contato)) {
                foreach ($request->contato as $contato) {
                    Contato::create([
                        'nm_contato_con' => empty($contato['nome_contato']) ? 'Não Informado' : $contato['nome_contato'],
                        'dc_email_con' => empty($contato['email_contato']) ? null : $contato['email_contato'],
                        'nu_fone_con' => empty($contato['telefone_contato']) ? null : $contato['telefone_contato'],
                        'cd_setor_set' => $setor->cd_setor_set
                    ]);
                }
            }
            return redirect('setores');
        }

        return view('setor.editar', compact('breadcrumb', 'locais', 'redes', 'setor'));
    }
}

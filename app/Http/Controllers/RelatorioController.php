<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use Excel;
use File;
use ZipArchive;
use App\Utils;
use App\Models\Relatorio;
use App\Models\Pessoa;
use App\Models\Candidato;
use App\Models\CandidatoClassificado;
use App\Models\TipoProva;
use App\Models\Categoria;
use App\Models\CategoriaEvento;
use App\Models\Curso;
use App\Models\CursoEvento;
use App\Models\CandidatoCondicaoEspecial;
use App\Models\EventoParametros;
use App\Models\Instituicao;
use App\Models\Municipio;
use App\Models\EstabelecimentoEnsinoEvento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Proner\PhpPimaco\Tag;
use Proner\PhpPimaco\Pimaco;
use Proner\PhpPimaco\Tags\Img;
use App\Exports\CandidatosCondicaoEspecial;
use App\Exports\CandidatoCondicaoEspecialView;

class RelatorioController extends Controller
{
    protected $evento;
    protected $breadcrumb;

    public function __construct()
    {
        $this->middleware('auth');
        $this->breadcrumb['icone'] = 'fa-chart-pie';
        $this->breadcrumb['titulo'] = 'Relatórios';
        $this->breadcrumb['itens'] = array();

        Session::put('menu_pai','relatorios');

        $this->evento = Session::get('evento_id');
    }

    public function index()
    {

    }

    public function indexResultado()
    {
        Session::put('menu_item','relatorios-resultado');

        $this->breadcrumb['itens'] = array(
            array('descricao' => 'Dashboard', 'url' => '/'),
            array('descricao' => 'Relatórios', 'url' => '#')
        );
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $instituicoes = Instituicao::get();
        $municipios = Municipio::where('cd_unidade_federacao_unf', 'SC')->orderBy('nm_municipio_mun')->get();

        return view('relatorios/index', compact('breadcrumb','instituicoes', 'municipios'));

    }

    public function estabelecimentos($cidade)
    {
        $estabelecimentos = EstabelecimentoEnsinoEvento::with(['estabelecimento' => function($query) use($cidade){
            $query->select('cd_municipio_mun','estabelecimento_ensino_ese.cd_estabelecimento_ensino_ese', 'nm_estabelecimento_ensino_ese');
        }])
        ->whereHas('estabelecimento', function ($query) use($cidade){
            $query->where('cd_municipio_mun', $cidade);
        })
        ->where('cd_evento_eve', $this->evento)->get()->sortBy('estabelecimento.nm_estabelecimento_ensino_ese');

        $est = array();

        foreach ($estabelecimentos as $key => $value) {
            $est[]=  array('cd_estabelecimento_ensino_ese' => $value->estabelecimento->cd_estabelecimento_ensino_ese,
                            'nm_estabelecimento_ensino_ese' => $value->estabelecimento->nm_estabelecimento_ensino_ese,
                            'cd_estabelecimento_ensino_evento_eee' => $value->cd_estabelecimento_ensino_evento_eee, );
        }

        return json_encode($est);
    }

    public function condicaoEspecialLogistica()
    {
        return Excel::download(new CandidatoCondicaoEspecialView, 'condicoes_especiais.xls','Html');
        //return Excel::download(new CandidatosCondicaoEspecial('nu_inscricao_can'), 'condicoes_especiais.xlsx', 'Html');
    }

    public function condicaoEspecial($tipo)
    {
        /* Nesse caso, os dados são os mesmos, só alterando a disposição deles nas listagens */
        $candidatos = array();
        $dados = array();
        $visao = null;

        /* Define qual visão chamar e carrega os dados */
        switch ($tipo) {
            case 'coordenacao':
                $visao = 'condicao-especial-coordenacao';
                $candidatos = Candidato::with('condicoes')
                                ->with('localEvento')
                                ->with('grupo')
                                ->whereHas('condicoes')
                                ->where('cd_evento_eve', $this->evento)
                                ->where('fl_homologado_can', true)
                                ->orderBy('cd_local_prova_evento_lpe')
                                ->orderBy('cd_setor_evento_see')
                                ->orderBy('cd_grupo_gru')
                                ->orderBy('nm_candidato_can')
                                ->get();
                break;

            case 'resultado':
                $visao = 'condicao-especial-resultado';
                $candidatos = Candidato::with('condicoes')
                                ->with('localEvento')
                                ->whereHas('condicoes')
                                ->where('cd_evento_eve', $this->evento)
                                ->where('fl_homologado_can', true)
                                ->orderBy('cd_local_prova_evento_lpe')
                                ->orderBy('nm_candidato_can')
                                ->get();
                break;

            case 'junta-medica':
                $visao = 'condicao-especial-junta-medica';

                $candidatos = Candidato::with('condicoes')
                    ->with('localEvento')
                    ->whereHas('condicoes')
                    ->whereHas('condicoes.condicaoEvento', function ($q){
                        return $q->where('fl_junta_medica_cee', true);
                    })
                    ->where('cd_evento_eve', $this->evento)
                    ->where('fl_homologado_can', true)
                    ->orderBy('cd_local_prova_evento_lpe')
                    ->orderBy('nm_candidato_can')
                    ->get();

                break;
        }

        foreach ($candidatos as $key => $candidato) {

            $condicoes = array();

            foreach ($candidato->condicoes as $key => $condicao) {

                $condicoes[] = array('condicao' => $condicao->condicaoEvento->condicao->nm_condicao_especial_coe,
                                     'outro' => $condicao->nm_outra_cce,
                                     'situacao' => ($condicao->situacao) ? $condicao->situacao->nm_situacao_sce : '',
                                     'cor' => ($condicao->situacao) ? $condicao->situacao->ds_color_sce : '#3F4254',
                                     'complemento' => ($condicao->ds_complemento_cce) ? $condicao->ds_complemento_cce : '',
                                     'motivo' => ($condicao->motivoIndeferimento) ? $condicao->motivoIndeferimento->nm_motivo_mic : '');
            }

            $dados[] = array('inscricao' => $candidato->nu_inscricao_can,
                             'nome' => $candidato->nm_candidato_can,
                             'local' => $candidato->localEvento->local->cd_local_prova_lop,
                             'ds_local' => $candidato->localEvento->local->nm_local_prova_lop,
                             'setor' => ($candidato->setorEvento) ? $candidato->setorEvento->setor->cd_setor_sel : true,
                             'ds_setor' => ($candidato->setorEvento) ? $candidato->setorEvento->setor->nm_setor_sel : "Não definido",
                             'grupo' => $candidato->grupo->nu_grupo_gru,
                             'ordem' => $candidato->cd_ordem_can,
                             'condicoes' => $condicoes);
        }

        $eventoParametros = EventoParametros::where('cd_evento_eve',$this->evento)->first();

        $data = [
            'evento'     => Session::get('evento_nome'),
            'logo'       => $eventoParametros->nm_logo_evp,
            'candidatos' => $dados
        ];

        return $pdf = PDF::loadView('relatorios.pdf.'.$visao,
                                    $data,
                                    [],
                                    ['title' => 'Relação de Condições Especiais - Coordenação','format' => 'A4-L'])
                         ->download('relatorio_condicoes_especiais.pdf');
    }

    public function graficaTotalProvasLocalSetorGrupoCorProva(Request $request){

        $input = $request->all();

        $relatorio = new Relatorio();
        $prova   = $input['prova'];
        $input['numeroMinimo'] = (int)$input['numeroMinimo'];

        if(!empty($input['local'])){
            $local = $input['local'];
        }else{
            $local = '';
        }

        if(!empty($input['setor'])){
            $setor = $input['setor'];
        }else{
            $setor = '';
        }

        $list = $relatorio->buscaProvasLocalSetorGrupoCorProvaGrafica($this->evento,$setor,$local);

        $dados = array();
        $i = 0;

        foreach ($list as $key => $value) {

            $local   = $value->cd_local_prova_lop;
            $nmLocal = $value->nm_local_prova_lop;
            $setor   = $value->cd_setor_sel;
            $setorUnico   = $value->cd_unico_sel;
            $nmSetor = $value->nm_setor_sel;
            $grupo   = $value->cd_grupo_gru;
            $grupoUnico   = $value->nu_grupo_gru;
            $grupoTotal = $value->grupo_total;
            $tipo   = $value->tipo;
            $percentual = 0;

            if($local == 1){
                $percentual = $input['percentualFpolis']/100;
            }else{
                $percentual = $input['percentualInterior']/100;
            }

            if($prova == 1){

                $fileName = 'totalProvasLocalSetorGrupoCorProvaGrafica';

                if($tipo == 1){
                    $totalCinza    = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,11);
                    $totalMarfim   = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,12);
                    $totalRosa     = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,13);
                    $totalAmarela  = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,14);
                    $totalAzul     = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,15);
                    $totalVerde    = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,16);
                    $totalVioleta  = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,17);
                    $totalLaranja  = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,18);
                    $totalMarrom   = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,19);
                }else{
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,11, $percentual);
                    $totalCinza    = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,12, $percentual);
                    $totalMarfim   = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,13, $percentual);
                    $totalRosa     = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,14, $percentual);
                    $totalAmarela  = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,15, $percentual);
                    $totalAzul     = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,16, $percentual);
                    $totalVerde    = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,17, $percentual);
                    $totalVioleta  = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,18, $percentual);
                    $totalLaranja  = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,19, $percentual);
                    $totalMarrom   = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                }

                $total = $totalCinza + $totalMarfim + $totalRosa + $totalAmarela + $totalAzul + $totalVerde + $totalVioleta + $totalLaranja + $totalMarrom;

                $dados[$i] = array('local' =>  str_pad($local, 2, '0', STR_PAD_LEFT),'nmLocal' => $nmLocal,'nmSetor' => $nmSetor ,'setor' => str_pad($setorUnico, 2, '0', STR_PAD_LEFT), 'grupo' => str_pad($grupoUnico, 2, '0', STR_PAD_LEFT), 'prova' => $prova,'totalCinza' => $totalCinza,'totalMarfim' => $totalMarfim, 'totalRosa' => $totalRosa, 'totalAmarela' => $totalAmarela, 'totalAzul' => $totalAzul, 'totalVerde' => $totalVerde, 'totalVioleta' => $totalVioleta, 'totalLaranja' => $totalLaranja, 'totalMarrom' => $totalMarrom, 'total' => $total, 'grupoTotal' => $grupoTotal);

                $i++;

            }else{
                if($prova == 2){

                    $fileName = 'totalProvasLocalSetorGrupoCorProvaGrafica2';

                    if($tipo == 1){

                        $totalAmarela = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,21);
                        $totalAzul    = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,22);
                        $totalVerde   = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,23);
                        $totalVioleta = (int)$relatorio->buscaQtdPorCorProva($this->evento,$local,$setor,$grupo,$prova,24);

                    }else{

                        $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,21, $percentual);
                        $totalAmarela = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                        $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,22, $percentual);
                        $totalAzul    = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                        $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,23, $percentual);
                        $totalVerde   = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                        $qdt = (int)$relatorio->buscaQtdPorCorProvaReserva($this->evento,$local,$setor,$prova,24, $percentual);
                        $totalVioleta = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    }

                    $total = $totalAmarela + $totalAzul + $totalVerde + $totalVioleta;

                    $dados[$i] = array('local' =>  str_pad($local, 2, '0', STR_PAD_LEFT),'nmLocal' => $nmLocal,'nmSetor' => $nmSetor ,'setor' => str_pad($setorUnico, 2, '0', STR_PAD_LEFT), 'grupo' => str_pad($grupoUnico, 2, '0', STR_PAD_LEFT), 'prova' => $prova,'totalAmarela' => $totalAmarela, 'totalAzul' => $totalAzul, 'totalVerde' => $totalVerde, 'totalVioleta' => $totalVioleta, 'total' => $total, 'grupoTotal' => $grupoTotal);

                    $i++;
                }else{

                    $fileName = 'totalProvasLocalSetorGrupoCorProvaGrafica3';

                    if($tipo == 1){
                        $totalMarfim   = (int)$relatorio->buscaQtdProva($this->evento,$local,$setor,$grupo);
                    }else{
                        $qdt = (int)$relatorio->buscaQtdProva($this->evento,$local,$setor,$grupo);
                        $totalMarfim = ($qdt < $input['numeroMinimo'])? $input['numeroMinimo'] : $qdt ;
                    }

                    $total = $totalMarfim;

                    $dados[$i] = array('local' =>  str_pad($local, 2, '0', STR_PAD_LEFT),'nmLocal' => $nmLocal,'nmSetor' => $nmSetor ,'setor' => str_pad($setorUnico, 2, '0', STR_PAD_LEFT), 'grupo' => str_pad($grupoUnico, 2, '0', STR_PAD_LEFT), 'prova' => $prova,'totalMarfim' => $totalMarfim, 'total' => $total, 'grupoTotal' => $grupoTotal);

                    $i++;
                }
            }

        }

        $eventoParametros = EventoParametros::where('cd_evento_eve',$this->evento)->first();
        $eventoParametros->nu_percentual_reserva_fpolis_evp = $input['percentualFpolis'];
        $eventoParametros->nu_percentual_reserva_interior_evp = $input['percentualInterior'];
        $eventoParametros->nu_qtd_minima_prova_reserva_evp = $input['numeroMinimo'];

        $eventoParametros->save();

        $data = [
            'evento'     => Session::get('evento_nome'),
            'logo'       => $eventoParametros->nm_logo_evp,
            'candidatos' => $dados
        ];

        //dd($dados);

        return $pdf = PDF::loadView('relatorios.pdf.'. $fileName,
                                    $data,
                                    [],
                                    ['title' => $fileName,'format' => 'A4'])
                         ->download($fileName.'_'.$this->evento.'.pdf');

    }

    public function graficaEtiquetas(Request $request){

        $pimaco = new Pimaco('6183');

        $input = $request->all();

        $relatorio = new Relatorio();
        $prova   = $input['prova'];
        $input['numeroMinimo'] = (int)$input['numeroMinimo'];
        $maximoPacote = (int)$input['maximoPacote'];
        $tipoRelatorio = $input['tipoRelatorio'];
        $opcaoReservas = $input['opcaoReservas'];

        if(!empty($input['local'])){
            $local = $input['local'];
        }else{
            $local = '';
        }

        if(!empty($input['setor'])){
            $setor = $input['setor'];
        }else{
            $setor = '';
        }

        $titulo = "";
        $topo   = "";

        switch($tipoRelatorio){
            case 'cartao':
                $titulo = "CARTÃO-RESPOSTA";
                $topo   = "Prova $prova";
            break;
            case 'provas':
                $titulo = " ";
                $topo   = "Prova $prova";
            break;

            case 'discursivas':
                $titulo = "FOLHA OFICIAL DISCURSIVAS";
                $topo   = "Prova $prova";
            break;

            case 'redacao':
                $titulo = "FOLHA OFICIAL REDAÇÃO";
                $topo   = "Prova $prova";
            break;
            default:
                die("Nenhum tipo escolhido.");
            break;
        }

        $list = $relatorio->buscaProvasLocalSetorGrupoCorProvaGrafica($this->evento,$setor,$local);

        if(count($list)<1){
            die("Nenhum candidato encontrado.");
        }

        $dados = array();

        foreach ($list as $key => $value) {

            $local   = $value->cd_local_prova_lop;
            $nmLocal = $value->nm_local_prova_lop;
            $setor   = $value->cd_setor_sel;
            $setorUnico   = $value->cd_unico_sel;
            $nmSetor = $value->nm_setor_sel;
            $grupo   = $value->cd_grupo_gru;
            $grupoUnico   = $value->nu_grupo_gru;
            $etiqLocal = str_pad($local, 2, '0', STR_PAD_LEFT)."  <span style='font-size:10px;'>".$nmLocal.'</span>';
            $etiqSetor = str_pad($setorUnico, 2, '0', STR_PAD_LEFT)."  <span style='font-size:9px;'>".$nmSetor.'</span>';
            $etiqGrupo = str_pad($grupoUnico, 3, '0', STR_PAD_LEFT);
            $grupoTotal = $value->grupo_total;
            $tipo   = $value->tipo;
            $percentual = 0;

            if($local == 1){
                $percentual = $input['percentualFpolis']/100;
            }else{
                $percentual = $input['percentualInterior']/100;
            }

            if($tipo == 1 and $opcaoReservas != 'somenteReservas'){
                $totalGrupo    = (int)$relatorio->buscaQtdProva($this->evento,$local,$setor,$grupo);

                if($tipoRelatorio == 'provas' and $totalGrupo > $maximoPacote){

                    $impressao  = true;
                    $pacote     = 1;
                    $nuEtiquetasOriginais = ceil($totalGrupo/$maximoPacote);
                    $totalGrupoOriginais = $totalGrupo;

                    while ($impressao) {

                            $nuEtiquetas = ceil($totalGrupo/$maximoPacote);
                            $nuProvasPacote = ceil($totalGrupo/$nuEtiquetas);

                            $tituloModificado = ($nuEtiquetasOriginais > 1)? 'PACOTE '.$pacote.' ('.$nuProvasPacote.') Provas': '';

                            $tag = $this->criaTag($topo, $tituloModificado, $etiqLocal,$etiqSetor, $etiqGrupo, $totalGrupoOriginais);
                            $pimaco->addTag($tag);

                            $pacote++;
                            $totalGrupo = $totalGrupo - $nuProvasPacote;

                        if($totalGrupo <= 0){
                            $impressao = false;
                        }
                    }

                }else{

                    $tag = $this->criaTag($topo, $titulo, $etiqLocal,$etiqSetor, $etiqGrupo, $totalGrupo);
                    $pimaco->addTag($tag);
                }
            }elseif($tipo != 1 and $opcaoReservas != 'semReservas'){
                $etiqGrupo = null;
                if($tipoRelatorio == 'provas'){

                    $tipos = TipoProva::where('cd_evento_eve',$this->evento)->where('cd_prova_pro',$prova)->get()->sortBy('nu_tipo_tip');
                    $totalCor    = 0;
                    $nomeCor    =  '';

                    foreach ($tipos as $key => $value) {
                        $cor = $relatorio->buscaQtdComCorProvaReserva($this->evento,$local,$setor,$prova,$value->nu_tipo_tip, $percentual);

                        if($cor){
                            $totalCor    = ($cor->qtd < $input['numeroMinimo'])? $input['numeroMinimo'] : $cor->qtd ;
                            $nomeCor    =  $cor->nm_tipo_tip;
                        }else{
                            $totalCor    = $input['numeroMinimo'];
                            $nomeCor    =  $tipos->where('nu_tipo_tip',$value->nu_tipo_tip)->first()->nm_tipo_tip;
                        }

                        $tituloModificado = 'RESERVAS '.$nomeCor;

                        if($tipoRelatorio == 'provas' and $totalCor > $maximoPacote){

                            $impressao  = true;
                            $pacote     = 1;
                            $nuEtiquetasOriginais = ceil($totalCor/$maximoPacote);
                            $totalGrupoOriginais = $totalCor;

                            while ($impressao) {

                                    $nuEtiquetas = ceil($totalCor/$maximoPacote);
                                    $nuProvasPacote = ceil($totalCor/$nuEtiquetas);

                                    $tituloModificadoRes = ($nuEtiquetasOriginais > 1)? $tituloModificado.' - PACOTE '.$pacote.' ('.$nuProvasPacote.') ': '';

                                    $tag = $this->criaTag($topo, $tituloModificadoRes, $etiqLocal,$etiqSetor, $etiqGrupo, $totalGrupoOriginais);
                                    $pimaco->addTag($tag);

                                    $pacote++;
                                    $totalCor = $totalCor - $nuProvasPacote;

                                if($totalCor <= 0){
                                    $impressao = false;
                                }
                            }

                        }else{

                            $tag = $this->criaTag($topo, $tituloModificado, $etiqLocal,$etiqSetor, $etiqGrupo, $totalCor);
                            $pimaco->addTag($tag);
                        }
                    }
                }else{
                    $totalGrupo    = (int)($relatorio->buscaQtdProvaParaReserva($this->evento,$local,$setor) * $percentual);
                    $totalCor    = 0;
                     $tituloModificado = 'RESERVAS - '.$titulo;
                    if($totalGrupo){
                        $totalCor    = ($totalGrupo < $input['numeroMinimo'])? $input['numeroMinimo'] : $totalGrupo ;
                    }else{
                        $totalCor    = $input['numeroMinimo'];
                    }
                    $tag = $this->criaTag($topo, $tituloModificado, $etiqLocal,$etiqSetor, $etiqGrupo, $totalCor);
                    $pimaco->addTag($tag);
                }
            }

        }

        $eventoParametros = EventoParametros::where('cd_evento_eve',$this->evento)->first();
        $eventoParametros->nu_percentual_reserva_fpolis_evp = $input['percentualFpolis'];
        $eventoParametros->nu_percentual_reserva_interior_evp = $input['percentualInterior'];
        $eventoParametros->nu_qtd_minima_prova_reserva_evp = $input['numeroMinimo'];

        $eventoParametros->save();

        $data = [
            'evento'     => Session::get('evento_nome'),
            'logo'       => $eventoParametros->nm_logo_evp,
            'candidatos' => $dados
        ];

        $pimaco->output();

    }

    public function criaTag($topo, $titulo, $local, $setor, $grupo, $total){
        $tag = new Tag();
        $tag->img("img/ufsc.jpg")->setHeight(13)->setAlign('left');
        $tag->p("Universidade Federal de Santa Catarina<br>");
        $tag->p("Comissão Permanente do Vestibular<br>");
        $tag->p(Session::get('evento_nome')."<br>");
        $tag->p($topo."<br>")->setSize(4)->b();
        $tag->p("<span style='color:red'>".$titulo."</span><br><br>");
        $tag->p("Local: <span style='font-weight:bold;'>".$local."</span><br>");
        $tag->p("Setor: <span style='font-weight:bold;'>".substr($setor,0,90)."</span><br>");
        if(!is_null($grupo)) {
            $tag->p("Grupo: <span style='font-weight:bold;'>".$grupo."</span>");
        }
        $tag->p("<div style='text-align:right;padding-right:3px;'>Total: <span style='font-weight:bold;'>".$total."</span></div>");

        return $tag->setPadding(1.2);

    }

     public function gerarPdfCurso($id, $todos=false)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $curso= Curso::where('cd_curso_cur', $id)->with('instituicao')->with('campus')
                ->first();

        $candidatoClassificado = new CandidatoClassificado();
        $classificados = $candidatoClassificado->getClassificadosCurso($this->evento, $curso->cd_curso_cur);

            $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'curso'  => $curso,
                'classificados' => $classificados,
            ];

        if($todos){
            if(!is_dir(public_path('resultado_por_curso/'.$this->evento))){
                mkdir(public_path('resultado_por_curso/'.$this->evento));
            }
            PDF::loadView('relatorios/pdf/resultado-por-curso', $data, [], ['title' => 'Relação de Candidatos Classificados','format' => 'A4'])->save(public_path('resultado_por_curso/'.$this->evento.'/resultado_'.$id.'.pdf'));
            return true;
        }else{

            return $pdf = PDF::loadView('relatorios/pdf/resultado-por-curso', $data, [], ['title' => 'Relação de Candidatos Classificados','format' => 'A4'])->download('resultado_'.$id.'.pdf');
        }

    }

    public function gerarPdfCompleto($instituicao)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $candidatoClassificado = new CandidatoClassificado();
        $classificados = $candidatoClassificado->getClassificadosCompleto($this->evento, $instituicao);

        $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'classificados' => $classificados,
            ];

        return $pdf = PDF::loadView('relatorios/pdf/resultado-completo', $data, [], ['title' => 'Relação de Candidatos Classificados','format' => 'A4'])->download('resultado_completo.pdf');

    }

    public function relatorioResultadoPorCurso(Request $request)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }
        $input = $request->all();

        if(isset($input['completo']) and $input['completo'] == 'S'){
            return $this->gerarPdfCompleto($input['instituicao']);
            exit;
        }else{
            Utils::rrmdir(public_path('resultado_por_curso/'.$this->evento));
            $candidatoClassificado = new CandidatoClassificado();
            $cursos = $candidatoClassificado->getCursosClassificados($this->evento, $input['instituicao']);

            foreach ($cursos as $key => $curso) {
                $this->gerarPdfCurso($curso->cd_curso_cur, true); // todos = true
            }
            $this->geraIndexLinks($cursos);
        }

        $zip = new ZipArchive;
        $fileName = 'resultado_'.$this->evento.'.zip';

        if(is_file(public_path($fileName))){
            unlink(public_path($fileName));
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('resultado_por_curso/'.$this->evento));
            foreach ($files as $key => $value) {
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }


    public function geraIndexLinks($cursos)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $dados = "<html><head><meta charset='utf-8'/>
            <title>Relação dos classificados por curso</title>
            </head><body>
            <br><br><table border=0 align='center'><tr><td align=center><strong>Relação dos classificados</strong><br><br></td></tr>";

        foreach ($cursos as $key => $curso) {
            $dados .= "<tr><td><a href='resultado_".$curso->cd_curso_cur.".pdf' >".$curso->nm_abrev_curso_cur."  -  ".$curso->nm_campus_cam."  ( ".$curso->sg_instituicao_ies." )</a></td></tr>";
        }
        $dados.= "</table><br><br></body></html>";

        $fileName = 'index.html';

        File::put(public_path('resultado_por_curso/'.$this->evento)."/".$fileName,$dados);

        return;
    }


    public function gerarPdfCategoria($categoria, $todos=false)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $candidatoClassificado = new CandidatoClassificado();
        $classificados = $candidatoClassificado->getNotaPrimeiroUltimo($this->evento, $categoria->cd_categoria_cat);

            $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'categoria'  => $categoria->nm_categoria_cat,
                'classificados' => $classificados,
            ];

        if($todos){
            if(!is_dir(public_path('nota_primeiro_ultimo/'.$this->evento))){
                mkdir(public_path('nota_primeiro_ultimo/'.$this->evento));
            }
            PDF::loadView('relatorios/pdf/nota_primeiro_ultimo', $data, [], ['title' => 'Nota do Primeiro e Último Candidato Classificado','format' => 'A4-L'])->save(public_path('nota_primeiro_ultimo/'.$this->evento.'/nota_primeiro_ultimo_cat'.$categoria->cd_categoria_cat.'.pdf'));
            return true;
        }else{

            return $pdf = PDF::loadView('relatorios/pdf/nota_primeiro_ultimo', $data, [], ['title' => 'Nota do Primeiro e Último Candidato Classificado','format' => 'A4-L'])->download('nota_primeiro_ultimo_cat'.$categoria->cd_categoria_cat.'.pdf');
        }

    }

    public function relatorioNotaPrimeiroUltimoClassificado(Request $request)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }
        $input = $request->all();

        if(isset($input['separar']) and $input['separar'] == 'S'){
            return $this->gerarPdfCompleto();
            exit;
        }else{
            Utils::rrmdir(public_path('nota_primeiro_ultimo/'.$this->evento));
            $categorias = CategoriaEvento::where('cd_evento_eve', $this->evento)->with('categoria')->get()->sortBy('cd_categoria_cat');

            foreach ($categorias as $key => $categoria) {
                $this->gerarPdfCategoria($categoria->categoria, true); // todos = true
            }
            $this->geraIndexLinksCategorias($categorias);
        }

        $zip = new ZipArchive;
        $fileName = 'nota_primeiro_ultimo'.$this->evento.'.zip';

        if(is_file(public_path($fileName))){
            unlink(public_path($fileName));
        }

        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('nota_primeiro_ultimo/'.$this->evento));
            foreach ($files as $key => $value) {
                $relativeName = basename($value);
                $zip->addFile($value, $relativeName);
            }
            $zip->close();
        }
        return response()->download(public_path($fileName));
    }


    public function geraIndexLinksCategorias($categorias)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }
        $dados = "<html><head><meta charset='utf-8'/>
            <title>Nota do Primeiro e Último Candidato Classificado</title>
            </head><body>
            <br><br><table border=0 align='center'><tr><td align=center><strong>Nota do Primeiro e Último Candidato Classificado</strong><br><br></td></tr>";

        foreach ($categorias as $key => $categoria) {
            $dados .= "<tr><td><a href='nota_primeiro_ultimo_cat".$categoria->categoria->cd_categoria_cat.".pdf' >".$categoria->categoria->nm_categoria_cat."</a></td></tr>";
        }
        $dados.= "</table><br><br></body></html>";

        $fileName = 'index.html';

        File::put(public_path('nota_primeiro_ultimo/'.$this->evento)."/".$fileName,$dados);

        return;
    }

    public function primeirosClassificados(Request $request)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }
        $input = $request->all();
        $paa = "";
        $candidatos="";

        if(isset($input['paa']) and $input['paa'] == 'S'){
            $paa = "_escolaPublica";
            $candidatoClassificado = new CandidatoClassificado();
            $candidatos= $candidatoClassificado->getPrimeirosClassificadosEscolaPublica($this->evento,$input['instituicao'], $input['limite']);
        }else{
            $candidatoClassificado = new CandidatoClassificado();
            $candidatos= $candidatoClassificado->getPrimeirosClassificados($this->evento,$input['instituicao'], $input['limite']);
        }

        $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'paa'  => $paa,
                'candidatos' => $candidatos,
            ];

            return $pdf = PDF::loadView('relatorios/pdf/primeiros_classificados', $data, [], ['title' => 'Relação dos Primeiros Candidatos Classificado','format' => 'A4-L'])->download($input['limite'].'_primeiros_classificados'.$paa.'.pdf');

    }

    public function estatisticasPorEscola()
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $candidatos="";
        $candidatoClassificado = new CandidatoClassificado();
        $candidatos= $candidatoClassificado->getEstatisticasPorEscola($this->evento);
        $total_inscritos= $candidatoClassificado->getTotalInscritos($this->evento);
        $total_classificados = $candidatoClassificado->getTotalClassificados($this->evento);

        $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'candidatos' => $candidatos,
                'total_inscritos' => $total_inscritos[0]->total,
                'total_classificados' => $total_classificados[0]->total
            ];

            return $pdf = PDF::loadView('relatorios/pdf/estatisticas-por-escola', $data, [], ['title' => 'Estatística de candidatos inscritos e classificados por escola de ensino médio','format' => 'A4-L'])->download('estatisticas-por-escola-ensino-medio.pdf');

    }

    public function relacaoClassificadosPorEscola(Request $request)
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $input = $request->all();

        $estabelecimento = EstabelecimentoEnsinoEvento::with('estabelecimento')->where('cd_estabelecimento_ensino_evento_eee', $input['escola_medio'])->first();

        $candidatos = '';
        $tipo = '';

        if(isset($input['tipo']) and $input['tipo'] == 'inscritos'){
            $tipo = "Inscritos";
             $candidatos = Candidato::where('cd_evento_eve', $this->evento)->where('fl_homologado_can', true)->where('cd_estabelecimento_ensino_evento_eee', $input['escola_medio'])->with('opcao.cursoEvento.curso.campus')->with('opcao.cursoEvento.curso.instituicao')->orderBy('nm_candidato_can')->get();
        }else{
            $tipo = "Classificados";
             $candidatos = Candidato::where('cd_evento_eve', $this->evento)->where('cd_estabelecimento_ensino_evento_eee', $input['escola_medio'])->with('opcao.cursoEvento.curso.campus')->with('opcao.cursoEvento.curso.instituicao')
                            ->whereHas('opcao.classificado')->orderBy('nm_candidato_can')->get();
        }

        $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'estabelecimento'=> $estabelecimento->estabelecimento->nm_estabelecimento_ensino_ese,
                'tipo'=>$tipo,
                'candidatos' => $candidatos
            ];

            return $pdf = PDF::loadView('relatorios/pdf/relacao-classificados-por-escola', $data, [], ['title' => 'Relação de '.$tipo.' por Escola do Ensino Médio','format' => 'A4'])->download('relacao-'.$tipo.'-por-escola-ensino-medio.pdf');

    }

    public function dadosGerais()
    {
        $breadcrumb = $this->breadcrumb;
        if(!Auth::user()->hasPermission('sigeve-relatorios-resultado')) {
            return view('auth/unauthorized', compact('breadcrumb'));
        }

        $dados=array();

        $candidatoClassificado = new CandidatoClassificado();

        $dados['experiencia'] = $candidatoClassificado->getTotalPorExperiencia($this->evento)[0]->total;
        $dados['concorrentes'] = $candidatoClassificado->getTotalConcorrentes($this->evento)[0]->total;
        $dados['inscritos'] = $dados['experiencia']+$dados['concorrentes'];

        $dados['abstencao1'] = $candidatoClassificado->getTotalAbstencaoDia1($this->evento)[0]->total;
        $dados['abstencao2'] = $candidatoClassificado->getTotalAbstencaoDia2($this->evento)[0]->total;
        $dados['abstencaoGeral'] = $candidatoClassificado->getTotalAbstencaoGeral($this->evento)[0]->total;

        $dados['classificados'] = $candidatoClassificado->getTotalClassificados($this->evento)[0]->total;
        $dados['aprovados'] = $candidatoClassificado->getTotalAprovados($this->evento)[0]->total;
        $dados['reprovados'] = $candidatoClassificado->getTotalReprovados($this->evento)[0]->total;

        $dados['reprovadosFalta'] = $candidatoClassificado->getTotalReprovadosFalta($this->evento)[0]->total;
        $dados['reprovadosCorteOpcao1'] = $candidatoClassificado->getTotalReprovadosCorteOpcao1($this->evento)[0]->total;
        $dados['reprovadosCorteOpcao1A'] = $candidatoClassificado->getTotalReprovadosCorteOpcao1A($this->evento)[0]->total;
        $dados['reprovadosRedacao'] = $candidatoClassificado->getTotalReprovadosRedacao($this->evento)[0]->total;

        $dados['vagasOferecidas'] = $candidatoClassificado->getTotalVagasOferecidas($this->evento)[0]->total;
        $dados['vagasOcupadasOpcao1'] = $candidatoClassificado->getTotalVagasOcupadasOpcao1($this->evento)[0]->total;
        $dados['vagasOcupadasOpcao1A'] = $candidatoClassificado->getTotalVagasOcupadasOpcao1A($this->evento)[0]->total;
        $dados['vagasOcupadasTotal'] = $candidatoClassificado->getTotalVagasOcupadasTotal($this->evento)[0]->total;

        $dados['isencoesRequeridas'] = $candidatoClassificado->getTotalIsencoesRequeridas($this->evento)[0]->total;
        $dados['isencoesConcedidas'] = $candidatoClassificado->getTotalIsencoesConcedidas($this->evento)[0]->total;
        $dados['isentosClassificados'] = $candidatoClassificado->getTotalIsentosClassificados($this->evento)[0]->total;

        $data = [
                'evento' => Session::get('evento_nome'),
                'logo' => 'ufsc-ifsc.gif',
                'dados' => $dados
            ];

            return $pdf = PDF::loadView('relatorios/pdf/dados-gerais', $data, [], ['title' => 'Dados Gerais do Vestibular','format' => 'A4'])->download('dados-gerais.pdf');

    }



}

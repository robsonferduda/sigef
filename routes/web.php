<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');
Route::get('meu-perfil','UserController@perfil');
Route::get('painel','DashboardController@painel');

Route::get('site', 'HomeController@site');

Route::get('alocacao/index','AlocacaoController@index');
Route::get('alocacao/canhotos','AlocacaoController@canhotos');
Route::post('alocacao/canhotos','AlocacaoController@canhotos');
Route::get('alocacao/faixas-cep','AlocacaoController@faixasCEP');
Route::post('alocacao/faixas-cep','AlocacaoController@faixasCEP');
Route::get('alocacao/geral','AlocacaoController@geral');
Route::post('alocacao/geral','AlocacaoController@geral');
Route::get('alocacao/condicao-especial','AlocacaoController@condicaoEspecial');
Route::get('alocacao/individual','AlocacaoController@individual');
Route::get('alocacao/sabatistas','AlocacaoController@sabatistas');
Route::get('alocacao/libras','AlocacaoController@libras');
Route::post('alocacao/sabatistas','AlocacaoController@sabatistas');
Route::post('alocacao/libras','AlocacaoController@libras');
Route::match(array('GET', 'POST'),'alocacao/tipo-prova','AlocacaoController@tipoProva')->name('indexAlocarTipoProva');

Route::post('alocacao/alocar-tipo-prova','AlocacaoController@alocarTipoProva');
Route::post('alocacao/alocar/condicoes-especiais','AlocacaoController@alocarCondicoesEspeciais');
Route::match(array('GET', 'POST'),'alocacao/tipo-prova','AlocacaoController@tipoProva')->name('indexAlocarTipoProva');

Route::get('anexos/excluir/{id}','AnexoController@excluir');

Route::get('avaliacao-condicoes-especiais','AvaliacaoCondicaoEspecialController@index');
Route::get('avaliacao-condicoes-especiais/avaliar/{id}','AvaliacaoCondicaoEspecialController@avaliar');
Route::resource('avaliacao-condicoes-especiais','AvaliacaoCondicaoEspecialController');

Route::get('isentos/lei/processamento','AvaliacaoIsencaoController@processamento');
Route::get('isencao/avaliacao/processamento/deferir','AvaliacaoIsencaoController@deferir');
Route::get('isencao/avaliacao/processamento/indeferir','AvaliacaoIsencaoController@indeferir');
Route::resource('avaliacao-isencao','AvaliacaoIsencaoController');

Route::match(array('GET', 'POST'),'candidatos','CandidatoController@index');
Route::match(array('GET', 'POST'),'candidatos/informacao','CandidatoController@informacao');
Route::get('candidatos/buscar/{inscricao}','CandidatoController@buscarByInscricao');
Route::get('candidatos/apenados/{inscricoes}','CandidatoController@getApenados');
Route::get('candidatos/nomes-sociais','CandidatoController@nomesSociais');
Route::get('candidatos/editar/{candidato}','CandidatoController@dados');
Route::get('candidatos/nomes-sociais/remover/{candidato}','CandidatoController@removerNomeSocial');
Route::get('candidatos/apenados','CandidatoController@apenados');
Route::get('candidatos/relatorios','CandidatoController@relatorios');
Route::get('candidato/dados/{id}','CandidatoController@dados');
Route::get('candidato/declaracao-presenca/{id}','CandidatoController@declaracaoPresenca');
Route::get('candidato/dados-informacao/{id}','CandidatoController@dadosInformacao');
Route::post('candidatos/apenados/validar','CandidatoController@validarApenados');
Route::post('candidato/email/alterar','CandidatoController@alterarEmail');
Route::get('candidatos/cancelados','CandidatoController@cancelados');
Route::get('candidatos/inscricao/requerimento/{pessoa}','CandidatoController@requerimento');
Route::get('candidatos/inscricao/confirmacao-definitiva/{pessoa}','CandidatoController@confirmacaoDefinitva');
Route::get('candidatos/inscricao/boletim-definitivo/{pessoa}','CandidatoController@boletimDefinitivo');
Route::get('candidatos/cancelados/desfazer/{candidato}','CandidatoController@desfazerCancelamento');
Route::resource('candidato','CandidatoController');
Route::post('candidatos/altera-lingua-tipo-prova','CandidatoController@alteraLinguaTipoProva');

Route::get('categorias','CategoriaController@index');

Route::get('condicoes-especiais','CondicaoEspecialController@index');
Route::get('condicoes-especiais/evento','CondicaoEspecialController@condicoesEvento');
Route::get('condicoes-especiais/equipe','CondicaoEspecialController@equipe');
Route::get('condicoes-especiais/pedidos','CondicaoEspecialController@pedidos');
Route::get('condicoes-especiais/relatorios','CondicaoEspecialController@relatorios');
Route::get('condicoes-especiais/editar/{id}','CondicaoEspecialController@editar');
Route::get('condicoes-especiais/excluir/{id}','CondicaoEspecialController@editar');
Route::get('condicoes-especiais/detalhes/{id}','CondicaoEspecialController@detalhes');
Route::get('condicoes-especiais/candidatos/lista/{lista}/local/{local}/condicao/{condicao}','CandidatoCondicaoEspecialController@getCandidatosCondicaoEvento');
Route::get('condicoes-especiais/{candidato}/arquivos/show/{arquivo}','CondicaoEspecialController@showFile');

Route::post('candidato-condicao-especial/avaliar', 'CandidatoCondicaoEspecialController@validar');
Route::resource('candidato-condicao-especial', 'CandidatoCondicaoEspecialController');

Route::post('cartao-resposta/critica/salvar','CartaoRespostaController@salvarCritica');
Route::get('cartoes-resposta/criticas','CartaoRespostaController@criticas');
Route::post('cartoes-resposta/criticas','CartaoRespostaController@criticas');
Route::get('cartoes-resposta/inserir','CartaoRespostaController@inserir');
Route::post('cartoes-resposta/inserir','CartaoRespostaController@inserir');
Route::get('cartoes-resposta/cartoesFaltantes','CartaoRespostaController@cartoesFaltantes');
Route::post('cartoes-resposta/cartoesFaltantes','CartaoRespostaController@cartoesFaltantes');

Route::get('cursos','CursoController@index');
Route::get('cursos/dashboard','CursoController@dashboard');
Route::get('cursos/relatorios','CursoController@relatorios');
Route::post('curso/relatorios/candidato-por-vaga','CursoController@relatorioCandidatoVaga');
Route::post('curso/relatorios/total-por-curso-categoria','CursoController@relatorioTotalCursoCategoria');

Route::get('eventos','EventoController@index');
Route::get('eventos/listar','EventoController@listar');
Route::get('evento/create','EventoController@create');
Route::post('evento/alterar','EventoController@alterar');

Route::get('estabelecimentos/cidade/{cidade}', 'RelatorioController@estabelecimentos');

Route::get('inscricao/requerimento/','IsencaoController@index');

Route::get('isentos','IsentoController@index');
Route::match(array('GET', 'POST'),'isentos/pedidos','IsentoController@pedidos');
Route::match(array('GET', 'POST'),'isentos/validacao/avaliacao','IsentoController@avaliacao');
Route::get('isentos/validacao/dashboard','IsentoController@dashboard');
Route::get('isentos/validacao/{tipo}/isento/{isento}','IsentoController@candidato');
Route::get('isentos/validacao/nis','IsentoController@nis');
Route::get('isentos/relatorios','IsentoController@relatorios');
Route::get('isentos/lei','IsentoController@lei');
Route::get('isentos/lei/requisitar','IsentoController@requisitar');
Route::get('isentos/lei/duvidas','IsentoController@duvidas');
Route::get('isentos/lei/discrepancias','IsentoController@discrepancias');
Route::get('isentos/detalhes/{id}','IsentoController@detalhes');
Route::get('isentos/{isento}/arquivos/{tipo}/{arquivo}','IsentoController@getFile');
Route::get('isentos/{isento}/arquivos/show/{tipo}/{arquivo}','IsentoController@showFile');
Route::post('isentos/deferir','IsentoController@deferirIsencao');
Route::post('isentos/indeferir','IsentoController@indeferirIsencao');
Route::post('isentos/excluir','IsentoController@excluirIsencao');
Route::get('isentos/editar-index/{id}','IsentoController@editarIndex');
Route::post('isentos/editar','IsentoController@editar');
Route::match(array('GET', 'POST'),'isentos/indexArquivoNisPorCandidatos','IsentoController@indexArquivoNisPorCandidatos')->name('indexArquivoNisPorCandidatos');
Route::post('isentos/armazenaGerarArquivoNis','IsentoController@armazenaGerarArquivoNis');
Route::post('isentos/removerCandidatoArquivoNis','IsentoController@removerCandidatoArquivoNis');

Route::post('isentos/gera_arquivo_nis','IsentoController@geraArquivoNis');
Route::post('isentos/gera_arquivo_nis_candidatos','IsentoController@geraArquivoNisPorCandidatos');
Route::post('isentos/zerar_arquivo_nis_candidatos','IsentoController@zerarArquivoNisPorCandidatos');
Route::post('isentos/processa_nis','IsentoController@processaNis');
Route::get('relatorios/isentos/{tipo}','IsentoController@relatorioDeferimento');
Route::get('relatorios/isentos/totais','IsentoController@relatorioTotais');
Route::get('relatorios/isentos/relatorioTotaisPorIndeferimento','IsentoController@relatorioTotaisPorIndeferimento');

Route::get('gabaritos','GabaritoController@index')->name('gabaritoIndex');
Route::post('gabaritos','GabaritoController@index');
Route::post('gabarito/update','GabaritoController@gabaritoUpdate');
Route::get('gabarito/anular/{prova}/{tipoProva}/{questao}','GabaritoController@anular');
Route::post('gabarito/gerarHtml','GabaritoController@gerarHtml');
Route::post('gabarito/gerarArquivos','GabaritoController@gerarArquivos');

Route::get('grafica/indexGerarArquivoImpressao','GraficaController@indexGerarArquivoImpressao')->name('indexGerarArquivoImpressao');
Route::post('grafica/gerarArquivoImpressao','GraficaController@gerarArquivoImpressao');
Route::get('grafica/index-relatorios','GraficaController@indexRelatorios');
Route::post('relatorios/grafica-total-provas-local-setor-grupo-cor-prova','RelatorioController@graficaTotalProvasLocalSetorGrupoCorProva');
Route::post('relatorios/grafica-etiquetas','RelatorioController@graficaEtiquetas');
Route::get('grafica/indexGerarAtasListas','GraficaController@indexGerarAtasListas');
Route::post('grafica/gerarAtasListasImpressao','GraficaController@gerarAtasListasImpressao');

Route::get('grupos/dados/{grupo}','GrupoController@getDadosGrupo');

Route::get('local/{local}/setores','LocalController@setores');
Route::get('local/{local}/setores/tipo/{tipo}','LocalController@setoresEspeciais');
Route::get('local/{local}/setor/{setor}','LocalController@grupos');

Route::get('matricula/dados','MatriculaController@dados');
Route::get('matricula/relatorio','MatriculaController@relatorio');
Route::get('file/{arquivo}','MatriculaController@getFile');
Route::post('matricula/gerar-dados','MatriculaController@gerarDados');
Route::post('matricula/gerar-relatorio','MatriculaController@gerarRelatorio');

Route::get('motivos-indeferimento-condicao-especial','MotivoIndeferimentoCondicaoEspecialController@index');

Route::get('pagamento','PagamentoController@index')->name('indexPagamentos');
Route::get('pagamento/exibe-erros-pagamentos','PagamentoController@exibeErrosPagamentos')->name('exibeErrosPagamentos');
Route::get('pagamento/index-processa-arquivo','PagamentoController@indexProcessaArquivo')->name('indexProcessaArquivo');
Route::get('pagamento/arquivos','PagamentoController@arquivos')->name('listaArquivo');
Route::get('pagamento/excluirArquivo/{nomeArquivo}','PagamentoController@excluiArquivoPagamento');
Route::get('pagamento/verArquivo/{nomeArquivo}/{metodo}','PagamentoController@verArquivoPagamento');
Route::get('pagamento/index-relatorios','PagamentoController@indexRelatorios');
Route::post('pagamento/processa-arquivo','PagamentoController@processaArquivo');
Route::get('pagamento/valida-PagTesouro','PagamentoController@validaPagTesouro');
Route::get('pagamento/relacao-falta-pagamento','PagamentoController@relatorioInscricoesNaoEfetivadasFaltaPagamento');
Route::post('pagamento/homologacao-inscricoes','PagamentoController@relatorioHomologacaoInscricoes');

Route::get('pessoa/editar/{id}','PessoaController@editar');
Route::get('pessoa/{id}/resetar-senha','PessoaController@resetarSenha');
Route::resource('pessoa','PessoaController');

Route::get('processamento/calcula-media-discursiva','CalculaMediaDiscursivaController@index');
Route::post('processamento/calcula-media-discursiva','CalculaMediaDiscursivaController@index');
Route::get('processamento/calcula-media-redacao','CalculaMediaRedacaoController@index');
Route::post('processamento/calcula-media-redacao','CalculaMediaRedacaoController@index');
Route::get('processamento/corrigir-prova-objetiva','CorrigirProvaObjetivaController@index');
Route::post('processamento/corrigir-prova-objetiva','CorrigirProvaObjetivaController@index');
Route::get('processamento/classificar-no-curso','ClassificacaoGeralController@index');
Route::post('processamento/classificar-no-curso','ClassificacaoGeralController@index');
Route::get('processamento/classificar-no-curso-categoria','ClassificacaoCursoCategoriaController@index');
Route::post('processamento/classificar-no-curso-categoria','ClassificacaoCursoCategoriaController@index');
Route::get('processamento/classificar-no-periodo','ClassificacaoPeriodoController@index');
Route::post('processamento/classificar-no-periodo','ClassificacaoPeriodoController@index');
Route::get('processamento/gerar-mapa-correcao','MapaCorrecaoController@index');
Route::post('processamento/gerar-mapa-correcao','MapaCorrecaoController@index');

Route::get('relatorio/condicao-especial/{tipo}','RelatorioController@condicaoEspecial');
Route::get('relatorio/condicao-especial/logistica/{tipo}','RelatorioController@condicaoEspecialLogistica');

Route::get('relatorios/resultado','RelatorioController@indexResultado');
Route::post('relatorios/resultado-por-curso','RelatorioController@relatorioResultadoPorCurso');
Route::post('relatorios/nota-primeiro-ultimo-classificado','RelatorioController@relatorioNotaPrimeiroUltimoClassificado');
Route::post('relatorios/primeiros-classificados','RelatorioController@primeirosClassificados');
Route::post('relatorios/estatisticas-classificados-por-escola','RelatorioController@estatisticasPorEscola');
Route::post('relatorios/relacao-classificados-por-escola','RelatorioController@relacaoClassificadosPorEscola');
Route::post('relatorios/dados-gerais','RelatorioController@dadosGerais');

Route::get('vistas/{inscricao}/cartao-resposta/{prova}', 'CandidatoController@vistasCartaoResposta');
Route::get('vistas/{inscricao}/redacao', 'CandidatoController@vistasRedacao');
Route::get('vistas/{inscricao}/discursiva/{numero}', 'CandidatoController@vistasDiscursiva');

Route::get('socioeconomico','SocioEconomicoController@index');

Route::get('disciplinas','DisciplinaController@index');

Route::get('/trigger/{data}', function ($data) {
    echo "<p>You have sent $data.</p>";
    event(new App\Events\RealTimeMessage($data));
});

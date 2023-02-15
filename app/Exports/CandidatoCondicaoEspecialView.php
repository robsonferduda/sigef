<?php

namespace App\Exports;

use App\Models\Candidato;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CandidatoCondicaoEspecialView implements FromView
{
public function view(): View
{
    $situacao = array(2,4);
    $condicaoId = null;
    $dados = array();

    $candidatos = Candidato::with('condicoes')
                ->with('localEvento')
                ->whereHas('condicoes', function ($q) use ($situacao, $condicaoId){        

                    $q->when($condicaoId, function ($q) use($condicaoId){
                        return $q->whereIn('cd_condicao_especial_evento_cee', $condicaoId);
                    });

                    $q->when($situacao, function ($q) use($situacao){
                        return $q->whereIn('cd_situacao_condicao_especial_sce', $situacao);
                    });
        
                })
                ->where('cd_evento_eve', 101)
                ->where('fl_homologado_can', true)
                ->orderBy('cd_local_prova_evento_lpe')
                ->orderBy('nm_candidato_can')
                ->get();

    foreach ($candidatos as $key => $candidato) {

        $condicoes = array();

        foreach ($candidato->condicoes as $key => $condicao) {

            $condicoes[] = array('condicao' => $condicao->condicaoEvento->condicao->nm_condicao_especial_coe,
                    'outro' => $condicao->nm_outra_cce,
                    'complemento' => $candidato->ds_complemento_cce,
                    'situacao' => ($condicao->situacao) ? $condicao->situacao->nm_situacao_sce : '',
                    'cor' => ($condicao->situacao) ? $condicao->situacao->ds_color_sce : '#3F4254',
                    'motivo' => ($condicao->motivoIndeferimento) ? $condicao->motivoIndeferimento->nm_motivo_mic : '');
        }

        $dados[] = array('inscricao' => $candidato->nu_inscricao_can,
                            'nome' => $candidato->nm_candidato_can,
                            'local' => $candidato->localEvento->local->cd_local_prova_lop,
                            'ds_local' => $candidato->localEvento->local->nm_local_prova_lop,
                            'setor' => ($candidato->setorEvento) ? $candidato->setorEvento->setor->cd_setor_sel : true, 
                            'ds_setor' => ($candidato->setorEvento) ? $candidato->setorEvento->setor->nm_setor_sel : "Não definido",
                            'grupo' => $candidato->cd_grupo_gru,
                            'ordem' => $candidato->cd_ordem_can,
                            'condicoes' => collect($condicoes));
    }

    return view('exports.condicao_especial', [
        'candidatos' => $dados
    ]);
 }
}
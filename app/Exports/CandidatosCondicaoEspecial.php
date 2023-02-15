<?php

namespace App\Exports;

use App\Models\Candidato;
use Maatwebsite\Excel\Concerns\FromCollection;

class CandidatosCondicaoEspecial implements FromCollection, FromView
{
    public function view(): View
    {
        return view('partials.view_loan_export', [
            'loans' => Loan::all()
        ]);
    
    }

    public function collection()
    {

        $candidatos = Candidato::with('condicoes')
                                ->with('localEvento')
                                ->whereHas('condicoes')
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

        return collect($dados);
    }
}

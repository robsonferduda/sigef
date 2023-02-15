<head>
    <title>Relação de Candidatos sem cartão resposta</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    @php $zebra = true; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">Relação de Candidatos sem cartão resposta - Prova {{$prova}}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10%">Inscrição</th>
                            <th style="width:50%; text-align: left;">Nome</th>
                            <th style="width:10%; text-align: left;">Local</th>
                            <th style="width:10%; text-align: left;">Setor</th>
                            <th style="width:10%; text-align: left;">Grupo</th>
                            <th style="width:10%; text-align: left;">Ordem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $key => $candidato)	
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $candidato->nu_inscricao_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->getNome() }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->localEvento->local->cd_local_prova_lop }}</td>
                            <td style="text-align: left; padding: 4px;">{{ (isset($candidato->setorEvento->setor->cd_setor_sel))? $candidato->setorEvento->setor->cd_setor_sel : "Não alocado" }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->grupo->nu_grupo_gru }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->cd_ordem_can }}</td>
                        </tr>	
                
                        @php $zebra = !$zebra; @endphp
                
                        @empty
                            <tr><td colspan="3"><h4 class="center">Nenhum dado para ser exibido</h4></td></tr>
                        @endforelse
                    </tbody>
                </table>
    </div>
    @include('relatorios.pdf.partes.footer')
</body>
<head>
    <title>Relação de Candidatos {{ $tipo }} por Escola de Conclusão do Ensino Médio</title>
    <link href="{{ asset('css/relatorios-pdf-footer-maior.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    @php $zebra = true; $contador=1; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px;">Relação de Candidatos {{ $tipo }} por Escola de Conclusão do Ensino Médio</h4>
        <h4 style="text-align: center; margin-bottom: 5px;">Estabelecimento: {{ $estabelecimento }}</h4>

                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:7%; text-align: center;">Ordem</th>
                            <th style="width:38%; text-align: left;">Nome do Candidato</th>
                            <th style="width:55%; text-align: left;">Curso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $key => $candidato)	
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $contador }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->getNome() }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->opcao->cursoEvento->curso->nm_abrev_curso_cur }} - {{ $candidato->opcao->cursoEvento->curso->campus->nm_campus_cam }} ({{ $candidato->opcao->cursoEvento->curso->instituicao->sg_instituicao_ies }}) </td>
                        </tr>	
                
                        @php $contador++; $zebra = !$zebra; @endphp
                
                        @empty
                            <tr><td colspan="3"><h4 class="center">Nenhum dado para ser exibido</h4></td></tr>
                        @endforelse
                    </tbody>
                </table>
    </div>
    @include('relatorios.pdf.partes.footer')
</body>
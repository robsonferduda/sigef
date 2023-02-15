<head>
    <title>Estatística por escola de ensino médio</title>
    <link href="{{ asset('css/relatorios-pdf-footer-maior.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    @php $zebra = true; $contador=1; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px;">Estatística de candidatos inscritos e classificados por escola de ensino médio</h4>

                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:15%; text-align: left;">Cidade</th>
                            <th style="width:50%; text-align: left;">Estabelecimento</th>
                            <th style="width:10%; text-align: center;">Inscritos</th>
                            <th style="width:10%; text-align: center;">Classificados</th>
                            <th style="width:15%; text-align: center;">Classificados/Inscritos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $key => $candidato)	
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: left; padding: 4px;">{{ $candidato->nm_municipio_mun }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->nm_estabelecimento_ensino_ese }} </td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->inscritos }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->classificados }}</td>
                            <td style="text-align: center; padding: 4px;">{{ number_format((  ($candidato->classificados / $candidato->inscritos)*100 ),2) }}%</td>
                        </tr>	
                
                        @php $contador++; $zebra = !$zebra; @endphp
                
                        @empty
                            <tr><td colspan="3"><h4 class="center">Nenhum dado para ser exibido</h4></td></tr>
                        @endforelse
                    </tbody>
                </table>
    </div>
    <htmlpagefooter name="page-footer">
        <div id="text-footer" style="font-size: 12px;">
           Obs.: - Os candidatos inscritos por experiência não fazem parte desta estatística.
                 - Total de candidatos inscritos: {{$total_inscritos}}
                 - Total de candidatos classificados: {{$total_classificados}}
        </div>
    </htmlpagefooter>
</body>
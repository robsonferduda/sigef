<head>
    <title>Primeiros candidatos classificados</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    @php $zebra = true; $contador=1; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px;">Relação dos {{ count($candidatos) }} primeiros candidatos classificados {{ ($paa !='')? ' de Escola Pública':'' }}</h4>

                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:25%; text-align: left;">Nome</th>
                            <th style="width:40%; text-align: left;">Curso</th>
                            <th style="width:10%; text-align: left;">Cidade</th>
                            @if($paa !='') 
                                <th style="width:20%; text-align: left;">Estabelecimento</th>
                                <th style="width:5%; text-align: left;">PAA</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $key => $candidato)	
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: left; padding: 4px;">{{ $contador }} {{ $candidato->nm_candidato_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->nm_abrev_curso_cur }} - {{ $candidato->nm_campus_cam }} ( {{ $candidato->sg_instituicao_ies }} )</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->nm_cidade_end }} - {{ $candidato->sg_estado_end }}</td>
                            @if($paa !='') 
                                <td style="text-align: left; padding: 4px;">{{ $candidato->nm_estabelecimento_ensino_ese }}</td>
                                <td style="text-align: left; padding: 4px;">{{ $candidato->cd_categoria_cat }}</td>
                            @endif
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
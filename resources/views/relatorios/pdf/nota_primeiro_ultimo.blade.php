<head>
    <title>Nota Final do primeiro e do último candidato classificado por curso e PAA</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-vertical')
    @php $zebra = true; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px;">Nota Final do primeiro e do último candidato classificado por curso e PAA</h4>
		<h4 style="text-align: center; margin-bottom: 10px; margin-top: 0px; ">{{ $categoria }}</h4>

                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10%; text-align: center;">Código</th>
                            <th style="width:50%; text-align: center;">Curso</th>
                            <th style="width:10%; text-align: center;">Nota Final do Primeiro</th>
                            <th style="width:10%; text-align: center;">Nota Final do Último</th>
                            <th style="width:10%; text-align: center;">Vagas Oferecidas</th>
                            <th style="width:10%; text-align: center;">Vagas Ocupadas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($classificados as $key => $candidato)	
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $candidato->cd_curso_cur }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->nm_abrev_curso_cur }} - {{ $candidato->nm_campus_cam }} ( {{ $candidato->sg_instituicao_ies }} )</td>
                            <td style="text-align: center; padding: 4px;">{{ ($candidato->max) ? : 'Sem classificados' }}</td>
                            <td style="text-align: center; padding: 4px;">{{ ($candidato->min) ? : 'Sem classificados' }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->nu_vagas_originais_cuc }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->nu_vagas_ocupadas_cuc }}</td>
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
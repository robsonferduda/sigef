<head>
    <title>Relação de Grupos com Canhotos - Coordenação</title>
	<link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    
    @php $ctrl = 0; $flag = 0; $zebra = true; $totalcanhotos =0;@endphp
           
        @forelse($candidatos as $key => $candidato)	
            @if($ctrl != $candidato->cd_setor_sel and $flag == 1)
                	<tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                        <td colspan="2" style="text-align: right; padding: 4px; font-weight: bold;">TOTAL</td>
                        <td style="text-align: center; padding: 4px; font-weight: bold;">{{ $totalcanhotos }}</td></td>
                    </tr>   
                    </tbody>
                </table></div>
                <div class="page-break"></div>
                @php $flag == 0; $zebra = true;  $totalcanhotos =0;@endphp
            @endif
    
            @if($ctrl != $candidato->cd_setor_sel)
            @include('relatorios.pdf.partes.cabecalho-horizontal')
            <div id="corpo"> 
                <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">RELAÇÃO DE GRUPOS COM CANDIDATOS CANHOTOS</h4>
                <h4 style="text-align: center; margin-top: 0px; margin-bottom: 5px; font-weight: 300;"> LOCAL {{ $candidato->cd_local_prova_lop }} - {{ $candidato->nm_local_prova_lop }}</h4>
                <h4 style="text-align: center; margin-top: 0px; font-weight: 300;"> SETOR {{ $candidato->cd_setor_sel }} - {{ $candidato->nm_setor_sel }}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:30%;">Grupo</th>
                            <th style="width:35%;">Candidatos</th>
                            <th style="width:35%;">Canhotos</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $flag = 1; @endphp
                    
            @endif	
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;"><span style="font-weight: bold;">{{ $candidato->nu_grupo_gru}} </span>{{" - ".$candidato->nm_grupo_gru }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->totalcandidatos }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->totalcanhotos }}</td></td>
                        </tr>	
    
            @php if($ctrl != $candidato->cd_setor_sel){ $ctrl = $candidato->cd_setor_sel; } @endphp
            @php $zebra = !$zebra;  $totalcanhotos += $candidato->totalcanhotos; @endphp

        @empty
         <table id="tabelaDados" border="0" cellspacing="0" width="100%">
         	<tbody>
            <tr>
            	<td>
            		<h4 class="center">Nenhum dado para ser exibido</h4>
        		</td>
        	</tr>
        @endforelse
        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                        <td colspan="2" style="text-align: right; padding: 4px; font-weight: bold;">TOTAL</td>
                        <td style="text-align: center; padding: 4px; font-weight: bold;">{{ $totalcanhotos }}</td></td>
                    </tr>   
         </tbody>
                </table></div>
    @include('relatorios.pdf.partes.footer')
</body>
<head>
    <title>Total de Candidatos e Grupos cpor Local - Coordenação</title>
	<link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    
    @php $ctrl = 0; $flag = 0; $zebra = true; $totalcandidatos = 0; @endphp
           
        @forelse($candidatos as $key => $candidato)	
            @if($ctrl != $candidato->cd_setor_sel and $flag == 1)
                	<tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                        <td colspan="2" style="text-align: center; padding: 4px; font-weight: bold;">TOTAL</td>
                        <td style="text-align: center; padding: 4px; font-weight: bold;">{{ $totalcandidatos }}</td>
                    </tr>   
                    </tbody>
                </table></div>
                <div class="page-break"></div>
                @php $flag == 0; $zebra = true; $totalcandidatos = 0; @endphp
            @endif
    
            @if($ctrl != $candidato->cd_setor_sel)
            @include('relatorios.pdf.partes.cabecalho-horizontal')
            <div id="corpo"> 
                <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">TOTAL DE CANDIDATOS E GRUPOS POR LOCAL</h4>
                <h4 style="text-align: center; margin-top: 0px; margin-bottom: 5px; font-weight: 300;"> LOCAL {{ $candidato->cd_local_prova_lop }} - {{ $candidato->nm_local_prova_lop }}</h4>
                <h4 style="text-align: center; margin-top: 0px; font-weight: 300;"> SETOR {{ $candidato->cd_setor_sel }} - {{ $candidato->nm_setor_sel }}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%" align="center">
                    <thead>
                        <tr>
                            <th style="width:15%;">Grupo</th>
                            <th style="width:60%;">Localização</th>
                            <th style="width:25%;">Candidatos</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $flag = 1; @endphp
                    
            @endif	
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;"><span style="font-weight: bold;">{{ $candidato->nu_grupo_gru}} </span></td>
                            <td style="text-align: center; padding: 4px;">{{$candidato->nm_grupo_gru }} - {{$candidato->ds_localizacao_gru }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->totalcandidatos }}</td>
                        </tr>	
    
            @php if($ctrl != $candidato->cd_setor_sel){ $ctrl = $candidato->cd_setor_sel; } @endphp
            @php $zebra = !$zebra; $totalcandidatos += $candidato->totalcandidatos; @endphp

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
                        <td style="text-align: center; padding: 4px; font-weight: bold;">TOTAL</td>
                        <td style="text-align: center; padding: 4px; font-weight: bold;">{{ $totalcandidatos }}</td>
                    </tr> 
         </tbody>
                </table></div>
    @include('relatorios.pdf.partes.footer')
</body>
<head>
    <title>Relação de Nomes Sociais - Coordenação</title>
	<link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    
    @php $ctrl = 0; $flag = 0; $zebra = true; @endphp
           
        @forelse($candidatos as $key => $candidato)	
            @if($ctrl != $candidato->setorEvento->cd_setor_evento_see and $flag == 1)
                	
                    </tbody>
                </table></div>
                <div class="page-break"></div>
                @php $flag == 0; $zebra = true; @endphp
            @endif
    
            @if($ctrl != $candidato->setorEvento->cd_setor_evento_see)
            @include('relatorios.pdf.partes.cabecalho-horizontal')
            <div id="corpo"> 
                <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">RELAÇÃO DE NOMES SOCIAIS</h4>
                <h4 style="text-align: center; margin-top: 0px; margin-bottom: 5px; font-weight: 300;"> LOCAL {{ $candidato->localEvento->local->cd_local_prova_lop }} - {{ $candidato->localEvento->local->nm_local_prova_lop }}</h4>
                <h4 style="text-align: center; margin-top: 0px; font-weight: 300;"> SETOR {{ $candidato->setorEvento->setor->cd_setor_sel }} - {{ $candidato->setorEvento->setor->nm_setor_sel }}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:6%;">Grupo</th>
                            <th style="width:6%;">Ordem</th>
                            <th style="width:8%;">Inscrição</th>
                            <th style="width:10%;">CPF</th>
                            <th style="width:35%; text-align: left;">Nome do Candidato</th>
                            <th style="width:35%; text-align: left;">Nome Social</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $flag = 1; @endphp
                    
            @endif	
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $candidato->grupo->nu_grupo_gru }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->cd_ordem_can}}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->nu_inscricao_can }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato->pessoa->cpf->nm_documento_doc }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->nm_candidato_can }}</td>
                            <td style="padding-bottom: 5px;">{{ $candidato->nm_social_can }}</td></td>
                        </tr>	
    
            @php if($ctrl != $candidato->setorEvento->cd_setor_evento_see){ $ctrl = $candidato->setorEvento->cd_setor_evento_see; } @endphp
            @php $zebra = !$zebra; @endphp

        @empty
         <table id="tabelaDados" border="0" cellspacing="0" width="100%">
         	<tbody>
            <tr>
            	<td>
            		<h4 class="center">Nenhum dado para ser exibido</h4>
        		</td>
        	</tr>
        @endforelse
         </tbody>
                </table></div>
    @include('relatorios.pdf.partes.footer')
</body>
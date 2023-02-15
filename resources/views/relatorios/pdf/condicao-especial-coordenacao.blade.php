<head>
    <title>Relação de Condições Especiais - Coordenação</title>
	<link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-horizontal')
    @php $ctrl = 0; $flag = 0; $zebra = true; @endphp
    <div id="corpo">        
        @forelse($candidatos as $key => $candidato)	
    
            @if($ctrl != $candidato['setor'] and $flag == 1)
                
                    </tbody>
                </table>
                <div class="page-break"></div>
                @php $flag == 0; $zebra = true; @endphp
            @endif
    
            @if($ctrl != $candidato['setor'])
                <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">RELAÇÃO DE SOLICITAÇÕES DE ATENDIMENTO DE CONDIÇÕES ESPECIAS</h4>
                <h4 style="text-align: center; margin-top: 0px; margin-bottom: 5px; font-weight: 300;"> LOCAL {{ $candidato['local'] }} - {{ $candidato['ds_local'] }}</h4>
                <h4 style="text-align: center; margin-top: 0px; font-weight: 300;"> SETOR {{ $candidato['setor'] }} - {{ $candidato['ds_setor'] }}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:5%">Grupo</th>
                            <th style="width:5%">Ordem</th>
                            <th style="width:7%">Inscrição</th>
                            <th style="width:23%; text-align: left;">Nome do Candidato</th>
                            <th style="width:60%; text-align: left;">Condição Especial - Resultado da Solicitação</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $flag = 1; @endphp
                    
            @endif	
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $candidato['grupo'] }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato['ordem'] }}</td>
                            <td style="text-align: center; padding: 4px;">{{ $candidato['inscricao'] }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato['nome'] }}</td>
                            <td style="padding-bottom: 5px;">
                                @foreach($candidato['condicoes'] as $key => $condicao)
                                    <h4 style="padding-top: 8px; margin-bottom: 8px; font-weight: 300;">
                                        <span>-</span>
                                        <span> {{ $condicao['condicao'] }} {{ ($condicao['outro']) ? "(".$condicao['outro'].")" : '' }} </span>
                                        <span style="color: {{ $condicao['cor'] }};">{{ " - ".$condicao['situacao'] }}</span>
                                        <span>{{ ($condicao['motivo']) ? " - ".$condicao['motivo'] : '' }} </span>
                                        <span>{{ ($condicao['complemento']) ? " - ".$condicao['complemento'] : '' }} </span>
                                    </h4>
                                @endforeach	
                            </td>
                        </tr>	
    
            @php if($ctrl != $candidato['setor']){ $ctrl = $candidato['setor']; } @endphp
            @php $zebra = !$zebra; @endphp
    
        @empty
            <h4 class="center">Nenhum dado para ser exibido</h4>
        @endforelse
        </tbody>
    </table>
    @include('relatorios.pdf.partes.footer')
</body>
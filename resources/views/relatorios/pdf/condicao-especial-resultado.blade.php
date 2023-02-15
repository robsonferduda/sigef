<head>
    <title>Resultado da Solicitação de Condições Especiais</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-horizontal')
    @php $ctrl = 0; $flag = 0; $zebra = true; @endphp
    <div id="corpo">    
    
        @forelse($candidatos as $key => $candidato)	
    
            @if($ctrl != $candidato['local'] and $flag == 1)
                
                    </tbody>
                </table>
                <div class="page-break"></div>
                @php $flag == 0; $zebra = true; @endphp
            @endif
    
            @if($ctrl != $candidato['local'])
                <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">Resultado da Solicitação de Condições Especiais</h4>
                <h4 style="text-align: center; margin-top: 0px; "> LOCAL {{ $candidato['local'] }} - {{ $candidato['ds_local'] }}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10%">Inscrição</th>
                            <th style="width:90%; text-align: left;">Condição Especial - Resultado da Solicitação</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php $flag = 1; @endphp
                    
            @endif	
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $candidato['inscricao'] }}</td>
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
    
            @php if($ctrl != $candidato['local']){ $ctrl = $candidato['local']; } @endphp
            @php $zebra = !$zebra; @endphp
    
        @empty
            <h4 class="center">Nenhum dado para ser exibido</h4>
        @endforelse
        </tbody>
    </table>
    @include('relatorios.pdf.partes.footer')
</body>
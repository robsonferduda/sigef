<head>
    <title>Relação de Provas Ampliadas</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-horizontal')
    @php $zebra = true; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">Relação de Inscritos por local, Setor e Grupo com prova ampliada</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%" style="text-align: left;">
                    <thead>
                        <tr>
                            <th style="width:8%; text-align: left;">Local</th>
                            <th style="width:8%; text-align: left;">Setor</th>
                            <th style="width:8%; text-align: left;">Grupo</th>
                            <th style="width:8%; text-align: left;">Ordem</th>
                            <th style="width:10%; text-align: left;">Inscrição</th>
                            <th style="width:34%; text-align: left;">Nome</th>
                            <th style="width:12%; text-align: left;">Cor Prova 1</th>
                            <th style="width:12%; text-align: left;">Cor Prova 2</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $key => $candidato) 
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="padding: 4px;">{{ $candidato->cd_local_prova_lop }}</td>
                            <td style="padding: 4px;">{{ $candidato->setor/*cd_unico_sel*/ }}</td>
                            <td style="padding: 4px;">{{ $candidato->nu_grupo_gru }}</td>
                            <td style="padding: 4px;">{{ $candidato->cd_ordem_can }}</td>
                            <td style="padding: 4px;">{{ $candidato->nu_inscricao_can}}</td>
                            <td style="padding: 4px;">{{ $candidato->nm_candidato_can }}</td>
                            <td style="padding: 4px;">{{ $candidato->prova1 }}</td>
                            <td style="padding: 4px;">{{ $candidato->prova2 }}</td>
                            
                        </tr>   
                
                        @php $zebra = !$zebra; @endphp
                
                        @empty
                            <tr><td colspan="6"><h4 class="center">Nenhum dado para ser exibido</h4></td>
                        @endforelse
                    </tbody>
                </table>
    </div>
    @include('relatorios.pdf.partes.footer')
</body>
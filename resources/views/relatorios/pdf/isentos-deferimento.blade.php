<head>
    <title>Relação das Isenções {{ $titulo }}</title>
    <link href="{{ asset('css/relatorios-pdf.css') }}" rel="stylesheet" type="text/css" />
</head>
<body>
    @include('relatorios.pdf.partes.cabecalho-horizontal')
    @php $zebra = true; @endphp
    <div id="corpo">    
        <h4 style="text-align: center; margin-bottom: 5px; font-weight: 300; text-transform: uppercase; ">Relação das Isenções {{ $titulo }}</h4>
                <table id="tabelaDados" border="0" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10%">Inscrição</th>
                            <th style="width:30%; text-align: left;">Nome</th>
                            <th style="width:30%; text-align: left;">Tipo Isenção</th>
                            @if($tipo == "indeferidos")<th style="width:30%; text-align: left;">Motivo Indeferimento</th>@endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $key => $candidato)	
    
                        <tr style="background: {{ ($zebra) ? '#DDD;' : '#FFFFFF;' }}">
                            <td style="text-align: center; padding: 4px;">{{ $candidato->candidato->nu_inscricao_can }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->candidato->getNome() }}</td>
                            <td style="text-align: left; padding: 4px;">{{ $candidato->razaoIsencao->nm_razao_isencao_rai }}</td>
                            @if($tipo == "indeferidos" and isset($candidato->indeferimento->nm_indeferimento_isi))<td style="text-align: left; padding: 4px;">{{ $candidato->indeferimento->nm_indeferimento_isi }}</td>@endif
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
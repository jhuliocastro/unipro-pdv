<table class="tabelaProdutos">
@foreach($data as $d)
    <?php
        $dadosProduto = \Illuminate\Support\Facades\DB::table('produtos')->where('id', $d->produto)->first();
    ?>
        <tr>
            <td>{{$d->id}}</td>
            <td class="nomeProduto">{{$dadosProduto->nome}}</td>
            <td align="center">{{$d->quantidade}} {{$dadosProduto->unidadeMedida}} X R$ {{number_format((float)$dadosProduto->precoVenda, 2, ',', '.')}}</td>
            <td align="right">R$ {{number_format($dadosProduto->precoVenda*$d->quantidade, 2, ',', '.')}}</td>
        </tr>
        <tr>
            <td></td>
            <td>{{$dadosProduto->idControle}}</td>
            <td></td>
            <td></td>
        </tr>
@endforeach
</table>

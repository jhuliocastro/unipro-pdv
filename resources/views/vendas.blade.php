@extends('main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    Relátorio de Vendas do Dia
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Valor Total</th>
                                <th>Desconto</th>
                                <th>Troco</th>
                                <th>Valor Pago</th>
                                <th>Dinheiro</th>
                                <th>Débito</th>
                                <th>Crédito</th>
                                <th>Crediário</th>
                                <th>PIX</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vendas as $venda)
                                <tr>
                                    <td>{{$venda->id}}</td>
                                    <td>{{$venda->cliente}}</td>
                                    <td>{{$venda->valorTotal}}</td>
                                    <td>{{$venda->desconto}}</td>
                                    <td>{{$venda->troco}}</td>
                                    <td>{{$venda->valorPago}}</td>
                                    <td>{{$venda->dinheiro}}</td>
                                    <td>{{$venda->debito}}</td>
                                    <td>{{$venda->credito}}</td>
                                    <td>{{$venda->crediario}}</td>
                                    <td>{{$venda->pix}}</td>
                                    <td><a href="#" onclick="imprimirCupom({{$venda->id}})"><img style="width: 25px;" src="{{asset('img/print.png')}}"></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <a href="{{route('dashboard')}}" class="btn btn-primary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function imprimirCupom(id){
            $.ajax({
                url: "{{route('vendas.imprimir')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(dados){
                    console.log(dados);
                }
            });
        }
    </script>
@endsection

@extends('main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col cabeca">
                <span>UNIPRO - PDV</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <span id="definirCliente">Definir Cliente (F2)</span> <br/>
                        @if(!isset($_SESSION["cliente"]))
                            Nenhum Cliente Informado
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="caixaPesquisa">
                            <span>Produto </span>
                            <input type="text" id="codigoProduto" name="codigoProduto">
                            <div id="imagemPesquisa">
                                <img src="/img/search.svg">
                                (F4)
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div id="caixaQuantidade">
                            <span class="textoCaixa">Quantidade </span>
                            <span class="valorCaixa">1</span>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="caixaValorTotalCompra">
                            <span class="textoCaixa">Valor Total da Compra </span>
                            <span class="valorCaixa">R$ 0,00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col cupomFiscal">
                <span>CUPOM FISCAL</span>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="/css/dashboard.css">
    <script src="/js/dashboard.js"></script>
    <script>
        let quantidade = 1;
        $(document).ready(function(){
            $("#codigoProduto").focus();

            $("#codigoProduto").keyup(function(e){
                if(e.which == 13){
                    let codigo = $("#codigoProduto").val();
                    $.ajax({
                       url: "{{route('consulta.produto')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'post',
                        data: {
                            codigo: codigo,
                            quantidade: quantidade
                        },
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                        }
                    });
                }
            });
        });
    </script>
@endsection

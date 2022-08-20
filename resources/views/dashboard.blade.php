@extends('main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col cabeca">
                <span id="cabecalho">-</span>
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
                            <span class="valorCaixa" id="valorTotalCompra">R$ {{$valorTotal}}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="caixaFinalizarVenda">
                            Finalizar venda (F4)
                            R$ 0,00
                        </div>
                    </div>
                </div>
            </div>
            <div class="col cupomFiscal">
                <span>CUPOM FISCAL</span>
                <hr>
                <div id="conteudoCupom"></div>
            </div>
        </div>
    </div>

    <div id="dialogPesquisaProduto" title="Pesquisar Produto">
        <div class="container">
            <div class="row">
                <div class="mb-3">
                    <label>Insira o nome do produto</label>
                    <input type="text" id="produtoPesquisa" name="produtoPesquisa" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <table id="tabelaProdutos" class="table">
                        <thead class="thead-dark">
                            <tr>
                                <td>PRODUTO</td>
                                <td>QUANTIDADE</td>
                                <td>UN MED</td>
                                <td>VALOR</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <link rel="stylesheet" href="/css/dashboard.css">
    <script src="/js/dashboard.js"></script>
    <script>
        var dialogPesquisaProduto;
        let quantidade = 1;
        $(document).ready(function(e){
            dialogPesquisaProduto = $("#dialogPesquisaProduto").dialog({
                autoOpen: false,
                width: 1000,
                height: 600,
                close: $("#codigoProduto").focus()
            });

            $("#codigoProduto").focus();
            $("#conteudoCupom").load('<?php echo url('listagemProdutosCaixa'); ?>');

            $("#codigoProduto").keyup(function(e){
                if(e.which == 13){
                    let codigo = $("#codigoProduto").val();
                    adicionarProdutoAjax(codigo);
                }
            });

        });

        $("#produtoPesquisa").keyup(function(e){
                let valor = $("#produtoPesquisa").val();
                if(valor.length > 1){
                    $.ajax({
                       url: "{{route('pesquisa.produto')}}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'post',
                        data: {
                            pesquisa: valor,
                        },
                        dataType: 'json',
                        success: function(dados){
                            $("#tabelaProdutos tbody tr").remove();
                            for(linha=0; linha < dados.length; linha++){
                                console.log(dados);
                                $("#tabelaProdutos").append("<tr><td>"+dados[linha].nome+"</td><td>"+dados[linha].estoqueAtual+"</td><td>"+dados[linha].unidadeMedida+"</td><td>R$ "+(dados[linha].precoVenda).toFixed(2)+"</td><td><button type='button' onClick='selecionarProduto(" + dados[linha].idControle + ")' class='btn btn-primary btn-sm'>Selecionar</button></td><</tr>");
                            }
                        }
                    });
                }
        });

        $("#codigoProduto").keydown(function(e){
            key(e);
        });

        $(document).keydown(function(e){
            key(e);
        });

        function key(e){
            switch (e.keyCode){
                case 115:
                    e.preventDefault();
                    dialogPesquisaProduto.dialog('open');
                    break;
            }
        }

        function selecionarProduto(id){
            dialogPesquisaProduto.dialog('close');
            adicionarProdutoAjax(id);
        }

        function adicionarProdutoAjax(codigo){
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
                            if(response.erro){
                                new Noty({
                                    type: 'error',
                                    text: response.erro,
                                    layout: 'bottomLeft',
                                    timeout: 2000
                                }).show();
                            }else{
                                $("#conteudoCupom").load('<?php echo url('listagemProdutosCaixa'); ?>');
                                $("#cabecalho").text(response.nome + ' [' + quantidade + ' * ' + response.precoVenda + ' = ' + response.valorTotal + ']');
                                $("#valorTotalCompra").text('R$ ' + response.valorTotal);
                            }
                            $("#codigoProduto").val("");
                        }
                    });
        }
    </script>
@endsection

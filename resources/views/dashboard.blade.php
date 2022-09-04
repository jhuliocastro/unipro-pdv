@extends('main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="infoCabeca">
                Operador: {{Auth::user()->name}}
            </div>
        </div>
        <div class="row">
            <div class="col cabeca">
                <span id="cabecalho">-</span>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="row">
                    <div class="col">
                        <span id="definirCliente">Definir Cliente (F1)</span> <br/>
                        <span id="clienteInfo" style="font-weight: bold;">Nenhum Cliente Informado</span>
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
                            <span class="textoCaixa">Desconto </span>
                            <span class="valorCaixa" id="descontoInfo"></span><span> (F2)</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="caixaQuantidade">
                            <span class="textoCaixa">Quantidade </span>
                            <span class="valorCaixa" id="quantidadeInfo"></span><span> (F3)</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="caixaValorTotalCompra">
                            <span class="textoCaixa" style="color: white;">Valor Total </span>
                            <span class="valorCaixa" id="valorTotalCompra">R$ {{$valorTotal}}</span>
                        </div>
                    </div>
                </div>
                <div class="row rodape">
                    <div class="col-md-6 opcoes">
                        CANCELAR ITEM<br/>
                        (F5)
                    </div>
                    <div class="col-md-6 opcoes">
                        NOVA VENDA<br/>
                        (F6)
                    </div>
                    <div class="col-md-6 opcoes">
                        CONCLUIR VENDA<br/>
                        (F7)
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

    <!-- DIALOGO INFORMAR CLIENTE -->
    <div id="dialogInformarCliente" title="Informar Cliente">
        <div class="container">
            <div class="row">
                <div class="mb-3">
                    <label>Insira o nome do cliente</label>
                    <input type="text" autocomplete="off" id="clientePesquisa" name="clientePesquisa" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="mb-3">
                    <table id="tabelaClientes" class="table">
                        <thead class="thead-dark">
                        <tr>
                            <td>ID</td>
                            <td>CLIENTE</td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- DIALOGO PESQUISAR PRODUTO -->
    <div id="dialogPesquisaProduto" title="Pesquisar Produto">
        <div class="container">
            <div class="row">
                <div class="mb-3">
                    <label>Insira o nome do produto</label>
                    <input type="text" autocomplete="off" id="produtoPesquisa" name="produtoPesquisa" class="form-control">
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

    <!-- DIALOGO ALTERAR QUANTIDADE-->
    <div id="dialogAlterarQuantidade" title="Alterar Quantidade">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <label>Insira a quantidade desejada:</label>
                    <form method="post" action="#" id="formQuantidade">
                        <input type="number" autocomplete="off" id="quantidadeProduto" name="quantidadeProduto" class="form-control">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="dialogCancelarItem" title="Cancelar Item">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <label>Insira o ID do produto:</label>
                    <form method="post" action="#" id="formCancelarItem">
                        <input type="number" id="idCancelamentoProduto" name="idCancelamentoProduto" class="form-control">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="dialogDesconto" title="Desconto">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <label>Valor do Desconto:</label>
                    <form method="post" action="#" id="formDesconto">
                        <input type="text" id="valorDescontoVenda" name="valorDescontoVenda" class="form-control">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="dialogFinalizarVenda" title="Pagamento">
        <form method="post" action="{{route('finalizar.venda')}}">
            @csrf
            <fieldset>
                <div class="row mb-2">
                    <div class="cell-sm-3">Dinheiro</div>
                    <div class="cell-sm-9">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" name="dinheiroPagamento" id="dinheiroPagamento" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="cell-sm-3">Débito</div>
                    <div class="cell-sm-9">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" name="debitoPagamento" id="debitoPagamento" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="cell-sm-3">Crédito</div>
                    <div class="cell-sm-9">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" name="creditoPagamento" id="creditoPagamento" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="cell-sm-3">Crediário</div>
                    <div class="cell-sm-9">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" name="crediarioPagamento" id="crediarioPagamento" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="cell-sm-3">Pix</div>
                    <div class="cell-sm-9">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            <input type="text" name="pixPagamento" id="pixPagamento" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                <hr>
                <input type="hidden" id="descontoFinalizar" name="descontoFinalizar">
                <input type="hidden" id="valorTotalFinalizar" name="valorTotalFinalizar">
                <input type="hidden" id="clienteFinalizar" name="clienteFinalizar">
                <div style="text-align: right; font-size: 20px;">
                    Valor Total: <span id="valorTotalPagamento" style="font-weight: bold;">R$ 0,00</span><br/>
                </div>
                <!-- Allow form submission with keyboard without duplicating the dialog button -->
                <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
            </fieldset>
        </form>
    </div>

@endsection

@section('scripts')
    <link rel="stylesheet" href="/css/dashboard.css">
    <script src="/js/dashboard.js"></script>
    <script>
        var dialogPesquisaProduto, dialogAlterarQuantidade, dialogInformarCliente;
        let quantidade = 1;
        let desconto = 0;
        var cliente = null;
        $(document).ready(function(e){
            dialogPesquisaProduto = $("#dialogPesquisaProduto").dialog({
                autoOpen: false,
                width: 1000,
                height: 600,
                close: $("#codigoProduto").focus()
            });

            dialogInformarCliente = $("#dialogInformarCliente").dialog({
                autoOpen: false,
                width: 1000,
                height: 600,
                close: $("#codigoProduto").focus()
            });

            dialogAlterarQuantidade = $("#dialogAlterarQuantidade").dialog({
                autoOpen: false,
                width: 400,
                height: 150,
                // close: $("#codigoProduto").focus()
            });

            dialogCancelarItem = $("#dialogCancelarItem").dialog({
                autoOpen: false,
                width: 400,
                height: 150
            });

            dialogFinalizarVenda = $("#dialogFinalizarVenda").dialog({
                autoOpen: false,
                width: 400,
                height: 500
            });

            dialogDesconto = $("#dialogDesconto").dialog({
                autoOpen: false,
                width: 400,
                height: 150
            });

            $("#codigoProduto").focus();
            $("#conteudoCupom").load('<?php echo url('listagemProdutosCaixa'); ?>');
            atualizarValorTotal();

            $("#quantidadeInfo").text(quantidade);

            $("#codigoProduto").keyup(function(e){
                if(e.which == 13){
                    let codigo = $("#codigoProduto").val();
                    console.log(codigo);
                    if(codigo !== ""){
                        adicionarProdutoAjax(codigo);
                    }
                }
            });

            $("#dinheiroPagamento").mask('#.##0,00', {reverse: true});
            $("#crediarioPagamento").mask('#.##0,00', {reverse: true});
            $("#creditoPagamento").mask('#.##0,00', {reverse: true});
            $("#debitoPagamento").mask('#.##0,00', {reverse: true});
            $("#pixPagamento").mask('#.##0,00', {reverse: true});
            $("#valorDescontoVenda").mask('#.##0,00', {reverse: true});
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

        $("#clientePesquisa").keyup(function(e){
            let valor = $("#clientePesquisa").val();
            if(valor.length > 1){
                $.ajax({
                    url: "{{route('pesquisa.cliente')}}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'post',
                    data: {
                        pesquisa: valor,
                    },
                    dataType: 'json',
                    success: function(dados){
                        $("#tabelaClientes tbody tr").remove();
                        for(linha=0; linha < dados.length; linha++){
                            console.log(dados);
                            $("#tabelaClientes").append("<tr><td>"+dados[linha].id+"</td><td>"+dados[linha].nome+"</td><td><button type='button' onClick='selecionarCliente(" + dados[linha].id + ")' class='btn btn-primary btn-sm'>Selecionar</button></td><</tr>");
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
                case 112: //F1 INFORMAR CLIENTE
                    e.preventDefault();
                    dialogInformarCliente.dialog('open');
                    break;
                case 113: //F2 DESCONTO
                    e.preventDefault();
                    dialogDesconto.dialog('open');
                    break;
                case 114: //F3 ALTERAR QUANTIDADE ATUAL
                    e.preventDefault();
                    dialogAlterarQuantidade.dialog('open');
                    break;
                case 115://F4 PESQUISA PRODUTO
                    e.preventDefault();
                    dialogPesquisaProduto.dialog('open');
                    break;
                case 116: //F5 CANCELAR ITEM
                    e.preventDefault();
                    dialogCancelarItem.dialog('open');
                    break;
                case 117://F6 NOVA VENDA
                    e.preventDefault();
                    confirmacaoNovaVenda();
                    break;
                case 118://F7 CONCLUIR VENDA
                    e.preventDefault();
                    dialogFinalizarVenda.dialog('open');
                    break;
            }
        }

        function confirmacaoNovaVenda(){
            let n = new Noty({
                text: 'Confirma Nova Venda?',
                layout: 'bottomLeft',
                buttons: [
                    Noty.button('SIM', 'btn btn-success', function () {
                        n.close();
                        $("#conteudoCupom").load('<?php echo url('listagemProdutosCaixa'); ?>');
                        $("#cabecalho").text('-');
                        atualizarValorTotal();
                        $.get("{{route('nova.venda')}}", function(e){
                            console.log(e);
                            new Noty({
                                type: 'success',
                                text: 'Ação concluída!',
                                layout: 'bottomLeft',
                                timeout: 2000
                            }).show();
                        });
                    }, {id: 'button1', 'data-status': 'ok'}),

                    Noty.button('NÃO', 'btn btn-error', function () {
                        n.close();
                    })
                ]
            });
            n.show();
        }

        $("#formQuantidade").submit(function(e){
            e.preventDefault();
            quantidade = $("#quantidadeProduto").val();
            $("#quantidadeProduto").val("");
            dialogAlterarQuantidade.dialog('close');
            $("#quantidadeInfo").text(quantidade);
        });

        $("#formDesconto").submit(function(e){
            e.preventDefault();
            desconto = $("#valorDescontoVenda").val();
            atualizarValorTotal();
            $("#valorDescontoVenda").val('');
            dialogDesconto.dialog('close');
            new Noty({
                type: 'success',
                text: 'Ação concluída!',
                layout: 'bottomLeft',
                timeout: 2000
            }).show();
        });

        $("#formCancelarItem").submit(function(e){
            e.preventDefault();
            let id = $("#idCancelamentoProduto").val();
            if(id === '' || id === null){
                new Noty({
                    type: 'warning',
                    text: 'ID em branco!',
                    layout: 'bottomLeft',
                    timeout: 2000
                }).show();
            }else{
                $("#idCancelamentoProduto").val('');
                dialogCancelarItem.dialog("close");
                $.get("{{route('cancelar.item')}}", {id: id}, function(e){
                    if(e === '1'){
                        $("#conteudoCupom").load('<?php echo url('listagemProdutosCaixa'); ?>');
                        $("#cabecalho").text('-');
                        atualizarValorTotal();
                        new Noty({
                            type: 'success',
                            text: 'Item cancelado!',
                            layout: 'bottomLeft',
                            timeout: 2000
                        }).show();
                    }else{
                        new Noty({
                            type: 'error',
                            text: 'Erro ao cancelar item!',
                            layout: 'bottomLeft',
                            timeout: 2000
                        }).show();
                    }
                });
            }
        });

        function selecionarProduto(id){
            dialogPesquisaProduto.dialog('close');
            adicionarProdutoAjax(id);
        }

        function selecionarCliente(id){
            dialogInformarCliente.dialog('close');
            $.ajax({
                url: "{{route('dados.cliente')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'post',
                data: {
                    id: id,
                },
                dataType: 'json',
                success: function(dados){
                    cliente = id;
                    $('#clienteInfo').text(dados.nome);
                    $('#clienteFinalizar').val(id);
                }
            });
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
                        atualizarValorTotal();
                    }
                    $("#codigoProduto").val("");
                }
            });

            quantidade = 1;
            $("#quantidadeInfo").text(quantidade);
        }

        function atualizarValorTotal(){
            $.get("{{route('valorTotalCaixa.pedidos')}}", function(e){
                $("#valorTotalCompra").text('R$ ' + e);
                let valor = parseFloat(e) - parseFloat(desconto);
                $("#valorTotalPagamento").text('R$ ' + e);
                $("#valorTotalFinalizar").val(e);
                $("#descontoFinalizar").val(desconto);
                $("#descontoInfo").text('R$ ' + desconto);
            });
        }
    </script>
@endsection

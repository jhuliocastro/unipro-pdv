<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Produtos;
use App\Models\Pedidos_Caixa;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [Dashboard::class, 'index']);

Route::post('/consulta/produto', [Produtos::class, 'consultaProduto'])->name('consulta.produto');

Route::view('listagemProdutosCaixa', 'listagemProdutosCaixa', [
    'data' => DB::table('pedidos_caixa')->where('ip', request()->ip())->orderBy('id', 'desc')->get()
]);

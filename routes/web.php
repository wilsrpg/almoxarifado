<?php

use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Pag;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MovimentacaoController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pagina_inicial');
});
//Route::get('/pag', Pag::class);
//Route::get('/postagens/{titulo?}', [PostagemController::class, 'index']);
Route::get('/categorias/{nome?}', [CategoriaController::class, 'index']);
Route::get('/nova_categoria', [CategoriaController::class, 'nova_categoria']);
Route::post('/cadastrar_categoria', [CategoriaController::class, 'cadastrar_categoria']);
Route::get('/itens/{nome?}', [ItemController::class, 'index']);
Route::get('/novo_item', [ItemController::class, 'novo_item']);
Route::post('/cadastrar_item', [ItemController::class, 'cadastrar_item']);
Route::get('/grupos/{nome?}', [GrupoController::class, 'index']);
Route::get('/novo_grupo', [GrupoController::class, 'novo_grupo']);
Route::post('/cadastrar_grupo', [GrupoController::class, 'cadastrar_grupo']);
Route::get('/movimentacoes/{id?}', [MovimentacaoController::class, 'index']);
Route::get('/novo_emprestimo', [MovimentacaoController::class, 'novo_emprestimo']);
Route::post('/registrar_emprestimo', [MovimentacaoController::class, 'registrar_emprestimo']);
Route::get('/nova_devolucao', [MovimentacaoController::class, 'nova_devolucao']);
Route::post('/registrar_devolucao', [MovimentacaoController::class, 'registrar_devolucao']);
Route::get('/nova_transferencia', [MovimentacaoController::class, 'nova_transferencia']);
Route::post('/registrar_transferencia', [MovimentacaoController::class, 'registrar_transferencia']);

//Route::get('/novo_emprestimo', [MovimentacaoController::class, 'nova_movimentacao']);
//Route::post('/registrar_emprestimo', [MovimentacaoController::class, 'registrar_movimentacao']);
//Route::get('/nova_devolucao', [MovimentacaoController::class, 'nova_movimentacao']);
//Route::post('/registrar_devolucao', [MovimentacaoController::class, 'registrar_movimentacao']);

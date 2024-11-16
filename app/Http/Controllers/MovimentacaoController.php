<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use App\Models\Item;
use App\Models\Grupo;

class MovimentacaoController extends Controller
{
  public function index($id = '')
  {
    if ($id == '')
      return view('movimentacoes', ['movimentacoes' => Movimentacao::all()]);
    else
      return view('movimentacoes', ['movimentacao' => Movimentacao::where('data', $id)->first()]);
  }

  public function novo_emprestimo() {
    return view('novo_emprestimo', [
      //'itens' => Item::aggregate()->project(_id: 1, nome: 1)->get(),
      'itens' => Item::all(),
      'grupos' => Grupo::all()
    ]);
  }

  public function registrar_emprestimo(Request $req) {
    //echo '<pre>';
    //$req->validate(['data' => 'required']);
    //print_r($req->data ?? 'cadê a data?');
    //print_r($req->all());
    //die();
    $movimentacao = new Movimentacao;
    $movimentacao->data = $_POST['data'];
    $movimentacao->hora = $_POST['hora'];
    $movimentacao->responsavel = $_POST['responsavel'];
    $movimentacao->tipo = 'emprestimo';
    //$movimentacao->itens = [];
    //if (isset($_POST['itens'])) {
      $movimentacao->itens = $_POST['itens'];
      //foreach ($_POST['itens'] as $item_id) {
        //if ($movimentacao->tipo == 'Empréstimo')
        //  $disp = false;
        //if ($movimentacao->tipo == 'Devolução')
        //  $disp = true;
      //  $res = Item::where('_id', $item_id)->first()->update(['disponivel' => $disp]);
      //}
      $resUpdate = Item::whereIn('_id', $movimentacao->itens)->update(['disponivel' => false]);
    //}
    $movimentacao->anotacoes = $_POST['anotacoes'];
    //echo '<pre>';print_r($movimentacao);
    //die();
    $res = $movimentacao->save();
    //echo '<pre>';print_r($res);die();
    return redirect('/')->with('registrou_emprestimo', $res);
  }

  public function nova_devolucao() {
    return view('nova_devolucao', [
      //'itens' => Item::aggregate()->project(_id: 1, nome: 1)->get(),
      'itens' => Item::all(),
      'grupos' => Grupo::all()
    ]);
  }

  public function registrar_devolucao() {
    $movimentacao = new Movimentacao;
    $movimentacao->data = $_POST['data'];
    $movimentacao->hora = $_POST['hora'];
    $movimentacao->responsavel = $_POST['responsavel'];
    $movimentacao->anotacoes = $_POST['anotacoes'];
    $movimentacao->tipo = 'devolucao';
    $movimentacao->itens = $_POST['itens'];
    $resUpdate = Item::whereIn('_id', $movimentacao->itens)->update(['disponivel' => true]);
    $res = $movimentacao->save();
    return redirect('/')->with('registrou_devolucao', $res);
  }
}

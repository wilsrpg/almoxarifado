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
    //Movimentacao::where('tipo', 'devolucao')->update(['tipo' => 'Devolução']);
    //Movimentacao::where('responsavel', 'eu')->where('tipo', 'Devolução')->update(['quem_recebeu' => 'eu']);
    //Movimentacao::where('responsavel', 'eu')->where('tipo', 'Empréstimo')->update(['quem_entregou' => 'eu']);
    if ($id == '') {
      $movimentacoes = Movimentacao::all();
      foreach ($movimentacoes as $movimentacao) {
        $movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
      }
      return view('movimentacoes', ['movimentacoes' => $movimentacoes]);
    } else {
      $movimentacao = Movimentacao::where('id', $id)->first();
      $movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
      return view('movimentacoes', ['movimentacao' => $movimentacao]);
    }
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
    $movimentacao->quem_entregou = $_POST['quem_entregou'];
    $movimentacao->quem_levou = $_POST['quem_levou'];
    $movimentacao->tipo = 'Empréstimo';
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
      $resUpdate = Item::whereIn('_id', $movimentacao->itens)->update([
        'disponivel' => false,
        'onde_esta' => $_POST['quem_levou']
      ]);
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
      'grupos' => Grupo::all(),
      'emprestimos' => Movimentacao::where('tipo', 'Empréstimo')->get()
    ]);
  }

  public function registrar_devolucao() {
    $movimentacao = new Movimentacao;
    $movimentacao->data = $_POST['data'];
    $movimentacao->hora = $_POST['hora'];
    $movimentacao->quem_recebeu = $_POST['quem_recebeu'];
    $movimentacao->quem_devolveu = $_POST['quem_devolveu'];
    $movimentacao->anotacoes = $_POST['anotacoes'];
    $movimentacao->tipo = 'Devolução';
    $movimentacao->itens = $_POST['itens'];
    $resUpdate = Item::whereIn('_id', $movimentacao->itens)->update([
      'disponivel' => true,
      'onde_esta' => 'Comunidade'
    ]);
    $res = $movimentacao->save();
    return redirect('/')->with('registrou_devolucao', $res);
  }
  
  public function nova_transferencia() {
    return view('nova_transferencia', [
      //'itens' => Item::aggregate()->project(_id: 1, nome: 1)->get(),
      'itens' => Item::all(),
      'grupos' => Grupo::all(),
      'emprestimos' => Movimentacao::where('tipo', 'Empréstimo')->get()
    ]);
  }

  public function registrar_transferencia() {
    $movimentacao = new Movimentacao;
    $movimentacao->data = $_POST['data'];
    $movimentacao->hora = $_POST['hora'];
    $movimentacao->quem_transferiu = $_POST['quem_transferiu'];
    $movimentacao->quem_recebeu = $_POST['quem_recebeu'];
    $movimentacao->anotacoes = $_POST['anotacoes'];
    $movimentacao->tipo = 'Empréstimo';
    $movimentacao->itens = $_POST['itens'];
      $resUpdate = Item::whereIn('_id', $movimentacao->itens)->update([
        'onde_esta' => $_POST['quem_recebeu']
      ]);
    $res = $movimentacao->save();
    return redirect('/')->with('registrou_transferencia', $res);
  }
}

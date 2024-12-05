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
/*
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
*/
  public function nova_movimentacao() {
    return view('nova_movimentacao', [
      //'itens' => Item::all(),
      'itens' => Item::aggregate()->project(_id: 1, nome: 1, disponivel: 1)->get(),
      //'grupos' => Grupo::aggregate()->project(_id: 1, nome: 1, itens: 1)->get(),
      'grupos' => Grupo::all(),
      'movimentacoes' => Movimentacao::all()
    ]);
  }

  public function registrar_movimentacao(Request $req) {
    $movimentacao = new Movimentacao;
    $movimentacao->data = $req->data;
    $movimentacao->hora = $req->hora;
    $movimentacao->quem_entregou = $req->quem_entregou;
    $movimentacao->quem_recebeu = $req->quem_recebeu;
    $movimentacao->anotacoes = $req->anotacoes;
    $movimentacao->tipo = $req->tipo;
    $movimentacao->itens = $req->itens;
    $itensUpdate = Item::whereIn('_id', $movimentacao->itens)->update([
      'disponivel' => $movimentacao->tipo == 'Devolução',
      'onde_esta' => $movimentacao->tipo == 'Devolução' ? 'Comunidade' : $movimentacao->quem_recebeu
    ]);
    $res = $movimentacao->save();
    //if ($res) {
    //  $itensMovUpdate = Item::whereIn('_id', $movimentacao->itens)
    //    ->push('historico_de_movimentacoes', $movimentacao->id);
    //}
    if ($movimentacao->tipo == 'Empréstimo')
      return redirect('/')->with('registrou_emprestimo', $res);
    elseif ($movimentacao->tipo == 'Devolução')
      return redirect('/')->with('registrou_devolucao', $res);
    elseif ($movimentacao->tipo == 'Transferência')
      return redirect('/')->with('registrou_transferencia', $res);
  }
/*
  public function editar($id) {
    return view('editar_movimentacao', [
      'movimentacao' => Movimentacao::where('id', $id)->first(),
      //'itens' => Item::all(),
      'itens' => Item::aggregate()->project(_id: 1, nome: 1, disponivel: 1)->get(),
      'grupos' => Grupo::all(),
      'movimentacoes' => Movimentacao::all()
    ]);
  }

  public function atualizar_movimentacao($id, Request $req) {
    //echo '<pre>'.$id.'<br>';
    //print_r($req);die();
    $movimentacao = Movimentacao::where('id', $id)->first();
    $movimentacao->data = $req->data;
    $movimentacao->hora = $req->hora;
    $movimentacao->quem_entregou = $req->quem_entregou;
    $movimentacao->quem_recebeu = $req->quem_recebeu;
    $movimentacao->anotacoes = $req->anotacoes;
    $movimentacao->tipo = $req->tipo;
    //implementar histórico de item e, caso haja alteração de item na movimentação,
    //retornar campos 'disponivel' e 'onde_esta' pros valores anteriores
    $itens_removidos = array_intersect($movimentacao->itens, array_diff($movimentacao->itens, $req->itens));
    if (count($itens_removidos)) {
      //foreach ($itens_removidos as $item) {
      //  array_pop($item->historico);
      //  $disponibilidade_anterior = end($item->historico)->disponivel;
      //  $onde_estava = end($item->historico)->onde_esta;
      //}
      $resUpdate = Item::whereIn('_id', $itens_removidos)->update([
        //'disponivel' => $disponibilidade_anterior,
        //'onde_esta' => $onde_estava
        'disponivel' => true, //errado, pq só vale para empréstimo
        'onde_esta' => 'Comunidade' //errado, pq só vale para empréstimo
      ]);
    }
    $movimentacao->itens = $req->itens;
    $resUpdate = Item::whereIn('_id', $movimentacao->itens)->update([
      'disponivel' => $movimentacao->tipo == 'Devolução',
      'onde_esta' => $movimentacao->tipo == 'Devolução' ? 'Comunidade' : $movimentacao->quem_recebeu
    ]);
    $res = $movimentacao->save();
    if ($movimentacao->tipo == 'Empréstimo')
      return redirect('/')->with('atualizou_emprestimo', $res);
    elseif ($movimentacao->tipo == 'Devolução')
      return redirect('/')->with('atualizou_devolucao', $res);
    elseif ($movimentacao->tipo == 'Transferência')
      return redirect('/')->with('atualizou_transferencia', $res);
  }*/
}

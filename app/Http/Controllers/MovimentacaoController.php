<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movimentacao;
use App\Models\Item;
use App\Models\Grupo;

class MovimentacaoController extends Controller
{
  public function index() {
    //Movimentacao::where('id', '6751ef9d515ffcbb02070017')->push('itens', '6751e467515ffcbb02070013');
    //Movimentacao::where('tipo', 'devolucao')->update(['tipo' => 'Devolução']);
    //Movimentacao::where('responsavel', 'eu')->where('tipo', 'Devolução')->update(['quem_recebeu' => 'eu']);
    //Movimentacao::whereNull('quem_recebeu')->update(['quem_recebeu' => '']);
    //Movimentacao::whereNull('quem_entregou')->update(['quem_entregou' => '']);
    //$respons = Movimentacao::where('responsavel', 'like', '%')->get();
    //$respons = Movimentacao::whereNot('responsavel', 'like', 'eu')->get();
    //$respons = Movimentacao::where('responsavel', 'like', '%')->update(['$unset' => ['responsavel' => 1]]);
    //Movimentacao::where('responsavel', 'eu')->where('tipo', 'Empréstimo')->update(['quem_entregou' => 'eu']);
    //echo '<pre>';
    //print_r($respons);die();
    $movimentacoes = Movimentacao::all();
    foreach ($movimentacoes as $movimentacao)
      $movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
    return view('movimentacoes.movimentacoes', ['movimentacoes' => $movimentacoes]);
  }

  public function ver($id) {
    $movimentacao = Movimentacao::where('id', $id)->first();
    $movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
    return view('movimentacoes.movimentacao', ['movimentacao' => $movimentacao]);
  }
  
  public function pagina_de_criacao() {
    return view('movimentacoes.nova_movimentacao', [
      //'itens' => Item::all(),
      'itens' => Item::aggregate()->project(_id: 1, nome: 1, disponivel: 1)->get(),
      //'grupos' => Grupo::aggregate()->project(_id: 1, nome: 1, itens: 1)->get(),
      'grupos' => Grupo::all(),
      //'movimentacoes' => Movimentacao::all()
      'movimentacoes' => Movimentacao::aggregate()->project(_id: 1, data: 1, hora: 1, itens: 1)->get(),
    ]);
  }

  public function criar(Request $req) {
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
    if ($res) {
      $itensMovUpdate = Item::whereIn('_id', $movimentacao->itens)
        ->push('historico_de_movimentacoes', $movimentacao->id);
    }
    $genero = $movimentacao->tipo == 'Empréstimo' ? 'o' : 'a';
    return redirect('/')->with('mensagem', $movimentacao->tipo.' realizad'.$genero.' com sucesso.');
  }

  public function pagina_de_edicao($id) {
    return view('movimentacoes.editar_movimentacao', [
      'movimentacao' => Movimentacao::where('id', $id)->first(),
      //'itens' => Item::all(),
      'itens' => Item::aggregate()->project(_id: 1, nome: 1, disponivel: 1)->get(),
      'grupos' => Grupo::all(),
      //'movimentacoes' => Movimentacao::all()
      'movimentacoes' => Movimentacao::aggregate()->project(id: 1, data: 1, hora: 1, itens: 1)->get(),
    ]);
  }

  public function atualizar($id, Request $req) {
    //echo '<pre>'.$id.'<br>';
    //print_r($req);die();
    $movimentacao = Movimentacao::where('id', $id)->first();
    $movimentacao->data = $req->data;
    $movimentacao->hora = $req->hora;
    $movimentacao->quem_entregou = $req->quem_entregou;
    $movimentacao->quem_recebeu = $req->quem_recebeu;
    $movimentacao->anotacoes = $req->anotacoes;
    $movimentacao->tipo = $req->tipo;
    $ids_dos_itens_removidos = array_intersect($movimentacao->itens, array_diff($movimentacao->itens, $req->itens));
    $itens_removidos = Item::whereIn('id', $ids_dos_itens_removidos)->get();
    if (count($itens_removidos)) {
      foreach ($itens_removidos as $item) {
        $histmovitem = $item->historico_de_movimentacoes;
        array_pop($histmovitem);
        $item->historico_de_movimentacoes = $histmovitem;
        //print_r($item->historico_de_movimentacoes);
        //die();
        if (count($histmovitem)) {
          $movimentacao_anterior = Movimentacao::where('id', end($histmovitem))->first();
          $item->disponivel = $movimentacao_anterior->tipo == 'Devolução';
          $item->onde_esta = $movimentacao_anterior->tipo == 'Devolução' ? 'Comunidade'
            : $movimentacao_anterior->quem_recebeu;
        } else {
          $item->disponivel = true;
          $item->onde_esta = 'Comunidade';
        }
        //$itemRemovUpdate = Item::where('id', $item->id)->update([
        //  'disponivel' => $movimentacao_anterior->tipo == 'Devolução',
        //  'onde_esta' => $movimentacao_anterior->tipo == 'Devolução' ? 'Comunidade' : $movimentacao_anterior->quem_recebeu
        //]);
        $item->save();
      }
    }
    $itens_adicionados = array_intersect($req->itens, array_diff($req->itens, $movimentacao->itens));
    if (count($itens_adicionados)) {
      foreach ($itens_adicionados as $item) {
        $itemAdicUpdate = Item::where('id', $item)->push('historico_de_movimentacoes', $id);
        //$itemUpdate = Item::where('id', $item)->update([
        //  'disponivel' => end($item->historico_de_movimentacoes)->disponivel ?? true,
        //  'onde_esta' => end($item->historico_de_movimentacoes)->onde_esta ?? 'Comunidade'
        //]);
      }
    }
    $movimentacao->itens = $req->itens;
    $itensUpdate = Item::whereIn('id', $movimentacao->itens)->update([
      'disponivel' => $movimentacao->tipo == 'Devolução',
      'onde_esta' => $movimentacao->tipo == 'Devolução' ? 'Comunidade' : $movimentacao->quem_recebeu
    ]);
    $res = $movimentacao->save();
    $genero = $movimentacao->tipo == 'Empréstimo' ? 'o' : 'a';
    return redirect('/')->with('mensagem', $movimentacao->tipo.' atualizad'.$genero.' com sucesso.');
  }

  public function excluir($id) {
    $movimentacao = Movimentacao::where('id', $id)->first();
    
    $itens_removidos = Item::whereIn('id', $movimentacao->itens)->get();
    //echo '<pre>';
    //print_r(count($itens_removidos));
    //die();
    if (count($itens_removidos)) {
      foreach ($itens_removidos as $item) {
        $histmovitem = $item->historico_de_movimentacoes;
        array_pop($histmovitem);
        $item->historico_de_movimentacoes = $histmovitem;
        //print_r($item->historico_de_movimentacoes);
        //die();
        if (count($histmovitem)) {
          $movimentacao_anterior = Movimentacao::where('id', end($histmovitem))->first();
          $item->disponivel = $movimentacao_anterior->tipo == 'Devolução';
          $item->onde_esta = $movimentacao_anterior->tipo == 'Devolução' ? 'Comunidade'
            : $movimentacao_anterior->quem_recebeu;
        } else {
          $item->disponivel = true;
          $item->onde_esta = 'Comunidade';
        }
        $item->save();
      }
    }

    $genero = $movimentacao->tipo == 'Empréstimo' ? 'o' : 'a';
    $res = $movimentacao->update(['deletado' => true]);
    return redirect('/')->with('mensagem', $movimentacao->tipo.' excluíd'.$genero.' com sucesso.');
  }
}

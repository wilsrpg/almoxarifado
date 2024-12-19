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
    $filtro = (object)[];
    $filtro->data = $_GET['data'] ?? '';
    $filtro->hora = $_GET['hora'] ?? '';
    $filtro->tipo = $_GET['tipo'] ?? '';
    $filtro->quem_entregou = $_GET['quem_entregou'] ?? '';
    $filtro->quem_recebeu = $_GET['quem_recebeu'] ?? '';
    $filtro->anotacoes = $_GET['anotacoes'] ?? '';
    $movimentacoes = Movimentacao::where('data', 'like', '%'.$filtro->data.'%')
      ->where('hora', 'like', '%'.$filtro->hora.'%')
      ->where('tipo', 'like', '%'.$filtro->tipo.'%')
      ->where('quem_entregou', 'like', '%'.$filtro->quem_entregou.'%')
      ->where('quem_recebeu', 'like', '%'.$filtro->quem_recebeu.'%')
      ->where('anotacoes', 'regexp', '/.*'.$filtro->anotacoes.'.*/ms')
      ->get();
    //$movimentacoes = Movimentacao::all();
    //foreach ($movimentacoes as $movimentacao)
    //  $movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
    foreach ($movimentacoes as $movimentacao) {
      $itens_db = Item::whereIn('_id', $movimentacao->itens)->get();
      $itens_em_ordem = [];
      foreach ($movimentacao->itens as $it)
        $itens_em_ordem[] = $itens_db->find($it);
      $movimentacao->itens = $itens_em_ordem;
    }
    return view('movimentacoes.movimentacoes', ['movimentacoes' => $movimentacoes, 'filtro' => $filtro]);
  }

  public function ver($id) {
    $movimentacao = Movimentacao::where('id', $id)->first();
    //$movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
    $itens_db = Item::whereIn('_id', $movimentacao->itens)->get();
    $itens_em_ordem = [];
    foreach ($movimentacao->itens as $it)
      $itens_em_ordem[] = $itens_db->find($it);
    $movimentacao->itens = $itens_em_ordem;
    return view('movimentacoes.movimentacao', ['movimentacao' => $movimentacao]);
  }

  public function pagina_de_criacao($id = null) {
    $movimentacao = [];
    if ($id)
      $movimentacao = Movimentacao::where('id', $id)->first();
    return view('movimentacoes.nova_movimentacao', [
      //'itens' => Item::all(),
      'itens' => Item::all(),
      //'grupos' => Grupo::aggregate()->project(_id: 1, nome: 1, itens: 1)->get(),
      'grupos' => Grupo::all(),
      //'movimentacoes' => Movimentacao::all()
      'movimentacoes' => Movimentacao::aggregate()->project(_id: 1, data: 1, hora: 1, itens: 1)->get(),
      'movimentacao' => $movimentacao
    ]);
  }

  public function criar(Request $req) {
    //echo '<pre>';
    //print_r($req->toArray());die();
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
      'itens' => Item::all(),
      'grupos' => Grupo::all(),
      //'movimentacoes' => Movimentacao::all()
      'movimentacoes' => Movimentacao::aggregate()->project(id: 1, data: 1, hora: 1, itens: 1)->get(),
    ]);
  }

  public function atualizar($id, Request $req) {
    //echo '<pre>'.$id.'<br>';
    //print_r($req->toArray());die();
    $movimentacao = Movimentacao::where('id', $id)->first();
    $ids_dos_itens_removidos = array_diff($movimentacao->itens, $req->itens);
    if ($movimentacao->tipo != $req->tipo || count($ids_dos_itens_removidos) > 0) {
      $itens_da_movimentacao = Item::whereIn('id', $movimentacao->itens)->get();
      foreach ($itens_da_movimentacao as $item) {
        if ($item->historico_de_movimentacoes[array_key_last($item->historico_de_movimentacoes)] != $id)
          return redirect('/')->with('mensagem',
            'Não foi possível alterar a movimentação, porque já houve movimentação mais recente em um ou mais itens.'
          );
      }
    }
    $movimentacao->data = $req->data;
    $movimentacao->hora = $req->hora;
    $movimentacao->quem_entregou = $req->quem_entregou;
    $movimentacao->quem_recebeu = $req->quem_recebeu;
    $movimentacao->anotacoes = $req->anotacoes;
    $movimentacao->tipo = $req->tipo;
    if (count($ids_dos_itens_removidos) > 0) {
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
    }
    $ids_dos_itens_adicionados = array_diff($req->itens, $movimentacao->itens);
    if (count($ids_dos_itens_adicionados)) {
      foreach ($ids_dos_itens_adicionados as $item) {
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
    $itens_da_movimentacao = Item::whereIn('id', $movimentacao->itens)->get();
    foreach ($itens_da_movimentacao as $item) {
      if ($item->historico_de_movimentacoes[array_key_last($item->historico_de_movimentacoes)] != $id)
        return redirect('/')->with('mensagem',
          'Não foi possível excluir, porque já houve movimentação mais recente em um ou mais itens.'
        );
    }
    //$itens_removidos = Item::whereIn('id', $movimentacao->itens)->get();
    //echo '<pre>';
    //print_r(count($itens_removidos));
    //die();
    if (count($itens_da_movimentacao)) {
      foreach ($itens_da_movimentacao as $item) {
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
    $res = Movimentacao::where('id', $id)->update(['deletado' => true]);
    return redirect('/')->with('mensagem', $movimentacao->tipo.' excluíd'.$genero.' com sucesso.');
  }
}

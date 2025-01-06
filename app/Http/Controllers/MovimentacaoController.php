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
    $filtro->dataAte = $_GET['dataAte'] ?? '';
    $filtro->hora = $_GET['hora'] ?? '';
    $filtro->horaAte = $_GET['horaAte'] ?? '';
    $filtro->tipo = $_GET['tipo'] ?? '';
    $filtro->itens = $_GET['itens'] ?? [];
    $filtro->qtdes = $_GET['qtdes'] ?? [];
    $filtro->quem_entregou = $_GET['quem_entregou'] ?? '';
    $filtro->quem_recebeu = $_GET['quem_recebeu'] ?? '';
    $filtro->anotacoes = $_GET['anotacoes'] ?? '';

    $movimentacoes = Movimentacao::where('tipo', 'like', '%'.$filtro->tipo.'%')
      ->where('quem_entregou', 'like', '%'.$filtro->quem_entregou.'%')
      ->where('quem_recebeu', 'like', '%'.$filtro->quem_recebeu.'%')
      ->where('anotacoes', 'regexp', '/.*'.$filtro->anotacoes.'.*/ms')
      ->get();
    //print_r($movimentacoes);die();

    if ($filtro->dataAte)
      $movimentacoes = $movimentacoes->where('data', '>=', $filtro->data)
        ->where('data', '<=', $filtro->dataAte);
    else if ($filtro->data)
      $movimentacoes = $movimentacoes->where('data', $filtro->data);

    if ($filtro->horaAte && $filtro->hora && $filtro->hora > $filtro->horaAte) {
      $horaDe = date_format(date_create($filtro->hora)->sub(new \DateInterval("PT1M")), 'H:i');
      $horaAte = date_format(date_create($filtro->horaAte)->add(new \DateInterval("PT1M")), 'H:i');
      //print_r($horaAte);die();
      $movimentacoes = $movimentacoes->whereNotBetween('hora', [$horaAte, $horaDe]);
    } else if ($filtro->horaAte)
      $movimentacoes = $movimentacoes->where('hora', '>=', $filtro->hora)
        ->where('hora', '<=', $filtro->horaAte);
    else if ($filtro->hora)
      $movimentacoes = $movimentacoes->where('hora', $filtro->hora);

    //print_r($movimentacoes);die();
    //$movimentacoes = Movimentacao::all();
    //foreach ($movimentacoes as $movimentacao)
    //  $movimentacao->itens = Item::whereIn('_id', $movimentacao->itens)->get();
    if (count($filtro->itens))
      $movimentacoes = $movimentacoes->filter(function ($movimentacao) use ($filtro) {
        $tem_tudo = count(array_diff($filtro->itens, $movimentacao->itens))==0;
        foreach ($movimentacao->itens as $key => $id_do_item)
          if (isset($movimentacao->qtdes[$key]) && isset($filtro->qtdes[array_search($id_do_item, $filtro->itens)]))
            if ($movimentacao->qtdes[$key] < $filtro->qtdes[array_search($id_do_item, $filtro->itens)])
              $tem_tudo = false;
        return $tem_tudo;
      });

    foreach ($movimentacoes as $movimentacao) {
      $itens_db = Item::whereIn('_id', $movimentacao->itens)->get();
      $itens_em_ordem = [];
      foreach ($movimentacao->itens as $it)
        $itens_em_ordem[] = $itens_db->find($it);
      $movimentacao->itens = $itens_em_ordem;
    }

    return view('movimentacoes.movimentacoes', ['movimentacoes' => $movimentacoes, 'itens' => Item::all(), 'grupos' => Grupo::all(), 'filtro' => $filtro]);
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

  public function pagina_de_criacao(Request $req) {
    $movimentacao = [];
    if (!empty($req->id)) {
      $movimentacao = Movimentacao::where('id', $req->id)->first();
      if ($movimentacao->tipo == 'Empréstimo' || $movimentacao->tipo == 'Transferência') {
          $movimentacao->quem_entregou = $movimentacao->quem_recebeu;
          $movimentacao->quem_recebeu = '';
      } else
      if ($movimentacao->tipo == 'Devolução') {
          $movimentacao->quem_recebeu = $movimentacao->quem_entregou;
          $movimentacao->quem_entregou = '';
      }
      $movimentacao->tipo = $req->tipo;
    }
    return view('movimentacoes.nova_movimentacao', [
      'itens' => Item::all(),
      'grupos' => Grupo::all(),
      'movimentacoes' => Movimentacao::aggregate()->project(_id: 1, data: 1, hora: 1, itens: 1)->get(),
      'movimentacao' => $movimentacao
    ]);
  }

  function validar_quantidades($movimentacao) {
    $ids_dos_itens_com_qtde = [];
    $indices_dos_itens_com_qtde = [];
    foreach ($movimentacao->itens as $key => $id_do_item)
      if ($movimentacao->qtdes[$key]){
        $ids_dos_itens_com_qtde[] = $id_do_item;
        $indices_dos_itens_com_qtde[] = $key;
      }
    $itens_da_movimentacao = Item::whereIn('_id', $ids_dos_itens_com_qtde)->get();
    foreach ($itens_da_movimentacao as $item) {
      $key = $indices_dos_itens_com_qtde[array_search($item->id, $ids_dos_itens_com_qtde)];
      $paradeiros = array_map(function($v){return $v['onde'];}, $item->onde_esta);
      $onde_esta = array_search($movimentacao->quem_entregou, $paradeiros);
      if ($movimentacao->tipo == 'Empréstimo') {
        if ($movimentacao->qtdes[$key] > $item->onde_esta[0]['qtde'])
          return ['status' => false, 'mensagem' => 'erro: quantidade do item "'.$item->nome.'" insuficiente para empréstimo.'
          .' Quantidade disponível: '.$item->onde_esta[0]['qtde'].';'
          .' quantidade solicitada: '.$movimentacao->qtdes[$key].'.'];
      }
      else if ($movimentacao->tipo == 'Devolução' || $movimentacao->tipo == 'Transferência') {
        if ($onde_esta === false)
          return ['status' => false,
            'mensagem' => 'erro: responsável pela entrega não encontrado: '.$movimentacao->quem_entregou.'.'];
        else if ($movimentacao->qtdes[$key] > $item->onde_esta[$onde_esta]['qtde'])
          return ['status' => false, 'mensagem' => 'erro: quantidade do item "'.$item->nome.'" insuficiente com "'
            .$item->onde_esta[$onde_esta]['onde'].'".'
            .' Quantidade emprestada: '.$item->onde_esta[$onde_esta]['qtde'].';'
            .' quantidade solicitada: '.$movimentacao->qtdes[$key].'.'];
      } else
        return ['status' => false, 'mensagem' => 'erro: tipo inválido: '.$movimentacao->tipo.'.'];
    }
    return ['status' => true];
  }

  function aplicar_movimentacao_nos_itens($movimentacao) {
    //atualização dos itens sem quantidade
    Item::whereIn('_id', $movimentacao->itens)->where('quantidade', null)->update([
      'disponivel' => $movimentacao->tipo == 'Devolução',
      'onde_esta' => $movimentacao->tipo == 'Devolução' ? 'Comunidade' : $movimentacao->quem_recebeu
    ]);
    Item::whereIn('_id', $movimentacao->itens)->where('quantidade', null)
      ->push('historico_de_movimentacoes', $movimentacao->id);
    //atualização dos itens com quantidade
    //$ids_dos_itens_com_qtde = [];
    //foreach ($movimentacao->itens as $key => $id_do_item)
      //if ($movimentacao->qtdes[$key])
        //$ids_dos_itens_com_qtde[] = $id_do_item;
    //$itens_com_qtde = Item::whereIn('_id', $ids_dos_itens_com_qtde)->get();
    $itens_com_qtde = Item::whereIn('_id', $movimentacao->itens)->where('quantidade', '!=', null)->get();
    foreach ($movimentacao->itens as $key => $id_do_item)
      if ($movimentacao->qtdes[$key]) {
        $item = $itens_com_qtde->find($id_do_item);
        $ultimo_indice = array_key_last($item->historico_de_movimentacoes);
        if ($item->historico_de_movimentacoes[$ultimo_indice] == $movimentacao->id)
          continue;
        else {
          $histmovitem = $item->historico_de_movimentacoes;
          $histmovitem[] = $movimentacao->id;
          $item->historico_de_movimentacoes = $histmovitem;
        }
        $paradeiros = array_map(function($v){return $v['onde'];}, $item->onde_esta);
        $onde_estava = array_search($movimentacao->quem_entregou, $paradeiros);
        $quem_vai_receber = array_search($movimentacao->quem_recebeu, $paradeiros);
        $arr = $item->onde_esta;
        if ($movimentacao->tipo == 'Empréstimo'){
          $arr[0]['qtde'] -= $movimentacao->qtdes[$key];
          if ($arr[0]['qtde'] <= 0)
            $item->disponivel = false;
          if ($quem_vai_receber === false)
            $arr[] = ['onde' => $movimentacao->quem_recebeu, 'qtde' => $movimentacao->qtdes[$key]];
          else
            $arr[$quem_vai_receber]['qtde'] += $movimentacao->qtdes[$key];
        }
        else if ($movimentacao->tipo == 'Devolução') {
          $arr[0]['qtde'] += $movimentacao->qtdes[$key];
          if ($arr[0]['qtde'] > 0)
            $item->disponivel = true;
          $arr[$onde_estava]['qtde'] -= $movimentacao->qtdes[$key];
          if ($arr[$onde_estava]['qtde'] == 0)
            unset($arr[$onde_estava]);
        }
        else if ($movimentacao->tipo == 'Transferência') {
          if ($quem_vai_receber === false)
            $arr[] = ['onde' => $movimentacao->quem_recebeu, 'qtde' => $movimentacao->qtdes[$key]];
          else
            $arr[$quem_vai_receber]['qtde'] += $movimentacao->qtdes[$key];
          $arr[$onde_estava]['qtde'] -= $movimentacao->qtdes[$key];
          if ($arr[$onde_estava]['qtde'] == 0)
            unset($arr[$onde_estava]);
        }
        $item->onde_esta = $arr;
        $item->save();
      }
  }

  function checar_ultima_movimentacao_de_itens_da_movimentacao($itens, $id_da_movimentacao) {
    $itens_da_movimentacao = Item::whereIn('id', $itens)->get();
    //$ultimo_indice = array_key_last($itens_da_movimentacao[0]->historico_de_movimentacoes);
    //$id_da_movimentacao = $itens_da_movimentacao[0]->historico_de_movimentacoes[$ultimo_indice];
    foreach ($itens_da_movimentacao as $item)
      if ($item->historico_de_movimentacoes[array_key_last($item->historico_de_movimentacoes)] != $id_da_movimentacao)
        return false;
    return true;
  }

  public function desfazer_ultima_movimentacao_de_itens_da_movimentacao($itens, $id_da_movimentacao) {
    $itens_da_movimentacao = Item::whereIn('id', $itens)->get();
    //$ultimo_indice = array_key_last($itens_da_movimentacao[0]->historico_de_movimentacoes);
    //$id_da_movimentacao = $itens_da_movimentacao[0]->historico_de_movimentacoes[$ultimo_indice];
    //if (!$this->checar_ultima_movimentacao_de_itens_da_movimentacao($itens, $id_da_movimentacao))
      //return false;
    $movimentacao = Movimentacao::where('id', $id_da_movimentacao)->first();
    //print_r(count($itens_removidos));
    //die();
    foreach ($movimentacao->itens as $key => $id_do_item) {
      $item = $itens_da_movimentacao->find($id_do_item);
      $histmovitem = $item->historico_de_movimentacoes;
      array_pop($histmovitem);
      $item->historico_de_movimentacoes = $histmovitem;
      //print_r($item->historico_de_movimentacoes);
      //die();
      if (count($histmovitem) == 0) {
        $item->disponivel = true;
        if (isset($item->quantidade))
          $item->onde_esta = [['onde' => 'Comunidade', 'qtde' => $item->quantidade]];
        else
          $item->onde_esta = 'Comunidade';
      } else if (!isset($item->quantidade)) {
        $movimentacao_anterior = Movimentacao::where('id', end($histmovitem))->first();
        $item->disponivel = $movimentacao_anterior->tipo == 'Devolução';
        $item->onde_esta = $movimentacao_anterior->tipo == 'Devolução' ? 'Comunidade'
          : $movimentacao_anterior->quem_recebeu;
      } else if (isset($item->quantidade)) {
        $paradeiros = array_map(function($v){return $v['onde'];}, $item->onde_esta);
        $onde_estava = array_search($movimentacao->quem_entregou, $paradeiros);
        $quem_tinha_recebido = array_search($movimentacao->quem_recebeu, $paradeiros);
        $arr = $item->onde_esta;
        if ($movimentacao->tipo == 'Empréstimo') {
          $arr[0]['qtde'] += $movimentacao->qtdes[$key];
          if ($arr[0]['qtde'] > 0)
            $item->disponivel = true;
          $arr[$quem_tinha_recebido]['qtde'] -= $movimentacao->qtdes[$key];
          if ($arr[$quem_tinha_recebido]['qtde'] == 0)
            unset($arr[$quem_tinha_recebido]);
        }
        else if ($movimentacao->tipo == 'Devolução') {
          $arr[0]['qtde'] -= $movimentacao->qtdes[$key];
          if ($arr[0]['qtde'] <= 0)
            $item->disponivel = false;
          if ($onde_estava === false)
            $arr[] = ['onde' => $movimentacao->quem_entregou, 'qtde' => $movimentacao->qtdes[$key]];
          else
            $arr[$onde_estava]['qtde'] += $movimentacao->qtdes[$key];
        }
        else if ($movimentacao->tipo == 'Transferência') {
          if ($onde_estava === false)
            $arr[] = ['onde' => $movimentacao->quem_entregou, 'qtde' => $movimentacao->qtdes[$key]];
          else
            $arr[$onde_estava]['qtde'] += $movimentacao->qtdes[$key];
          $arr[$quem_tinha_recebido]['qtde'] -= $movimentacao->qtdes[$key];
          if ($arr[$quem_tinha_recebido]['qtde'] == 0)
            unset($arr[$quem_tinha_recebido]);
        }
        $item->onde_esta = $arr;
      }
      $item->save();
    }
    //return true;
  }

  public function criar(Request $req) {
    //echo '<pre>';
    //print_r($req->toArray());die();
    $movimentacao = new Movimentacao;
    $movimentacao->data = $req->data ?? '';
    $movimentacao->hora = $req->hora ?? '';
    $movimentacao->quem_entregou = $req->quem_entregou ?? '';
    $movimentacao->quem_recebeu = $req->quem_recebeu ?? '';
    $movimentacao->anotacoes = $req->anotacoes ?? '';
    $movimentacao->tipo = $req->tipo;
    $movimentacao->itens = $req->itens;
    $movimentacao->qtdes = $req->qtdes;

    $validacao_qtdes = $this->validar_quantidades($movimentacao);
    if (!$validacao_qtdes['status'])
      return redirect('/')->with('mensagem', $validacao_qtdes['mensagem']);

    $res = $movimentacao->save();
    if ($res) {
    //  $itensMovUpdate = Item::whereIn('_id', $movimentacao->itens)
    //    ->push('historico_de_movimentacoes', $movimentacao->id);
      $this->aplicar_movimentacao_nos_itens($movimentacao);
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
    $ids_dos_itens_adicionados = array_diff($req->itens, $movimentacao->itens);
    //só muda tipo ou remove item se a movimentação mais recente de todos os itens for a mesma
    if ($movimentacao->tipo != $req->tipo) {
      if (!$this->checar_ultima_movimentacao_de_itens_da_movimentacao($movimentacao->itens, $id))
        return redirect('/')->with('mensagem',
          'Não foi possível alterar a movimentação porque ela não é a mais recente em todos os itens.'
        );
    } else {
      if (count($ids_dos_itens_removidos) > 0) {
        if (!$this->checar_ultima_movimentacao_de_itens_da_movimentacao($ids_dos_itens_removidos, $id))
          return redirect('/')->with('mensagem',
            'Não foi possível alterar a movimentação porque ela não é a mais recente em todos os itens.'
          );
      }
      if (count($ids_dos_itens_adicionados) > 0) {
        $movtemp = $movimentacao;
        $movtemp->quem_entregou = $req->quem_entregou ?? '';
        $movtemp->quem_recebeu = $req->quem_recebeu ?? '';
        $movtemp->tipo = $req->tipo ?? '';
        $movtemp->itens = [];
        $movtemp->qtdes = [];
        foreach ($req->qtdes as $key => $qtde)
          if ($qtde) {
            $movtemp->itens [] = $req->itens[$key];
            $movtemp->qtdes [] = $qtde;
          }
        $validacao_qtdes = $this->validar_quantidades($movtemp);
        if (!$validacao_qtdes['status'])
          return redirect('/')->with('mensagem', $validacao_qtdes['mensagem']);
      }
    }

    if ($movimentacao->tipo != $req->tipo)
      $this->desfazer_ultima_movimentacao_de_itens_da_movimentacao($movimentacao->itens, $id);
    else if (count($ids_dos_itens_removidos) > 0)
      $this->desfazer_ultima_movimentacao_de_itens_da_movimentacao($ids_dos_itens_removidos, $id);
    $movimentacao->data = $req->data ?? '';
    $movimentacao->hora = $req->hora ?? '';
    $movimentacao->quem_entregou = $req->quem_entregou ?? '';
    $movimentacao->quem_recebeu = $req->quem_recebeu ?? '';
    $movimentacao->anotacoes = $req->anotacoes ?? '';
    $movimentacao->tipo = $req->tipo ?? '';
    $movimentacao->itens = $req->itens ?? '';
    $movimentacao->qtdes = $req->qtdes ?? '';
    $this->aplicar_movimentacao_nos_itens($movimentacao);
    //tipo mudou?
        //menos itens?
            //atualiza itens sem qtde q saíram
            //tem item qtde?
                //atualiza qtde dos itens com qtde q saíram
            //atualiza movimentação
        //mais itens?
            //atualiza itens sem qtde q entraram
            //tem item qtde?
                //atualiza qtde dos itens com qtde q entraram
        //itens n mudaram?
            //tem item qtde & qtde mudou?
                //atualiza qtde
    //tipo n mudou?
        //menos itens?
            //atualiza itens sem qtde q saíram
            //tem item qtde?
                //atualiza qtde dos itens com qtde q saíram
            //atualiza movimentação
        //mais itens?
            //atualiza itens sem qtde q entraram
            //tem item qtde?
                //atualiza qtde dos itens com qtde q entraram
        //itens n mudaram?
            //tem item qtde & qtde mudou?
                //atualiza qtde

    //verificação de erros nos itens com quantidade
    //$itens_com_qtde = [];
    //$indices_dos_itens_com_qtde = [];
    //foreach ($movimentacao->itens as $key => $id_do_item) {
    //  if ($movimentacao->qtdes[$key]){
    //    $item = Item::where('_id', $id_do_item)->first();
    //    $itens_com_qtde[] = $item;
    //    $indices_dos_itens_com_qtde[] = $key;
    //    $paradeiros = array_map(function($v){return $v['onde'];}, $item->onde_esta);
    //    $onde_estava = array_search($movimentacao->quem_entregou, $paradeiros);
    //    $quem_vai_receber = array_search($movimentacao->quem_recebeu, $paradeiros);

    //    if ($movimentacao->tipo == 'Empréstimo') {
    //      if ($movimentacao->qtdes[$key] > $item->onde_esta[0]['qtde'])
    //        return 'erro: quantidade inválida';
    //    }

    //    else if ($movimentacao->tipo == 'Devolução') {
    //      if ($onde_estava === false)
    //        return 'erro: responsável pela entrega não encontrado: '.$movimentacao->quem_entregou;
    //      else if ($movimentacao->qtdes[$key] > $item->onde_esta[$onde_estava]['qtde'])
    //        return 'erro: quantidade inválida';

    //    } else if ($movimentacao->tipo == 'Transferência') {
    //      if ($onde_estava === false)
    //        return 'erro: responsável pela entrega não encontrado: '.$movimentacao->quem_entregou;
    //      else if ($movimentacao->qtdes[$key] > $item->onde_esta[$onde_estava]['qtde'])
    //        return 'erro: quantidade inválida';
    //    } else
    //      return 'erro: tipo inválido';
    //  }
    //}

    //atualização dos itens com quantidade
    //for ($i=0; $i < count($itens_com_qtde); $i++) {
    //  $item = $itens_com_qtde[$i];
    //  $key = $indices_dos_itens_com_qtde[$i];
    //  $paradeiros = array_map(function($v){return $v['onde'];}, $item->onde_esta);
    //  $onde_estava = array_search($movimentacao->quem_entregou, $paradeiros);
    //  $quem_vai_receber = array_search($movimentacao->quem_recebeu, $paradeiros);
    //  if ($movimentacao->tipo == 'Empréstimo'){
    //    $arr = $item->onde_esta;
    //    $arr[0]['qtde'] -= $movimentacao->qtdes[$key];
    //    if ($arr[0]['qtde'] <= 0)
    //      $item->disponivel = false;
    //    if ($quem_vai_receber === false)
    //      $arr[] = ['onde' => $movimentacao->quem_recebeu, 'qtde' => $movimentacao->qtdes[$key]];
    //    else
    //      $arr[$quem_vai_receber]['qtde'] += $movimentacao->qtdes[$key];
    //    $item->onde_esta = $arr;
    //  }
    //  else if ($movimentacao->tipo == 'Devolução') {
    //    $arr = $item->onde_esta;
    //    $arr[0]['qtde'] += $movimentacao->qtdes[$key];
    //    if ($arr[0]['qtde'] > 0)
    //      $item->disponivel = true;
    //    $arr[$onde_estava]['qtde'] -= $movimentacao->qtdes[$key];
    //    if ($arr[$onde_estava]['qtde'] == 0)
    //      unset($arr[$onde_estava]);
    //    $item->onde_esta = $arr;
    //  }
    //  else if ($movimentacao->tipo == 'Transferência') {
    //    $arr = $item->onde_esta;
    //    if ($quem_vai_receber === false)
    //      $arr[] = ['onde' => $movimentacao->quem_recebeu, 'qtde' => $movimentacao->qtdes[$key]];
    //    else
    //      $arr[$quem_vai_receber]['qtde'] += $movimentacao->qtdes[$key];
    //    $arr[$onde_estava]['qtde'] -= $movimentacao->qtdes[$key];
    //    if ($arr[$onde_estava]['qtde'] == 0)
    //      unset($arr[$onde_estava]);
    //    $item->onde_esta = $arr;
    //  }
    //  $item->save();
    //}

    //if (count($ids_dos_itens_removidos) > 0) {
    //  $itens_removidos = Item::whereIn('id', $ids_dos_itens_removidos)->get();
    //  if (count($itens_removidos)) {
    //    foreach ($itens_removidos as $item) {
    //      $histmovitem = $item->historico_de_movimentacoes;
    //      array_pop($histmovitem);
    //      $item->historico_de_movimentacoes = $histmovitem;
    //      //print_r($item->historico_de_movimentacoes);
    //      //die();
    //      if (count($histmovitem) == 0) {
    //        $item->disponivel = true;
    //        if (gettype($item->onde_esta) == 'array')
    //          $item->onde_esta = [['onde' => 'Comunidade', 'qtde' => $item->quantidade]];
    //        else
    //          $item->onde_esta = 'Comunidade';
    //      } else if (!isset($item->quantidade)) {
    //        $movimentacao_anterior = Movimentacao::where('id', end($histmovitem))->first();
    //        $item->disponivel = $movimentacao_anterior->tipo == 'Devolução';
    //        $item->onde_esta = $movimentacao_anterior->tipo == 'Devolução' ? 'Comunidade'
    //          : $movimentacao_anterior->quem_recebeu;
    //      } else {
    //        $paradeiros = array_map(function($v){return $v['onde'];}, $item->onde_esta);
    //        $onde_estava = array_search($movimentacao->quem_entregou, $paradeiros);
    //        $quem_tinha_recebido = array_search($movimentacao->quem_recebeu, $paradeiros);
    //        $key = array_search($item->id, $movimentacao->itens);
    //        if ($movimentacao->tipo == 'Empréstimo') {
    //          $arr = $item->onde_esta;
    //          $arr[0]['qtde'] += $movimentacao->qtdes[$key];
    //          if ($arr[0]['qtde'] > 0)
    //            $item->disponivel = true;
    //          $arr[$quem_tinha_recebido]['qtde'] -= $movimentacao->qtdes[$key];
    //          if ($arr[$quem_tinha_recebido]['qtde'] == 0)
    //            unset($arr[$quem_tinha_recebido]);
    //          $item->onde_esta = $arr;
    //        }
    //        else if ($movimentacao->tipo == 'Devolução') {
    //          $arr = $item->onde_esta;
    //          $arr[0]['qtde'] -= $movimentacao->qtdes[$key];
    //          if ($arr[0]['qtde'] <= 0)
    //            $item->disponivel = false;
    //          if ($onde_estava === false)
    //            $arr[] = ['onde' => $movimentacao->quem_entregou, 'qtde' => $movimentacao->qtdes[$key]];
    //          else
    //            $arr[$onde_estava]['qtde'] += $movimentacao->qtdes[$key];
    //          $item->onde_esta = $arr;
    //        }
    //        else if ($movimentacao->tipo == 'Transferência') {
    //          $arr = $item->onde_esta;
    //          if ($onde_estava === false)
    //            $arr[] = ['onde' => $movimentacao->quem_entregou, 'qtde' => $movimentacao->qtdes[$key]];
    //          else
    //            $arr[$onde_estava]['qtde'] += $movimentacao->qtdes[$key];
    //          $arr[$quem_tinha_recebido]['qtde'] -= $movimentacao->qtdes[$key];
    //          if ($arr[$quem_tinha_recebido]['qtde'] == 0)
    //            unset($arr[$quem_tinha_recebido]);
    //          $item->onde_esta = $arr;
    //        }
    //      }
    //      //$itemRemovUpdate = Item::where('id', $item->id)->update([
    //      //  'disponivel' => $movimentacao_anterior->tipo == 'Devolução',
    //      //  'onde_esta' => $movimentacao_anterior->tipo == 'Devolução' ? 'Comunidade' : $movimentacao_anterior->quem_recebeu
    //      //]);
    //      $item->save();
    //    }
    //  }
    //}

    //$movimentacao->tipo = $req->tipo;
    //$ids_dos_itens_adicionados = array_diff($req->itens, $movimentacao->itens);
    //if (count($ids_dos_itens_adicionados)) {
    //  foreach ($ids_dos_itens_adicionados as $item) {
    //    $itemAdicUpdate = Item::where('id', $item)->push('historico_de_movimentacoes', $id);
        //$itemUpdate = Item::where('id', $item)->update([
        //  'disponivel' => end($item->historico_de_movimentacoes)->disponivel ?? true,
        //  'onde_esta' => end($item->historico_de_movimentacoes)->onde_esta ?? 'Comunidade'
        //]);
    //  }
    //}

    //$movimentacao->itens = $req->itens;
    //atualização dos itens sem quantidade
    //$itensUpdate = Item::whereIn('id', $movimentacao->itens)->where('quantidade', null)->update([
    //  'disponivel' => $movimentacao->tipo == 'Devolução',
    //  'onde_esta' => $movimentacao->tipo == 'Devolução' ? 'Comunidade' : $movimentacao->quem_recebeu
    //]);
    $res = $movimentacao->save();
    $genero = $movimentacao->tipo == 'Empréstimo' ? 'o' : 'a';
    return redirect('/')->with('mensagem', $movimentacao->tipo.' atualizad'.$genero.' com sucesso.');
  }

  public function excluir($id) {
    $movimentacao = Movimentacao::where('id', $id)->first();
    if (!$this->checar_ultima_movimentacao_de_itens_da_movimentacao($movimentacao->itens, $id))
      return redirect('/')->with('mensagem',
        'Não foi possível excluir a movimentação porque ela não é a mais recente em todos os itens.'
      );
    //$desfez = 
    $this->desfazer_ultima_movimentacao_de_itens_da_movimentacao($movimentacao->itens, $id);
    //if (!$desfez)
    //  return redirect('/')->with('mensagem',
    //    'Não foi possível excluir a movimentação porque a movimentação mais recente não é a mesma em todos os itens.'
    //  );
    $res = Movimentacao::where('id', $id)->update(['deletado' => true]);
    $genero = $movimentacao->tipo == 'Empréstimo' ? 'o' : 'a';
    return redirect('/')->with('mensagem', $movimentacao->tipo.' excluíd'.$genero.' com sucesso.');
  }
}

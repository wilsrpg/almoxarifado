<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Categoria;

class ItemController extends Controller
{
  public function index() {
    $filtro = (object)[];
    $filtro->nome = $_GET['nome'] ?? '';
    $filtro->categoria = $_GET['categoria'] ?? '';
    $disp = $_GET['disponivel'] ?? '';
    $filtro->disponivel = $disp == 'sim' ? true : ($disp == 'nao' ? false : '');
    $filtro->onde_esta = $_GET['onde_esta'] ?? '';
    $filtro->emprestado = $_GET['emprestado'] ?? '';
    $filtro->emQuantidade = $_GET['emQuantidade'] ?? '';
    $filtro->quantidade = $_GET['quantidade'] ?? '';
    if ($filtro->quantidade != '')
      $filtro->quantidade = (int) $filtro->quantidade;
    $filtro->anotacoes = $_GET['anotacoes'] ?? '';
    $itens = Item::where('nome', 'like', '%'.$filtro->nome.'%')
      ->where('anotacoes', 'regexp', '/.*'.$filtro->anotacoes.'.*/ms')
      ->get();
    if ($filtro->onde_esta != ''){
      $itens = $itens->filter(function($item) use($filtro){
        if (gettype($item->onde_esta) == 'string')
          return stripos($item->onde_esta, $filtro->onde_esta) !== false;
        else
          return array_search($filtro->onde_esta, array_map(function($v){return $v['onde'];}, $item->onde_esta)) !== false;
      });
    }
    if ($filtro->categoria != ''){
      if ($filtro->categoria == 'sem_categoria')
        $id_da_categoria = '';
      else
        $id_da_categoria = Categoria::where('nome', $filtro->categoria)->first()->id;
      $itens = $itens->where('categoria.id', $id_da_categoria);
    }
    if ($filtro->disponivel !== '')
      $itens = $itens->where('disponivel', $filtro->disponivel);
    if ($filtro->emprestado !== '') {
      if ($filtro->emprestado == 'nao')
        $itens = $itens->where('disponivel', true);
      else if ($filtro->emprestado == 'sim')
        $itens = $itens->filter(function($item) use($filtro){
          if (gettype($item->onde_esta) == 'array')
            return count($item->onde_esta) > 1;
          else
            return !$item->disponivel;
        });
    }
    if ($filtro->emQuantidade == 'nao')
      $itens = $itens->where('quantidade', null);
    else if ($filtro->emQuantidade == 'sim' || $filtro->quantidade > 0)
      $itens = $itens->where('quantidade', '!=', null)->where('quantidade', '>=', $filtro->quantidade);
    foreach ($itens as $item)
      if ($item->categoria['id'])
        $item->categoria = Categoria::where('id', $item->categoria['id'])->first();
    return view('itens.itens', ['itens' => $itens, 'filtro' => $filtro, 'categorias' => Categoria::all()]);
  }

  public function ver($id) {
    $item = Item::where('id', $id)->first();
    if ($item->categoria['id'])
      $item->categoria = Categoria::where('id', $item->categoria['id'])->first();
    return view('itens.item', ['item' => $item]);
  }

  public function pagina_de_criacao() {
    return view('itens.novo_item', ['categorias' => Categoria::all()]);
  }

  public function criar() {
    $item = new Item;
    $item->nome = $_POST['nome'];
    $item->anotacoes = $_POST['anotacoes'] ?? '';
    $categoria = (object)['id' => '', 'nome' => ''];
    if ($_POST['categoria'])
      $categoria = Categoria::where('id', $_POST['categoria'])->first();
    $item->categoria = ['id' => $categoria->id, 'nome' => $categoria->nome];
    $item->disponivel = true;
    if (isset($_POST['emQuantidade'])) {
      $item->quantidade = (int) $_POST['quantidade'];
      $item->onde_esta = [['onde' => 'Comunidade', 'qtde' => $item->quantidade]];
    } else
      $item->onde_esta = 'Comunidade';
    $item->movimentacoes = [];
    $res = $item->save();
    return redirect('/')->with('mensagem', 'Item cadastrado com sucesso.');
  }

  public function pagina_de_edicao($id) {
    return view('itens.editar_item', ['item' => Item::where('id', $id)->first(), 'categorias' => Categoria::all()]);
  }

  public function atualizar($id) {
    $item = Item::where('id', $id)->first();
    $item->nome = $_POST['nome'];
    if (isset($item->quantidade) && !isset($_POST['emQuantidade'])) {
        if (gettype($item->onde_esta) == 'array')
          $item->onde_esta = $item->onde_esta[array_key_last($item->onde_esta)]['onde'];
        unset($item->quantidade);
    } else if (!isset($item->quantidade) && isset($_POST['emQuantidade'])) {
      $item->quantidade = (int) $_POST['quantidade'];
      $arr = [['onde' => 'Comunidade', 'qtde' => 0]];
      if ($item->onde_esta == 'Comunidade')
        $arr[0]['qtde'] = $item->quantidade;
      else
        $arr[] = ['onde' => $item->onde_esta, 'qtde' => $item->quantidade];
      $item->onde_esta = $arr;
    } else if (isset($item->quantidade) && isset($_POST['emQuantidade']) && $item->quantidade != (int) $_POST['quantidade']) {
      $arr = $item->onde_esta;
      $arr[0]['qtde'] += (int) $_POST['quantidade'] - $item->quantidade;
      $item->onde_esta = $arr;
      $item->quantidade = (int) $_POST['quantidade'];
    }
    $item->anotacoes = $_POST['anotacoes'] ?? '';
    $categoria = (object)['id' => '', 'nome' => ''];
    if ($_POST['categoria'])
      $categoria = Categoria::where('id', $_POST['categoria'])->first();
    $item->categoria = ['id' => $categoria->id, 'nome' => $categoria->nome];
    $res = $item->save();
    return redirect('/')->with('mensagem', 'Item atualizado com sucesso.');
  }

  public function excluir($id) {
    //$res = Item::where('id', $id)->first()->delete();
    $res = Item::where('id', $id)->update(['deletado' => true]);
    return redirect('/')->with('mensagem', 'Item excluído com sucesso.');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Categoria;

class ItemController extends Controller
{
  public function index() {
    //$itens = Item::all();
    //Item::all()->unset('0');
    //$categorias = Categoria::all();
    //echo '<pre>';
    //$item = Item::where('nome', 'item6')->first();
    //foreach ($itens as $item){
      //$item->categoria = (object) ['id' => '', 'nome' => ''];
      //Item::where('nome', 'item6')
      //->update(['categoria', (object) ['id' => '', 'nome' => '']]);
      //$item->save();
    //echo '<pre>';
    //  print_r($itens[0]->categoria);
    //  die();
    //  echo '<br><br>';
    //  if ($item->categoria){
    //    $cat = Categoria::where('nome', $item->categoria)->first();
    ////    $cat->itens()->save($item);
    //    $item->categoria = ['id' => $cat->id, 'nome' => $item->categoria];
    //    $item->save();
    //  } else {
        
    //    $item->categoria = ['id' => '', 'nome' => ''];
    //    $item->save();
      //}
    //}
    //die();
    //$item->update(['categoria', array_search($item->categoria, $categorias)]);
    //Item::whereNull('historico_de_movimentacoes')->update(['historico_de_movimentacoes' => []]);
    return view('itens.itens', ['itens' => Item::all()]);
  }

  public function ver($id) {
    //$item = Item::where('id', $id)->first();
        //$cat = Categoria::where('nome', $item->categoria)->first();
        //$cat->itens()->save($item);
    //    $grupo = Grupo::where('nome', 'grupo1')->first();
    //    $grupo->itens()->save($item);
    //echo '<pre>';
    //print_r($item->grupos);
    //die();
    //$item->categoria = Categoria::where('id', $id)->first();
    return view('itens.itens', ['item' => Item::where('id', $id)->first()]);
  }

  public function pagina_de_criacao() {
    return view('itens.novo_item', ['categorias' => Categoria::all()]);
  }

  public function criar() {
    //echo '<pre>';print_r($_POST);
    //die();
    $item = new Item;
    $item->nome = $_POST['nome'];
    $item->anotacoes = $_POST['anotacoes'];
    $categoria = (object)['id' => '', 'nome' => ''];
    if ($_POST['categoria'])
      $categoria = Categoria::where('id', $_POST['categoria'])->first();
    $item->categoria = ['id' => $categoria->id, 'nome' => $categoria->nome];
    $item->disponivel = isset($_POST['disponivel']) && $_POST['disponivel'] == 'on';
    $item->historico_de_movimentacoes = [];
    //echo '<pre>';print_r($item);
    //die();
    $res = $item->save();
    //echo '<pre>';print_r($res);die();
    //return redirect('/')->with('cadastrou_item', $res);
    return redirect('/')->with('mensagem', 'Item cadastrado com sucesso.');
  }

  public function pagina_de_edicao($id) {
    return view('itens.editar_item', ['item' => Item::where('id', $id)->first(), 'categorias' => Categoria::all()]);
  }

  public function atualizar($id) {
    $item = Item::where('id', $id)->first();
    $item->nome = $_POST['nome'];
    $item->anotacoes = $_POST['anotacoes'];
    $categoria = (object)['id' => '', 'nome' => ''];
    if ($_POST['categoria'])
      $categoria = Categoria::where('id', $_POST['categoria'])->first();
    $item->categoria = ['id' => $categoria->id, 'nome' => $categoria->nome];
    $res = $item->save();
    //return redirect('/')->with('atualizou_item', $res);
    return redirect('/')->with('mensagem', 'Item atualizado com sucesso.');
  }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Categoria;

class ItemController extends Controller
{
  public function index(Request $req) {
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
    //echo '<pre>';
    //print_r($req->toArray());die();
    //$a = ['$regex' => '/.*/ms'];
    //var_dump($a);die();
    $filtro = (object)[];
    //$filtro->nome = $req->nome ?? '';
    $filtro->nome = $_GET['nome'] ?? '';
    //$filtro->categoria = $req->categoria ?? '';
    $filtro->categoria = $_GET['categoria'] ?? '';
    //$filtro->disponivel = $req->disponivel == 'sim' ? true : ($req->disponivel == 'nao' ? false : '');
    $disp = $_GET['disponivel'] ?? '';
    $filtro->disponivel = $disp == 'sim' ? true : ($disp == 'nao' ? false : '');
    //$filtro->onde_esta = $req->onde_esta ?? '';
    $filtro->onde_esta = $_GET['onde_esta'] ?? '';
    //$filtro->anotacoes = $req->anotacoes ?? '';
    $filtro->anotacoes = $_GET['anotacoes'] ?? '';
    //$itens = Item::all();
    $itens = Item::where('nome', 'like', '%'.$filtro->nome.'%')
      ->where('onde_esta', 'like', '%'.$filtro->onde_esta.'%')
      //->where('anotacoes', 'REGEX', new Regex('.*'.$filtro->anotacoes.'.*', 'ms'))
      ->where('anotacoes', 'regexp', '/.*'.$filtro->anotacoes.'.*/ms')
      //->where('anotacoes', ['$regex' => '/.*/ms'])
      ->get();
    if ($filtro->categoria != ''){
      if ($filtro->categoria == 'sem_categoria')
        $id_da_categoria = '';
      else
        $id_da_categoria = Categoria::where('nome', $filtro->categoria)->first()->id;
      $itens = $itens->where('categoria.id', $id_da_categoria);
    }
    if ($filtro->disponivel !== '')
      $itens = $itens->where('disponivel', $filtro->disponivel);
    foreach ($itens as $item)
      if ($item->categoria['id'])
        $item->categoria = Categoria::where('id', $item->categoria['id'])->first();
    return view('itens.itens', ['itens' => $itens, 'filtro' => $filtro, 'categorias' => Categoria::all()]);
  }

  public function ver($id) {
    $item = Item::where('id', $id)->first();
        //$cat = Categoria::where('nome', $item->categoria)->first();
        //$cat->itens()->save($item);
    //    $grupo = Grupo::where('nome', 'grupo1')->first();
    //    $grupo->itens()->save($item);
    //echo '<pre>';
    //print_r($item->grupos);
    //die();
    if ($item->categoria['id'])
      $item->categoria = Categoria::where('id', $item->categoria['id'])->first();
    return view('itens.item', ['item' => $item]);
  }

  public function pagina_de_criacao() {
    return view('itens.novo_item', ['categorias' => Categoria::all()]);
  }

  public function criar() {
    //echo '<pre>';print_r($_POST);
    //die();
    $item = new Item;
    $item->nome = $_POST['nome'];
    //$item->anotacoes = str_replace(chr(13), '', $_POST['anotacoes']);
    $item->anotacoes = $_POST['anotacoes'] ?? '';
    $categoria = (object)['id' => '', 'nome' => ''];
    if ($_POST['categoria'])
      $categoria = Categoria::where('id', $_POST['categoria'])->first();
    $item->categoria = ['id' => $categoria->id, 'nome' => $categoria->nome];
    //$item->disponivel = isset($_POST['disponivel']) && $_POST['disponivel'] == 'on';
    $item->disponivel = true;
    $item->onde_esta = 'Comunidade';
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
    //$item->anotacoes = $_POST['anotacoes'];
    //echo ord(str_split($_POST['anotacoes'])[2]);
    //echo chr(98);
    //die();
    //$item->anotacoes = str_replace(chr(13).chr(10), '', $_POST['anotacoes']); //chr(10) = caractere '\n', q eh adicionado com novas linhas na tag <textarea>
    //$item->anotacoes = str_replace(chr(13), '', $item->anotacoes); //chr(13) = caractere '\r', q eh adicionado com novas linhas na tag <textarea>
    $item->anotacoes = $_POST['anotacoes'] ?? '';
    $categoria = (object)['id' => '', 'nome' => ''];
    if ($_POST['categoria'])
      $categoria = Categoria::where('id', $_POST['categoria'])->first();
    $item->categoria = ['id' => $categoria->id, 'nome' => $categoria->nome];
    $res = $item->save();
    //return redirect('/')->with('atualizou_item', $res);
    return redirect('/')->with('mensagem', 'Item atualizado com sucesso.');
  }

  public function excluir($id) {
    $res = Item::where('id', $id)->update(['deletado' => true]);
    return redirect('/')->with('mensagem', 'Item excluído com sucesso.');
  }
}

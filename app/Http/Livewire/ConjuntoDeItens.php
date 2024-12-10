<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Collection;

class ConjuntoDeItens extends Component
{
  public $nome;
  public $name;
  public $tipo;
  public $destino;
  public $texto_botao = 'x';
  public $itens = [];
  public $enviados = [];

  public function mount($itens = []) {
    if ($itens instanceof Collection)
      $this->itens = $itens->toArray();
    //else
      //$this->texto_botao = print_r($itens);
    $this->enviados = array_pad($this->enviados, count($this->itens), false);
  }
  public function enviar($item, $destino, $indice) {
    $this->itens[$indice]['enviado'] = true;
    $this->dispatch('adicionar-item', $item, $destino);
  }
  #[On('adicionar-item')]
  public function adicionar($item, $destino) {
    //$this->texto_botao = json_decode(str_replace('\\r', chr(13), str_replace('\\n', chr(10), $item)), true)['anotacoes'];
    if ($this->nome == $destino) {
      //$this->itens[] = json_decode(str_replace('\r', chr(13), str_replace('\n', chr(10), $item)), true);
      $this->itens[] = json_decode($item, true);
    }
  }
  public function remover($id_do_item) {
    //$novo = [];
    //foreach ($this->itens as $i)
    //  if ($i['id'] != $id_do_item)
    //    $novo[] = $i;
    //$this->itens = $novo;
    $this->itens = array_filter($this->itens, function($i) use($id_do_item) { return $i['id'] != $id_do_item; });
    $this->dispatch('item-removido', $id_do_item);
    //$this->itens = $this->itens->filter(function($i){ return $i['id'] != $id_do_item; });
  }
  #[On('item-removido')]
  public function reabilitar($id_do_item) {
    if ($this->tipo == 'envio') {
      $ids = array_map(function($i){ return $i['id']; }, $this->itens);
      $indice = array_search($id_do_item, $ids);
      unset($this->itens[$indice]['enviado']);
    }
  }
}

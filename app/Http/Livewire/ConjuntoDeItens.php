<?php

namespace App\Http\Livewire;
use Livewire\Component;
use Livewire\Attributes\On;

class ConjuntoDeItens extends Component
{
  public $nome;
  public $name;
  public $itens_do_grupo = [];

  #[On('adicionar-item')]
  public function adicionar($item, $destino) {
    //$this->texto_botao = json_decode(str_replace('\\r', chr(13), str_replace('\\n', chr(10), $item)), true)['anotacoes'];
    if ($this->nome == $destino) {
      //$this->itens_do_grupo[] = json_decode(str_replace('\r', chr(13), str_replace('\n', chr(10), $item)), true);
      $this->itens_do_grupo[] = $item;
    }
  }
  public function remover($id_do_item) {
    //$novo = [];
    //foreach ($this->itens_do_grupo as $i)
    //  if ($i['id'] != $id_do_item)
    //    $novo[] = $i;
    //$this->itens_do_grupo = $novo;
    $this->itens_do_grupo = array_filter($this->itens_do_grupo, function($i) use($id_do_item) { return $i['id'] != $id_do_item; });
    $this->dispatch('item-removido', $id_do_item);
    //$this->itens_do_grupo = $this->itens_do_grupo->filter(function($i){ return $i['id'] != $id_do_item; });
  }
}

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
    if ($this->nome == $destino)
      $this->itens_do_grupo[] = $item;
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_grupo)
    );
  }

  public function remover($id_do_item) {
    $this->itens_do_grupo = array_filter($this->itens_do_grupo,
      function($i) use($id_do_item) { return $i['id'] != $id_do_item; }
    );
    //$this->dispatch('item-removido', $id_do_item);
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_grupo)
    );
  }

  //public function hydrate() {
  //  $this->dispatch('atualizar-itens-enviados',
  //    array_map(function($i){ return $i['id']; }, $this->itens_do_grupo)
  //  );
  //}

  #[On('obter-itens-enviados')]
  public function atualizar_lista() {
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_grupo)
    );
  }
}

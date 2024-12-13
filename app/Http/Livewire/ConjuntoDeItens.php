<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ConjuntoDeItens extends Component
{
  public $nome;
  public $name;
  public $itens_do_conjunto = [];

  #[On('adicionar-item')]
  public function adicionar($item, $destino) {
    if ($this->nome == $destino)
      $this->itens_do_conjunto[] = $item;
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  public function remover($id_do_item) {
    $this->itens_do_conjunto = array_filter($this->itens_do_conjunto,
      function($i) use($id_do_item) { return $i['id'] != $id_do_item; }
    );
    //$this->dispatch('item-removido', $id_do_item);
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  //public function hydrate() {
  //  $this->dispatch('atualizar-itens-enviados',
  //    array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
  //  );
  //}

  #[On('obter-itens-enviados')]
  public function atualizar_lista() {
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }
}

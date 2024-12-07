<?php

namespace App\Http\Livewire;
use Livewire\Component;

class ConjuntoDeItens extends Component
{
  public $itens = [];

  public function adicionar($item) {
    $this->itens[] = $item;
  }
  public function remover($item) {
    $novo = [];
    foreach ($this->itens as $i)
      if ($i->id != $item['id'])
        $novo[] = $i;
    $this->itens = $novo;
  }
}

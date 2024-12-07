<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VerItem extends Component
{
  public $id;
  public $nome;
  public $categoria;
  public $disponivel;
  public $onde_esta;
  public $historico_de_movimentacoes;
  public $anotacoes;
  public $link;

  public function mount($item, $link = false) {
    $this->id = $item->id;
    $this->nome = $item->nome;
    $this->categoria = $item->categoria;
    $this->disponivel = $item->disponivel;
    $this->onde_esta = $item->onde_esta;
    $this->historico_de_movimentacoes = $item->historico_de_movimentacoes;
    $this->anotacoes = $item->anotacoes;
    $this->link = $link;
  }
}

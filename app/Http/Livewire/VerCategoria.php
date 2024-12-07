<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VerCategoria extends Component
{
  public $id;
  public $nome;
  public $anotacoes;
  public $link;

  public function mount($categoria, $link = false) {
    $this->id = $categoria->id;
    $this->nome = $categoria->nome;
    $this->anotacoes = $categoria->anotacoes;
    $this->link = $link;
  }
}

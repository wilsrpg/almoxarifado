<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VerGrupo extends Component
{
  public $id;
  public $nome;
  public $itens;
  public $anotacoes;
  public $link;

  public function mount($grupo, $link = false) {
    $this->id = $grupo->id;
    $this->nome = $grupo->nome;
    $this->itens = $grupo->itens;
    $this->anotacoes = $grupo->anotacoes;
    $this->link = $link;
  }
}

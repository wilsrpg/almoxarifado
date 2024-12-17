<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TipoDaMovimentacao extends Component
{
  public $tipo_da_movimentacao = '';

  function updatedTipoDaMovimentacao() {
    $this->dispatch('mudou-tipo', $this->tipo_da_movimentacao);
  }
}

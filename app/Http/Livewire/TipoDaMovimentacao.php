<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TipoDaMovimentacao extends Component
{
  public $tipo_da_movimentacao = '';
  public $nome_em_branco = 'Selecione';
  public $opcional = false;

  function updatedTipoDaMovimentacao() {
    $this->dispatch('mudou-tipo', $this->tipo_da_movimentacao);
  }
}

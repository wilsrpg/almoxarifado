<?php

namespace App\Http\Livewire;

use Livewire\Component;

class VerMovimentacao extends Component
{
  public $id;
  public $data;
  public $hora;
  public $tipo;
  public $quem_entregou;
  public $quem_recebeu;
  public $itens;
  public $anotacoes;
  public $link;

  public function mount($movimentacao, $link = false) {
    $this->id = $movimentacao->id;
    $this->data = $movimentacao->data;
    $this->hora = $movimentacao->hora;
    $this->tipo = $movimentacao->tipo;
    $this->quem_entregou = $movimentacao->quem_entregou;
    $this->quem_recebeu = $movimentacao->quem_recebeu;
    $this->itens = $movimentacao->itens;
    $this->anotacoes = $movimentacao->anotacoes;
    $this->link = $link;
  }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ListaDeItens extends Component
{
  public $lista_de_itens;
  public $destino;
  public $enviados = [];

  public function mount() {
    $this->enviados = array_pad($this->enviados, count($this->lista_de_itens), false);
  }
  public function indice($id_do_item) {
    $ids = array_map(function($i){ return $i['id']; }, $this->lista_de_itens->toArray());
    return array_search($id_do_item, $ids);
  }
  public function enviar($id_do_item) {
    $indice = $this->indice($id_do_item);
    $this->enviados[$indice] = true;
    $this->dispatch('adicionar-item', $this->lista_de_itens[$indice], $this->destino);
  }
  #[On('item-removido')]
  public function reabilitar($id_do_item) {
    $this->enviados[$this->indice($id_do_item)] = false;
  }
}

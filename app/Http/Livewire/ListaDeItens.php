<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
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
  public function enviar($id_do_item) {
    //$item = $this->lista_de_itens->find($id_do_item);
    //$this->lista_de_itens->find($id_do_item)['enviado'] = true;
    $ids = array_map(function($i){ return $i['id']; }, $this->lista_de_itens->toArray());
    //$ids = array_map(function($i){ return $i['id']; }, $this->lista_de_itens);
    $indice = array_search($id_do_item, $ids);
    //$item['enviado'] = true;
    $this->enviados[$indice] = true;
    $item = $this->lista_de_itens[$indice];
    //$this->lista_de_itens[0]['anotacoes'] = print_r(array_search($id_do_item, $ids), true);
    $this->dispatch('adicionar-item', $item, $this->destino);
  }
  #[On('item-removido')]
  public function reabilitar($id_do_item) {
    $ids = array_map(function($i){ return $i['id']; }, $this->lista_de_itens->toArray());
    $indice = array_search($id_do_item, $ids);
    $this->enviados[$indice] = false;
    //unset($this->lista_de_itens[$indice]['enviado']);
    //$this->lista_de_itens->find($id_do_item)['enviado'] = false;
  }
}

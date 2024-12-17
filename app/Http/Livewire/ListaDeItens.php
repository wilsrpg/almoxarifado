<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ListaDeItens extends Component
{
  public $lista_de_itens;
  public $destino;
  public $enviados = [];
  public $em_movimentacao;
  public $tipo_da_movimentacao;

  public function mount($tipo_da_movimentacao = null, $em_movimentacao = false) {
    if (!$em_movimentacao)
      $this->em_movimentacao = !empty($tipo_da_movimentacao);
    $this->enviados = array_pad($this->enviados, count($this->lista_de_itens), false);
    $this->dispatch('obter-itens-enviados');
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

  public function remover($id_do_item) {
    $this->dispatch('remover-item', $id_do_item, $this->destino);
  }

  #[On('atualizar-itens-enviados')]
  public function atualizar($ids_dos_itens_do_conjunto) {
    for ($i=0; $i < count($this->lista_de_itens); $i++) {
      $this->enviados[$i] = array_search($this->lista_de_itens[$i]['id'], $ids_dos_itens_do_conjunto) !== false;
    }
  }

  #[On('mudou-tipo')]
  function mudou_tipo($novo_tipo) {
    $this->tipo_da_movimentacao = $novo_tipo;
  }
}

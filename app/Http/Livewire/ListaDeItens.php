<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ListaDeItens extends Component
{
  public $lista_de_itens;
  public $destino;
  public $enviados = [];
  public $enviados_parcialmente = [];
  public $qtdes = [];
  public $qtde_input = [];
  public $em_movimentacao;
  public $tipo_da_movimentacao;

  public function mount($tipo_da_movimentacao = null, $em_movimentacao = false) {
    if (!$em_movimentacao)
      $this->em_movimentacao = !empty($tipo_da_movimentacao);
    $this->enviados = array_pad($this->enviados, count($this->lista_de_itens), false);
    $this->enviados_parcialmente = $this->enviados;
    foreach ($this->lista_de_itens as $it)
      array_push($this->qtdes, $it['quantidade'] ?? null);
    $this->qtde_input = $this->qtdes;
    $this->dispatch('obter-itens-enviados');
  }

  public function indice($id_do_item) {
    $ids = array_map(function($i){ return $i['id']; }, $this->lista_de_itens->toArray());
    return array_search($id_do_item, $ids);
  }

  public function enviar($id_do_item, $qtde = null) {
    $indice = $this->indice($id_do_item);
    if ($qtde !== 0)
    $this->dispatch('adicionar-item', $this->lista_de_itens[$indice], $this->destino, $qtde);
  }

  public function remover($id_do_item) {
    $this->dispatch('remover-item', $id_do_item, $this->destino);
  }

  #[On('atualizar-itens-enviados')]
  public function atualizar($ids_dos_itens_do_conjunto, $qtdes_do_conjunto = null) {
    for ($i=0; $i < count($this->lista_de_itens); $i++) {
      $indice = array_search($this->lista_de_itens[$i]['id'], $ids_dos_itens_do_conjunto);
      if ($indice === false) {
        $this->enviados[$i] = false;
        $this->enviados_parcialmente[$i] = false;
        $this->qtdes[$i] = $this->lista_de_itens[$i]['quantidade'];
        $this->qtde_input[$i] = $this->qtdes[$i];
      } else {
        if (!isset($this->lista_de_itens[$i]['quantidade'])) {
          $this->enviados[$i] = true;
        } else {
          $this->qtdes[$i] = $this->lista_de_itens[$i]['quantidade'] - $qtdes_do_conjunto[$indice];
          $this->qtde_input[$i] = $this->qtdes[$i];
          $this->enviados[$i] = $this->qtdes[$i] == 0;
        }
        $this->enviados_parcialmente[$i] = !$this->enviados[$i];
      }
    }
  }

  #[On('mudou-tipo')]
  function mudou_tipo($novo_tipo) {
    $this->tipo_da_movimentacao = $novo_tipo;
  }
}

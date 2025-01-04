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
    //if (isset($this->lista_de_itens[$indice]['quantidade'])) {
    //  $this->qtdes = $this->lista_de_itens[$indice]['quantidade'] - $this->qtdes; //estranho, mas tá ok
    //  if ($this->qtdes == 0)
    //    $this->enviados[$indice] = true;
    //  else
    //    $this->enviados_parcialmente[$indice] = true;
    //} else
    //  $this->enviados[$indice] = true;
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
          //$this->enviados_parcialmente[$i] = false;
        } else {
          $this->qtdes[$i] = $this->lista_de_itens[$i]['quantidade'] - $qtdes_do_conjunto[$indice];
          $this->qtde_input[$i] = $this->qtdes[$i];
          if ($this->qtdes[$i] == 0) {
            $this->enviados[$i] = true;
            //$this->enviados_parcialmente[$i] = false;
          } else {
            //$this->enviados_parcialmente[$i] = true;
            $this->enviados[$i] = false;
          }
        }
        $this->enviados_parcialmente[$i] = !$this->enviados[$i];
      }
      //if (!$this->enviados[$i] && isset($this->lista_de_itens[$i]['quantidade']))
      //  $this->qtdes = $this->lista_de_itens[$i]['quantidade'];
      //if ($this->enviados[$i] && isset($this->lista_de_itens[$i]['quantidade'])) {
      //  $this->qtdes = $this->lista_de_itens[$i]['quantidade'] - $qtdes_do_conjunto[$indice];
      //}
    }
    //$ids_dos_itens = array_map(function($i){ return $i['id']; }, $this->lista_de_itens->toArray());
    //for ($i=0; $i < count($ids_dos_itens_do_conjunto); $i++) {
    //  //$indice = array_search($ids_dos_itens_do_conjunto[$i], $ids_dos_itens);
    //  $indice = $this->indice($ids_dos_itens_do_conjunto[$i]);
    //  $this->enviados[$i] = false;
    //  if ($qtdes_do_conjunto && $qtdes_do_conjunto[$i]) {
    //    $this->qtdes += $qtdes_do_conjunto[$i];
    //    $this->enviados_parcialmente[$i] = $this->qtdes != $this->lista_de_itens[$i]['quantidade'];
    //  }
    //}
  }

  #[On('mudou-tipo')]
  function mudou_tipo($novo_tipo) {
    $this->tipo_da_movimentacao = $novo_tipo;
  }
}

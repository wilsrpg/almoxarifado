<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ConjuntoDeItens extends Component
{
  public $nome;
  public $name;
  public $itens_do_conjunto = [];
  public $qtdes = [];
  public $tipo_da_movimentacao;

  public function mount($qtdes = null) {
    if (!$qtdes)
      foreach ($this->itens_do_conjunto as $it)
        array_push($this->qtdes, $it['quantidade'] ?? null);
  }

  #[On('adicionar-item')]
  public function adicionar($item_enviado, $destino, $qtde = null) {
    if ($this->nome == $destino) {
      $ids_dos_itens_do_conjunto = array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto);
      $indice = array_search($item_enviado['id'], $ids_dos_itens_do_conjunto);
      if ($qtde && $indice !== false) {
        $this->qtdes[$indice] += $qtde;
        if ($this->qtdes[$indice] > $item_enviado['quantidade'])
          $this->qtdes[$indice] = $item_enviado['quantidade'];
      }
      if ($indice === false) {
        $this->itens_do_conjunto[] = $item_enviado;
        $this->qtdes[] = $qtde;
      }
    }
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto),
      $this->qtdes
    );
  }

  #[On('adicionar-itens')]
  public function adicionar_itens($itens, $destino, $qtdes = null) {
    if ($this->nome == $destino)
      for ($i=0; $i < count($itens); $i++) {
        $item = $itens[$i];
        $ids_dos_itens = array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto);
        $indice = array_search($item['id'], $ids_dos_itens);
        if ($qtdes[$i] && $indice !== false) {
          $this->qtdes[$indice] += $qtdes[$i];
          if ($this->qtdes[$indice] > $item['quantidade'])
            $this->qtdes[$indice] = $item['quantidade'];
        }
        if($indice === false) {
          $this->itens_do_conjunto[] = $item;
          $this->qtdes[] = $qtdes[$i];
        }
      }
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto),
      $this->qtdes
    );
  }

  #[On('remover-item')]
  public function remover($id_do_item, $destino, $qtde = null) {
    if ($this->nome == $destino) {
      $ids_dos_itens = array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto);
      $indice = array_search($id_do_item, $ids_dos_itens);
      if($indice !== false) {
        array_splice($this->itens_do_conjunto, $indice, 1);
        array_splice($this->qtdes, $indice, 1);
      }
      $this->dispatch('atualizar-itens-enviados',
        array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto),
        $this->qtdes
      );
    }
  }

  #[On('remover-itens')]
  public function remover_itens($ids_dos_itens, $destino, $qtdes = null) {
    if ($this->nome == $destino){
      foreach ($ids_dos_itens as $key => $id_do_item) {
        $ids_dos_itens_do_conjunto = array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto);
        $indice = array_search($id_do_item, $ids_dos_itens_do_conjunto);
        if($indice !== false) {
          if ($this->qtdes[$indice]) {
            $this->qtdes[$indice] -= $qtdes[$key];
            if ($this->qtdes[$indice] < 0)
              $this->qtdes[$indice] = 0;
          }
          if (!$this->qtdes[$indice] || $this->qtdes[$indice] <= 0) {
            array_splice($this->itens_do_conjunto, $indice, 1);
            array_splice($this->qtdes, $indice, 1);
          }
        }
      }
      $this->dispatch('atualizar-itens-enviados',
        array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto),
        $this->qtdes
      );
    }
  }

  public function remover_tudo() {
    $this->itens_do_conjunto = [];
    $this->qtdes = [];
    $this->dispatch('atualizar-itens-enviados', [], []);
  }

  #[On('obter-itens-enviados')]
  public function atualizar_lista() {
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto),
      $this->qtdes
    );
  }

  #[On('mudou-tipo')]
  function mudou_tipo($novo_tipo) {
    $this->tipo_da_movimentacao = $novo_tipo;
  }
}

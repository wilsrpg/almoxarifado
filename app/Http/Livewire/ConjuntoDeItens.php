<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ConjuntoDeItens extends Component
{
  public $nome;
  public $name;
  public $itens_do_conjunto = [];
  public $tipo_da_movimentacao;

  #[On('adicionar-item')]
  public function adicionar($item, $destino) {
    if ($this->nome == $destino && array_search($item['id'], array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)) === false)
      $this->itens_do_conjunto[] = $item;
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  #[On('adicionar-itens')]
  public function adicionar_itens($itens, $destino) {
    if ($this->nome == $destino)
      foreach ($itens as $it) {
        if(array_search($it['id'], array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)) === false)
          $this->itens_do_conjunto[] = $it;
      }
      //$this->itens_do_conjunto = array_merge($this->itens_do_conjunto, $itens);
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  #[On('remover-item')]
  public function remover($id_do_item) {
    $this->itens_do_conjunto = array_filter($this->itens_do_conjunto,
      function($i) use($id_do_item) { return $i['id'] != $id_do_item; }
    );
    //$this->dispatch('item-removido', $id_do_item);
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  #[On('remover-itens')]
  public function remover_itens($ids_dos_itens) {
    //$this->itens_do_conjunto = array_diff($this->itens_do_conjunto,
    $this->itens_do_conjunto = array_filter($this->itens_do_conjunto,
      function($i) use($ids_dos_itens) { return array_search($i['id'], $ids_dos_itens) === false; }
    );
    //$this->dispatch('item-removido', $ids_dos_itens);
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  public function remover_tudo() {
    $this->itens_do_conjunto = [];
    $this->dispatch('atualizar-itens-enviados', []);
  }

  //public function hydrate() {
  //  $this->dispatch('atualizar-itens-enviados',
  //    array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
  //  );
  //}

  #[On('obter-itens-enviados')]
  public function atualizar_lista() {
    $this->dispatch('atualizar-itens-enviados',
      array_map(function($i){ return $i['id']; }, $this->itens_do_conjunto)
    );
  }

  #[On('mudou-tipo')]
  function mudou_tipo($novo_tipo) {
    $this->tipo_da_movimentacao = $novo_tipo;
  }
}

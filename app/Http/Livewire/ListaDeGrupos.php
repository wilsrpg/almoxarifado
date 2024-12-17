<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ListaDeGrupos extends Component
{
  public $lista_de_grupos;
  public $lista_de_itens;
  public $destino;
  public $enviados = [];
  public $enviados_parcialmente = [];
  public $tipo_da_movimentacao;
  public $tudo_disponivel = [];
  public $tudo_indisponivel = [];

  public function mount() {
    $this->enviados = array_pad($this->enviados, count($this->lista_de_itens), false);
    $this->enviados_parcialmente = $this->enviados;
    $this->dispatch('obter-itens-enviados');
    for ($i=0; $i < count($this->lista_de_grupos); $i++) {
      $todos_disp = true;
      for ($j=0; $j < count($this->lista_de_grupos[$i]->itens) && $todos_disp; $j++) {
        $todos_disp = $this->lista_de_itens->find($this->lista_de_grupos[$i]->itens[$j])->disponivel;
      }
      $todos_indisp = true;
      for ($j=0; $j < count($this->lista_de_grupos[$i]->itens) && $todos_indisp; $j++) {
        $todos_indisp = !$this->lista_de_itens->find($this->lista_de_grupos[$i]->itens[$j])->disponivel;
      }
      $this->tudo_disponivel[$i] = $todos_disp;
      $this->tudo_indisponivel[$i] = $todos_indisp;
    }
  }

  public function boot() {
    foreach ($this->lista_de_grupos as $grupo) {
      $disp = true;
      for ($j=0; $j < count($grupo->itens) && $disp; $j++) {
        $disp = $this->lista_de_itens->find($grupo->itens[$j])->disponivel;
      }
      $grupo->disponivel = $disp;
    }
  }

  public function indice($id_do_grupo) {
    $ids = array_map(function($i){ return $i['id']; }, $this->lista_de_grupos->toArray());
    return array_search($id_do_grupo, $ids);
  }

  public function enviar($id_do_grupo) {
    $indice = $this->indice($id_do_grupo);
    $this->enviados[$indice] = true;
    $conteudo = [];
    foreach ($this->lista_de_grupos[$indice]->itens as $it) {
      //$conteudo[] = $this->lista_de_itens[$this->indice($it, $this->lista_de_itens->toArray())];
      $conteudo[] = $this->lista_de_itens->find($it);
    }
    $this->dispatch('adicionar-itens', $conteudo, $this->destino);
  }

  public function remover($id_do_grupo) {
    $this->dispatch('remover-itens', $this->lista_de_grupos->find($id_do_grupo)->itens, $this->destino);
  }

  #[On('atualizar-itens-enviados')]
  public function atualizar($ids_dos_itens_do_conjunto) {
    for ($i=0; $i < count($this->lista_de_grupos); $i++) {
      $falta_algum = false;
      for ($j=0; $j < count($this->lista_de_grupos[$i]->itens) && !$falta_algum; $j++) {
        $falta_algum = array_search($this->lista_de_grupos[$i]->itens[$j], $ids_dos_itens_do_conjunto) === false;
      }
      $tem_algum = false;
      for ($j=0; $j < count($this->lista_de_grupos[$i]->itens) && !$tem_algum; $j++) {
        $tem_algum = array_search($this->lista_de_grupos[$i]->itens[$j], $ids_dos_itens_do_conjunto) !== false;
      }
      //foreach ($this->lista_de_grupos[$i]->itens as $it) {
      //  if (!$tem_algum)
      //    $tem_algum = array_search($it, $ids_dos_itens_do_conjunto) !== false;
      //  if (!$falta_algum)
      //    $falta_algum = array_search($it, $ids_dos_itens_do_conjunto) === false;
      //}
      $this->enviados[$i] = !$falta_algum;
      $this->enviados_parcialmente[$i] = $tem_algum;
    }
  }

  #[On('mudou-tipo')]
  function mudou_tipo($novo_tipo) {
    $this->tipo_da_movimentacao = $novo_tipo;
  }
}

<?php
namespace App\Http\Livewire;
use Livewire\Component;

class Pag extends Component {
  public $count=0;
  public function increment() {
    $this->count++;
  }
  public function decrement() {
    $this->count--;
  }

  public $texto;
  public function limpar() {
    $this->texto = '';
  }
  public $opcoes = [];

  //funções de ciclo de vida do componente:
  public $msgs_comp = [];
  function mount() { $this->msgs_comp[] = 'montou'; }
  function hydrate() { $this->msgs_comp[] = 'hydrate?'; }
  function updating() { $this->msgs_comp[] = 'atualizando'; }
  function updated() { $this->msgs_comp[] = 'atualizou'; }
  function updatingTexto() { $this->msgs_comp[] = 'atualizando $texto'; }
  function updatedTexto() { $this->msgs_comp[] = 'atualizou $texto'; }
  function updatingOpcoes() { $this->msgs_comp[] = 'atualizando $opcoes'; }
  function updatedOpcoes() { $this->msgs_comp[] = 'atualizou $opcoes'; }

  public function render(){
    return view('livewire.pag');
  }
}
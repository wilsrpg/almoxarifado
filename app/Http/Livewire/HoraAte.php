<?php
namespace App\Http\Livewire;

use Livewire\Component;

class HoraAte extends Component {
  public $ativo;
  public $horaAte;

  public function mount($horaAte) {
    if ($horaAte)
      $this->ativo = true;
  }

  public function render(){
    return <<<'HTML'
      <div style="display: inline">
        @if ($ativo)
          ~ <input type="time" name="horaAte" value="{{$horaAte}}">
        @endif
        <input type="button" wire:click="$toggle('ativo')" value="{{$ativo ? 'x' : '~'}}">
      </div>
      HTML;
  }
}
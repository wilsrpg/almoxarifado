<?php
namespace App\Http\Livewire;

use Livewire\Component;

class DataAte extends Component {
  public $ativo;
  public $dataAte;

  public function mount($dataAte) {
    if ($dataAte)
      $this->ativo = true;
  }

  public function render(){
    return <<<'HTML'
      <div style="display: inline">
        @if ($ativo)
          ~ <input type="date" name="dataAte" value="{{$dataAte}}">
        @endif
        <input type="button" wire:click="$toggle('ativo')" value="{{$ativo ? 'x' : '~'}}">
      </div>
      HTML;
  }
}
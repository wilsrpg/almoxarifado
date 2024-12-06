<div>
  Texto.live: <input wire:model.live="texto" wire:keydown.escape="limpar()" /><br>
  Texto.blur: <input wire:model.blur="texto" /><br>
  Texto: {{$texto}}<br><br>

  <input type="checkbox" id="change" wire:model.change="opcoes" value="change" />
  <label for="change">opcoes.change</label><br>
  <input type="checkbox" id="live" wire:model.live="opcoes" value="live" />
  <label for="live">opcoes.live</label><br>
  <input type="checkbox" id="debounce0" wire:model.live.debounce.0ms="opcoes" value="live.debounce.0ms" />
  <label for="debounce0">opcoes.live.debounce.0ms</label><br>
  <input type="checkbox" id="debounce1000" wire:model.live.debounce.1000ms="opcoes" value="live.debounce.1000ms" />
  <label for="debounce1000">opcoes.live.debounce.1000ms</label><br>
  <br>

  Opções marcadas:<br>
  <ul style="margin: 0">
    @foreach ($opcoes as $op)
      <li>{{$op}}</li>
    @endforeach
  </ul>

  <h1>{{ $count }}</h1>
  <button wire:click="increment">+</button>
  <button wire:click="decrement">-</button>

  <br><br>
  Ciclo de vida do componente e de suas variáveis "$texto" e "$opcoes":<br>
  @foreach ($msgs_comp as $msg_comp)
    <span>{{$msg_comp}}, </span>
  @endforeach
</div>
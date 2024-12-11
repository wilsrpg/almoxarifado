<ul>
  @foreach ($lista_de_itens as $key => $item)
    <li>
      <button type="button" onclick="this.disabled = true" wire:click="enviar('{{$item['id']}}')"
        {{$enviados[$key] ? 'disabled' : ''}}
      ><</button> {{$item['nome']}}
    </li>
  @endforeach
</ul>

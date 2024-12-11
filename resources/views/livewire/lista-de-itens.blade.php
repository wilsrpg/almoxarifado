<ul class="lista-de-itens">
  @foreach ($lista_de_itens as $key => $item)
    <li>
      <button type="button" onclick="this.disabled = true" {{$enviados[$key] ? 'disabled' : ''}}
        wire:click="enviar('{{$item['id']}}')"
      ><</button>
      {{$item['nome']}}
    </li>
  @endforeach
</ul>

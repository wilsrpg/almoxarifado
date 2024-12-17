<div>
  <p>Itens adicionados:</p>
  <ul class="lista-de-itens">
    @foreach ($itens_do_conjunto as $item)
      <input type="hidden" name="{{$name}}" value="{{$item['id']}}">
      <li>
        <button type="button" onclick="this.disabled = true" wire:click="remover('{{$item['id']}}')">x</button>
        <span
          {{$tipo_da_movimentacao != '' && ($tipo_da_movimentacao == 'Empréstimo' && !$item['disponivel'] 
            || $tipo_da_movimentacao != 'Empréstimo' && $item['disponivel']) ? 'class=cinza' : ''}}
        >
          {{$item['nome']}}
        </span>
      </li>
    @endforeach
  </ul>
</div>

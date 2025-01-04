<div>
  <p>Itens adicionados:</p>
  <ul class="lista-de-itens">
    @if ($itens_do_conjunto)
      <button id="remover-itens" type="button" onclick="this.disabled = true" wire:click="remover_tudo()">
        x
      </button>
      Remover tudo
    @endif
    @foreach ($itens_do_conjunto as $key => $item)
      <input type="hidden" name="{{$name}}" value="{{$item['id']}}">
      <input type="hidden" name="qtdes[]" value="{{$qtdes[$key]}}">
      <li>
        <button type="button" onclick="this.disabled = true" wire:click="remover('{{$item['id']}}', '{{$nome}}')">
          x
        </button>
        <span
          {{
            $tipo_da_movimentacao != '' && (
              $tipo_da_movimentacao == 'Empréstimo' && (
                isset($item['quantidade'])
                ? $qtdes[$key] > $item['onde_esta'][0]['qtde']
                : !$item['disponivel']
              )
              || $tipo_da_movimentacao != 'Empréstimo' && (
                isset($item['quantidade'])
                ? $qtdes[$key] > $item['quantidade'] - $item['onde_esta'][0]['qtde']
                : $item['disponivel']
              )
            )
            ? 'class=cinza'
            : ''
          }}
        >
          {{$item['nome']}}
          @if ($qtdes[$key])
            <i>({{$qtdes[$key]}})</i>
          @endif
        </span>
      </li>
    @endforeach
  </ul>
</div>

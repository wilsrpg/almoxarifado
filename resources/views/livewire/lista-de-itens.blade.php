<div>
  <p>Todos os itens:</p>
  <ul class="lista-de-itens">
    @foreach ($lista_de_itens as $key => $item)
      <li>
        <button type="button" onclick="this.disabled = true"
          {{$em_movimentacao && $tipo_da_movimentacao == '' || !$enviados[$key] ? 'disabled' : ''}}
          wire:click="remover('{{$item['id']}}')"
        >
          >
        </button>
        <button type="button" onclick="this.disabled = true"
          {{$em_movimentacao && $tipo_da_movimentacao == '' || $enviados[$key] ? 'disabled' : ''}}
          wire:click="enviar('{{$item['id']}}')"
        >
          <
        </button>
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

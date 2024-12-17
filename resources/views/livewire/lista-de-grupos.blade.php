<div>
  <p>Grupos de itens:</p>
  <ul class="lista-de-itens">
    @foreach ($lista_de_grupos as $key => $grupo)
      <li>
        <button type="button" onclick="this.disabled = true"
          {{$tipo_da_movimentacao == '' || !$enviados_parcialmente[$key] ? 'disabled' : ''}}
          wire:click="remover('{{$grupo['id']}}')"
        >
          >
        </button>
        <button type="button" onclick="this.disabled = true"
          {{$tipo_da_movimentacao == '' || $enviados[$key] ? 'disabled' : ''}}
          wire:click="enviar('{{$grupo['id']}}')"
        >
          <
        </button>
        <span
          @if ($tipo_da_movimentacao != '')
            {{$tipo_da_movimentacao == 'Empréstimo' && !$tudo_disponivel[$key] 
              || $tipo_da_movimentacao != 'Empréstimo' && !$tudo_indisponivel[$key] ? 'class=cinza' : ''}}
          @endif
        >
          {{$grupo['nome']}}
        </span>
      </li>
    @endforeach
  </ul>
</div>

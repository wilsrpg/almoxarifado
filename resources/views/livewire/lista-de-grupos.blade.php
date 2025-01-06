<div>
  <p>Grupos de itens:</p>
  <ul class="lista-de-itens">
    @foreach ($lista_de_grupos as $key => $grupo)
      <li>
        <button type="button" onclick="this.disabled = true"
          {{$em_movimentacao && $tipo_da_movimentacao == '' || !$enviados_parcialmente[$key] ? 'disabled' : ''}}
          wire:click="remover('{{$grupo['id']}}')"
        >
          >
        </button>
        <button type="button" onclick="this.disabled = true"
          {{$em_movimentacao && $tipo_da_movimentacao == '' || $enviados[$key] ? 'disabled' : ''}}
          wire:click="enviar('{{$grupo['id']}}')"
        >
          <
        </button>
        <a href="/grupo/{{$grupo['id']}}"
          @if ($tipo_da_movimentacao != '')
            {{$tipo_da_movimentacao == 'Empréstimo' && !$tudo_disponivel[$key] 
              || $tipo_da_movimentacao != 'Empréstimo' && !$tudo_indisponivel[$key] ? 'class=cinza' : ''}}
          @endif
        >{{$grupo['nome']}}</a>
        <label style="cursor: help;"
          title="<?php
            $texto = 'Itens:';
            foreach ($grupo['itens'] as $key => $id_do_item) {
              $item = $lista_de_itens->find($id_do_item);
              $texto .= chr(10).$item->nome;
              if (isset($item->quantidade))
                $texto .= ': '.$grupo['qtdes'][$key];
            }
            $texto .= chr(10).chr(10).'Anotações:'.chr(10).$grupo['anotacoes'];
            echo str_replace('"', '&quot;', $texto);
          ?>"
        >ⓘ</label>
      </li>
    @endforeach
  </ul>
</div>

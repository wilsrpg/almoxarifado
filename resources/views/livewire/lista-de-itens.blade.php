<div>
  <p>Todos os itens:</p>
  <ul class="lista-de-itens">
    @foreach ($lista_de_itens as $key => $item)
      <li>
        <button type="button" onclick="this.disabled = true"
          {{$em_movimentacao && $tipo_da_movimentacao == '' || !$enviados[$key] && !$enviados_parcialmente[$key]
            ? 'disabled' : ''}} wire:click="remover('{{$item['id']}}')"
        >
          >
        </button>
        <button type="button" onclick="this.disabled = true"
          {{$em_movimentacao && $tipo_da_movimentacao == '' || $enviados[$key] ? 'disabled' : ''}}
          wire:click="enviar('{{$item['id']}}', {{$qtde_input[$key]}})"
        >
          <
        </button>
        <a href="/item/{{$item['id']}}"
          {{
            $tipo_da_movimentacao != '' && (
              $tipo_da_movimentacao == 'Empréstimo' && (
                isset($item['quantidade'])
                ? $item['quantidade'] - $qtdes[$key] + $qtde_input[$key] > $item['onde_esta'][0]['qtde']
                : !$item['disponivel']
              )
              || $tipo_da_movimentacao != 'Empréstimo' && (
                isset($item['quantidade'])
                ? $item['quantidade'] - $qtdes[$key] + $qtde_input[$key] > $item['quantidade'] - $item['onde_esta'][0]['qtde']
                : $item['disponivel']
              )
            )
            ? 'class=cinza'
            : ''
          }}
        >{{$item['nome']}}</a>
        @if (isset($qtdes[$key]))
          ({{$qtde_input[$key]}}/{{$item['quantidade']}}){{$qtdes[$key]}}
          <input type="number" min="1" max="{{$qtdes[$key]}}" size="5" wire:model.live="qtde_input.{{$key}}"
            {{$enviados[$key] ? 'disabled' : ''}}
          >
          <label style="cursor: help;"
            title="<?php
              $texto = 'Onde está:';
              foreach ($item->onde_esta as $loc)
                $texto .= chr(10).$loc['onde'].': '.$loc['qtde'];
              $texto .= chr(10).chr(10).'Anotações:'.chr(10).$item->anotacoes;
              echo str_replace('"', '&quot;', $texto);
            ?>"
          >ⓘ</label>
        @else
          <label style="cursor: help;"
            title="<?php
              $texto = 'Onde está:'.chr(10).$item->onde_esta.chr(10).chr(10).'Anotações:'.chr(10).$item->anotacoes;
              echo str_replace('"', '&quot;', $texto);
            ?>"
          >ⓘ</label>
        @endif
    </li>
    @endforeach
  </ul>
</div>

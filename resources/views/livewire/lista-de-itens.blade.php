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
        <span
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
        >
          {{$item['nome']}}
        </span>
        @if (isset($qtdes[$key]))
          ({{$qtde_input[$key]}}/{{$item['quantidade']}}){{$qtdes[$key]}}
          <input type="number" min="1" max="{{$qtdes[$key]}}" size="5" wire:model.live="qtde_input.{{$key}}"
            {{$enviados[$key] ? 'disabled' : ''}}
          >
          <label style="cursor: help;"
            title="<?php
              foreach ($item->onde_esta as $loc)
                echo $loc['onde'].': '.$loc['qtde'].chr(10);
            ?>"
          >ⓘ</label>
        @endif
    </li>
    @endforeach
  </ul>
</div>

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
        <a href="/item/{{$item['id']}}"
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
        >{{$item['nome']}}</a>
        @if ($qtdes[$key])
          <i>({{$qtdes[$key]}})</i>
          <label style="cursor: help;"
            title="<?php
              $texto = 'Onde está:';
              foreach ($item['onde_esta'] as $loc)
                $texto .= chr(10).$loc['onde'].': '.$loc['qtde'];
              $texto .= chr(10).chr(10).'Anotações:'.chr(10).$item['anotacoes'];
              echo str_replace('"', '&quot;', $texto);
            ?>"
          >ⓘ</label>
        @else
          <label style="cursor: help;"
            title="<?php
              $texto = 'Onde está:'.chr(10).$item['onde_esta'].chr(10).chr(10).'Anotações:'.chr(10).$item['anotacoes'];
              echo str_replace('"', '&quot;', $texto);
            ?>"
          >ⓘ</label>
        @endif
      </li>
    @endforeach
  </ul>
</div>

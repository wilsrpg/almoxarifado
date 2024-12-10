<ul>
  {{--<input type="hidden" name="{{$name}}" value="{{$itens->implode('id',',')}}">--}}
  <input type="hidden" name="{{$name}}"
    value="{{implode(',', array_map(function($i){ return $i['id']; }, $itens))}}"
  >
  @foreach ($itens as $indice => $item)
    <li>
      <button type="button" onclick="this.disabled = true" title="{{print_r($item['anotacoes'],true)}}"
        {{isset($item['enviado']) ? 'disabled' : ''}}
        @if ($tipo == 'envio')
          wire:click="enviar('{{json_encode($item)}}', '{{$destino}}', {{$indice}})"
        @else
          wire:click="remover('{{$item['id']}}')"
        @endif
      >{{$texto_botao}}</button> {{print_r(str_replace(chr(13), '\\u000d', str_replace(chr(10), '\\u000a', json_encode($item['anotacoes']))),true)}}
    </li>
  @endforeach
</ul>

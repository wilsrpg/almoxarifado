<ul>
  {{--<input type="hidden" name="{{$name}}" value="{{$itens_do_grupo->implode('id',',')}}">--}}
  <input type="hidden" name="{{$name}}"
    value="{{implode(',', array_map(function($i){ return $i['id']; }, $itens_do_grupo))}}"
  >
  @foreach ($itens_do_grupo as $item)
    <li>
      <button type="button" onclick="this.disabled = true" wire:click="remover('{{$item['id']}}')"
      >x</button> {{$item['nome']}}
    </li>
  @endforeach
</ul>

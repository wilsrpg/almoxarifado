<ul>
  @foreach ($itens as $item)
    <li><button type="button" wire:click="remover({{$item}})">x</button> {{$item['nome']}}</li>
  @endforeach
</ul>

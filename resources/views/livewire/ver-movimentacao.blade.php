<div>
  <p>ID:
    @if ($link)
      <a href="/movimentacao/{{$id}}">{{$id}}</a>
    @else
      {{$id}}
    @endif
  </p>
  <p>Data: {{date_format(date_create($data), 'd/m/Y')}}</p>
  <p>Hora: {{$hora}}</p>
  <p>Tipo: {{$tipo}}</p>
  <p>Responsável por entregar: {{$quem_entregou}}</p>
  <p>Responsável por receber: {{$quem_recebeu}}</p>
  <p>Itens:</p>
  <ul>
    @if (count($itens) > 0)
      @foreach ($itens as $item)
        <li><a href="/item/{{$item->id}}">{{$item->nome}}</a></li>
      @endforeach
    @else
      <li>Nenhum</li>{{--impossível--}}
    @endif
  </ul>
  <p>Anotações: {{$anotacoes}}</p>
</div>

@extends('layouts.layout')
@section('titulo', 'Item: '.$item->nome.' - Almoxarifado')
@section('conteudo')

<p>Nome: {{$item->nome}} <?= isset($item->deletado) ? '<i class=vermelho>(deletado)</i>' : '' ?></p>
<p>Categoria: <a href="/categoria/{{$item->categoria['id']}}">{{$item->categoria['nome']}}</a></p>
<p>Disponível: {{$item->disponivel ? 'Sim' : 'Não'}}</p>
@if ($item->quantidade)
  <p>Quantidade total: {{$item->quantidade}}</p>
@endif
<p>Onde está:
@if (gettype($item->onde_esta) == 'string')
  {{$item->onde_esta}}</p>
@else
  </p><ul>
    @foreach ($item->onde_esta as $onde)
      <li>{{$onde['onde']}}: {{$onde['qtde']}}</li>
    @endforeach
  </ul>
@endif
<p>Anotações: <br><pre>{{$item->anotacoes}}</pre></p>
<p>Total de movimentações: {{count($item->movimentacoes)}}<br>
<a href="/movimentacoes?itens[]={{$item->id}}">Ver tudo</a>
</p>

<a href="/item/{{$item->id}}/editar">Editar</a>
@if (empty($item->deletado))
<form action="/item/{{$item->id}}/excluir" method="POST">
  @csrf
  @method('DELETE')
  <button>Excluir</button>
</form>
@endif

@endsection
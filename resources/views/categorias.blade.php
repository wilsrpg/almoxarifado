<a href="/">Ir para página inicial</a>

@if (isset($categoria))
  <p>Nome: {{$categoria->nome}}</p>
  <p>Anotações: <br><pre>{{$categoria->anotacoes}}</pre></p>
  <a href="/categorias/{{$categoria->nome}}/editar">Editar</a>

@elseif (isset($categorias) && count($categorias) > 0)
{{--@elseif (!empty($categorias))--}}
  <p>{{count($categorias) . (count($categorias) > 1 ? ' categorias:' : ' categoria:')}}</p>
  @foreach ($categorias as $categoria)
    <p>Nome: <a href="/categorias/{{$categoria->nome}}">{{$categoria->nome}}</a></p>
    <p>Anotações: {{$categoria->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma categoria.</p>
@endif

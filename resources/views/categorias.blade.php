<a href="/">Voltar</a>

@if (isset($categoria))
  <p>Nome: {{$categoria->nome}}</p>
  <p>Anotações: {{$categoria->anotacoes}}</p>
@elseif (isset($categorias) && count($categorias) > 0)
{{--@elseif (!empty($categorias))--}}
  <p>{{count($categorias) . (count($categorias) > 1 ? ' categorias:' : ' categoria:')}}</p>
  @foreach ($categorias as $categoria)
    <p>Nome: {{$categoria->nome}}</p>
    <p>Anotações: {{$categoria->anotacoes}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma categoria.</p>
@endif

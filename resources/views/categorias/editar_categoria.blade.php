<a href="/">Ir para página inicial</a>

<form action="/categoria/{{$categoria->id}}/atualizar" method="post">
  <p>Nome da categoria: <input name="nome" value="{{$categoria->nome}}" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$categoria->anotacoes}}</textarea>
  </p>
  @csrf
  <input type="submit" value="Salvar">
</form>
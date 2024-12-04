<a href="/">Voltar</a>

<form action="atualizar_categoria" method="post">
  <p>Nome da categoria: <input type="text" name="nome" value="{{$categoria->nome}}" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes">{{$categoria->anotacoes}}</textarea>
  </p>
  @csrf
  <input type="submit" value="Salvar">
</form>
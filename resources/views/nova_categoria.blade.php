<a href="/">Ir para página inicial</a>

<form action="cadastrar_categoria" method="post">
  <p>Nome da categoria: <input type="text" name="nome" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  @csrf
  <input type="submit" value="Cadastrar">
</form>
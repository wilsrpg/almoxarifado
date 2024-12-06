<a href="/">Ir para página inicial</a>

<form action="/categorias/criar" method="post">
  <p>Nome da categoria: <input name="nome" required></p>
  <p>
    <span style="vertical-align: top;">Anotações: </span>
    <textarea name="anotacoes"></textarea>
  </p>
  @csrf
  <input type="submit" value="Cadastrar">
</form>
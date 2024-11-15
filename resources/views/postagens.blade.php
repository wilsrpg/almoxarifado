<a href="/">Voltar</a>

@if (isset($postagem))
  <p>Título: {{$postagem->titulo_do_blog}}</p>
  <p>Descrição: {{$postagem->descricao_do_blog}}</p>
  <p>Imagem: {{$postagem->nome_da_imagem_do_blog}}</p>
  <p>Publicado: {{$postagem->publicado}}</p>
@elseif (isset($postagens) && count($postagens) > 0)
  @foreach ($postagens as $postagem)
    <p>Título: {{$postagem->titulo_do_blog}}</p>
    <p>Descrição: {{$postagem->descricao_do_blog}}</p>
    <p>Imagem: {{$postagem->nome_da_imagem_do_blog}}</p>
    <p>Publicado: {{$postagem->publicado}}</p>
    <br>
  @endforeach
@else
  <p>Nenhuma postagem.</p>
@endif

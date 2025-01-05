<!DOCTYPE html>
<html lang="pt_BR">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--<link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
      integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
      crossorigin="anonymous">--}}
    <link rel="stylesheet" href="/css/estilo.css">

    <title>@yield('titulo')</title>
  </head>

  <body>
    <header>
      <a href="/">Página inicial</a>
      <a href="/itens">Itens</a>
      <a href="/grupos">Grupos de itens</a>
      <a href="/categorias">Categorias</a>
      <a href="/movimentacoes">Movimentações</a>
    </header>

    <div class="conteudo">
      @if(session('mensagem'))
        <p>{{session('mensagem')}}</p>
      @endif

      @yield('conteudo')
    </div>

    <footer>
      Rodapé &copy; 2024
    </footer>
  </body>
</html>
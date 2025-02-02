Aplicação web de gerenciamento de almoxarifado, desenvolvido com o intuito de aprender e praticar o framework Laravel e a biblioteca front-end Livewire.

Para testar localmente, após clonar o repositório é necessário renomear o arquivo `.env.example` para `.env` e adicionar uma string de conexão com um banco de dados MongoDB à variável de ambiente `DB_URI`. Feito isso, execute os comandos:

```
composer install
```
```
php artisan key:generate
```
```
php artisan serve
```
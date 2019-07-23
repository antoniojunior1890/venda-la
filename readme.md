# Teste vaga Venda.la - Criação de produtos KIT via API

### Back-end
API Laravel - JWT autenticação de usuario

- Implementado login e logout de usuarios
- Rotas para cadastrar, vizualizar e apagar produto
- Rotas para cadastrar e vizualizar kit

##### Instalação

- Foi utilizado Laradock para auxiliar o desenvolvimento

* php artisan migrate - criar tabelas 
* php artisan db:seed - criar usuario: 'usuario@email.com', senha: 'secret'

### Front-end
SPA utilizando VueJS - Vue-router, Vuex, Bootstrap-vue, Axios

- Implementado telas de Login, Home, Produtos e Kit
- Produtos e Login precisa esta logado para acessar

##### Instalação

* npm i - instalar modulos
* npm rum serve - subir aplicação

** Obs: Verificar arquivo "src/plugins/axios.js" e alterar "baseURL" para endpoint do backend




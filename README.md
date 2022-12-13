# PHP CRUD
## Projeto CRUD (CREATE, READ, UPDATE & DELETE) desenvolvido em PHP
### Tecnologias utilizadas até então:
- PHP: Utilizando o PHP vanilla (Puro) para desenvolvimento do server side, junto de classes e objetos.
- MySQL: para banco de dandos junto do PHP.
- JavaScript Puro: utilizei para ter um maior controle sobre o FrontEnd.
- CSS: Para dar estilo ao FrontEnd.
- Modelo de projeto em MVC.
- Utilizei o site FontAwesome para icones

# ⚠ ATENÇÃO ⚠
- Quando terminar de baixar o projeto e coloca-lo em sua máquina, lembre-se de ler o arquivo no root chamado 'config.php', para-se alterar as informações de banco de dados, quanto informaçõs de URL's e outro parâmetros necessários para rodar o sistema.

# Partes que foram finalizadas: 

# MODELS: Informação
## Para esse projeto, só foi preciso utilizar um modelo, que - o coloquei numa classe chamada INFORMAÇÃO:
### Dentro desse modelo possui 3 tipos de dados:
- As variáveis do tipo pedido String chama-se '$informacao', '$dataCriacao' e '$dataAtualizacao':
Cada uma guarda-se a informação requerida em seu proprio nome, entretanto as informação são mudadas conforme são requisitadas em seus devidos GET's & SET's:
- Por exemplo: quando chama-se a variável do tipo 'Informacao->$informacao' dentro da view, ela análisa sinteticamente a botar um limite de 30 caracteres (para não quebrar o FRONT-END). 
- Isso vale também para as informações do tipo: $dataAtualizacao, que recebem o construtor nativo Date() do PHP. 

### PS: também temos o arquivo chamado 'SuperModel.php', onde ele se extende através das classes de MODEL, onde ela automaticamente adiciona outros duas variaveis. Chama-se '$id' e '$tableName', que é para melhor trabalhar com o banco de dados.

# CONTROLLERS: Informação
## A Controller também possui 

## VIEW - parte onde mostra as informações cadastradas:

### ✅ Sistema de visualização dos itens salvos no banco de dados (mysql) finalizados.
### ✅ Sistema de FILTROS de informação finalizados: 
- ✅ Consegue-se buscar as informações atráves do campo de busca, tanto por nome da informação, quanto a data que foi cadastrado, quanto a data que foi atualizado. (Utiliza-se o LIKE em Mysql);
- ✅ Consegue-se filtrar as informações através do $id, $informacao, $dataCriacao e $dataAtualizacao utilizando o orderBy (do Mysql);
- ✅Sistema de paginação customizada, utilizando PHP(Math.CEIL) e Mysql (LIMIT 0,10);
- ✅Sistema de seleção (mesmo entre páginas), utilizando $_COOKIES, para adicionar e remover seleções, e para fazer tudo sem precisar recarregar a página, utiliza-se o javaScript com o XhtmlHttpRequest.



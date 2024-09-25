# Gerenciador de Produtos

Este é um gerenciador de produtos desenvolvido em PHP, utilizando SQLite como banco de dados. A aplicação permite criar, visualizar, atualizar e deletar produtos, além de manter um registro de logs de ações realizadas.

## Índice

- [Funcionalidades](#funcionalidades)
- [Tecnologias Utilizadas](#tecnologias-utilizadas)
- [Instalação](#instalação)
- [Estrutura do Código](#estrutura-do-código)
- [Desenvolvimento da Aplicação](#desenvolvimento-da-aplicação)
- [Implementação dos Logs](#implementação-dos-logs)
- [Validação dos Campos](#validação-dos-campos)
- [Interface do Usuário](#interface-do-usuário)
- [Contribuição](#contribuição)
- [Licença](#licença)

## Funcionalidades

- **Listar Produtos:** Visualize todos os produtos cadastrados.
- **Inserir Produto:** Adicione novos produtos com nome, descrição, preço e estoque.
- **Editar Produto:** Atualize as informações de produtos existentes.
- **Deletar Produto:** Remova produtos do banco de dados.
- **Logs de Auditoria:** Registre e visualize ações realizadas no sistema.

## Tecnologias Utilizadas

- **PHP:** Linguagem de programação principal.
- **SQLite:** Banco de dados utilizado para armazenamento de dados.
- **HTML/CSS/JavaScript:** Tecnologias utilizadas para a interface do usuário.
- **Bootstrap:** Framework CSS para estilização e responsividade.

## Instalação

1. Clone o repositório:
   ```
   git clone https://github.com/seu-usuario/seu-repositorio.git
   ```
2. Acesse o diretório do projeto:
  ```
   cd seu-repositorio
  ```
3. Abra o arquivo index.php em um servidor web ou localmente através de um servidor PHP embutido:
```
  php -S localhost:8000
```

## Estrutura do Código 

/seu-repositorio  
│  
├── /src  
│   ├── Database.php   
│   ├── Produtos.db  
│   ├── Product.php  
│   ├── index.php  
│   ├── style.css  
│   ├── script.js  
│   └── Log.php  
│  
├── Vendor  
│   ├── Composer  
│   └── autoload.php  
└── composer.json  

## Endpoints

### Produtos

- **GET /produtos**
  - **Descrição:** Retorna todos os produtos.
  - **Status:** 200 OK

- **GET /produtos/{id}**
  - **Descrição:** Retorna o produto com o ID especificado.
  - **Status:** 200 OK, 404 Not Found

- **POST /produtos**
  - **Descrição:** Cria um novo produto (com validação de campos).
  - **Status:** 201 Created, 400 Bad Request

- **PUT /produtos/{id}**
  - **Descrição:** Atualiza os dados de um produto existente (com validação de campos).
  - **Status:** 200 OK, 404 Not Found, 400 Bad Request

- **DELETE /produtos/{id}**
  - **Descrição:** Exclui o produto com o ID especificado.
  - **Status:** 204 No Content, 404 Not Found

### Logs

- **GET /logs**
  - **Descrição:** Retorna todos os logs das operações realizadas nos produtos.
  - **Status:** 200 OK

## Validação dos Campos

- **Obrigatórios:**
  - O nome do produto deve ter no mínimo 3 caracteres.
  - O preço deve ser um valor positivo.
  - O estoque deve ser um número inteiro maior ou igual a zero.

## Implementação dos Logs

Cada vez que um produto for criado, atualizado ou excluído, uma entrada é registrada na tabela de logs, contendo:
- O tipo de operação (criação, atualização, exclusão).
- A data e hora da operação.
- O ID do produto afetado.
- Usuário qual realizou.

## Desenvolvimento da Aplicação

A aplicação foi desenvolvida seguindo as diretrizes estabelecidas pela atividade para atender às necessidades de gerenciamento de produtos. A escolha do SQLite como banco de dados proporcionou simplicidade e eficiência na criação e manipulação de tabelas.

## Dificuldades Encontradas

Durante o desenvolvimento, enfrentamos desafios relacionados à implementação da validação dos campos e à configuração adequada dos endpoints. A solução envolveu o uso de funções de validação personalizadas e testes rigorosos usando o Postman.

## Interface do Usuário

A interface é responsiva e foi desenvolvida utilizando o Bootstrap, garantindo uma boa experiência em diferentes dispositivos. Os formulários possuem validação para garantir que os usuários insiram dados válidos.

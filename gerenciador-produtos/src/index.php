<?php
require_once 'Database.php';
require_once 'Product.php';
require_once 'Log.php';

$db = new Database('produtos.db');
$product = new Product($db);
$log = new Log($db);

// Roteamento
require_once 'routes.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Adicione seu CSS aqui -->
    <title>Gerenciador de Produtos</title>
</head>
<body class="bg-dark text-light">
    <div id="sectionsContainer">
        <div id="menu" class="vh-100">
            <div id="produtosButton" class="text-button" data-text="PRODUTOS">PRODUTOS</div>
            <div id="inserirButton" class="text-button" data-text="INSERIR">INSERIR</div>
            <div id="auditoriaButton" class="text-button" data-text="AUDITORIA">AUDITORIA</div>
        </div>
        <div id="inserirSection" class="section">
            <div id="inserirContainer" class="section">
                <form id="insertProductForm">
                    <input type="hidden" id="userInsert" name="userInsert" value="UsuárioPadrão">
                    <label for="nome">Nome:</label>
                    <input type="text" id="insertNome" name="nome" required>

                    <label for="descricao">Descrição:</label>
                    <textarea id="insertDescricao" name="descricao" required></textarea>  

                    <label for="preco">Preço:</label>
                    <input type="number" id="insertPreco" name="preco" step="0.01" required>

                    <label for="estoque">Estoque:</label>
                    <input type="number" id="insertEstoque" name="estoque" required>

                    <button type="submit" class="inserir-button">Inserir Produto</button>
                    <button type="button" class="backButton">Voltar</button>
                </form>
            </div>
        </div>
        <div id="produtosSection" class="section">
            <button class="backButton">Voltar</button>
            <div id="produtosContainer" class="produtos-container">
                <!-- Produtos serão inseridos aqui via JavaScript -->
            </div>
        </div>

        <!-- Modal para edição de produto -->
        
        <div id="auditoriaSection" class="section">
            <div id="logsContainer" class="logs-container">
                <!-- Logs serão inseridos aqui via JavaScript -->
            </div>
            <button class="backButton">Voltar</button>
        </div>
    </div>
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2 class="modal-top">Editar Produto</h2>
            <form id="editProductForm">
                <input type="hidden" id="productId" name="id">
                <input type="hidden" id="userInsert" name="userInsert">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea>
                <label for="preco">Preço:</label>
                <input type="number" id="preco" name="preco" required>
                <label for="estoque">Estoque:</label>
                <input type="number" id="estoque" name="estoque" required>
                <button type="submit" class="atualizar-button">Salvar</button>
                <button type="button" class="excluir-button">Excluir</button> <!-- Novo botão de excluir -->
            </form>
        </div>
    </div>

    <script src="script.js"></script> <!-- Adicione seu JS aqui -->
</body>
</html>

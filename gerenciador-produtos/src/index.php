<?php
require_once 'Database.php';
require_once 'Product.php';
require_once 'Log.php';

$db = new Database('produtos.db');
$product = new Product($db);
$log = new Log($db);

error_reporting(0);

// Roteamento
require_once 'routes.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- Adicione seu CSS aqui -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <title>Gerenciador de Produtos</title>
</head>
<body class="bg-light text-dark">
    <div id="app" class="container mt-5">
        <header class="mb-4">
            <h1 class="text-center">Gerenciador de Produtos</h1>
            <nav class="nav justify-content-center mb-4">
                <!-- <button class="btn btn-outline-primary mx-2" @click="showView('home')">Home</button> -->
                <button class="btn btn-outline-primary mx-2" @click="showView('produtos')">Produtos</button>
                <button class="btn btn-outline-primary mx-2" @click="showView('inserir')">Inserir</button>
                <button class="btn btn-outline-primary mx-2" @click="showView('auditoria')">Auditoria</button>
            </nav>
        </header>

        <transition name="fade">
            <component :is="currentView"></component>
        </transition>

        <!-- Seção de Produtos -->
        <div id="produtosSection" class="section" v-if="currentView === 'produtos'">
            <h2 class="text-center">Lista de Produtos</h2>
            <button class="btn btn-secondary mb-3" @click="showView('home')">Voltar</button>
            <div id="produtosContainer" class="produtos-container">
                <div v-for="produto in produtos" :key="produto.ID" class="produto-card">
                    <h3>{{ produto.nome }}</h3>
                    <p>{{ produto.descricao }}</p>
                    <p><strong>Preço:</strong> R$ {{ produto.preco }}</p>
                    <p><strong>Estoque:</strong> {{ produto.estoque }}</p>
                    <button class="btn btn-warning" @click="openEditModal(produto)">Editar</button>
                </div>
            </div>
        </div>


        <!-- Seção de Inserção -->
        <div id="inserirSection" class="section" v-if="currentView === 'inserir'">
            <h2 class="text-center">Inserir Novo Produto</h2>
            <button class="btn btn-secondary mb-3" @click="showView('home')">Voltar</button>
            <form @submit.prevent="insertProduct">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" v-model="newProduct.nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" v-model="newProduct.descricao" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="preco">Preço:</label>
                    <input type="number" id="preco" v-model="newProduct.preco" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="estoque">Estoque:</label>
                    <input type="number" id="estoque" v-model="newProduct.estoque" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Inserir</button>
            </form>
        </div>


        <!-- Seção de Auditoria -->
        <div id="auditoriaSection" class="section" v-if="currentView === 'auditoria'">
            <h2 class="text-center">Logs de Auditoria</h2>
            <button class="btn btn-secondary mb-3" @click="showView('home')">Voltar</button>
            <div id="logsContainer" class="logs-container">
                <div v-for="log in logs" :key="log.id" class="log-card">
                    <div class="log-header">
                        <h4>{{ log.acao }}</h4>
                        <span class="log-timestamp">{{ log.dataHora }}</span>
                    </div>
                    <div class="log-details">
                        <p><strong>Produto:</strong> {{ log.nome_produto }}</p>
                        <p><strong>ID do Produto:</strong> {{ log.produtoID }}</p>
                        <p><strong>Inserido por:</strong> {{ log.userInsert }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Edição -->
        <div class="modal" :class="{ active: editModalVisible }">
            <div class="modal-content">
                <span class="close-button" @click="closeEditModal">&times;</span>
                <h2>Editar Produto</h2>
                <div class="form-group">
                    <label for="nome">Nome</label>
                    <input v-model="productToEdit.nome" type="text" id="nome" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea v-model="productToEdit.descricao" id="descricao" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="preco">Preço</label>
                    <input v-model="productToEdit.preco" type="text" id="preco" class="form-control" />
                </div>
                <div class="form-group">
                    <label for="estoque">Estoque</label>
                    <input v-model="productToEdit.estoque" type="number" id="estoque" class="form-control" />
                </div>
                <button @click="updateProduct" class="btn btn-primary">Atualizar Produto</button>
            </div>
        </div>

    </div>

    <script src="script.js"></script>
</body>
</html>

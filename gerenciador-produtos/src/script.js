document.addEventListener('DOMContentLoaded', function() {
    const menu = document.getElementById('menu');
    const produtosButton = document.getElementById('produtosButton');
    const inserirButton = document.getElementById('inserirButton');
    const auditoriaButton = document.getElementById('auditoriaButton');
    const sectionsContainer = document.getElementById('sectionsContainer');
    const backButtons = document.querySelectorAll('.backButton');
    const editModal = document.getElementById('editModal');
    const closeButton = document.querySelector('.close-button');
    const editProductForm = document.getElementById('editProductForm');
    const insertProductForm = document.getElementById('insertProductForm');
    
    produtosButton.addEventListener('click', function() {
        sectionsContainer.style.transform = 'translateX(100vw)';
        loadProducts();
    });

    inserirButton.addEventListener('click', function() {
        sectionsContainer.style.transform = 'translateX(-100vw)';
        insertProductForm.reset();
    });

    auditoriaButton.addEventListener('click', function() {
        sectionsContainer.style.transform = 'translateY(-100vh)'; // Ajuste para a animação
        loadLogs(); // Chama a função para carregar os dados da auditoria ao abrir a seção
    });
    

    backButtons.forEach(button => {
        button.addEventListener('click', function() {
            sectionsContainer.style.transform = 'translate(0, 0)';
        });
    });

    async function loadProducts() {
        try {
            const response = await fetch('http://localhost:8080/index.php/produtos');
            const products = await response.json();
            const produtosContainer = document.getElementById('produtosContainer');
            produtosContainer.innerHTML = ''; // Limpa o container antes de adicionar novos produtos
            
            products.forEach(product => {
                const productItem = document.createElement('div');
                productItem.className = 'showElemento-item';
                productItem.innerHTML = `
                    <div class="showElemento-info">
                        <span>${product.nome} (${product.estoque} em estoque)</span>
                        <span class="seta">&#9654;</span>
                    </div>
                    <div class="showElemento-detalhes">
                        <p><strong>Descrição:</strong> ${product.descricao}</p>
                        <p><strong>Preço:</strong> R$ ${product.preco}</p>
                        <p><strong>Usuário:</strong> ${product.userInsert}</p>
                        <p><strong>Data:</strong> ${product.dataHora}</p>
                        <button class="alterar-button">Alterar</button> <!-- Novo botão -->
                    </div>
                `;
                productItem.addEventListener('click', function() {
                    const detalhes = this.querySelector('.showElemento-detalhes');
                    if (this.classList.contains('expanded')) {
                        detalhes.style.animation = 'collapse 0.3s ease-out';
                        setTimeout(() => {
                            this.classList.remove('expanded');
                            detalhes.style.display = 'none';
                        }, 300);
                    } else {
                        detalhes.style.display = 'block';
                        detalhes.style.animation = 'expand 0.3s ease-out';
                        this.classList.add('expanded');
                    }
                });
    
                // Adicionando o evento de clique ao botão de alterar
                productItem.querySelector('.alterar-button').addEventListener('click', function(event) {
                    event.stopPropagation(); // Evita que o evento de clique no card seja ativado

                    // Preenche os campos do modal com as informações do produto
                    document.getElementById('productId').value = product.ID;
                    document.getElementById('nome').value = product.nome;
                    document.getElementById('descricao').value = product.descricao;
                    document.getElementById('preco').value = product.preco;
                    document.getElementById('estoque').value = product.estoque;
                    document.getElementById('userInsert').value = 'UsuárioPadrão';

                    // Abre o modal
                    editModal.style.display = 'flex';
                });
                
    
                produtosContainer.appendChild(productItem);
            });
        } catch (error) {
            console.error('Error loading products:', error);
        }
    }

    closeButton.addEventListener('click', function() {
        editModal.style.display = 'none';
    });
    

    editProductForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const productId = document.getElementById('productId').value;
        const formData = new FormData(editProductForm);
        const data = JSON.stringify(Object.fromEntries(formData.entries()));
    
        try {
            const response = await fetch(`http://localhost:8080/index.php/produtos/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: data,
            });
    
            if (response.ok) {
                alert('Produto atualizado com sucesso!');
                editModal.style.display = 'none';
                await loadProducts();
            } else {
                const errorData = await response.json();
                alert(`Erro ao atualizar produto: ${errorData.error}`);
            }
        } catch (error) {
            console.error('Error updating product:', error);
        }
    });
    // Adicione isso logo após o event listener de fechamento do modal
    const excluirButton = document.querySelector('.excluir-button');

    excluirButton.addEventListener('click', async function() {
        const productId = document.getElementById('productId').value;

        if (confirm('Você tem certeza que deseja excluir este produto?')) {
            try {
                const response = await fetch(`http://localhost:8080/index.php/produtos/${productId}`, {
                    method: 'DELETE',
                });

                if (response.ok) {
                    alert('Produto excluído com sucesso!');
                    editModal.style.display = 'none';
                    await loadProducts(); // Atualiza a lista de produtos após a exclusão
                } else {
                    const errorData = await response.json();
                    alert(`Erro ao excluir produto: ${errorData.error}`);
                }
            } catch (error) {
                console.error('Error deleting product:', error);
            }
        }
    });



    async function loadLogs() {
        try {
            const response = await fetch('http://localhost:8080/index.php/logs');
            const logs = await response.json();
            const logsContainer = document.getElementById('logsContainer');
            logsContainer.innerHTML = ''; // Limpa o container antes de adicionar novos logs
            
            logs.forEach(log => {
                if (log.nome_produto) {
                    const logItem = document.createElement('div');
                    logItem.className = 'showElemento-item';
                    logItem.innerHTML = `
                        <div class="showElemento-info">
                            <span>${log.acao} &nbsp; | &nbsp; realizada em ${log.dataHora}</span>
                            <span class="seta">&#9654;</span>
                        </div>
                        <div class="showElemento-detalhes">
                            <p><strong>ID de log:</strong> ${log.ID}</p>
                            <p><strong>ID do produto:</strong> ${log.produtoID}</p>
                            <p><strong>Produto:</strong> ${log.nome_produto}</p>
                            <p><strong>Ação realizada:</strong> ${log.acao}</p>
                            <p><strong>Realizado por:</strong> ${log.userInsert}</p>
                            <p><strong>Data e hora de log:</strong> ${log.dataHora}</p>
                        </div>
                    `;
                    logItem.addEventListener('click', function() {
                        const detalhes = this.querySelector('.showElemento-detalhes');
                        if (this.classList.contains('expanded')) {
                            detalhes.style.animation = 'collapse 0.3s ease-out';
                            setTimeout(() => {
                                this.classList.remove('expanded');
                                detalhes.style.display = 'none';
                            }, 300);
                        } else {
                            detalhes.style.display = 'block';
                            detalhes.style.animation = 'expand 0.3s ease-out';
                            this.classList.add('expanded');
                        }
                    });
                    
                    // Adiciona o item ao container de logs
                    logsContainer.appendChild(logItem);
                } else {
                    const logItem = document.createElement('div');
                    logItem.className = 'showElemento-item';
                    logItem.innerHTML = `
                        <div class="showElemento-info">
                            <span>${log.acao} &nbsp; | &nbsp; realizada em ${log.dataHora}</span>
                            <span class="seta">&#9654;</span>
                        </div>
                        <div class="showElemento-detalhes">
                            <p><strong>ID de log:</strong> ${log.ID}</p>
                            <p><strong>ID do produto:</strong> ${log.produtoID}</p>
                            <p><strong>Ação realizada:</strong> ${log.acao}</p>
                            <p><strong>Realizado por:</strong> ${log.userInsert}</p>
                            <p><strong>Data e hora de log:</strong> ${log.dataHora}</p>
                        </div>
                    `;
                    logItem.addEventListener('click', function() {
                        const detalhes = this.querySelector('.showElemento-detalhes');
                        if (this.classList.contains('expanded')) {
                            detalhes.style.animation = 'collapse 0.3s ease-out';
                            setTimeout(() => {
                                this.classList.remove('expanded');
                                detalhes.style.display = 'none';
                            }, 300);
                        } else {
                            detalhes.style.display = 'block';
                            detalhes.style.animation = 'expand 0.3s ease-out';
                            this.classList.add('expanded');
                        }
                    });
                    
                    // Adiciona o item ao container de logs
                    logsContainer.appendChild(logItem);
                }
            });
            
        } catch (error) {
            console.error('Error loading logs:', error);
        }
    }



    insertProductForm.addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(insertProductForm);
        const data = JSON.stringify(Object.fromEntries(formData.entries()));

        try {
            const response = await fetch('http://localhost:8080/index.php/produtos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: data,
            });

            if (response.ok) {
                alert('Produto inserido com sucesso!');
                insertProductForm.reset();
            } else {
                const errorData = await response.json();
                alert(`Erro ao inserir produto: ${errorData.error}`);
            }
        } catch (error) {
            console.error('Error inserting product:', error);
        }
    });
     
    
});

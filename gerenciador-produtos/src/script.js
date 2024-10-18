new Vue({
    el: '#app',
    data: {
        produtos: [],
        logs: [],
        currentView: 'home',
        productToEdit: {},
        newProduct: {
            nome: '',
            descricao: '',
            preco: '',
            estoque: '',
            userInsert: ''
        },
        editModalVisible: false, // Para controlar a visibilidade do modal de edição
        insertModalVisible: false // Para controlar a visibilidade do modal de inserção
    },
    methods: {
        async loadProducts() {
            try {
                const response = await fetch('http://localhost:8080/index.php/produtos');
                if (!response.ok) {
                    throw new Error(`Error: ${response.statusText}`);
                }
                this.produtos = await response.json();
            } catch (error) {
                console.error('Error loading products:', error);
                alert('Erro ao carregar produtos. Tente novamente.');
            }
        },
        async loadLogs() {
            try {
                const response = await fetch('http://localhost:8080/index.php/logs');
                if (!response.ok) {
                    throw new Error(`Error: ${response.statusText}`);
                }
                this.logs = await response.json();
                console.log('Logs carregados:', this.logs);
            } catch (error) {
                console.error('Error loading logs:', error);
                alert('Erro ao carregar logs. Tente novamente.');
            }
        },
        showView(view) {
            this.currentView = view;
            console.log('Current View:', this.currentView); // Para depuração
            if (view === 'produtos') {
                this.loadProducts();
            } else if (view === 'auditoria') {
                this.loadLogs();
            }
        },
        openEditModal(product) {
            console.log('Abrindo modal de edição para:', product);
            this.productToEdit = { ...product };
            setTimeout(() => {
                this.editModalVisible = true; 
            }, 100);
        },
        closeEditModal() {
            this.editModalVisible = false; // Fecha o modal de edição
            this.productToEdit = {}; // Limpa os dados do produto ao fechar
        },
        async updateProduct() {
            try {
                const response = await fetch(`http://localhost:8080/index.php/produtos/${this.productToEdit.ID}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.productToEdit)
                });

                if (response.ok) {
                    alert('Produto atualizado com sucesso!');
                    this.closeEditModal(); // Fecha o modal e limpa os dados
                    this.loadProducts(); // Atualiza a lista
                } else {
                    const errorData = await response.json();
                    alert(`Erro ao atualizar produto: ${errorData.error}`);
                }
            } catch (error) {
                console.error('Error updating product:', error);
            }
        },
        async deleteProduct() {
            const confirmDelete = confirm('Você tem certeza que deseja excluir este produto?');
            if (!confirmDelete) return;
        
            try {
                const response = await fetch(`http://localhost:8080/index.php/produtos/${this.productToEdit.ID}`, {
                    method: 'DELETE'
                });
        
                if (response.ok) {
                    alert('Produto excluído com sucesso!');
                    this.closeEditModal();
                    this.loadProducts();
                } else {
                    const errorData = await response.json();
                    alert(`Erro ao excluir produto: ${errorData.error}`);
                }
            } catch (error) {
                console.error('Error deleting product:', error);
            }
        },
        async insertProduct() {
            try {
                const response = await fetch('http://localhost:8080/index.php/produtos', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(this.newProduct)
                });
        
                if (response.ok) {
                    alert('Produto inserido com sucesso!');
                    this.newProduct = { nome: '', descricao: '', preco: '', estoque: '', userInsert: '' };
                    this.loadProducts();
                } else {
                    const errorData = await response.json();
                    alert(`Erro ao inserir produto: ${errorData.error}`);
                }
            } catch (error) {
                console.error('Error inserting product:', error);
            }
        }
        
    },
    mounted() {
        this.showView('home'); // Inicializa a visualização
    }
});

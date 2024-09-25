<?php
class Product {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllProducts() {
        $query = "SELECT * FROM produtos";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $query = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($data) {
        // Validação dos dados
        if (empty($data['nome']) || strlen($data['nome']) < 3) {
            throw new Exception("O nome do produto deve ter pelo menos 3 caracteres.");
        }
        if ($data['preco'] <= 0) {
            throw new Exception("O preço deve ser um valor positivo.");
        }
        if ($data['estoque'] < 0) {
            throw new Exception("O estoque deve ser um número inteiro maior ou igual a zero.");
        }
    
        // Inserção no banco
        try {
            $query = "INSERT INTO produtos (nome, descricao, preco, estoque, userInsert, dataHora) VALUES (:nome, :descricao, :preco, :estoque, :userInsert, datetime('now'))";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':descricao', $data['descricao']);
            $stmt->bindParam(':preco', $data['preco']);
            $stmt->bindParam(':estoque', $data['estoque']);
            $stmt->bindParam(':userInsert', $data['userInsert']);
    
            if (!$stmt->execute()) {
                throw new Exception("Erro ao inserir produto: " . implode(", ", $stmt->errorInfo()));
            }
    
            return $this->db->lastInsertId();
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            http_response_code(500);
            exit;
        }
    }
    

    public function updateProduct($id, $data) {
        try {
            $query = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, estoque = :estoque WHERE ID = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':descricao', $data['descricao']);
            $stmt->bindParam(':preco', $data['preco']);
            $stmt->bindParam(':estoque', $data['estoque']);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log('Erro ao atualizar produto: ' . $e->getMessage());
        }
    }
    

    public function deleteProduct($id) {
        $query = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
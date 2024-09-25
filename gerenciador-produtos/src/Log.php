<?php
class Log {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function logAction($acao, $produtoID, $userInsert) {
        try {
            $query = "INSERT INTO logs (acao, produtoID, userInsert) VALUES (:acao, :produtoID, :userInsert)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':acao', $acao);
            $stmt->bindParam(':produtoID', $produtoID);
            $stmt->bindParam(':userInsert', $userInsert);
            $stmt->execute();
    
        } catch (PDOException $e) {
            error_log('Erro ao registrar log: ' . $e->getMessage());
        }
    }    
    

    public function getAllLogs() {
        $query = "
SELECT logs.*, produtos.nome AS nome_produto 
FROM logs 
LEFT JOIN produtos ON logs.produtoID = produtos.ID 
ORDER BY logs.dataHora DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
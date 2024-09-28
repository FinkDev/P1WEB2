<?php
$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = explode('/', trim($_SERVER['PATH_INFO'], '/'));

if ($requestMethod === 'GET') {
    if (count($requestUri) === 1 && $requestUri[0] === 'produtos') {
        $products = $product->getAllProducts();
        echo json_encode($products);
        exit();
    } elseif (count($requestUri) === 2 && $requestUri[0] === 'produtos') {
        $id = intval($requestUri[1]);
        $productData = $product->getProductById($id);
        echo json_encode($productData);
        exit();
    } elseif (count($requestUri) === 1 && $requestUri[0] === 'logs') {
        $logs = $log->getAllLogs();
        echo json_encode($logs);
        exit();
    }
} elseif ($requestMethod === 'POST' && $requestUri[0] === 'produtos') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $product->createProduct($data);
    $log->logAction('criação', $id, $data['userInsert']);
    echo json_encode(['message' => 'Produto criado com sucesso', 'id' => $id]);
    exit();
} elseif ($requestMethod === 'PUT' && count($requestUri) === 2 && $requestUri[0] === 'produtos') {
    $id = intval($requestUri[1]);
    $data = json_decode(file_get_contents("php://input"), true);
    $product->updateProduct($id, $data);
    $log->logAction('atualização', $id, $data['userInsert']);
    echo json_encode(['message' => 'Produto atualizado com sucesso']);
    exit();
} elseif ($requestMethod === 'DELETE' && count($requestUri) === 2 && $requestUri[0] === 'produtos') {
    $id = intval($requestUri[1]);
    $product->deleteProduct($id);
    $log->logAction('exclusão', $id, $data['userInsert']);
    echo json_encode(['message' => 'Produto deletado com sucesso']);
    exit();
} else {
    echo json_encode(['error' => 'Rota não encontrada']);
}

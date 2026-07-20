<?php
require_once __DIR__ . '/../../config/database.php';
$db = (new Database())->getConnection();

if (isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM santri WHERE id_santri = ?");
    $stmt->execute([$_GET['id']]);
    $data = $stmt->fetch();
    
    if ($data) {
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
    }
}
?>
<?php
require_once 'db.php';

class Setting {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM settings";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO settings SET `key`=:key, value=:value";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    public function update($id, $data) {
        $query = "UPDATE settings SET `key`=:key, value=:value WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM settings WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}

// 路由处理
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $setting = new Setting();
    echo json_encode($setting->getAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $setting = new Setting();
    echo json_encode(['id' => $setting->create($data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    $setting = new Setting();
    $id = $data['id'];
    unset($data['id']);
    echo json_encode(['success' => $setting->update($id, $data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $setting = new Setting();
    echo json_encode(['success' => $setting->delete($data['id'])]);
}
?>

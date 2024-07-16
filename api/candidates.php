<?php
require_once 'db.php';

class Candidate {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM candidates";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO candidates SET name=:name, gender=:gender, birthday=:birthday, education=:education, graduation_school=:graduation_school, major=:major, title=:title, phone=:phone, email=:email";
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
        $query = "UPDATE candidates SET name=:name, gender=:gender, birthday=:birthday, education=:education, graduation_school=:graduation_school, major=:major, title=:title, phone=:phone, email=:email WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM candidates WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}

// 路由处理
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $candidate = new Candidate();
    echo json_encode($candidate->getAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $candidate = new Candidate();
    echo json_encode(['id' => $candidate->create($data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    $candidate = new Candidate();
    $id = $data['id'];
    unset($data['id']);
    echo json_encode(['success' => $candidate->update($id, $data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $candidate = new Candidate();
    echo json_encode(['success' => $candidate->delete($data['id'])]);
}
?>

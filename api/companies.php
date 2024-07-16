<?php
require_once 'db.php';

class Company {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT * FROM companies";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO companies SET name=:name, description=:description, company_type=:company_type, company_size=:company_size";
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
        $query = "UPDATE companies SET name=:name, description=:description, company_type=:company_type, company_size=:company_size WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM companies WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}

// 路由处理
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $company = new Company();
    echo json_encode($company->getAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $company = new Company();
    echo json_encode(['id' => $company->create($data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    $company = new Company();
    $id = $data['id'];
    unset($data['id']);
    echo json_encode(['success' => $company->update($id, $data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $company = new Company();
    echo json_encode(['success' => $company->delete($data['id'])]);
}
?>

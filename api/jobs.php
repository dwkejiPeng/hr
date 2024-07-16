<?php
require_once 'db.php';

class Job {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAll() {
        $query = "SELECT jobs.*, companies.name as company_name FROM jobs JOIN companies ON jobs.company_id = companies.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO jobs SET title=:title, salary=:salary, experience=:experience, education=:education, job_type=:job_type, job_address=:job_address, detailed_address=:detailed_address, phone=:phone, company_id=:company_id";
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
        $query = "UPDATE jobs SET title=:title, salary=:salary, experience=:experience, education=:education, job_type=:job_type, job_address=:job_address, detailed_address=:detailed_address, phone=:phone, company_id=:company_id WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM jobs WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
}

// 路由处理
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $job = new Job();
    echo json_encode($job->getAll());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $job = new Job();
    echo json_encode(['id' => $job->create($data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $data);
    $job = new Job();
    $id = $data['id'];
    unset($data['id']);
    echo json_encode(['success' => $job->update($id, $data)]);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $data);
    $job = new Job();
    echo json_encode(['success' => $job->delete($data['id'])]);
}
?>

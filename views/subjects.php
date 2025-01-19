<?php
require_once 'core/model.php';

class SubjectsModel extends Model {
    public function getSubjects() {
        $query = $this->getDB()->query("SELECT * FROM subjects");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addSubject($name) {
        $stmt = $this->getDB()->prepare("INSERT INTO subjects (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
    }

    public function updateSubject($id, $name) {
        $stmt = $this->getDB()->prepare("UPDATE subjects SET name = :name WHERE id = :id");
        $stmt->execute([':name' => $name, ':id' => $id]);
    }

    public function deleteSubject($id) {
        $stmt = $this->getDB()->prepare("DELETE FROM subjects WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}


$model = new SubjectsModel();
$subjects = $model->getSubjects();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $model->addSubject($_POST['name']);
    } elseif (isset($_POST['update'])) {
        $model->updateSubject($_POST['id'], $_POST['name']);
    } elseif (isset($_POST['delete'])) {
        $model->deleteSubject($_POST['id']);
    }
    header('Location: /subjects.php');
}

require 'views/subjects.php';
?>

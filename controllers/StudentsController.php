<?php
require_once 'models/StudentsModel.php';

class StudentsController {
    private $model;

    public function __construct() {
        $this->model = new StudentsModel();
    }

    public function index() {
        include 'views/default.php';
    }

    public function getData() {
        $data['students'] = $this->model->getStudentsFromDB();
        $data['groups'] = $this->model->getGroups();
        die(json_encode($data));
    }

    public function addStudent() {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $name = $_POST['name'] ?? '';
                $group_id = $_POST['group_id'] ?? 0;

                if (!$name || !$group_id) {
                    throw new Exception("Invalid data: name or group is missing.");
                }

                if ($this->model->addStudentToDB($name, $group_id)) {
                    die(json_encode(true));
                } else {
                    throw new Exception("Error adding student to the database.");
                }
            }
        } catch (Exception $e) {
            die(json_encode(['error' => $e->getMessage()]));
        }
    }

    public function actions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['update'])) {
                $id = intval($_POST['id']);
                $name = $_POST['name'] ?? '';
                $group_id = $_POST['group_id'] ?? 0;
                $this->model->updateStudentFromDB($id, $name, $group_id);
            } elseif (isset($_POST['delete'])) {
                $id = intval($_POST['id']);
                $this->model->deleteStudentFromDB($id);
            }
            die(json_encode(true));
        }
    }
}

?>

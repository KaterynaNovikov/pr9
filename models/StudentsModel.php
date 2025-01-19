<?php
class StudentsModel extends Model {
    public function getStudentsFromDB() {
        $query = $this->db->query('SELECT students.id, students.name, groups.name AS group_name, students.group_id 
                                   FROM students 
                                   LEFT JOIN `groups` ON students.group_id = groups.id');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addStudentToDB($name, $group_id) {
        $stmt = $this->db->prepare('INSERT INTO students (name, group_id) VALUES (:name, :group_id)');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->execute();
    }

    public function deleteStudentFromDB($id) {
        $stmt = $this->db->prepare('DELETE FROM students WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateStudentFromDB($id, $name, $group_id) {
        $stmt = $this->db->prepare('UPDATE students SET name = :name, group_id = :group_id WHERE id = :id');
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':group_id', $group_id);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getGroups() {
        $query = $this->db->query('SELECT id, name FROM `groups`');
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>

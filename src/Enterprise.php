<?php
namespace Service;

class Enterprise
{
    private $conn;

    public function __construct()
    {
        $conn = new \Service\DBConnection();
        $this->conn = $conn->getConnection();
    }

    public function get()
    {
        $sql = 'SELECT * FROM Enterprise WHERE dealership = 0 ORDER BY created ASC';
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        return json_encode($result);
    }

    public function post($values)
    {
        if (array_filter($values, array($this, 'testEmpty'))) {
            throw new \Exception('Os campos não podem estar vazios.');
        }

        $sql = 'INSERT INTO Enterprise (name, phone, contact, email, city, state, branch)
            VALUES (:name, :phone, :contact, :email, :city, :state, :branch)';

        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception('Ocorreu um erro ao salvar ao salvar a empresa');
        }

        $stmt->bindParam(':name', $values['name']);
        $stmt->bindParam(':phone', $values['phone']);
        $stmt->bindParam(':contact', $values['contact']);
        $stmt->bindParam(':email', $values['email']);
        $stmt->bindParam(':city', $values['city']);
        $stmt->bindParam(':state', $values['state']);
        $stmt->bindParam(':branch', $values['branch']);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function put($values)
    {
        if (array_filter($values, array($this, 'testEmpty'))) {
            throw new \Exception('Os campos não podem estar vazios.');
        }

        $sql = 'UPDATE Enterprise SET name = :name, phone = :phone, contact = :contact,
            email = :email, city = :city, state = :state, branch = :branch WHERE id = :id';
        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception('Ocorreu um erro ao editar a empresa');
        }

        $stmt->bindParam(':id', $values['id']);
        $stmt->bindParam(':name', $values['name']);
        $stmt->bindParam(':phone', $values['phone']);
        $stmt->bindParam(':contact', $values['contact']);
        $stmt->bindParam(':email', $values['email']);
        $stmt->bindParam(':city', $values['city']);
        $stmt->bindParam(':state', $values['state']);
        $stmt->bindParam(':branch', $values['branch']);

        $stmt->execute();
    }

    public function delete($value)
    {
        $sql = 'DELETE FROM Enterprise WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $value['id']);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new \Exception('Ocorreu um erro ao remover a empresa');
        }
    }

    private function testEmpty($value)
    {
        return !isset($value);
    }
}

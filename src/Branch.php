<?php
namespace Service;

class Branch
{
    private $conn;

    public function __construct()
    {
        $conn = new \Service\DBConnection();
        $this->conn = $conn->getConnection();
    }

    public function get()
    {
        $sql = 'SELECT * FROM Branch ORDER BY created ASC';
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

        $sql = 'INSERT INTO Branch (description) VALUES (:description)';
        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception('Ocorreu um erro ao salvar o ramo da empresa');
        }

        $stmt->bindParam(':description', $values['description']);
        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function put($values)
    {
        if (array_filter($values, array($this, 'testEmpty'))) {
            throw new \Exception('Os campos não podem estar vazios.');
        }

        $sql = 'UPDATE Branch SET description = :description WHERE id = :id';
        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception('Ocorreu um erro ao editar o ramo da empresa');
        }

        $stmt->bindParam(':id', $values['id']);
        $stmt->bindParam(':description', $values['description']);

        $stmt->execute();
    }

    public function delete($value)
    {
        $sql = 'DELETE FROM Branch WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $value['id']);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new \Exception('Ocorreu um erro ao remover o ramo da empresa');
        }
    }

    private function testEmpty($value)
    {
        return !isset($value);
    }
}

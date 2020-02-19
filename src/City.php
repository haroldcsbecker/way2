<?php
namespace Service;

class City
{
    private $conn;

    public function __construct()
    {
        $conn = new \Service\DBConnection();
        $this->conn = $conn->getConnection();
    }

    public function get()
    {
        $sql = 'SELECT * FROM City ORDER BY created ASC';
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();

        return json_encode($result);
    }

    public function post($values)
    {
        if (array_filter($values, array($this, 'testEmpty'))) {
            throw new \Exception('Os campos não podem estar vazios');
        }

        $sql = 'INSERT INTO City (description) VALUES (:description)';
        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception('Ocorreu um erro ao salvar a cidade');
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

        $sql = 'UPDATE City SET description = :description WHERE id = :id';
        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception('Ocorreu um erro ao editar a cidade');
        }

        $stmt->bindParam(':id', $values['id']);
        $stmt->bindParam(':description', $values['description']);

        $stmt->execute();
    }

    public function delete($value)
    {
        $sql = 'DELETE FROM City WHERE id = :id';

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $value['id']);
        $stmt->execute();

        if ($stmt->rowCount() < 1) {
            throw new \Exception('Ocorreu um erro ao remover a cidade');
        }
    }

    private function testEmpty($value)
    {
        return !isset($value);
    }
}

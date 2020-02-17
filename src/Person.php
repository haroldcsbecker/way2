<?php
    namespace Service;

    use Service\DBConnection;

    class Person
    {
        private $conn;
        private $api;

        public function __construct()
        {
            $config = new Config();
            $this->api = $config->getApiConfig();
            $this->conn = new DBConnection();
        }

        public function get()
        {
            $sql = "SELECT * FROM Person ORDER BY created ASC";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            return json_encode($result);
        }

        public function post($values)
        {
            if (array_filter($values, array($this, "testEmpty"))) {
                throw new \Exception("Os campos não podem estar vazios.");
            }

            $sql = "INSERT INTO task (type, content, sort_order, done)
                VALUES (:type, :content, :sort_order, :done)";
            $stmt = $this->conn->prepare($sql);

            if (false === $stmt) {
                throw new \Exception("Ocorreu um erro ao salvar a tarefa.");
            }

            $stmt->bindParam(':type', $values['type']);
            $stmt->bindParam(':done', $values['done']);
            $stmt->bindParam(':content', $values['content']);
            $stmt->bindParam(':sort_order', $values['sort_order']);

            $stmt->execute();
        }

        public function put($values)
        {
            if (array_filter($values, array($this, "testEmpty"))) {
                throw new \Exception("Os campos não podem estar vazios.");
            }

            $sql = "UPDATE task SET type = :type, content = :content,
                sort_order = :sort_order, done = :done WHERE uuid = :id";
            $stmt = $this->conn->prepare($sql);

            if (false === $stmt) {
                throw new \Exception("Ocorreu um erro ao editar a tarefa.");
            }

            $stmt->bindParam(':id', $values['id']);
            $stmt->bindParam(':type', $values['type']);
            $stmt->bindParam(':done', $values['done']);
            $stmt->bindParam(':content', $values['content']);
            $stmt->bindParam(':sort_order', $values['sort_order']);

            $stmt->execute();
        }

        public function delete($value)
        {
            $sql = "DELETE FROM task WHERE uuid = :id";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $value['id']);
            $stmt->execute();

            if ($stmt->rowCount() < 1) {
                throw new \Exception("Ocorreu um erro ao remover a tarrefa.");
            }
        }

        public function importLegacy()
        {

        }

        private function testEmpty($value)
        {
            return !isset($value);
        }
    }

<?php
namespace Service;

class LegacyImport
{
    private $api;
    private $conn;

    public function __construct()
    {
        $config = new \Config\Config();
        $conn = new \Service\DBConnection();

        $this->api = $config->getApiConfig();
        $this->conn = $conn->getConnection();
        $this->branchService = new Branch();
        $this->cityService = new City();
        $this->stateService = new State();
        $this->enterpriseService = new Enterprise();
        $this->dealershipService = new Dealership();
    }

    public function importLegacy()
    {
        if (!empty($this->alreadyImported())) {
            return;
        }

        $data = $this->getLegacyData()['body'];
        foreach ($data as $value) {
            $branch = ['description' => $value['ramoatividade']];
            $branch = $this->branchService->post($branch);

            $city = ['description' => $value['cidade']];
            $city = $this->cityService->post($city);

            $state = ['description' => $value['estado']];
            $state = $this->stateService->post($state);

            $enterprise = [
                'name' => $value['empresa'],
                'phone' => $value['telefonecontato'],
                'email' => $value['emailcontato'],
                'contact' => $value['contato'],
                'city' => $city,
                'state' => $state,
                'branch' => $branch
            ];
            $this->enterpriseService->post($enterprise);

            $dealership = [
                'name' => $value['concessionaria'],
                'phone' => $value['telefonecontatoconcessionaria'],
                'email' => $value['emailcontatoconecssionaria'],
                'contact' => $value['contatoconcessionaria'],
                'dealership' => true
            ];
            $this->dealershipService->post($dealership);
        }
        $this->copleteImportation();
    }

    private function getLegacyData()
    {
        $opts = [
            'http' => [
                'method' => 'GET',
                'ignore_errors' => false,
            ],
        ];

        $context = stream_context_create($opts);
        $result = file_get_contents(
            $this->api['url'],
            false,
            $context
        );

        return json_decode($result, true);
    }

    private function testEmpty($value)
    {
        return !isset($value);
    }

    private function alreadyImported()
    {
        $sql = "SELECT * FROM LegacyImport WHERE imported = 1";
        $stmt = $this->conn->prepare($sql);

        $stmt->execute();
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $stmt->fetch();

        return $result;
    }

    private function copleteImportation()
    {
        $sql = "INSERT INTO LegacyImport (imported) VALUES (true)";
        $stmt = $this->conn->prepare($sql);

        if (false === $stmt) {
            throw new \Exception("Ocorreu um erro ao salvar a importação.");
        }

        $stmt->execute();
    }
}

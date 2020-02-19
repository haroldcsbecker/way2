<?php
require 'vendor/autoload.php';

use Service\City;
use Service\State;
use Service\Branch;
use Service\Enterprise;
use Service\Dealership;
use Service\LegacyImport;

try {
    $city = new City();
    $state = new State();
    $branch = new Branch();
    $import = new LegacyImport();
    $dealership = new Dealership();
    $enterprise = new Enterprise();
    $import->importLegacy();

    $cityId = $city->post(['description' => 'teste']);
    $city->put(['id' => $cityId, 'description' => 'Cidade cadastrada manual']);
    $response = $city->get();
    // print_r($response);

    $stateId = $state->post(['description' => 'teste']);
    $state->put(['id' => $stateId, 'description' => 'Estado cadastrado manual']);
    $response = $state->get();
    // print_r($response);

    $branchId = $branch->post(['description' => 'teste']);
    $branch->put(['id' => $branchId, 'description' => 'Ramo cadastrado manual']);
    $response = $branch->get();
    // print_r($response);

    $enterpriseId = $enterprise->post([
        'name' => 'teste',
        'phone' => '123',
        'email' => 'teste@teste',
        'contact' => 'teste',
        'city' => $cityId,
        'state' => $stateId,
        'branch' => $branchId
    ]);

    $enterprise->put([
        'id' => $enterpriseId,
        'name' => 'Empresa',
        'phone' => '1233',
        'email' => 'empresa@empresa',
        'contact' => 'empresa',
        'city' => $cityId,
        'state' => $stateId,
        'branch' => $branchId
    ]);
    $response = $enterprise->get();
    // print_r($response);

    $dealershipId = $dealership->post([
        'name' => 'testeD',
        'phone' => '123',
        'email' => 'testeD@testeD',
        'contact' => 'testeD',
        'dealership' => 1
    ]);

    $dealership->put([
        'id' => $dealershipId,
        'name' => 'Dealership',
        'phone' => '1233',
        'email' => 'dealership@dealership',
        'contact' => 'dealership',
        'dealership' => 1
    ]);
    $response = $dealership->get();
    // print_r($response);

    $dealership->delete(['id' => $dealershipId]);
    $enterprise->delete(['id' => $enterpriseId]);
    $city->delete(['id' => $cityId]);
    $state->delete(['id' => $stateId]);
    $branch->delete(['id' => $branchId]);

} catch (\Exception $e) {
    echo $e->getMessage();
}

$city = null;
$state = null;
$branch = null;
$dealership = null;
$enterprise = null;

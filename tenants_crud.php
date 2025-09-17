<?php
header("Content-Type: application/json");
$file = "tenants.json";

// Helper: load JSON
function loadData($file) {
    if (!file_exists($file)) return [];
    return json_decode(file_get_contents($file), true);
}

// Helper: save JSON
function saveData($file, $data) {
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
}

$method = $_SERVER['REQUEST_METHOD'];
$data = loadData($file);

if ($method === "GET") {
    echo json_encode($data);
}

elseif ($method === "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    $newId = count($data) > 0 ? max(array_column($data, 'id')) + 1 : 1;
    $newTenant = [
        "id" => $newId,
        "name" => $input['name'],
        "unit" => $input['unit'],
        "contact" => $input['contact'],
        "status" => "Active"
    ];
    $data[] = $newTenant;
    saveData($file, $data);
    echo json_encode(["message" => "Tenant added"]);
}

elseif ($method === "PUT") {
    $input = json_decode(file_get_contents("php://input"), true);
    foreach ($data as &$t) {
        if ($t['id'] == $input['id']) {
            $t['name'] = $input['name'];
            $t['unit'] = $input['unit'];
            $t['contact'] = $input['contact'];
            $t['status'] = $input['status'];
        }
    }
    saveData($file, $data);
    echo json_encode(["message" => "Tenant updated"]);
}

elseif ($method === "DELETE") {
    $id = $_GET['id'] ?? null;
    if ($id) {
        $data = array_filter($data, fn($t) => $t['id'] != $id);
        saveData($file, array_values($data));
        echo json_encode(["message" => "Tenant deleted"]);
    }
}
?>

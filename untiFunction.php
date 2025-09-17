<?php
function loadUnits($file = "units.json") {
    if (!file_exists($file)) {
        return [];
    }
    return json_decode(file_get_contents($file), true);
}

function saveUnits($units, $file = "units.json") {
    file_put_contents($file, json_encode($units, JSON_PRETTY_PRINT));
}

function addUnit($unit_no, $type, $monthly_rent, $availability, $current_tenant = null, $file = "units.json") {
    $units = loadUnits($file);

    $newUnit = [
        "unit_no" => $unit_no,
        "type" => $type,
        "monthly_rent" => (int)$monthly_rent,
        "availability" => $availability,
        "current_tenant" => $current_tenant
    ];

    $units[] = $newUnit;
    saveUnits($units, $file);
}

function editUnit($unit_no, $type, $monthly_rent, $availability, $current_tenant = null, $file = "units.json") {
    $units = loadUnits($file);

    foreach ($units as &$unit) {
        if ($unit["unit_no"] == $unit_no) {
            $unit["type"] = $type;
            $unit["monthly_rent"] = (int)$monthly_rent;
            $unit["availability"] = $availability;
            $unit["current_tenant"] = $current_tenant;
            break;
        }
    }

    saveUnits($units, $file);
}

function deleteUnit($unit_no, $file = "units.json") {
    $units = loadUnits($file);

    foreach ($units as $key => $unit) {
        if ($unit["unit_no"] == $unit_no) {
            unset($units[$key]);
            $units = array_values($units); // reindex
            break;
        }
    }

    saveUnits($units, $file);
}
?>

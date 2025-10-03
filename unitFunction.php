<?php
include "conn.php";

// Load all units with tenant info
function loadUnits() {
    global $conn;
    $units = [];

    $sql = "SELECT u.unit_id, u.unit_no, u.type, u.monthly_rent, u.availability, 
                   t.full_name AS tenant_name
            FROM units u
            LEFT JOIN tenants t ON u.current_tenant = t.tenant_id
            ORDER BY u.unit_id ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $units[] = [
                "id" => $row["unit_id"],
                "unit_no" => $row["unit_no"],
                "type" => $row["type"],
                "rent" => $row["monthly_rent"],
                "availability" => $row["availability"],
                "tenant" => $row["tenant_name"] ?? "-"
            ];
        }
    }

    return $units;
}

// Add new unit
function addUnit($unit_no, $type, $monthly_rent) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO units (unit_no, type, monthly_rent, availability) VALUES (?, ?, ?, 'Available')");
    $stmt->bind_param("ssd", $unit_no, $type, $monthly_rent);
    $stmt->execute();
    $stmt->close();
}

// Edit unit (with tenant support)
function editUnit($id, $unit_no, $type, $monthly_rent, $availability, $tenant_id = null) {
    global $conn;

    if (empty($tenant_id)) {
        // If no tenant assigned, set current_tenant = NULL
        $stmt = $conn->prepare("UPDATE units 
                                SET unit_no = ?, type = ?, monthly_rent = ?, availability = ?, current_tenant = NULL 
                                WHERE unit_id = ?");
        $stmt->bind_param("ssdsi", $unit_no, $type, $monthly_rent, $availability, $id);
    } else {
        // Update with assigned tenant
        $stmt = $conn->prepare("UPDATE units 
                                SET unit_no = ?, type = ?, monthly_rent = ?, availability = ?, current_tenant = ? 
                                WHERE unit_id = ?");
        $stmt->bind_param("ssdsii", $unit_no, $type, $monthly_rent, $availability, $tenant_id, $id);
    }

    $stmt->execute();
    $stmt->close();
}

// Delete unit
function deleteUnit($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM units WHERE unit_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

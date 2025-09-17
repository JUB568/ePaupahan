<?php
include "conn.php";

/**
 * Load all tenants (with optional unit if linked)
 * Returns array of tenants with keys:
 *  - id, username, name, contact, status, unit
 */
function loadTenants() {
    global $conn;
    $tenants = [];

    $sql = "SELECT t.tenant_id, t.username, t.full_name, t.contact, t.status, u.unit_no
            FROM tenants t
            LEFT JOIN units u ON t.tenant_id = u.current_tenant
            ORDER BY t.tenant_id DESC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tenants[] = [
                "id" => $row["tenant_id"],
                "username" => $row["username"],
                "name" => $row["full_name"],
                "contact" => $row["contact"],
                "status" => ucfirst($row["status"]),
                "unit" => $row["unit_no"] ?? "N/A"
            ];
        }
    }

    return $tenants;
}

/**
 * Add tenant (plain text password, per request)
 * Params: full_name, username, password, contact
 */
function addTenant($full_name, $username, $password, $contact) {
    global $conn;

    // Optional: you may want to check for duplicate username before insert
    $check = $conn->prepare("SELECT COUNT(*) AS c FROM tenants WHERE username = ?");
    $check->bind_param("s", $username);
    $check->execute();
    $res = $check->get_result();
    $row = $res->fetch_assoc();
    $check->close();

    if ($row && intval($row['c']) > 0) {
        // Username already exists — handle as needed. For now, abort silently.
        return false;
    }

    $stmt = $conn->prepare("INSERT INTO tenants (username, user_password, full_name, contact, status) VALUES (?, ?, ?, ?, 'active')");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("ssss", $username, $password, $full_name, $contact);
    $stmt->execute();
    $stmt->close();

    return true;
}

/**
 * Edit tenant
 * If $password is empty or null -> do not change password.
 * Params: id, full_name, username, password, contact
 */
function editTenant($id, $full_name, $username, $password, $contact) {
    global $conn;

    if (empty($password)) {
        // Update without changing password
        $stmt = $conn->prepare("UPDATE tenants SET username = ?, full_name = ?, contact = ? WHERE tenant_id = ?");
        $stmt->bind_param("sssi", $username, $full_name, $contact, $id);
    } else {
        // Update with new password (plain text as requested)
        $stmt = $conn->prepare("UPDATE tenants SET username = ?, user_password = ?, full_name = ?, contact = ? WHERE tenant_id = ?");
        $stmt->bind_param("ssssi", $username, $password, $full_name, $contact, $id);
    }

    if ($stmt) {
        $stmt->execute();
        $stmt->close();
        return true;
    }

    return false;
}

/**
 * Delete tenant
 * Frees up any unit assigned to this tenant, then deletes tenant record
 */
function deleteTenant($id) {
    global $conn;

    // Free up unit(s) assigned to this tenant (if any)
    $stmt = $conn->prepare("UPDATE units SET availability = 'Available', current_tenant = NULL WHERE current_tenant = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    // Delete tenant
    $stmt2 = $conn->prepare("DELETE FROM tenants WHERE tenant_id = ?");
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $stmt2->close();

    return true;
}

/* --- Summary / small count helpers --- */

function countTenants() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM tenants";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return (int)$row["total"];
    }
    return 0;
}

function countUnits() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM units";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return (int)$row["total"];
    }
    return 0;
}

function countOccupiedUnits() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM units WHERE availability = 'Occupied'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return (int)$row["total"];
    }
    return 0;
}

function countAvailableUnits() {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM units WHERE availability = 'Available'";
    $result = $conn->query($sql);

    if ($result) {
        $row = $result->fetch_assoc();
        return (int)$row["total"];
    }
    return 0;
}

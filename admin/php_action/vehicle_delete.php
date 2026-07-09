<?php
require_once '../php_action/db_connect.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

// === VEHICLE DELETE ===
if (isset($_POST['vehicle_id'])) {
    $vehicleId = intval($_POST['vehicle_id']);

    // 1. Get all images linked to this vehicle
    $query = "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vehicleId AND images_type = 'vehicle' ";
    $result = mysqli_query($dbc, $query);

    // 2. Delete image files from folder
    while ($row = mysqli_fetch_assoc($result)) {
        $filePath = "../img/vehicles_images/" . $row['vehicle_image_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // 3. Delete image records from DB
    mysqli_query($dbc, "DELETE FROM vehicle_images WHERE vehicle_id = $vehicleId AND images_type = 'vehicle' ");

    // 4. Delete the vehicle itself
    mysqli_query($dbc, "DELETE FROM vehicle_info WHERE vehicle_id = $vehicleId");

    echo json_encode(['success' => true, 'message' => 'Vehicle Info and images deleted successfully']);
    exit;
}

// === PART DELETE ===
if (isset($_POST['part_id'])) {
    $partId = intval($_POST['part_id']);

    // 1. Get all images linked to this part
    $query = "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $partId AND images_type = 'part'";
    $result = mysqli_query($dbc, $query);

    // 2. Delete image files from folder
    while ($row = mysqli_fetch_assoc($result)) {
        $filePath = "../img/vehicles_images/" . $row['vehicle_image_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // 3. Delete image records from DB
    mysqli_query($dbc, "DELETE FROM vehicle_images WHERE vehicle_id = $partId AND images_type = 'part'");

    // 4. Delete the part itself
    mysqli_query($dbc, "DELETE FROM vehicle_parts WHERE part_id = $partId");

    echo json_encode(['success' => true, 'message' => 'Part Info and images deleted successfully']);
    exit;
}


// === MACHINE DELETE ===
if (isset($_POST['machine_id'])) {
    $machineId = intval($_POST['machine_id']);

    // 1. Get all images linked to this machine
    $query = "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $machineId AND images_type = 'machine' ";
    $result = mysqli_query($dbc, $query);

    // 2. Delete image files from folder
    while ($row = mysqli_fetch_assoc($result)) {
        $filePath = "../img/vehicles_images/" . $row['vehicle_image_name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    // 3. Delete image records from DB
    mysqli_query($dbc, "DELETE FROM vehicle_images WHERE vehicle_id = $machineId AND images_type = 'machine' ");

    // 4. Delete the machine itself
    mysqli_query($dbc, "DELETE FROM machines WHERE machine_id = $machineId");

    echo json_encode(['success' => true, 'message' => 'Machine Info and images deleted successfully']);
    exit;
}

echo json_encode(['success' => false, 'message' => 'Invalid request']);
exit;

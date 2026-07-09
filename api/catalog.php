<?php
require_once __DIR__ . '/bootstrap.php';

$path = '/';
if (!empty($_SERVER['PATH_INFO'])) {
    $path = $_SERVER['PATH_INFO'];
} elseif (!empty($_SERVER['REQUEST_URI'])) {
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $projectBase = '/Pickup_Export_old';
    if (strpos($requestUri, $projectBase) === 0) {
        $requestUri = substr($requestUri, strlen($projectBase));
    }

    $basePath = '/api/catalog';
    if (strpos($requestUri, $basePath) === 0) {
        $path = substr($requestUri, strlen($basePath));
    } elseif (strpos($requestUri, '/api/catalog.php') === 0) {
        $path = substr($requestUri, strlen('/api/catalog.php'));
    } else {
        $path = $requestUri;
    }
}
$segments = array_values(array_filter(explode('/', trim($path, '/'))));

if ($segments === []) {
    respondJson(200, [
        'status' => 'success',
        'message' => 'Catalog API is running.',
        'endpoints' => [
            '/api/catalog/makers',
            '/api/catalog/brands',
            '/api/catalog/types'
        ]
    ]);
}

$resource = $segments[0] ?? '';
$action = $segments[1] ?? '';

if ($resource === 'makers') {
    requireApiToken();

    $query = "SELECT m.maker_id, m.maker_name, m.maker_img, m.maker_sts, ";
    $query .= "(SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_maker = m.maker_id AND v.vehicle_status != 'sold') AS vehicle_count ";
    $query .= "FROM maker m";
    $query .= " WHERE m.maker_sts = 1";
    $query .= " ORDER BY m.maker_id ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch makers.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['maker_id'],
            'name' => $row['maker_name'],
            'status' => (int) $row['maker_sts'],
            'image' => normalizeImageUrl($row['maker_img']),
            'available_vehicle_count' => (int) $row['vehicle_count'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'brands') {
    requireApiToken();

    $query = "SELECT b.brand_id, b.brand_name, b.brand_status, b.brand_m3, b.maker_id ";
    $query .= "(SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_brand = b.brand_id AND v.vehicle_status != 'sold') AS vehicle_count";
    $query .= " FROM brands b LEFT JOIN maker m ON m.maker_id = b.maker_id";
    $query .= " WHERE b.brand_status = 1";
    $query .= " ORDER BY b.brand_id ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch brands.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['brand_id'],
            'name' => $row['brand_name'],
            'status' => (int) $row['brand_status'],
            'm3' => $row['brand_m3'],
            'maker_id' => (int) $row['maker_id'],
            'available_vehicle_count' => (int) $row['vehicle_count'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'types') {
    requireApiToken();

    $query = "SELECT bt.body_type_id, bt.body_type_name, bt.body_type_img, bt.body_type_sts, ";
    $query .= "(SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_type = bt.body_type_id AND v.vehicle_status != 'sold') AS vehicle_count ";
    $query .= "FROM body_type bt";
    $query .= " WHERE bt.body_type_sts = 1";
    $query .= " ORDER BY bt.body_type_id ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch body types.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['body_type_id'],
            'name' => $row['body_type_name'],
            'status' => (int) $row['body_type_sts'],
            'image' => normalizeImageUrl($row['body_type_img']),
            'available_vehicle_count' => (int) $row['vehicle_count'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}



// Filters endpoint for advanced search UI
if ($resource === 'filters') {
    requireApiToken();

    // Makers
    $makers = [];
    $mq = mysqli_query($dbc, "SELECT m.maker_id, m.maker_name, m.maker_img, m.maker_sts, (SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_maker = m.maker_id AND v.vehicle_status != 'sold') AS vehicle_count FROM maker m WHERE m.maker_sts = 1 ORDER BY m.maker_name ASC");
    while ($r = mysqli_fetch_assoc($mq)) {
        $makers[] = [
            'id' => (int) $r['maker_id'],
            'name' => $r['maker_name'],
            'image' => normalizeImageUrl($r['maker_img']),
            'available_vehicle_count' => (int) $r['vehicle_count'],
        ];
    }

    // Brands
    $brands = [];
    $bq = mysqli_query($dbc, "SELECT b.brand_id, b.brand_name, b.brand_status, b.brand_m3, b.maker_id, m.maker_name, (SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_brand = b.brand_id AND v.vehicle_status != 'sold') AS vehicle_count FROM brands b LEFT JOIN maker m ON m.maker_id = b.maker_id WHERE b.brand_status = 1 ORDER BY b.brand_name ASC");
    while ($r = mysqli_fetch_assoc($bq)) {
        $brands[] = [
            'id' => (int) $r['brand_id'],
            'name' => $r['brand_name'],
            'maker_id' => (int) $r['maker_id'],
            'available_vehicle_count' => (int) $r['vehicle_count'],
        ];
    }

    // Types
    $types = [];
    $tq = mysqli_query($dbc, "SELECT bt.body_type_id, bt.body_type_name, bt.body_type_img, bt.body_type_sts, (SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_type = bt.body_type_id AND v.vehicle_status != 'sold') AS vehicle_count FROM body_type bt WHERE bt.body_type_sts = 1 ORDER BY bt.body_type_name ASC");
    while ($r = mysqli_fetch_assoc($tq)) {
        $types[] = [
            'id' => (int) $r['body_type_id'],
            'name' => $r['body_type_name'],
            'image' => normalizeImageUrl($r['body_type_img']),
            'available_vehicle_count' => (int) $r['vehicle_count'],
        ];
    }
    // Colors (from vehicle_info distinct)
    $colors = [];
    $cq = mysqli_query($dbc, "SELECT color_code_id,color_name,color_code_name_code FROM color_code WHERE color_code_sts = '1' ORDER BY color_name ASC");
    while ($r = mysqli_fetch_assoc($cq))
        $colors[] = ['name' => $r['color_name'], 'code' => $r['color_code_name_code']];

    // Transmissions
    $transmissions = [];
    $tq2 = mysqli_query($dbc, "SELECT transmission_id ,	transmission_name FROM transmission WHERE transmission_sts = '1' ORDER BY 	transmission_name  ASC");
    while ($r = mysqli_fetch_assoc($tq2))
        $transmissions[] = ['id' => (int) $r['transmission_id'], 'name' => $r['transmission_name']];

    // Fuel types
    $fuels = [];
    $fq = mysqli_query($dbc, "SELECT fuel_id, fuel_name FROM fuel WHERE fuel_sts = 1 ORDER BY fuel_name ASC");
    while ($r = mysqli_fetch_assoc($fq))
        $fuels[] = ['id' => (int) $r['fuel_id'], 'name' => $r['fuel_name']];

    $cc_range = [];
    $c_range = mysqli_query($dbc, "SELECT cc_id, cc_name FROM cc WHERE cc_sts = 1 ORDER BY cc_name ASC");
    while ($r = mysqli_fetch_assoc($c_range))
        $cc_range[] = ['id' => (int) $r['cc_id'], 'name' => $r['cc_name']];

    // Driven
    $driven = [];
    $dv = mysqli_query($dbc, "SELECT drive_id, drive_name FROM drive WHERE drive_sts = 1 ORDER BY drive_name ASC");
    while ($r = mysqli_fetch_assoc($dv))
        $driven[] = ['id' => (int) $r['drive_id'], 'name' => $r['drive_name']];

    // steering
    $steering = [];
    $st = mysqli_query($dbc, "SELECT option_id, option_name FROM options WHERE option_sts = 1 ORDER BY option_name ASC");
    while ($r = mysqli_fetch_assoc($st))
        $steering[] = ['id' => (int) $r['option_id'], 'name' => $r['option_name']];


    // features
    $features = [];
    $fte = mysqli_query($dbc, "SELECT vehicle_feature_id, vehicle_feature_name FROM vehicle_feature WHERE vehicle_feature_sts = 1 ORDER BY vehicle_feature_name ASC");
    while ($r = mysqli_fetch_assoc($fte))
        $features[] = ['id' => (int) $r['vehicle_feature_id'], 'name' => $r['vehicle_feature_name']];

    respondJson(200, [
        'status' => 'success',
        'makers' => $makers,
        'brands' => $brands,
        'body_types' => $types,
        'colors' => $colors,
        'transmissions' => $transmissions,
        'fuels' => $fuels,
        'cc_range' => $cc_range,
        'driven' => $driven,
        'steering' => $steering,
        'features' => $features
    ]);
}

if ($resource === 'search') {
    requireApiToken();

    $conditions = ["vehicle_status != ''"];
    $params = $_GET;

    $escape = fn($value) => mysqli_real_escape_string($dbc, trim((string) $value));

    if (!empty($params['maker']) && $params['maker'] !== 'null' && $params['maker'] !== '0') {
        $conditions[] = 'vehicle_maker = ' . (int) $params['maker'];
    }
    if (!empty($params['brands']) && $params['brands'] !== 'null') {
        $conditions[] = 'vehicle_brand = ' . (int) $params['brands'];
    }
    if (!empty($params['min_year']) && $params['min_year'] !== 'null' && !empty($params['max_year']) && $params['max_year'] !== 'null') {
        $conditions[] = 'vehicle_manu_year BETWEEN ' . (int) $params['min_year'] . ' AND ' . (int) $params['max_year'];
    } elseif (!empty($params['min_year']) && $params['min_year'] !== 'null') {
        $conditions[] = 'vehicle_manu_year >= ' . (int) $params['min_year'];
    } elseif (!empty($params['max_year']) && $params['max_year'] !== 'null') {
        $conditions[] = 'vehicle_manu_year <= ' . (int) $params['max_year'];
    }
    if (!empty($params['from_engine']) && $params['from_engine'] !== 'null' && !empty($params['to_engine']) && $params['to_engine'] !== 'null') {
        $conditions[] = 'vehicle_cc BETWEEN ' . (int) $params['from_engine'] . ' AND ' . (int) $params['to_engine'];
    } elseif (!empty($params['from_engine']) && $params['from_engine'] !== 'null') {
        $conditions[] = 'vehicle_cc >= ' . (int) $params['from_engine'];
    } elseif (!empty($params['to_engine']) && $params['to_engine'] !== 'null') {
        $conditions[] = 'vehicle_cc <= ' . (int) $params['to_engine'];
    }
    if (!empty($params['from_km']) && $params['from_km'] !== 'null' && !empty($params['to_km']) && $params['to_km'] !== 'null') {
        $conditions[] = 'vehicle_km BETWEEN ' . (int) $params['from_km'] . ' AND ' . (int) $params['to_km'];
    } elseif (!empty($params['from_km']) && $params['from_km'] !== 'null') {
        $conditions[] = 'vehicle_km >= ' . (int) $params['from_km'];
    } elseif (!empty($params['to_km']) && $params['to_km'] !== 'null') {
        $conditions[] = 'vehicle_km <= ' . (int) $params['to_km'];
    }
    if (!empty($params['color']) && $params['color'] !== 'null') {
        $color = $escape($params['color']);
        $conditions[] = "(vehicle_color_name = '$color' OR vehicle_color = '$color')";
    }
    if (!empty($params['body_type']) && $params['body_type'] !== 'null') {
        $conditions[] = 'vehicle_type = ' . (int) $params['body_type'];
    }
    if (!empty($params['options']) && $params['options'] !== 'null') {
        $conditions[] = "vehicle_option = '" . $escape($params['options']) . "'";
    }
    if (!empty($params['steering']) && $params['steering'] !== 'null') {
        $conditions[] = "vehicle_option = '" . $escape($params['steering']) . "'";
    }
    if (!empty($params['driven']) && $params['driven'] !== 'null') {
        $conditions[] = "vehicle_drive = '" . $escape($params['driven']) . "'";
    }
    if (!empty($params['lot_number'])) {
        $conditions[] = "lot_number = '" . $escape($params['lot_number']) . "'";
    }
    if (!empty($params['fuel_type']) && $params['fuel_type'] !== 'null') {
        $conditions[] = "vehicle_fuel = '" . $escape($params['fuel_type']) . "'";
    }
    $featureNames = [];
    if (isset($params['features']) && $params['features'] !== 'null') {
        $featureNames = is_array($params['features']) ? $params['features'] : array_filter(array_map('trim', explode(',', $params['features'])));
    }
    if (isset($params['feature']) && $params['feature'] !== 'null') {
        $featureNames[] = trim($params['feature']);
    }
    foreach ($featureNames as $featureName) {
        if ($featureName === '' || strtolower($featureName) === 'null') {
            continue;
        }
        $jsonFeature = json_encode(trim($featureName));
        $conditions[] = "JSON_CONTAINS(vehicle_feature_list, '$jsonFeature')";
    }
    if (!empty($params['transmission']) && $params['transmission'] !== 'null') {
        $conditions[] = "vehicle_transmission = '" . $escape($params['transmission']) . "'";
    }
    if (!empty($params['stockid']) && $params['stockid'] !== 'null') {
        $conditions[] = "vehicle_stock_id = '" . $escape($params['stockid']) . "'";
    }
    if (!empty($params['from_date']) && !empty($params['to_date'])) {
        $fromDate = $escape($params['from_date']);
        $toDate = $escape($params['to_date']);
        $conditions[] = "buying_date BETWEEN '$fromDate' AND '$toDate'";
    }

    $where = implode(' ', array_map(fn($c) => 'AND ' . $c, $conditions));
    $limit = isset($params['limit']) ? max(1, min(1000, (int) $params['limit'])) : 100;
    $offset = isset($params['offset']) ? max(0, (int) $params['offset']) : 0;

    $countSql = "SELECT COUNT(*) AS total FROM vehicle_info WHERE " . substr($where, 4);
    $countResult = mysqli_query($dbc, $countSql);
    $total = 0;
    if ($countResult) {
        $countRow = mysqli_fetch_assoc($countResult);
        $total = (int) $countRow['total'];
    }

    $sql = "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name FROM vehicle_info vi " .
        "LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id " .
        "LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id " .
        "LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id " .
        "WHERE " . substr($where, 4) . " ORDER BY vi.vehicle_id DESC LIMIT $limit OFFSET $offset";

    $result = mysqli_query($dbc, $sql);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch filtered vehicles.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $vehicles = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $vehicleId = (int) $row['vehicle_id'];
        $image = null;
        $imgResult = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vehicleId ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
        if ($imgResult && ($imgRow = mysqli_fetch_assoc($imgResult))) {
            $image = normalizeImageUrl($imgRow['vehicle_image_name']);
        }
        $featureList = [];
        if (!empty($row['vehicle_feature_list'])) {
            $decodedFeatures = json_decode($row['vehicle_feature_list'], true);
            if (is_array($decodedFeatures)) {
                $featureList = $decodedFeatures;
            }
        }

        $vehicles[] = [
            'id' => $vehicleId,
            'stock_id' => $row['vehicle_stock_id'] ?? null,
            'maker_name' => $row['maker_name'] ?? null,
            'brand_name' => $row['brand_name'] ?? null,
            'type_name' => $row['body_type_name'] ?? null,
            'chassis_no' => $row['vehicle_chassis_no'] ?? null,
            'engine_no' => $row['vehicle_engine_no'] ?? null,
            'year' => $row['vehicle_manu_year'] ?? null,
            'registration_year' => $row['vehicle_reg_year'] ?? null,
            'mileage' => $row['vehicle_km'] ?? null,
            'cc' => $row['vehicle_cc'] ?? $row['vehicle_engine_type'] ?? null,
            'fuel' => $row['vehicle_fuel'] ?? null,
            'transmission' => $row['vehicle_transmission'] ?? null,
            'color' => $row['vehicle_color_name'] ?: $row['vehicle_color'] ?? null,
            'seats' => $row['vehicle_seat'] ?? null,
            'doors' => $row['vehicle_doors'] ?? null,
            'option' => $row['vehicle_option'] ?? null,
            'driven' => $row['vehicle_drive'] ?? null,
            'steering' => $row['vehicle_option'] ?? null,
            'price' => isset($row['vehicle_est_price']) ? (float) $row['vehicle_est_price'] : null,
            'discount' => isset($row['vehicle_discount']) ? (float) $row['vehicle_discount'] : null,
            'vehicle_feature_list' => $featureList,
            'image' => $image,
            'status' => $row['vehicle_status'] ?? null,
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'total' => $total,
        'limit' => $limit,
        'offset' => $offset,
        'count' => count($vehicles),
        'vehicles' => $vehicles,
    ]);
}

respondJson(404, [
    'status' => 'error',
    'message' => 'Endpoint not found.'
]);

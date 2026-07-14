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
            '/api/catalog/types',
            '/api/catalog/body-types',
            '/api/catalog/fuels',
            '/api/catalog/machine-types',
            '/api/catalog/steering',
            '/api/catalog/transmissions',
            '/api/catalog/locations',
            '/api/catalog/colors',
            '/api/catalog/driven',
            '/api/catalog/cc-range',
            '/api/catalog/features'
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

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $makerId = null;
    if (!empty($params['make_id']) && $params['make_id'] !== 'null' && $params['make_id'] !== '0') {
        $makerId = (int) $params['make_id'];
    } elseif (!empty($params['maker_id']) && $params['maker_id'] !== 'null' && $params['maker_id'] !== '0') {
        $makerId = (int) $params['maker_id'];
    }

    $query = "SELECT b.brand_id, b.brand_name, b.brand_status, b.brand_m3, b.maker_id, ";
    $query .= "(SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_brand = b.brand_id AND v.vehicle_status != 'sold') AS vehicle_count";
    $query .= " FROM brands b LEFT JOIN maker m ON m.maker_id = b.maker_id";
    $query .= " WHERE b.brand_status = 1";
    if ($makerId !== null) {
        $query .= " AND b.maker_id = " . mysqli_real_escape_string($dbc, (string) $makerId);
    }
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
            'maker_id' => (int) $row['maker_id'],
            'available_vehicle_count' => (int) $row['vehicle_count'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'brands' => $items,
        'data' => $items
    ]);
}

if ($resource === 'fuels' || $resource === 'fuel_types') {
    requireApiToken();

    $query = "SELECT fuel_id, fuel_name, fuel_sts FROM fuel";
    $query .= " WHERE fuel_sts = 1";
    $query .= " ORDER BY fuel_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch fuels.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['fuel_id'],
            'name' => $row['fuel_name'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'machine-types' || $resource === 'machine_types') {
    requireApiToken();

    $query = "SELECT mt.machine_type_id, mt.machine_type_name, mt.machine_type_img, mt.machine_type_sts, ";
    $query .= "(SELECT COUNT(*) FROM machines m WHERE m.machine_type = mt.machine_type_id AND m.machine_sts = 1 AND (m.machine_sale_stts IS NULL OR m.machine_sale_stts != 'sold')) AS machine_count ";
    $query .= "FROM machine_type mt";
    $query .= " WHERE mt.machine_type_sts = 1";
    $query .= " ORDER BY mt.machine_type_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch machine types.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['machine_type_id'],
            'name' => $row['machine_type_name'],
            'image' => normalizeImageUrl($row['machine_type_img']),
            'available_vehicle_count' => (int) $row['machine_count'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'types' || $resource === 'body-types' || $resource === 'body_types') {
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

if ($resource === 'steering' || $resource === 'steerings' || $resource === 'options') {
    requireApiToken();

    $query = "SELECT option_id, option_name, option_sts FROM options";
    $query .= " WHERE option_sts = 1";
    $query .= " ORDER BY option_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch steering options.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['option_id'],
            'name' => $row['option_name'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'transmissions' || $resource === 'transmission') {
    requireApiToken();

    $query = "SELECT transmission_id, transmission_name, transmission_sts FROM transmission";
    $query .= " WHERE transmission_sts = 1";
    $query .= " ORDER BY transmission_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch transmissions.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['transmission_id'],
            'name' => $row['transmission_name'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'locations' || $resource === 'location' || $resource === 'countries') {
    requireApiToken();

    $query = "SELECT c.country_id, c.country_name, c.image, ";
    $query .= "(SELECT COUNT(*) FROM vehicle_info v WHERE v.country_id = c.country_id AND v.vehicle_status != 'sold') AS vehicle_count ";
    $query .= "FROM countries c";
    $query .= " ORDER BY c.country_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch locations.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['country_id'],
            'name' => $row['country_name'],
            'image' => $row['image'],
            'available_vehicle_count' => (int) $row['vehicle_count'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'colors' || $resource === 'color') {
    requireApiToken();

    $query = "SELECT color_code_id, color_name, color_code_name_code, color_code_sts FROM color_code";
    $query .= " WHERE color_code_sts = 1";
    $query .= " ORDER BY color_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch colors.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['color_code_id'],
            'name' => $row['color_name'],
            'code' => $row['color_code_name_code'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'driven' || $resource === 'drive' || $resource === 'drives') {
    requireApiToken();

    $query = "SELECT drive_id, drive_name, drive_sts FROM drive";
    $query .= " WHERE drive_sts = 1";
    $query .= " ORDER BY drive_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch driven options.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['drive_id'],
            'name' => $row['drive_name'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'cc-range' || $resource === 'cc_range' || $resource === 'ccrange' || $resource === 'cc') {
    requireApiToken();

    $query = "SELECT cc_id, cc_name, cc_sts FROM cc";
    $query .= " WHERE cc_sts = 1";
    $query .= " ORDER BY cc_id ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch cc range options.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['cc_id'],
            'name' => $row['cc_name'],
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'features' || $resource === 'feature' || $resource === 'vehicle-features') {
    requireApiToken();

    $query = "SELECT vehicle_feature_id, vehicle_feature_name, vehicle_feature_sts FROM vehicle_feature";
    $query .= " WHERE vehicle_feature_sts = 1";
    $query .= " ORDER BY vehicle_feature_name ASC";

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch vehicle features.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $items[] = [
            'id' => (int) $row['vehicle_feature_id'],
            'name' => $row['vehicle_feature_name'],
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

    // Type
    $types = [];

    $query = mysqli_query($dbc, "SELECT (SELECT COUNT(*) FROM vehicle_info WHERE vehicle_status != 'sold' AND vehicle_sts = 1) AS car_count,
        (SELECT COUNT(*) FROM machines WHERE machine_sts = 1 AND (machine_sale_stts IS NULL OR machine_sale_stts != 'sold')) AS machine_count");

    if ($row = mysqli_fetch_assoc($query)) {
        $types = [
            [
                'id' => 1,
                'name' => 'car',
                'image' => normalizeImageUrl('images/types/car.png'),
                'available_vehicle_count' => (int) $row['car_count']
            ],
            [
                'id' => 2,
                'name' => 'machine',
                'image' => normalizeImageUrl('images/types/machine.png'),
                'available_vehicle_count' => (int) $row['machine_count']   // consistent key name
            ]
        ];
    }

    // codes
    $codes = [];

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
    $body_types = [];
    $tq = mysqli_query($dbc, "SELECT bt.body_type_id, bt.body_type_name, bt.body_type_img, bt.body_type_sts, (SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_type = bt.body_type_id AND v.vehicle_status != 'sold') AS vehicle_count FROM body_type bt WHERE bt.body_type_sts = 1 ORDER BY bt.body_type_name ASC");
    while ($r = mysqli_fetch_assoc($tq)) {
        $body_types[] = [
            'id' => (int) $r['body_type_id'],
            'name' => $r['body_type_name'],
            'image' => normalizeImageUrl($r['body_type_img']),
            'available_vehicle_count' => (int) $r['vehicle_count'],
        ];
    }

    // Machine Types
    $machine_types = [];

    $tq = mysqli_query($dbc, "SELECT mt.machine_type_id, mt.machine_type_name, mt.machine_type_img, mt.machine_type_sts, (SELECT COUNT(*) 
         FROM machines m 
         WHERE m.machine_type = mt.machine_type_id AND m.machine_sts = 1 AND (m.machine_sale_stts IS NULL OR m.machine_sale_stts != 'sold')) AS machine_count 
    FROM machine_type mt 
    WHERE mt.machine_type_sts = 1 
    ORDER BY mt.machine_type_name ASC
");

    while ($r = mysqli_fetch_assoc($tq)) {
        $machine_types[] = [
            'id' => (int) $r['machine_type_id'],
            'name' => $r['machine_type_name'],
            'image' => normalizeImageUrl($r['machine_type_img']),
            'available_vehicle_count' => (int) $r['machine_count'],
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
    $c_range = mysqli_query($dbc, "SELECT cc_id, cc_name FROM cc WHERE cc_sts = 1 ORDER BY cc_id ASC");
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

    // Locations
    $locations = [];
    $mq = mysqli_query($dbc, "SELECT c.country_id, c.country_name, c.image,  (SELECT COUNT(*) FROM vehicle_info v WHERE v.country_id = c.country_id AND v.vehicle_status != 'sold') AS vehicle_count FROM countries c ORDER BY c.country_name ASC");
    while ($r = mysqli_fetch_assoc($mq)) {
        $locations[] = [
            'id' => (int) $r['country_id'],
            'name' => $r['country_name'],
            'image' => $r['image'],
            'available_vehicle_count' => (int) $r['vehicle_count'],
        ];
    }
    // port
    $port = [];
    // features
    $features = [];
    $fte = mysqli_query($dbc, "SELECT vehicle_feature_id, vehicle_feature_name FROM vehicle_feature WHERE vehicle_feature_sts = 1 ORDER BY vehicle_feature_name ASC");
    while ($r = mysqli_fetch_assoc($fte))
        $features[] = ['id' => (int) $r['vehicle_feature_id'], 'name' => $r['vehicle_feature_name']];

    respondJson(200, [
        'status' => 'success',
        'types' => $types,
        'makers' => $makers,
        'models' => $brands,
        'codes' => $codes,
        'fuels' => $fuels,
        'machine_types' => $machine_types,
        'steering' => $steering,
        'body_types' => $body_types,
        'transmissions' => $transmissions,
        'colors' => $colors,
        'locations' => $locations,
        'port' => $port,
        'driven' => $driven,
        'cc_range' => $cc_range,
        'features' => $features
    ]);
}


// Combined API: latest vehicles + discounted vehicles grouped by maker
if ($resource === 'latest_discounted' || $resource === 'latest-discounted') {
    requireApiToken();

    // Latest vehicles (limit 6)
    $latest = [];
    $lq = mysqli_query($dbc, "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE vi.vehicle_status != 'sold' ORDER BY vi.vehicle_id DESC LIMIT 6");
    if ($lq) {
        while ($row = mysqli_fetch_assoc($lq)) {
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
            $latest[] = [
                'id' => $vehicleId,
                'stock_id' => $row['vehicle_stock_id'] ?? null,
                'maker_name' => $row['maker_name'] ?? null,
                'brand_name' => $row['brand_name'] ?? null,
                'type_name' => $row['body_type_name'] ?? null,
                'year' => $row['vehicle_manu_year'] ?? null,
                'registration_year' => $row['vehicle_reg_year'] ?? null,
                'mileage' => $row['vehicle_km'] ?? null,
                'price' => isset($row['vehicle_est_price']) ? (float) $row['vehicle_est_price'] : null,
                'discount' => isset($row['vehicle_discount']) ? (float) $row['vehicle_discount'] : null,
                'fuel' => $row['vehicle_fuel'] ?? null,
                'driven' => $row['vehicle_drive'] ?? null,
                'vehicle_mode' => $row['vehicle_mode'] ?? null,
                'vehicle_feature_list' => $featureList,
                'featured_image' => $image,
                'status' => $row['vehicle_status'] ?? null,
            ];
        }
    }

    // Discounted vehicles grouped by maker, limit 6 per maker
    $discounted_by_maker = [];
    $mq = mysqli_query($dbc, "SELECT DISTINCT vehicle_maker FROM vehicle_info WHERE vehicle_discount > 0 AND vehicle_status != 'sold' ORDER BY vehicle_maker ASC");
    if ($mq) {
        while ($mrow = mysqli_fetch_assoc($mq)) {
            $maker_id = (int) $mrow['vehicle_maker'];
            if ($maker_id <= 0)
                continue;
            $makerInfo = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT maker_id, maker_name FROM maker WHERE maker_id = $maker_id LIMIT 1"));
            $maker_name = $makerInfo['maker_name'] ?? null;

            $vehicles = [];
            $vq = mysqli_query($dbc, "SELECT vi.*, b.brand_name, bt.body_type_name FROM vehicle_info vi LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE vi.vehicle_maker = $maker_id AND vi.vehicle_discount > 0 AND vi.vehicle_status != 'sold' ORDER BY vi.vehicle_id DESC LIMIT 6");
            if ($vq) {
                while ($row = mysqli_fetch_assoc($vq)) {
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
                        'brand_name' => $row['brand_name'] ?? null,
                        'type_name' => $row['body_type_name'] ?? null,
                        'year' => $row['vehicle_manu_year'] ?? null,
                        'registration_year' => $row['vehicle_reg_year'] ?? null,
                        'mileage' => $row['vehicle_km'] ?? null,
                        'price' => isset($row['vehicle_est_price']) ? (float) $row['vehicle_est_price'] : null,
                        'discount' => isset($row['vehicle_discount']) ? (float) $row['vehicle_discount'] : null,
                        'fuel' => $row['vehicle_fuel'] ?? null,
                        'driven' => $row['vehicle_drive'] ?? null,
                        'vehicle_mode' => $row['vehicle_mode'] ?? null,
                        'vehicle_feature_list' => $featureList,
                        'featured_image' => $image,
                        'status' => $row['vehicle_status'] ?? null,
                    ];
                }
            }

            $discounted_by_maker[] = [
                'maker_id' => $maker_id,
                'maker_name' => $maker_name,
                'vehicles' => $vehicles,
            ];
        }
    }

    respondJson(200, [
        'status' => 'success',
        'latest' => $latest,
        'discounted_by_maker' => $discounted_by_maker,
    ]);
}

// Single vehicle API: accept `vehicle_id` or `vehicle_stock_id`, return full details, all images, and up to 6 similar vehicles
if ($resource === 'vehicle' || $resource === 'single_vehicle' || $resource === 'single-vehicle') {
    requireApiToken();

    // Normalize query string to be tolerant of malformed requests
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $escape = fn($v) => mysqli_real_escape_string($dbc, trim((string) $v));

    $vehicle = null;
    if (!empty($params['id'])) {
        $vid = (int) $params['id'];
        $q = "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE vi.vehicle_id = $vid LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res)
            $vehicle = mysqli_fetch_assoc($res);
    } elseif (!empty($params['stock_id']) || !empty($params['vehicle_stock'])) {
        $stock = $escape($params['stock_id'] ?? $params['vehicle_stock']);
        $q = "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE vi.vehicle_stock_id = '$stock' LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res)
            $vehicle = mysqli_fetch_assoc($res);
    }

    if (!$vehicle) {
        respondJson(404, [
            'status' => 'error',
            'message' => 'Vehicle not found.'
        ]);
    }

    $vehicleId = (int) $vehicle['vehicle_id'];

    // images
    $images = [];
    $imgQ = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vehicleId ORDER BY vehicle_image_featured DESC, order_no ASC");
    while ($ir = mysqli_fetch_assoc($imgQ)) {
        $images[] = normalizeImageUrl($ir['vehicle_image_name']);
    }

    // build vehicle details
    $featureList = [];
    if (!empty($vehicle['vehicle_feature_list'])) {
        $decoded = json_decode($vehicle['vehicle_feature_list'], true);
        if (is_array($decoded))
            $featureList = $decoded;
    }

    $vehicleData = [
        'id' => $vehicleId,
        'stock_id' => $vehicle['vehicle_stock_id'] ?? null,
        'maker_name' => $vehicle['maker_name'] ?? null,
        'brand_name' => $vehicle['brand_name'] ?? null,
        'type_name' => $vehicle['body_type_name'] ?? null,
        'chassis_no' => $vehicle['vehicle_chassis_no'] ?? null,
        'engine_no' => $vehicle['vehicle_engine_no'] ?? null,
        'year' => $vehicle['vehicle_manu_year'] ?? null,
        'registration_year' => $vehicle['vehicle_reg_year'] ?? null,
        'mileage' => $vehicle['vehicle_km'] ?? null,
        'cc' => $vehicle['vehicle_cc'] ?? $vehicle['vehicle_engine_type'] ?? null,
        'fuel' => $vehicle['vehicle_fuel'] ?? null,
        'transmission' => $vehicle['vehicle_transmission'] ?? null,
        'color' => $vehicle['vehicle_color_name'] ?: $vehicle['vehicle_color'] ?? null,
        'seats' => $vehicle['vehicle_seat'] ?? null,
        'doors' => $vehicle['vehicle_doors'] ?? null,
        'option' => $vehicle['vehicle_option'] ?? $vehicle['machine_steering'] ?? null,
        'driven' => $vehicle['vehicle_drive'] ?? null,
        'steering' => $vehicle['vehicle_option'] ?? $vehicle['machine_steering'] ?? null,
        'vehicle_mode' => $vehicle['vehicle_mode'] ?? null,
        'price' => isset($vehicle['vehicle_est_price']) ? (float) $vehicle['vehicle_est_price'] : null,
        'discount' => isset($vehicle['vehicle_discount']) ? (float) $vehicle['vehicle_discount'] : null,
        'vehicle_feature_list' => $featureList,
        'images' => $images,
        'featured_image' => $images[0] ?? null,
        'status' => $vehicle['vehicle_status'] ?? null,
    ];

    // similar vehicles: by same maker or same brand, exclude current
    $similar = [];
    $maker_id = isset($vehicleData['maker_id']) ? (int) $vehicleData['maker_id'] : 0;
    $brand_id = isset($vehicleData['brand_id']) ? (int) $vehicleData['brand_id'] : 0;
    $whereSim = [];
    if ($maker_id > 0)
        $whereSim[] = "vi.vehicle_maker = $maker_id";
    if ($brand_id > 0)
        $whereSim[] = "vi.vehicle_brand = $brand_id";
    if (!empty($whereSim)) {
        $whereClause = implode(' OR ', $whereSim);
        $simQ = mysqli_query($dbc, "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE ( $whereClause ) AND vi.vehicle_id != $vehicleId AND vi.vehicle_status != 'sold' ORDER BY vi.vehicle_id DESC LIMIT 6");
        if ($simQ) {
            while ($row = mysqli_fetch_assoc($simQ)) {
                $vid2 = (int) $row['vehicle_id'];
                $img = null;
                $imgR = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vid2 ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
                if ($imgR && ($ir = mysqli_fetch_assoc($imgR)))
                    $img = normalizeImageUrl($ir['vehicle_image_name']);
                $similar[] = [
                    'id' => $vid2,
                    'stock_id' => $row['vehicle_stock_id'] ?? null,
                    'maker_name' => $row['maker_name'] ?? null,
                    'brand_name' => $row['brand_name'] ?? null,
                    'year' => $row['vehicle_manu_year'] ?? null,
                    'price' => isset($row['vehicle_est_price']) ? (float) $row['vehicle_est_price'] : null,
                    'discount' => isset($row['vehicle_discount']) ? (float) $row['vehicle_discount'] : null,
                    'vehicle_mode' => $row['vehicle_mode'] ?? null,
                    'featured_image' => $img,
                ];
            }
        }
    }

    // fallback: fill with latest vehicles if similar less than 6
    if (count($similar) < 6) {
        $excludeIds = array_map('intval', array_column($similar, 'id'));
        $excludeIds[] = $vehicleId;
        $excludeClause = '';
        if (!empty($excludeIds))
            $excludeClause = ' AND vi.vehicle_id NOT IN (' . implode(',', $excludeIds) . ')';
        $need = 6 - count($similar);
        $fillQ = mysqli_query($dbc, "SELECT vi.*, m.maker_name, b.brand_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id WHERE vi.vehicle_status != 'sold' $excludeClause ORDER BY vi.vehicle_id DESC LIMIT $need");
        if ($fillQ) {
            while ($row = mysqli_fetch_assoc($fillQ)) {
                $vid2 = (int) $row['vehicle_id'];
                $img = null;
                $imgR = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vid2 ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
                if ($imgR && ($ir = mysqli_fetch_assoc($imgR)))
                    $img = normalizeImageUrl($ir['vehicle_image_name']);
                $similar[] = [
                    'id' => $vid2,
                    'stock_id' => $row['vehicle_stock_id'] ?? null,
                    'maker_name' => $row['maker_name'] ?? null,
                    'brand_name' => $row['brand_name'] ?? null,
                    'year' => $row['vehicle_manu_year'] ?? null,
                    'price' => isset($row['vehicle_est_price']) ? (float) $row['vehicle_est_price'] : null,
                    'discount' => isset($row['vehicle_discount']) ? (float) $row['vehicle_discount'] : null,
                    'vehicle_mode' => $row['vehicle_mode'] ?? null,
                    'featured_image' => $img,
                ];
            }
        }
    }

    respondJson(200, [
        'status' => 'success',
        'vehicle' => $vehicleData,
        'similar' => $similar,
    ]);

}

// Download all vehicle images as ZIP by vehicle_id or vehicle_stock_id
if ($resource === 'download_vehicle_images' || $resource === 'download-vehicle-images') {
    requireApiToken();

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $escape = fn($v) => mysqli_real_escape_string($dbc, trim((string) $v));
    $vehicle = null;

    if (!empty($params['id'])) {
        $vid = (int) $params['id'];
        $q = "SELECT vehicle_id, vehicle_stock_id FROM vehicle_info WHERE vehicle_id = $vid LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res)
            $vehicle = mysqli_fetch_assoc($res);
    } elseif (!empty($params['stock_id']) || !empty($params['vehicle_stock'])) {
        $stock = $escape($params['stock_id'] ?? $params['vehicle_stock']);
        $q = "SELECT vehicle_id, vehicle_stock_id FROM vehicle_info WHERE vehicle_stock_id = '$stock' LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res)
            $vehicle = mysqli_fetch_assoc($res);
    }

    if (!$vehicle) {
        respondJson(404, [
            'status' => 'error',
            'message' => 'Vehicle not found.'
        ]);
    }

    $vehicleId = (int) $vehicle['vehicle_id'];
    $stockId = $vehicle['vehicle_stock_id'] ?? $vehicleId;

    $imageRows = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vehicleId ORDER BY vehicle_image_featured DESC, order_no ASC");
    if (!$imageRows || mysqli_num_rows($imageRows) === 0) {
        respondJson(404, [
            'status' => 'error',
            'message' => 'No images found for this vehicle.'
        ]);
    }

    $imageFiles = [];
    while ($img = mysqli_fetch_assoc($imageRows)) {
        $imageFiles[] = $img['vehicle_image_name'];
    }

    $imageDir = realpath(__DIR__ . '/../admin/img/vehicles_images');
    if (!$imageDir) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Image directory not found on server.'
        ]);
    }

    $zipPath = tempnam(sys_get_temp_dir(), 'vehicle_images_');
    $zip = new ZipArchive();
    if ($zip->open($zipPath, ZipArchive::OVERWRITE) !== true) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to create zip file.'
        ]);
    }

    foreach ($imageFiles as $imageFileName) {
        $sourcePath = $imageDir . DIRECTORY_SEPARATOR . $imageFileName;
        if (is_file($sourcePath)) {
            $zip->addFile($sourcePath, basename($sourcePath));
        }
    }

    $zip->close();

    if (!is_file($zipPath)) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Zip file creation failed.'
        ]);
    }

    $downloadName = 'vehicle_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $stockId) . '_images.zip';

    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="' . $downloadName . '"');
    header('Content-Length: ' . filesize($zipPath));
    header('Pragma: public');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Expires: 0');

    readfile($zipPath);
    unlink($zipPath);
    exit;
}

if ($resource === 'search') {
    requireApiToken();

    // Normalize query string to handle malformed client requests (e.g. extra leading '?')
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $escape = fn($value) => mysqli_real_escape_string($dbc, trim((string) $value));
    $typeParam = strtolower(trim((string) ($params['type'] ?? '')));
    $searchType = null;
    if ($typeParam === 'car' || $typeParam === '1') {
        $searchType = 'car';
    } elseif ($typeParam === 'machine' || $typeParam === '2') {
        $searchType = 'machine';
    }
    $steeringValue = null;
    if (!empty($params['options']) && $params['options'] !== 'null' && (empty($params['steering']) || $params['steering'] === 'null')) {
        $params['steering'] = $params['options'];
    }
    if (!empty($params['steering']) && $params['steering'] !== 'null') {
        $steeringValue = strtoupper(trim((string) $params['steering']));
        if ($steeringValue === '') {
            $steeringValue = null;
        }
    }
    $isCar = $searchType === 'car';
    $isMachine = $searchType === 'machine';
    $useBoth = $searchType === null;

    $vehicleConditions = ["vehicle_status != ''"];
    $machineConditions = ["machine_sts = 1", "(machine_sale_stts IS NULL OR machine_sale_stts != 'sold')"];

    $addVehicle = function ($condition) use (&$vehicleConditions) {
        $vehicleConditions[] = $condition;
    };
    $addMachine = function ($condition) use (&$machineConditions) {
        $machineConditions[] = $condition;
    };

    if (!empty($params['maker']) && $params['maker'] !== 'null' && $params['maker'] !== '0') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_maker = ' . (int) $params['maker']);
        }
        if ($isMachine || $useBoth) {
            $addMachine('machine_maker = ' . (int) $params['maker']);
        }
    }
    if (!empty($params['brands']) && $params['brands'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_brand = ' . (int) $params['brands']);
        }
        if ($isMachine || $useBoth) {
            $addMachine('machine_brand = ' . (int) $params['brands']);
        }
    }
    if (!empty($params['country_id']) && $params['country_id'] !== 'null' && $params['country_id'] !== '0') {
        if ($isCar || $useBoth) {
            $addVehicle('country_id = ' . (int) $params['country_id']);
        }
        if ($isMachine || $useBoth) {
            $addMachine('country_id = ' . (int) $params['country_id']);
        }
    }
    if (!empty($params['body_type']) && $params['body_type'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_type = ' . (int) $params['body_type']);
        }
    }
    if (!empty($params['machine_type']) && $params['machine_type'] !== 'null') {
        if ($isMachine || $useBoth) {
            $addMachine('machine_type = ' . (int) $params['machine_type']);
        }
    }
    if (!empty($params['fuel_type']) && $params['fuel_type'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle("vehicle_fuel = '" . $escape($params['fuel_type']) . "'");
        }
        if ($isMachine || $useBoth) {
            $addMachine("machine_fuel = '" . $escape($params['fuel_type']) . "'");
        }
    }
    if (!empty($params['transmission']) && $params['transmission'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle("vehicle_transmission = '" . $escape($params['transmission']) . "'");
        }
        if ($isMachine || $useBoth) {
            $addMachine("machine_transmission = '" . $escape($params['transmission']) . "'");
        }
    }
    if (!empty($params['color']) && $params['color'] !== 'null') {
        $color = $escape($params['color']);
        if ($isCar || $useBoth) {
            $addVehicle("(vehicle_color_name = '$color' OR vehicle_color = '$color')");
        }
        if ($isMachine || $useBoth) {
            $addMachine("machine_color = '$color'");
        }
    }
    if ($steeringValue !== null) {
        $steeringValueEscaped = $escape($steeringValue);
        if ($isCar || $useBoth) {
            $addVehicle("TRIM(UPPER(vehicle_option)) = '$steeringValueEscaped'");
        }
        if ($isMachine || $useBoth) {
            $addMachine("TRIM(UPPER(machine_steering)) = '$steeringValueEscaped'");
        }
    }
    if (!empty($params['driven']) && $params['driven'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle("vehicle_drive = '" . $escape($params['driven']) . "'");
        }
        if ($isMachine || $useBoth) {
            $addMachine("machine_drive = '" . $escape($params['driven']) . "'");
        }
    }
    if (!empty($params['lot_number'])) {
        $addVehicle("lot_number = '" . $escape($params['lot_number']) . "'");
    }
    if (!empty($params['stockid']) && $params['stockid'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle("vehicle_stock_id = '" . $escape($params['stockid']) . "'");
        }
        if ($isMachine || $useBoth) {
            $addMachine("machine_stock_id = '" . $escape($params['stockid']) . "'");
        }
    }
    if (!empty($params['min_year']) && $params['min_year'] !== 'null' && !empty($params['max_year']) && $params['max_year'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_manu_year BETWEEN ' . (int) $params['min_year'] . ' AND ' . (int) $params['max_year']);
        }
        if ($isMachine || $useBoth) {
            $addMachine('machine_manu_year BETWEEN ' . (int) $params['min_year'] . ' AND ' . (int) $params['max_year']);
        }
    } elseif (!empty($params['min_year']) && $params['min_year'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_manu_year >= ' . (int) $params['min_year']);
        }
        if ($isMachine || $useBoth) {
            $addMachine('machine_manu_year >= ' . (int) $params['min_year']);
        }
    } elseif (!empty($params['max_year']) && $params['max_year'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_manu_year <= ' . (int) $params['max_year']);
        }
        if ($isMachine || $useBoth) {
            $addMachine('machine_manu_year <= ' . (int) $params['max_year']);
        }
    }
    if (!empty($params['from_engine']) && $params['from_engine'] !== 'null' && !empty($params['to_engine']) && $params['to_engine'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_cc BETWEEN ' . (int) $params['from_engine'] . ' AND ' . (int) $params['to_engine']);
        }
    } elseif (!empty($params['from_engine']) && $params['from_engine'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_cc >= ' . (int) $params['from_engine']);
        }
    } elseif (!empty($params['to_engine']) && $params['to_engine'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_cc <= ' . (int) $params['to_engine']);
        }
    }
    if (!empty($params['from_km']) && $params['from_km'] !== 'null' && !empty($params['to_km']) && $params['to_km'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_km BETWEEN ' . (int) $params['from_km'] . ' AND ' . (int) $params['to_km']);
        }
    } elseif (!empty($params['from_km']) && $params['from_km'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_km >= ' . (int) $params['from_km']);
        }
    } elseif (!empty($params['to_km']) && $params['to_km'] !== 'null') {
        if ($isCar || $useBoth) {
            $addVehicle('vehicle_km <= ' . (int) $params['to_km']);
        }
    }
    if (!empty($params['from_date']) && !empty($params['to_date'])) {
        $fromDate = $escape($params['from_date']);
        $toDate = $escape($params['to_date']);
        $addVehicle("buying_date BETWEEN '$fromDate' AND '$toDate'");
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
        if ($isCar || $useBoth) {
            $addVehicle("JSON_CONTAINS(vehicle_feature_list, '$jsonFeature')");
        }
    }

    $vehicleWhere = implode(' AND ', $vehicleConditions);
    $machineWhere = implode(' AND ', $machineConditions);

    // Enforce server-side fixed page size. Frontend should send only `page` (1-based).
    $SERVER_PAGE_SIZE = 10; // change this server-side value to adjust per-page results
    $limit = $SERVER_PAGE_SIZE;
    $page = isset($params['page']) ? max(1, (int) $params['page']) : 1;
    $offset = ($page - 1) * $limit;

    if ($searchType === 'car') {
        $countSql = "SELECT COUNT(*) AS total FROM vehicle_info WHERE $vehicleWhere";
        $sql = "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_reg_year AS registration_year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS option, vi.vehicle_drive AS driven, vi.vehicle_option AS steering, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE $vehicleWhere ORDER BY vi.vehicle_id DESC LIMIT $limit OFFSET $offset";
    } elseif ($searchType === 'machine') {
        $countSql = "SELECT COUNT(*) AS total FROM machines WHERE $machineWhere";
        $sql = "SELECT m.machine_id AS item_id, 'machine' AS item_type, m.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, m.machine_serial_no AS chassis_no, m.machine_manu_year AS year, m.machine_year AS registration_year, m.machine_hours AS mileage, NULL AS cc, m.machine_fuel AS fuel, m.machine_transmission AS transmission, m.machine_color AS color, NULL AS seats, NULL AS doors, m.machine_steering AS option, m.machine_drive AS driven, m.machine_steering AS steering, m.machine_condition AS mode, m.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, m.machine_sale_stts AS status, m.country_id AS country_id FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id WHERE $machineWhere ORDER BY m.machine_id DESC LIMIT $limit OFFSET $offset";
    } else {
        $countSql = "SELECT COUNT(*) AS total FROM (SELECT vehicle_id AS item_id FROM vehicle_info WHERE $vehicleWhere UNION ALL SELECT machine_id AS item_id FROM machines WHERE $machineWhere) combined";
        $sql = "SELECT * FROM (" .
            "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_reg_year AS registration_year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS option, vi.vehicle_drive AS driven, vi.vehicle_option AS steering, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, NULL AS featured_image FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id WHERE $vehicleWhere " .
            "UNION ALL " .
            "SELECT m.machine_id AS item_id, 'machine' AS item_type, m.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, m.machine_serial_no AS chassis_no, NULL AS engine_no, m.machine_manu_year AS year, m.machine_year AS registration_year, m.machine_hours AS mileage, NULL AS cc, m.machine_fuel AS fuel, m.machine_transmission AS transmission, m.machine_color AS color, NULL AS seats, NULL AS doors, m.machine_steering AS option, m.machine_drive AS driven, m.machine_steering AS steering, m.machine_condition AS mode, m.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, m.machine_sale_stts AS status, m.country_id AS country_id, NULL AS featured_image FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id WHERE $machineWhere " .
            ") AS combined ORDER BY item_id DESC LIMIT $limit OFFSET $offset";
    }

    $countResult = mysqli_query($dbc, $countSql);
    $total = 0;
    if ($countResult) {
        $countRow = mysqli_fetch_assoc($countResult);
        $total = (int) $countRow['total'];
    }

    $total_pages = $limit > 0 ? (int) ceil($total / $limit) : 0;
    $current_page = $page;
    $has_next = ($offset + $limit) < $total;
    $has_prev = $page > 1;
    $next_page = $has_next ? $current_page + 1 : null;
    $prev_page = $has_prev ? $current_page - 1 : null;

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
        $itemId = (int) $row['item_id'];
        $image = null;
        if ($row['item_type'] === 'machine') {
            $imgResult = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId AND images_type = 'machine' ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
        } else {
            $imgResult = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
        }
        if ($imgResult && ($imgRow = mysqli_fetch_assoc($imgResult))) {
            $image = normalizeImageUrl($imgRow['vehicle_image_name']);
        }

        $featureList = [];
        if (!empty($row['feature_list'])) {
            $decodedFeatures = json_decode($row['feature_list'], true);
            if (is_array($decodedFeatures)) {
                $featureList = $decodedFeatures;
            }
        }

        $vehicles[] = [
            'id' => $itemId,
            'type' => $row['item_type'],
            'stock_id' => $row['stock_id'] ?? null,
            'maker_name' => $row['maker_name'] ?? null,
            'brand_name' => $row['brand_name'] ?? null,
            'type_name' => $row['type_name'] ?? null,
            'chassis_no' => $row['chassis_no'] ?? null,
            'engine_no' => $row['engine_no'] ?? null,
            'year' => $row['year'] ?? null,
            'registration_year' => $row['registration_year'] ?? null,
            'mileage' => $row['mileage'] ?? null,
            'cc' => $row['cc'] ?? null,
            'fuel' => $row['fuel'] ?? null,
            'transmission' => $row['transmission'] ?? null,
            'color' => $row['color'] ?? null,
            'seats' => $row['seats'] ?? null,
            'doors' => $row['doors'] ?? null,
            'option' => $row['option'] ?? null,
            'driven' => $row['driven'] ?? null,
            'steering' => $row['steering'] ?? null,
            'mode' => $row['mode'] ?? null,
            'price' => isset($row['price']) ? (float) $row['price'] : null,
            'discount' => isset($row['discount']) ? (float) $row['discount'] : null,
            'vehicle_feature_list' => $featureList,
            'featured_image' => $image,
            'status' => $row['status'] ?? null,
            'country_id' => isset($row['country_id']) ? (int) $row['country_id'] : null,
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'total' => $total,
        'page' => $current_page,
        'total_pages' => $total_pages,
        'has_next' => $has_next,
        'has_prev' => $has_prev,
        'next_page' => $next_page,
        'prev_page' => $prev_page,
        'count' => count($vehicles),
        'vehicles' => $vehicles,
    ]);
}

respondJson(404, [
    'status' => 'error',
    'message' => 'Endpoint not found.'
]);

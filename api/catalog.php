<?php
require_once __DIR__ . '/bootstrap.php';

function resolveCatalogPath(): string
{
    if (!empty($_SERVER['PATH_INFO'])) {
        return (string) $_SERVER['PATH_INFO'];
    }

    if (empty($_SERVER['REQUEST_URI'])) {
        return '/';
    }

    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($requestUri === null || $requestUri === '') {
        return '/';
    }

    $baseCandidates = [
        '/api/catalog',
        '/api/catalog.php',
        '/Pickup_Export_old/api/catalog',
        '/Pickup_Export_old/api/catalog.php',
        '/Pickup_Export_php/api/catalog',
        '/Pickup_Export_php/api/catalog.php',
    ];

    foreach ($baseCandidates as $basePath) {
        if (strpos($requestUri, $basePath) === 0) {
            $suffix = substr($requestUri, strlen($basePath));
            return $suffix === '' ? '/' : $suffix;
        }
    }

    if (preg_match('#/api(?:/catalog)?(?:\.php)?/?(.*)$#', $requestUri, $matches)) {
        return '/' . ltrim($matches[1], '/');
    }

    return $requestUri;
}

$path = resolveCatalogPath();
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
            '/api/catalog/features',
            '/api/catalog/sliders',
            '/api/catalog/vertical-sliders'
        ]
    ]);
}

$resource = $segments[0] ?? '';
$action = $segments[1] ?? '';

if ($resource === 'makers') {
    requireApiToken();

    $items = cache_remember('makers:v2', 60, function () use ($dbc) {
        $query = "SELECT m.maker_id, m.maker_name, m.maker_img, m.maker_sts, ";
        $query .= "((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_maker = m.maker_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_maker = m.maker_id AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count ";
        $query .= "FROM maker m";
        $query .= " WHERE m.maker_sts = 1";
        $query .= " HAVING item_count > 0";
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
                'available_vehicle_count' => (int) $row['item_count'],
            ];
        }
        return $items;
    });

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

    $cacheKey = 'brands:v2:' . ($makerId ?? 'all');
    $items = cache_remember($cacheKey, 60, function () use ($dbc, $makerId) {
        $query = "SELECT b.brand_id, b.brand_name, b.brand_status, b.brand_m3, b.maker_id, ";
        $query .= "((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_brand = b.brand_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_brand = b.brand_id AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count";
        $query .= " FROM brands b LEFT JOIN maker m ON m.maker_id = b.maker_id";
        $query .= " WHERE b.brand_status = 1";
        if ($makerId !== null) {
            $query .= " AND b.maker_id = " . mysqli_real_escape_string($dbc, (string) $makerId);
        }
        $query .= " HAVING item_count > 0";
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
                'available_vehicle_count' => (int) $row['item_count'],
            ];
        }
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'brands' => $items,
        'data' => $items
    ]);
}

if ($resource === 'fuels' || $resource === 'fuel_types') {
    requireApiToken();

    $items = cache_remember('fuels', 60, function () use ($dbc) {
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'machine-types' || $resource === 'machine_types') {
    requireApiToken();

    $items = cache_remember('machine-types', 60, function () use ($dbc) {
        $query = "SELECT mt.machine_type_id, mt.machine_type_name, mt.machine_type_img, mt.machine_type_sts, ";
        $query .= "(SELECT COUNT(*) FROM machines m WHERE m.machine_type = mt.machine_type_id AND m.machine_sts = 1 AND (m.machine_sale_stts IS NULL OR m.machine_sale_stts != 'sold')) AS machine_count ";
        $query .= "FROM machine_type mt";
        $query .= " WHERE mt.machine_type_sts = 1";
        $query .= " HAVING machine_count > 0";
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'types' || $resource === 'body-types' || $resource === 'body_types') {
    requireApiToken();

    $items = cache_remember('body-types', 60, function () use ($dbc) {
        $query = "SELECT bt.body_type_id, bt.body_type_name, bt.body_type_img, bt.body_type_sts, ";
        $query .= "(SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_type = bt.body_type_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) AS vehicle_count ";
        $query .= "FROM body_type bt";
        $query .= " WHERE bt.body_type_sts = 1";
        $query .= " HAVING vehicle_count > 0";
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'steering' || $resource === 'steerings' || $resource === 'options') {
    requireApiToken();

    $items = cache_remember('steering', 60, function () use ($dbc) {
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'transmissions' || $resource === 'transmission') {
    requireApiToken();

    $items = cache_remember('transmissions', 60, function () use ($dbc) {
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'locations' || $resource === 'location' || $resource === 'countries') {
    requireApiToken();

    $items = cache_remember('locations:v2', 60, function () use ($dbc) {
        $query = "SELECT c.country_id, c.country_name, c.image, ";
        $query .= "((SELECT COUNT(*) FROM vehicle_info v WHERE v.country_id = c.country_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.country_id = c.country_id AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count ";
        $query .= "FROM countries c";
        $query .= " HAVING item_count > 0";
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
                'available_vehicle_count' => (int) $row['item_count'],
            ];
        }
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'colors' || $resource === 'color') {
    requireApiToken();

    $items = cache_remember('colors', 60, function () use ($dbc) {
        $query = "SELECT cc.color_code_id, cc.color_name, cc.color_code_name_code, cc.color_code_sts, ";
        $query .= "((SELECT COUNT(*) FROM vehicle_info v WHERE (v.vehicle_color_name = cc.color_name OR v.vehicle_color = cc.color_name) AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + ";
        $query .= "(SELECT COUNT(*) FROM machines mch WHERE mch.machine_color = cc.color_name AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count ";
        $query .= "FROM color_code cc";
        $query .= " WHERE cc.color_code_sts = 1";
        $query .= " HAVING item_count > 0";
        $query .= " ORDER BY cc.color_name ASC";

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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'driven' || $resource === 'drive' || $resource === 'drives') {
    requireApiToken();

    $items = cache_remember('driven', 60, function () use ($dbc) {
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'cc-range' || $resource === 'cc_range' || $resource === 'ccrange' || $resource === 'cc') {
    requireApiToken();

    $items = cache_remember('cc-range', 60, function () use ($dbc) {
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'features' || $resource === 'feature' || $resource === 'vehicle-features') {
    requireApiToken();

    $items = cache_remember('features', 60, function () use ($dbc) {
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
        return $items;
    });

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'sliders' || $resource === 'slider' || $resource === 'slides' || $resource === 'slider-images' || $resource === 'slider_img') {
    requireApiToken();

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $onlyActive = !isset($params['all']) || $params['all'] !== '1';
    $limit = isset($params['limit']) && is_numeric($params['limit']) ? (int) $params['limit'] : 0;

    $query = "SELECT slider_img_id, slider_img, slider_img_heading, slider_img_desc, slider_img_sts, slider_img_type FROM slider_img";

    $query .= " WHERE slider_img_sts = 1";

    $query .= " AND (slider_img_type = 'horizontal' OR slider_img_type = '')";

    $query .= " ORDER BY slider_img_id ASC";
    if ($limit > 0) {
        $query .= " LIMIT " . (int) $limit;
    }

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch slider images.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $imgName = trim((string) $row['slider_img']);
        $imgUrl = normalizeImageUrl($imgName);
        if ($imgUrl === null && $imgName !== '') {
            $imgUrl = '/admin/img/slider/' . ltrim($imgName, '/');
        }

        $items[] = [
            'id' => (int) $row['slider_img_id'],
            'image' => $imgUrl,
            'type' => $row['slider_img_type'] ?? 'horizontal'
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($items),
        'data' => $items
    ]);
}

if ($resource === 'vertical-sliders') {
    requireApiToken();

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $onlyActive = !isset($params['all']) || $params['all'] !== '1';
    $limit = isset($params['limit']) && is_numeric($params['limit']) ? (int) $params['limit'] : 0;

    $query = "SELECT slider_img_id, slider_img, slider_img_heading, slider_img_desc, slider_img_sts FROM slider_img";

    $query .= " WHERE slider_img_sts = 1";

    $query .= " AND slider_img_type = 'vertical'";

    $query .= " ORDER BY slider_img_id ASC";
    if ($limit > 0) {
        $query .= " LIMIT " . (int) $limit;
    }

    $result = mysqli_query($dbc, $query);
    if (!$result) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to fetch vertical slider images.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $imgName = trim((string) $row['slider_img']);
        $imgUrl = normalizeImageUrl($imgName);
        if ($imgUrl === null && $imgName !== '') {
            $imgUrl = '/admin/img/slider/' . ltrim($imgName, '/');
        }

        $items[] = [
            'id' => (int) $row['slider_img_id'],
            'image' => $imgUrl,
            'heading' => $row['slider_img_heading'] ?? '',
            'description' => $row['slider_img_desc'] ?? ''
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

    $filterData = cache_remember('filters', 60, function () use ($dbc) {
        // Type
        $types = [];

        $query = mysqli_query($dbc, "SELECT (SELECT COUNT(*) FROM vehicle_info WHERE (vehicle_sale_stts IS NULL OR vehicle_sale_stts != 'sold') AND vehicle_sts = 1) AS car_count,
            (SELECT COUNT(*) FROM machines WHERE machine_sts = 1 AND (machine_sale_stts IS NULL OR machine_sale_stts != 'sold')) AS machine_count");

        if ($row = mysqli_fetch_assoc($query)) {
            $carCount = (int) $row['car_count'];
            $machineCount = (int) $row['machine_count'];
            if ($carCount > 0) {
                $types[] = [
                    'id' => 1,
                    'name' => 'car',
                    'image' => normalizeImageUrl('images/types/car.png'),
                    'available_vehicle_count' => $carCount
                ];
            }
            if ($machineCount > 0) {
                $types[] = [
                    'id' => 2,
                    'name' => 'machine',
                    'image' => normalizeImageUrl('images/types/machine.png'),
                    'available_vehicle_count' => $machineCount
                ];
            }
        }

        $codes = [];

        // Makers
        $makers = [];
        $mq = mysqli_query($dbc, "SELECT m.maker_id, m.maker_name, m.maker_img, m.maker_sts, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_maker = m.maker_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_maker = m.maker_id AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS vehicle_count FROM maker m WHERE m.maker_sts = 1 HAVING vehicle_count > 0 ORDER BY m.maker_name ASC");
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
        $bq = mysqli_query($dbc, "SELECT b.brand_id, b.brand_name, b.brand_status, b.brand_m3, b.maker_id, m.maker_name, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_brand = b.brand_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_brand = b.brand_id AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS vehicle_count FROM brands b LEFT JOIN maker m ON m.maker_id = b.maker_id WHERE b.brand_status = 1 HAVING vehicle_count > 0 ORDER BY b.brand_name ASC");
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
        $tq = mysqli_query($dbc, "SELECT bt.body_type_id, bt.body_type_name, bt.body_type_img, bt.body_type_sts, (SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_type = bt.body_type_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) AS vehicle_count FROM body_type bt WHERE bt.body_type_sts = 1 HAVING vehicle_count > 0 ORDER BY bt.body_type_name ASC");
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
        HAVING machine_count > 0
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
        $cq = mysqli_query($dbc, "SELECT cc.color_code_id, cc.color_name, cc.color_code_name_code, ((SELECT COUNT(*) FROM vehicle_info v WHERE (v.vehicle_color_name = cc.color_name OR v.vehicle_color = cc.color_name) AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_color = cc.color_name AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count FROM color_code cc WHERE cc.color_code_sts = '1' HAVING item_count > 0 ORDER BY cc.color_name ASC");
        while ($r = mysqli_fetch_assoc($cq))
            $colors[] = ['name' => $r['color_name'], 'code' => $r['color_code_name_code']];

        // Transmissions
        $transmissions = [];
        $tq2 = mysqli_query($dbc, "SELECT t.transmission_id, t.transmission_name, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_transmission = t.transmission_name AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_transmission = t.transmission_name AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count FROM transmission t WHERE t.transmission_sts = '1' HAVING item_count > 0 ORDER BY t.transmission_name ASC");
        while ($r = mysqli_fetch_assoc($tq2))
            $transmissions[] = ['id' => (int) $r['transmission_id'], 'name' => $r['transmission_name']];

        // Fuel types
        $fuels = [];
        $fq = mysqli_query($dbc, "SELECT f.fuel_id, f.fuel_name, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_fuel = f.fuel_name AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_fuel = f.fuel_name AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count FROM fuel f WHERE f.fuel_sts = 1 HAVING item_count > 0 ORDER BY f.fuel_name ASC");
        while ($r = mysqli_fetch_assoc($fq))
            $fuels[] = ['id' => (int) $r['fuel_id'], 'name' => $r['fuel_name']];

        $cc_range = [];
        $c_range = mysqli_query($dbc, "SELECT c.cc_id, c.cc_name, (SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_cc = c.cc_name AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) AS item_count FROM cc c WHERE c.cc_sts = 1 HAVING item_count > 0 ORDER BY c.cc_id ASC");
        while ($r = mysqli_fetch_assoc($c_range))
            $cc_range[] = ['id' => (int) $r['cc_id'], 'name' => $r['cc_name']];

        // Driven
        $driven = [];
        $dv = mysqli_query($dbc, "SELECT d.drive_id, d.drive_name, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_drive = d.drive_name AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_drive = d.drive_name AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count FROM drive d WHERE d.drive_sts = 1 HAVING item_count > 0 ORDER BY d.drive_name ASC");
        while ($r = mysqli_fetch_assoc($dv))
            $driven[] = ['id' => (int) $r['drive_id'], 'name' => $r['drive_name']];

        // steering
        $steering = [];
        $st = mysqli_query($dbc, "SELECT o.option_id, o.option_name, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.vehicle_option = o.option_name AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.machine_steering = o.option_name AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS item_count FROM options o WHERE o.option_sts = 1 HAVING item_count > 0 ORDER BY o.option_name ASC");
        while ($r = mysqli_fetch_assoc($st))
            $steering[] = ['id' => (int) $r['option_id'], 'name' => $r['option_name']];

        // Locations
        $locations = [];
        $mq = mysqli_query($dbc, "SELECT c.country_id, c.country_name, c.image, ((SELECT COUNT(*) FROM vehicle_info v WHERE v.country_id = c.country_id AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) + (SELECT COUNT(*) FROM machines mch WHERE mch.country_id = c.country_id AND mch.machine_sts = 1 AND (mch.machine_sale_stts IS NULL OR mch.machine_sale_stts != 'sold'))) AS vehicle_count FROM countries c HAVING vehicle_count > 0 ORDER BY c.country_name ASC");
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
        $fte = mysqli_query($dbc, "SELECT vf.vehicle_feature_id, vf.vehicle_feature_name, (SELECT COUNT(*) FROM vehicle_info v WHERE JSON_CONTAINS(v.vehicle_feature_list, CONCAT('\"', vf.vehicle_feature_name, '\"')) AND (v.vehicle_sale_stts IS NULL OR v.vehicle_sale_stts != 'sold')) AS item_count FROM vehicle_feature vf WHERE vf.vehicle_feature_sts = 1 HAVING item_count > 0 ORDER BY vf.vehicle_feature_name ASC");
        while ($r = mysqli_fetch_assoc($fte))
            $features[] = ['id' => (int) $r['vehicle_feature_id'], 'name' => $r['vehicle_feature_name']];

        return compact('types', 'makers', 'brands', 'codes', 'fuels', 'machine_types', 'steering', 'body_types', 'transmissions', 'colors', 'locations', 'port', 'driven', 'cc_range', 'features');
    });

    respondJson(200, array_merge(['status' => 'success'], $filterData));
}


// Combined API: latest vehicles and machines, grouped by country in fixed order
if ($resource === 'latest_discounted' || $resource === 'latest-discounted') {
    requireApiToken();

    $buildCombinedItem = function (array $row, string $itemType) use ($dbc): array {
        $itemId = (int) ($row['item_id'] ?? 0);
        $image = null;
        $imageQuery = "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId";
        if ($itemType === 'machine') {
            $imageQuery .= " AND images_type = 'machine'";
        } elseif ($itemType === 'part') {
            $imageQuery .= " AND images_type = 'part'";
        }
        $imageQuery .= " ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1";
        $imgResult = mysqli_query($dbc, $imageQuery);
        if ($imgResult && ($imgRow = mysqli_fetch_assoc($imgResult))) {
            $image = normalizeImageUrl($imgRow['vehicle_image_name']);
        }

        $featureList = [];
        $featureValue = $row['feature_list'] ?? $row['vehicle_feature_list'] ?? null;
        if (!empty($featureValue)) {
            $decodedFeatures = json_decode($featureValue, true);
            if (is_array($decodedFeatures)) {
                $featureList = $decodedFeatures;
            }
        }

        return [
            'id' => $itemId,
            'type' => $itemType,
            'stock_id' => $row['stock_id'] ?? null,
            'title' => ($row['maker_name'] ?? '') . ' ' . ($row['brand_name'] ?? ''),
            'year' => $row['year'] ?? null,
            'fuel' => $row['fuel'] ?? null,
            'price' => isset($row['price']) ? (float) $row['price'] : null,
            'transmission' => $row['transmission'] ?? null,
            'driven' => $row['driven'] ?? null,
            'steering' => $row['steering'] ?? null,
            'cc' => $row['cc'] ?? null,
            'vehicle_mode' => $row['vehicle_mode'] ?? null,
            'mileage' => $row['mileage'] ?? null,
            'featured_image' => $image,
            'country_id' => isset($row['country_id']) ? (int) $row['country_id'] : null,
            'country_name' => $row['country_name'] ?? null,
        ];
    };

    $fetchCountryData = function () use ($dbc): array {
        $data = [];
        $result = mysqli_query($dbc, "SELECT country_id, country_name, image FROM countries WHERE country_id IN (63, 116, 118, 138)");
        while ($row = mysqli_fetch_assoc($result)) {
            $data[(int) $row['country_id']] = [
                'country_name' => $row['country_name'],
                'image' => $row['image'],
            ];
        }
        return $data;
    };

    $LIMIT = 4;

    // Latest vehicles and machines
    $vehicleItems = [];
    $vehicleQuery = mysqli_query($dbc, "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_reg_year AS registration_year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_drive AS driven, vi.vehicle_option AS steering, vi.vehicle_mode AS vehicle_mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE (vi.vehicle_sale_stts IS NULL OR vi.vehicle_sale_stts != 'sold') ORDER BY vi.vehicle_id DESC LIMIT $LIMIT");
    if ($vehicleQuery) {
        while ($row = mysqli_fetch_assoc($vehicleQuery)) {
            $vehicleItems[] = $row;
        }
    }

    $machineItems = [];
    $machineQuery = mysqli_query($dbc, "SELECT m.machine_id AS item_id, 'machine' AS item_type, m.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, m.machine_serial_no AS chassis_no, NULL AS engine_no, m.machine_manu_year AS year, m.machine_year AS registration_year, m.machine_hours AS mileage, NULL AS cc, m.machine_fuel AS fuel, m.machine_transmission AS transmission, m.machine_color AS color, NULL AS seats, NULL AS doors, m.machine_drive AS driven, m.machine_steering AS steering, m.machine_condition AS vehicle_mode, m.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, m.machine_sale_stts AS status, m.country_id AS country_id, c.country_name FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE m.machine_sts = 1 AND (m.machine_sale_stts IS NULL OR m.machine_sale_stts != 'sold') ORDER BY m.machine_id DESC LIMIT $LIMIT");
    if ($machineQuery) {
        while ($row = mysqli_fetch_assoc($machineQuery)) {
            $machineItems[] = $row;
        }
    }

    // Interleave for latest
    $latest = [];
    $vi = 0;
    $mi = 0;
    while (count($latest) < $LIMIT && ($vi < count($vehicleItems) || $mi < count($machineItems))) {
        if ($vi < count($vehicleItems)) {
            $latest[] = $buildCombinedItem($vehicleItems[$vi++], 'car');
        }
        if (count($latest) >= $LIMIT)
            break;
        if ($mi < count($machineItems)) {
            $latest[] = $buildCombinedItem($machineItems[$mi++], 'machine');
        }
    }

    // Country data (includes flag image)
    $countryData = $fetchCountryData();

    $groupedByCountry = [];

    // Order: Thailand, Singapore, Hong Kong, Spare Parts, Japan
    $sections = [
        ['type' => 'country', 'cid' => 118, 'name' => 'THAILAND'],
        ['type' => 'country', 'cid' => 116, 'name' => 'SINGAPORE'],
        ['type' => 'country', 'cid' => 138, 'name' => 'HONGKONG'],
        ['type' => 'parts'],
        ['type' => 'country', 'cid' => 63, 'name' => 'JAPAN'],
    ];

    foreach ($sections as $sec) {
        if ($sec['type'] === 'country') {
            $cid = $sec['cid'];
            $rows = [];
            $vq = mysqli_query($dbc, "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_reg_year AS registration_year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_drive AS driven, vi.vehicle_option AS steering, vi.vehicle_mode AS vehicle_mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE vi.country_id = $cid AND (vi.vehicle_sale_stts IS NULL OR vi.vehicle_sale_stts != 'sold') ORDER BY vi.vehicle_id DESC LIMIT $LIMIT");
            if ($vq) {
                while ($row = mysqli_fetch_assoc($vq)) {
                    $rows[] = $row;
                }
            }
            $mq = mysqli_query($dbc, "SELECT m.machine_id AS item_id, 'machine' AS item_type, m.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, m.machine_serial_no AS chassis_no, NULL AS engine_no, m.machine_manu_year AS year, m.machine_year AS registration_year, m.machine_hours AS mileage, NULL AS cc, m.machine_fuel AS fuel, m.machine_transmission AS transmission, m.machine_color AS color, NULL AS seats, NULL AS doors, m.machine_drive AS driven, m.machine_steering AS steering, m.machine_condition AS vehicle_mode, m.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, m.machine_sale_stts AS status, m.country_id AS country_id, c.country_name FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE m.country_id = $cid AND m.machine_sts = 1 AND (m.machine_sale_stts IS NULL OR m.machine_sale_stts != 'sold') ORDER BY m.machine_id DESC LIMIT $LIMIT");
            if ($mq) {
                while ($row = mysqli_fetch_assoc($mq)) {
                    $rows[] = $row;
                }
            }

            usort($rows, fn($a, $b) => (int) ($b['item_id'] ?? 0) - (int) ($a['item_id'] ?? 0));
            $countryItems = [];
            foreach (array_slice($rows, 0, $LIMIT) as $row) {
                $countryItems[] = $buildCombinedItem($row, $row['item_type']);
            }

            $countryInfo = $countryData[$cid] ?? [];
            $groupedByCountry[] = [
                'country_id' => $cid,
                'country_name' => $sec['name'],
                'image' => $countryInfo['image'] ?? null,
                'vehicles' => $countryItems,
            ];
        } else {
            // Spare parts
            $partsItems = [];
            $partsSql = "SELECT vp.part_id AS item_id, 'part' AS item_type, vp.part_stock_id AS stock_id, m.maker_name, b.brand_name, NULL AS type_name, vp.part_chassis_no AS chassis_no, vp.part_no AS engine_no, vp.part_manu_year AS year, vp.part_year AS registration_year, vp.part_km AS mileage, vp.part_cc AS cc, vp.part_fuel AS fuel, vp.part_transmission AS transmission, vp.part_color AS color, NULL AS seats, NULL AS doors, NULL AS driven, vp.part_steering AS steering, NULL AS vehicle_mode, vp.part_fob_price AS price, NULL AS discount, NULL AS feature_list, vp.part_sale_stts AS status, NULL AS country_id, NULL AS country_name FROM vehicle_parts vp LEFT JOIN maker m ON vp.part_maker = m.maker_id LEFT JOIN brands b ON vp.part_brand = b.brand_id WHERE vp.part_sts = 1 ORDER BY vp.part_id DESC LIMIT $LIMIT";
            $partsResult = mysqli_query($dbc, $partsSql);
            if ($partsResult) {
                while ($row = mysqli_fetch_assoc($partsResult)) {
                    $partsItems[] = $buildCombinedItem($row, 'part');
                }
            }

            $groupedByCountry[] = [
                'country_id' => null,
                'country_name' => 'SPARE PARTS',
                'image' => null,
                'vehicles' => $partsItems,
            ];
        }
    }

    respondJson(200, [
        'status' => 'success',
        'count' => count($latest),
        'latest' => $latest,
        'grouped_by_country' => $groupedByCountry,
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

    $item = null;
    $itemType = null;

    $stock = null;
    if (!empty($params['stock_id'])) {
        $stock = $params['stock_id'];
    } elseif (!empty($params['vehicle_stock'])) {
        $stock = $params['vehicle_stock'];
    } elseif (!empty($params['stockid'])) {
        $stock = $params['stockid'];
    }

    if (!empty($params['id'])) {
        $vid = (int) $params['id'];
        $q = "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE vi.vehicle_id = $vid LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            $item = mysqli_fetch_assoc($res);
            $itemType = 'vehicle';
        } else {
            $q = "SELECT m.*, maker.maker_name, b.brand_name, mt.machine_type_name, c.country_name FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE m.machine_id = $vid LIMIT 1";
            $res = mysqli_query($dbc, $q);
            if ($res && mysqli_num_rows($res) > 0) {
                $item = mysqli_fetch_assoc($res);
                $itemType = 'machine';
            }
        }
    }

    if ($item === null && $stock !== null) {
        $stock = $escape($stock);
        $q = "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE vi.vehicle_stock_id = '$stock' LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res && mysqli_num_rows($res) > 0) {
            $item = mysqli_fetch_assoc($res);
            $itemType = 'vehicle';
        } else {
            $q = "SELECT m.*, maker.maker_name, b.brand_name, mt.machine_type_name, c.country_name FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE m.machine_stock_id = '$stock' LIMIT 1";
            $res = mysqli_query($dbc, $q);
            if ($res && mysqli_num_rows($res) > 0) {
                $item = mysqli_fetch_assoc($res);
                $itemType = 'machine';
            }
        }
    }

    if (!$item) {
        respondJson(404, [
            'status' => 'error',
            'message' => 'Item not found.'
        ]);
    }

    $images = [];
    if ($itemType === 'machine') {
        $itemId = (int) $item['machine_id'];
        $imgQ = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId AND images_type = 'machine' ORDER BY vehicle_image_featured DESC, order_no ASC");
    } else {
        $itemId = (int) $item['vehicle_id'];
        $imgQ = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId ORDER BY vehicle_image_featured DESC, order_no ASC");
    }
    while ($ir = mysqli_fetch_assoc($imgQ)) {
        $images[] = normalizeImageUrl($ir['vehicle_image_name']);
    }

    if ($itemType === 'machine') {
        $itemData = [
            'id' => (int) $item['machine_id'],
            'type' => 'machine',
            'stock_id' => $item['machine_stock_id'] ?? null,
            'maker_id' => (int) ($item['machine_maker'] ?? 0),
            'brand_id' => (int) ($item['machine_brand'] ?? 0),
            'title' => $item['maker_name'] . " " . $item['brand_name'] ?? null,
            'maker_name' => $item['maker_name'] ?? null,
            'brand_name' => $item['brand_name'] ?? null,
            'type_name' => $item['machine_type_name'] ?? null,
            'chassis_no' => $item['machine_serial_no'] ?? null,
            'engine_no' => null,
            'year' => $item['machine_manu_year'] ?? null,
            'registration_year' => $item['machine_year'] ?? null,
            'mileage' => $item['machine_hours'] ?? null,
            'cc' => null,
            'fuel' => $item['machine_fuel'] ?? null,
            'transmission' => $item['machine_transmission'] ?? null,
            'color' => $item['machine_color'] ?? null,
            'seats' => null,
            'doors' => null,
            'option' => $item['machine_steering'] ?? null,
            'driven' => $item['machine_drive'] ?? null,
            'steering' => $item['machine_steering'] ?? null,
            'vehicle_mode' => $item['machine_condition'] ?? null,
            'price' => isset($item['machine_fob_price']) ? (float) $item['machine_fob_price'] : null,
            'discount' => null,
            'vehicle_feature_list' => null,
            'vehicle_accesries' => null,
            'vehicle_url' => null,
            'images' => $images,
            'featured_image' => $images[0] ?? null,
            'status' => $item['machine_sale_stts'] ?? null,
            'country_id' => isset($item['country_id']) ? (int) $item['country_id'] : null,
            'country_name' => $item['country_name'] ?? null,
        ];
    } else {
        $featureList = [];
        if (!empty($item['vehicle_feature_list'])) {
            $decoded = json_decode($item['vehicle_feature_list'], true);
            if (is_array($decoded)) {
                $featureList = $decoded;
            }
        }
        $itemData = [
            'id' => (int) $item['vehicle_id'],
            'type' => 'vehicle',
            'stock_id' => $item['vehicle_stock_id'] ?? null,
            'maker_id' => (int) ($item['vehicle_maker'] ?? 0),
            'brand_id' => (int) ($item['vehicle_brand'] ?? 0),
            'title' => $item['maker_name'] . " " . $item['brand_name'] ?? null,
            'maker_name' => $item['maker_name'] ?? null,
            'brand_name' => $item['brand_name'] ?? null,
            'type_name' => $item['body_type_name'] ?? null,
            'chassis_no' => $item['vehicle_chassis_no'] ?? null,
            'engine_no' => $item['vehicle_engine_no'] ?? null,
            'year' => $item['vehicle_manu_year'] ?? null,
            'registration_year' => $item['vehicle_reg_year'] ?? null,
            'mileage' => $item['vehicle_km'] ?? null,
            'cc' => $item['vehicle_cc'] ?? $item['vehicle_engine_type'] ?? null,
            'fuel' => $item['vehicle_fuel'] ?? null,
            'transmission' => $item['vehicle_transmission'] ?? null,
            'color' => $item['vehicle_color_name'] ?: $item['vehicle_color'] ?? null,
            'seats' => $item['vehicle_seat'] ?? null,
            'doors' => $item['vehicle_doors'] ?? null,
            'option' => $item['vehicle_option'] ?? $item['machine_steering'] ?? null,
            'driven' => $item['vehicle_drive'] ?? null,
            'steering' => $item['vehicle_option'] ?? $item['machine_steering'] ?? null,
            'vehicle_mode' => $item['vehicle_mode'] ?? null,
            'price' => isset($item['vehicle_est_price']) ? (float) $item['vehicle_est_price'] : null,
            'discount' => isset($item['vehicle_discount']) ? (float) $item['vehicle_discount'] : null,
            'vehicle_feature_list' => $featureList,
            'vehicle_accesries' => $item['vehicle_access'] ?? null,
            'vehicle_url' => $item['vehicle_url'] ?? null,
            'images' => $images,
            'featured_image' => $images[0] ?? null,
            'status' => $item['vehicle_status'] ?? null,
            'country_id' => isset($item['country_id']) ? (int) $item['country_id'] : null,
            'country_name' => $item['country_name'] ?? null,
        ];
    }

    $similar = [];
    $maker_id = isset($itemData['maker_id']) ? (int) $itemData['maker_id'] : 0;
    $brand_id = isset($itemData['brand_id']) ? (int) $itemData['brand_id'] : 0;
    $whereSim = [];
    if ($maker_id > 0) {
        if ($itemType === 'machine') {
            $whereSim[] = "m.machine_maker = $maker_id";
        } else {
            $whereSim[] = "vi.vehicle_maker = $maker_id";
        }
    }
    if ($brand_id > 0) {
        if ($itemType === 'machine') {
            $whereSim[] = "m.machine_brand = $brand_id";
        } else {
            $whereSim[] = "vi.vehicle_brand = $brand_id";
        }
    }

    if (!empty($whereSim) && $itemType === 'vehicle') {
        $whereClause = implode(' OR ', $whereSim);
        $simQ = mysqli_query($dbc, "SELECT vi.*, m.maker_name, b.brand_name, bt.body_type_name, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE ($whereClause) AND vi.vehicle_id != " . (int) $itemData['id'] . " AND (vi.vehicle_sale_stts IS NULL OR vi.vehicle_sale_stts != 'sold') ORDER BY vi.vehicle_id DESC LIMIT 6");
        if ($simQ) {
            while ($row = mysqli_fetch_assoc($simQ)) {
                $vid2 = (int) $row['vehicle_id'];
                $img = null;
                $imgR = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vid2 ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
                if ($imgR && ($ir = mysqli_fetch_assoc($imgR))) {
                    $img = normalizeImageUrl($ir['vehicle_image_name']);
                }
                $similar[] = [
                    'id' => $vid2,
                    'type' => 'vehicle',
                    'stock_id' => $row['vehicle_stock_id'] ?? null,
                    'title' => $row['maker_name'] . " " . $row['brand_name'] ?? null,
                    'year' => $row['vehicle_manu_year'] ?? null,
                    'fuel' => $row['vehicle_fuel'] ?? null,
                    'price' => isset($row['vehicle_est_price']) ? (float) $row['vehicle_est_price'] : null,
                    'transmission' => $row['vehicle_transmission'] ?? null,
                    'driven' => $row['vehicle_drive'] ?? null,
                    'steering' => $row['vehicle_option'] ?? null,
                    'vehicle_mode' => $row['vehicle_mode'] ?? null,
                    'mileage' => $row['vehicle_km'] ?? null,
                    'featured_image' => $img,
                    'country_id' => isset($row['country_id']) ? (int) $row['country_id'] : null,
                    'country_name' => $row['country_name'] ?? null,
                ];
            }
        }
    }

    if (!empty($whereSim) && $itemType === 'machine') {
        $whereClause = implode(' OR ', $whereSim);
        $simQ = mysqli_query($dbc, "SELECT m.machine_id, m.machine_stock_id, m.machine_fob_price, m.machine_year, m.machine_manu_year, m.machine_steering, m.machine_fuel, m.machine_transmission, m.machine_drive, m.machine_condition, m.machine_hours, m.country_id, maker.maker_name, b.brand_name, c.country_name FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE ($whereClause) AND m.machine_id != " . (int) $itemData['id'] . " AND m.machine_sts = 1 AND (m.machine_sale_stts IS NULL OR m.machine_sale_stts != 'sold') ORDER BY m.machine_id DESC LIMIT 6");
        if ($simQ) {
            while ($row = mysqli_fetch_assoc($simQ)) {
                $vid2 = (int) $row['machine_id'];
                $img = null;
                $imgR = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $vid2 AND images_type = 'machine' ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
                if ($imgR && ($ir = mysqli_fetch_assoc($imgR))) {
                    $img = normalizeImageUrl($ir['vehicle_image_name']);
                }
                $similar[] = [
                    'id' => $vid2,
                    'type' => 'machine',
                    'stock_id' => $row['machine_stock_id'] ?? null,
                    'title' => $row['maker_name'] . " " . $row['brand_name'] ?? null,
                    'year' => $row['machine_manu_year'] ?? null,
                    'fuel' => $row['machine_fuel'] ?? null,
                    'price' => isset($row['machine_fob_price']) ? (float) $row['machine_fob_price'] : null,
                    'transmission' => $row['machine_transmission'] ?? null,
                    'driven' => $row['machine_drive'] ?? null,
                    'steering' => $row['machine_steering'] ?? null,
                    'vehicle_mode' => $row['machine_condition'] ?? null,
                    'mileage' => $row['machine_hours'] ?? null,
                    'featured_image' => $img,
                    'country_id' => isset($row['country_id']) ? (int) $row['country_id'] : null,
                    'country_name' => $row['country_name'] ?? null,
                ];
            }
        }
    }

    respondJson(200, [
        'status' => 'success',
        'item' => $itemData,
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

    $vehicleConditions = ["(vehicle_sale_stts IS NULL OR vehicle_sale_stts != 'sold')"];
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
    if (!empty($params['location']) && $params['location'] !== 'null' && $params['location'] !== '0') {
        $countryId = (int) $params['location'];
        if ($isCar || $useBoth) {
            $addVehicle('vi.country_id = ' . $countryId);
        }
        if ($isMachine || $useBoth) {
            $addMachine('m.country_id = ' . $countryId);
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
        $addVehicle("(buying_date IS NULL OR buying_date = '' OR buying_date BETWEEN '$fromDate' AND '$toDate')");
    } elseif (!empty($params['from_date'])) {
        $fromDate = $escape($params['from_date']);
        $addVehicle("(buying_date IS NULL OR buying_date = '' OR buying_date >= '$fromDate')");
    } elseif (!empty($params['to_date'])) {
        $toDate = $escape($params['to_date']);
        $addVehicle("(buying_date IS NULL OR buying_date = '' OR buying_date <= '$toDate')");
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
        $countSql = "SELECT COUNT(*) AS total FROM vehicle_info vi WHERE $vehicleWhere";
        $sql = "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_reg_year AS registration_year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS option, vi.vehicle_drive AS driven, vi.vehicle_option AS steering, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE $vehicleWhere ORDER BY vi.vehicle_id DESC LIMIT $limit OFFSET $offset";
    } elseif ($searchType === 'machine') {
        $countSql = "SELECT COUNT(*) AS total FROM machines m WHERE $machineWhere";
        $sql = "SELECT m.machine_id AS item_id, 'machine' AS item_type, m.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, m.machine_serial_no AS chassis_no, m.machine_manu_year AS year, m.machine_year AS registration_year, m.machine_hours AS mileage, NULL AS cc, m.machine_fuel AS fuel, m.machine_transmission AS transmission, m.machine_color AS color, NULL AS seats, NULL AS doors, m.machine_steering AS option, m.machine_drive AS driven, m.machine_steering AS steering, m.machine_condition AS mode, m.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, m.machine_sale_stts AS status, m.country_id AS country_id, c.country_name FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE $machineWhere ORDER BY m.machine_id DESC LIMIT $limit OFFSET $offset";
    } else {
        $countSql = "SELECT COUNT(*) AS total FROM (SELECT vi.vehicle_id AS item_id FROM vehicle_info vi WHERE $vehicleWhere UNION ALL SELECT m.machine_id AS item_id FROM machines m WHERE $machineWhere) combined";
        $sql = "SELECT * FROM (" .
            "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_reg_year AS registration_year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS option, vi.vehicle_drive AS driven, vi.vehicle_option AS steering, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name, NULL AS featured_image FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE $vehicleWhere " .
            "UNION ALL " .
            "SELECT m.machine_id AS item_id, 'machine' AS item_type, m.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, m.machine_serial_no AS chassis_no, NULL AS engine_no, m.machine_manu_year AS year, m.machine_year AS registration_year, m.machine_hours AS mileage, NULL AS cc, m.machine_fuel AS fuel, m.machine_transmission AS transmission, m.machine_color AS color, NULL AS seats, NULL AS doors, m.machine_steering AS option, m.machine_drive AS driven, m.machine_steering AS steering, m.machine_condition AS mode, m.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, m.machine_sale_stts AS status, m.country_id AS country_id, c.country_name, NULL AS featured_image FROM machines m LEFT JOIN maker maker ON m.machine_maker = maker.maker_id LEFT JOIN brands b ON m.machine_brand = b.brand_id LEFT JOIN machine_type mt ON m.machine_type = mt.machine_type_id LEFT JOIN countries c ON m.country_id = c.country_id WHERE $machineWhere " .
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
            'title' => $row['maker_name'] . " " . $row['brand_name'] ?? null,
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
            'country_name' => $row['country_name'] ?? null,
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

// Free-text keyword search — user types anything (stock ID, keyword, etc.)
if ($resource === 'search-text' || $resource === 'search-keyword' || $resource === 'search_free' || $resource === 'search_text') {
    requireApiToken();

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $q = trim((string) ($params['q'] ?? $params['query'] ?? $params['keyword'] ?? ''));
    if ($q === 'null') {
        $q = '';
    }

    $escape = fn($v) => mysqli_real_escape_string($dbc, trim((string) $v));
    $escapedQ = $escape($q);
    $likeQ = '%' . $escapedQ . '%';

    $typeParam = strtolower(trim((string) ($params['type'] ?? '')));
    $searchType = null;
    if ($typeParam === 'car' || $typeParam === '1') {
        $searchType = 'car';
    } elseif ($typeParam === 'machine' || $typeParam === '2') {
        $searchType = 'machine';
    }
    $isCar = $searchType === 'car';
    $isMachine = $searchType === 'machine';
    $useBoth = $searchType === null;

    $SERVER_PAGE_SIZE = 10;
    $limit = $SERVER_PAGE_SIZE;
    $page = isset($params['page']) ? max(1, (int) $params['page']) : 1;
    $offset = ($page - 1) * $limit;

    // First, try exact stock ID match (single item)
    $exactVehicle = null;
    $exactMachine = null;
    if ($isCar || $useBoth) {
        $vq = mysqli_query($dbc, "SELECT vehicle_id AS item_id, 'car' AS item_type, vehicle_stock_id AS stock_id FROM vehicle_info WHERE vehicle_stock_id = '$escapedQ' AND (vehicle_sale_stts IS NULL OR vehicle_sale_stts != 'sold') LIMIT 1");
        if ($vq) {
            $exactVehicle = mysqli_fetch_assoc($vq);
        }
    }
    if ($isMachine || $useBoth) {
        $mq = mysqli_query($dbc, "SELECT machine_id AS item_id, 'machine' AS item_type, machine_stock_id AS stock_id FROM machines WHERE machine_stock_id = '$escapedQ' LIMIT 1");
        if ($mq) {
            $exactMachine = mysqli_fetch_assoc($mq);
        }
    }
    $exactMatch = $exactVehicle ?: $exactMachine;

    if ($exactMatch) {
        $itemId = (int) $exactMatch['item_id'];
        $itemType = $exactMatch['item_type'];

        $image = null;
        if ($itemType === 'machine') {
            $imgResult = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId AND images_type = 'machine' ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
        } else {
            $imgResult = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $itemId ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
        }
        if ($imgResult && ($imgRow = mysqli_fetch_assoc($imgResult))) {
            $image = normalizeImageUrl($imgRow['vehicle_image_name']);
        }

        if ($itemType === 'machine') {
            $row = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT mch.machine_id AS item_id, 'machine' AS item_type, mch.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, mch.machine_serial_no AS chassis_no, mch.machine_manu_year AS year, mch.machine_hours AS mileage, NULL AS cc, mch.machine_fuel AS fuel, mch.machine_transmission AS transmission, mch.machine_color AS color, NULL AS seats, NULL AS doors, mch.machine_steering AS steering, mch.machine_drive AS driven, mch.machine_condition AS mode, mch.machine_fob_price AS price, NULL AS discount, mch.machine_sale_stts AS status, mch.country_id AS country_id, c.country_name FROM machines mch LEFT JOIN maker maker ON mch.machine_maker = maker.maker_id LEFT JOIN brands b ON mch.machine_brand = b.brand_id LEFT JOIN machine_type mt ON mch.machine_type = mt.machine_type_id LEFT JOIN countries c ON mch.country_id = c.country_id WHERE mch.machine_id = $itemId LIMIT 1"));
        } else {
            $row = mysqli_fetch_assoc(mysqli_query($dbc, "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS steering, vi.vehicle_drive AS driven, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE vi.vehicle_id = $itemId LIMIT 1"));
        }

        if (!$row) {
            respondJson(404, ['status' => 'error', 'message' => 'Item not found.']);
        }

        $vehicles = [
            [
                'id' => (int) $row['item_id'],
                'type' => $row['item_type'],
                'stock_id' => $row['stock_id'] ?? null,
                'title' => ($row['maker_name'] ?? '') . ' ' . ($row['brand_name'] ?? ''),
                'maker_name' => $row['maker_name'] ?? null,
                'brand_name' => $row['brand_name'] ?? null,
                'type_name' => $row['type_name'] ?? null,
                'chassis_no' => $row['chassis_no'] ?? null,
                'engine_no' => $row['engine_no'] ?? null,
                'year' => $row['year'] ?? null,
                'mileage' => $row['mileage'] ?? null,
                'cc' => $row['cc'] ?? null,
                'fuel' => $row['fuel'] ?? null,
                'transmission' => $row['transmission'] ?? null,
                'color' => $row['color'] ?? null,
                'seats' => $row['seats'] ?? null,
                'doors' => $row['doors'] ?? null,
                'steering' => $row['steering'] ?? null,
                'driven' => $row['driven'] ?? null,
                'mode' => $row['mode'] ?? null,
                'price' => isset($row['price']) ? (float) $row['price'] : null,
                'discount' => isset($row['discount']) ? (float) $row['discount'] : null,
                'featured_image' => $image,
                'status' => $row['status'] ?? null,
                'country_id' => isset($row['country_id']) ? (int) $row['country_id'] : null,
                'country_name' => $row['country_name'] ?? null,
            ]
        ];

        respondJson(200, [
            'status' => 'success',
            'match_type' => 'exact',
            'query' => $q,
            'total' => 1,
            'page' => 1,
            'total_pages' => 1,
            'has_next' => false,
            'has_prev' => false,
            'next_page' => null,
            'prev_page' => null,
            'count' => 1,
            'vehicles' => $vehicles,
        ]);
    }

    // No exact stock match — do keyword search across multiple fields
    if ($q !== '') {
        $vehicleKeywordWhere = "(
            vi.vehicle_stock_id LIKE '$likeQ'
            OR vi.vehicle_chassis_no LIKE '$likeQ'
            OR vi.vehicle_engine_no LIKE '$likeQ'
            OR vi.vehicle_engine_type LIKE '$likeQ'
            OR vi.vehicle_manu_year LIKE '$likeQ'
            OR vi.vehicle_reg_year LIKE '$likeQ'
            OR m.maker_name LIKE '$likeQ'
            OR b.brand_name LIKE '$likeQ'
            OR bt.body_type_name LIKE '$likeQ'
            OR vi.vehicle_fuel LIKE '$likeQ'
            OR vi.vehicle_transmission LIKE '$likeQ'
            OR vi.vehicle_drive LIKE '$likeQ'
            OR vi.vehicle_option LIKE '$likeQ'
            OR vi.vehicle_color LIKE '$likeQ'
            OR vi.vehicle_color_name LIKE '$likeQ'
            OR vi.vehicle_interior_color LIKE '$likeQ'
            OR vi.vehicle_mode LIKE '$likeQ'
            OR vi.vehicle_note LIKE '$likeQ'
            OR vi.vehicle_note_comp LIKE '$likeQ'
            OR vi.vehicle_cc LIKE '$likeQ'
            OR vi.vehicle_grade LIKE '$likeQ'
            OR vi.vehicle_km LIKE '$likeQ'
            OR vi.vehicle_package LIKE '$likeQ'
            OR vi.vehicle_chassis_code LIKE '$likeQ'
            OR vi.vehicle_auctionhouse LIKE '$likeQ'
            OR vi.auction_sheet LIKE '$likeQ'
            OR vi.lot_number LIKE '$likeQ'
            OR c.country_name LIKE '$likeQ'
        )";
        $machineKeywordWhere = "(
            mch.machine_stock_id LIKE '$likeQ'
            OR mch.machine_serial_no LIKE '$likeQ'
            OR maker.maker_name LIKE '$likeQ'
            OR b.brand_name LIKE '$likeQ'
            OR mt.machine_type_name LIKE '$likeQ'
            OR mch.machine_fuel LIKE '$likeQ'
            OR mch.machine_transmission LIKE '$likeQ'
            OR mch.machine_drive LIKE '$likeQ'
            OR mch.machine_steering LIKE '$likeQ'
            OR mch.machine_color LIKE '$likeQ'
            OR mch.machine_note LIKE '$likeQ'
            OR mch.machine_condition LIKE '$likeQ'
            OR mch.machine_manu_year LIKE '$likeQ'
            OR mch.machine_year LIKE '$likeQ'
            OR mch.machine_hours LIKE '$likeQ'
            OR mch.machine_weight LIKE '$likeQ'
            OR c.country_name LIKE '$likeQ'
        )";
    } else {
        $vehicleKeywordWhere = '1=1';
        $machineKeywordWhere = '1=1';
    }

    $vehicleWhere = "(vehicle_sale_stts IS NULL OR vehicle_sale_stts != 'sold') AND $vehicleKeywordWhere";
    $machineWhere = "(machine_sts = 1 AND (machine_sale_stts IS NULL OR machine_sale_stts != 'sold')) AND $machineKeywordWhere";

    if ($searchType === 'car') {
        $countSql = "SELECT COUNT(*) AS total FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE $vehicleWhere";
        $sql = "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS steering, vi.vehicle_drive AS driven, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE $vehicleWhere ORDER BY vi.vehicle_id DESC LIMIT $limit OFFSET $offset";
    } elseif ($searchType === 'machine') {
        $countSql = "SELECT COUNT(*) AS total FROM machines mch LEFT JOIN maker maker ON mch.machine_maker = maker.maker_id LEFT JOIN brands b ON mch.machine_brand = b.brand_id LEFT JOIN machine_type mt ON mch.machine_type = mt.machine_type_id LEFT JOIN countries c ON mch.country_id = c.country_id WHERE $machineWhere";
        $sql = "SELECT mch.machine_id AS item_id, 'machine' AS item_type, mch.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, mch.machine_serial_no AS chassis_no, mch.machine_manu_year AS year, mch.machine_hours AS mileage, NULL AS cc, mch.machine_fuel AS fuel, mch.machine_transmission AS transmission, mch.machine_color AS color, NULL AS seats, NULL AS doors, mch.machine_steering AS steering, mch.machine_drive AS driven, mch.machine_condition AS mode, mch.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, mch.machine_sale_stts AS status, mch.country_id AS country_id, c.country_name FROM machines mch LEFT JOIN maker maker ON mch.machine_maker = maker.maker_id LEFT JOIN brands b ON mch.machine_brand = b.brand_id LEFT JOIN machine_type mt ON mch.machine_type = mt.machine_type_id LEFT JOIN countries c ON mch.country_id = c.country_id WHERE $machineWhere ORDER BY mch.machine_id DESC LIMIT $limit OFFSET $offset";
    } else {
        $countSql = "SELECT COUNT(*) AS total FROM (SELECT vi.vehicle_id AS item_id FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE $vehicleWhere UNION ALL SELECT mch.machine_id AS item_id FROM machines mch LEFT JOIN maker maker ON mch.machine_maker = maker.maker_id LEFT JOIN brands b ON mch.machine_brand = b.brand_id LEFT JOIN machine_type mt ON mch.machine_type = mt.machine_type_id LEFT JOIN countries c ON mch.country_id = c.country_id WHERE $machineWhere) combined";
        $sql = "SELECT * FROM (" .
            "SELECT vi.vehicle_id AS item_id, 'car' AS item_type, vi.vehicle_stock_id AS stock_id, m.maker_name, b.brand_name, bt.body_type_name AS type_name, vi.vehicle_chassis_no AS chassis_no, vi.vehicle_engine_no AS engine_no, vi.vehicle_manu_year AS year, vi.vehicle_km AS mileage, vi.vehicle_cc AS cc, vi.vehicle_fuel AS fuel, vi.vehicle_transmission AS transmission, COALESCE(vi.vehicle_color_name, vi.vehicle_color) AS color, vi.vehicle_seat AS seats, vi.vehicle_door AS doors, vi.vehicle_option AS steering, vi.vehicle_drive AS driven, vi.vehicle_mode AS mode, vi.vehicle_est_price AS price, vi.vehicle_discount AS discount, vi.vehicle_feature_list AS feature_list, vi.vehicle_status AS status, vi.country_id AS country_id, c.country_name FROM vehicle_info vi LEFT JOIN maker m ON vi.vehicle_maker = m.maker_id LEFT JOIN brands b ON vi.vehicle_brand = b.brand_id LEFT JOIN body_type bt ON vi.vehicle_type = bt.body_type_id LEFT JOIN countries c ON vi.country_id = c.country_id WHERE $vehicleWhere " .
            "UNION ALL " .
            "SELECT mch.machine_id AS item_id, 'machine' AS item_type, mch.machine_stock_id AS stock_id, maker.maker_name, b.brand_name, mt.machine_type_name AS type_name, mch.machine_serial_no AS chassis_no, NULL AS engine_no, mch.machine_manu_year AS year, mch.machine_hours AS mileage, NULL AS cc, mch.machine_fuel AS fuel, mch.machine_transmission AS transmission, mch.machine_color AS color, NULL AS seats, NULL AS doors, mch.machine_steering AS steering, mch.machine_drive AS driven, mch.machine_condition AS mode, mch.machine_fob_price AS price, NULL AS discount, NULL AS feature_list, mch.machine_sale_stts AS status, mch.country_id AS country_id, c.country_name FROM machines mch LEFT JOIN maker maker ON mch.machine_maker = maker.maker_id LEFT JOIN brands b ON mch.machine_brand = b.brand_id LEFT JOIN machine_type mt ON mch.machine_type = mt.machine_type_id LEFT JOIN countries c ON mch.country_id = c.country_id WHERE $machineWhere " .
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
            'message' => 'Failed to execute search.',
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

        $vehicles[] = [
            'id' => $itemId,
            'type' => $row['item_type'],
            'stock_id' => $row['stock_id'] ?? null,
            'title' => ($row['maker_name'] ?? '') . ' ' . ($row['brand_name'] ?? ''),
            'maker_name' => $row['maker_name'] ?? null,
            'brand_name' => $row['brand_name'] ?? null,
            'type_name' => $row['type_name'] ?? null,
            'chassis_no' => $row['chassis_no'] ?? null,
            'engine_no' => $row['engine_no'] ?? null,
            'year' => $row['year'] ?? null,
            'mileage' => $row['mileage'] ?? null,
            'cc' => $row['cc'] ?? null,
            'fuel' => $row['fuel'] ?? null,
            'transmission' => $row['transmission'] ?? null,
            'color' => $row['color'] ?? null,
            'steering' => $row['steering'] ?? null,
            'driven' => $row['driven'] ?? null,
            'mode' => $row['mode'] ?? null,
            'price' => isset($row['price']) ? (float) $row['price'] : null,
            'discount' => isset($row['discount']) ? (float) $row['discount'] : null,
            'featured_image' => $image,
            'status' => $row['status'] ?? null,
            'country_id' => isset($row['country_id']) ? (int) $row['country_id'] : null,
            'country_name' => $row['country_name'] ?? null,
        ];
    }

    respondJson(200, [
        'status' => 'success',
        'match_type' => 'keyword',
        'query' => $q,
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

if ($resource === 'search-parts') {
    requireApiToken();

    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $makerId = null;
    if (!empty($params['maker']) && $params['maker'] !== 'null' && $params['maker'] !== '0') {
        $makerId = (int) $params['maker'];
    } elseif (!empty($params['make']) && $params['make'] !== 'null' && $params['make'] !== '0') {
        $makerId = (int) $params['make'];
    } elseif (!empty($params['maker_id']) && $params['maker_id'] !== 'null' && $params['maker_id'] !== '0') {
        $makerId = (int) $params['maker_id'];
    }

    $brandId = null;
    if (!empty($params['brands']) && $params['brands'] !== 'null' && $params['brands'] !== '0') {
        $brandId = (int) $params['brands'];
    } elseif (!empty($params['brand']) && $params['brand'] !== 'null' && $params['brand'] !== '0') {
        $brandId = (int) $params['brand'];
    } elseif (!empty($params['brand_id']) && $params['brand_id'] !== 'null' && $params['brand_id'] !== '0') {
        $brandId = (int) $params['brand_id'];
    }

    $conditions = ['vp.part_sts = 1'];
    if ($makerId !== null) {
        $conditions[] = 'vp.part_maker = ' . $makerId;
    }
    if ($brandId !== null) {
        $conditions[] = 'vp.part_brand = ' . $brandId;
    }
    $whereClause = implode(' AND ', $conditions);

    $SERVER_PAGE_SIZE = 10;
    $limit = $SERVER_PAGE_SIZE;
    $page = isset($params['page']) ? max(1, (int) $params['page']) : 1;
    $offset = ($page - 1) * $limit;

    $countSql = "SELECT COUNT(*) AS total FROM vehicle_parts vp WHERE $whereClause";
    $sql = "SELECT vp.*, m.maker_name, b.brand_name FROM vehicle_parts vp " .
        "LEFT JOIN maker m ON vp.part_maker = m.maker_id " .
        "LEFT JOIN brands b ON vp.part_brand = b.brand_id " .
        "WHERE $whereClause " .
        "ORDER BY vp.part_id DESC LIMIT $limit OFFSET $offset";

    $countResult = mysqli_query($dbc, $countSql);
    if (!$countResult) {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to count parts.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $countRow = mysqli_fetch_assoc($countResult);
    $total = (int) $countRow['total'];
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
            'message' => 'Failed to fetch parts.',
            'details' => mysqli_error($dbc)
        ]);
    }

    $parts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $partId = (int) $row['part_id'];
        $image = null;
        $imgQuery = "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $partId AND images_type = 'part' ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1";
        $imgResult = mysqli_query($dbc, $imgQuery);
        if ($imgResult && ($imgRow = mysqli_fetch_assoc($imgResult))) {
            $image = normalizeImageUrl($imgRow['vehicle_image_name']);
        }

        $parts[] = [
            'id' => $partId,
            'stock_id' => $row['part_stock_id'] ?? null,
            'maker_name' => $row['maker_name'] ?? null,
            'brand_name' => $row['brand_name'] ?? null,

            'part_color' => $row['part_color'] ?? null,
            'part_year' => $row['part_year'] ?? null,
            'part_manu_year' => $row['part_manu_year'] ?? null,
            'part_package' => $row['part_package'] ?? null,
            'part_fob_price' => isset($row['part_fob_price']) ? (float) $row['part_fob_price'] : null,
            'part_note' => $row['part_note'] ?? null,
            'part_condition_remarks' => $row['part_condition_remarks'] ?? null,
            'featured_image' => $image,
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
        'count' => count($parts),
        'parts' => $parts,
    ]);
}

if ($resource === 'part' || $resource === 'single_part' || $resource === 'single-part') {
    requireApiToken();

    // Normalize query string to be tolerant of malformed requests
    $qs = $_SERVER['QUERY_STRING'] ?? '';
    $qs = ltrim($qs, '?');
    parse_str($qs, $params);

    $escape = fn($v) => mysqli_real_escape_string($dbc, trim((string) $v));

    $part = null;
    if (!empty($params['part_id'])) {
        $partId = (int) $params['part_id'];
        $q = "SELECT vp.*, m.maker_name, b.brand_name FROM vehicle_parts vp LEFT JOIN maker m ON vp.part_maker = m.maker_id LEFT JOIN brands b ON vp.part_brand = b.brand_id WHERE vp.part_id = $partId LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res) {
            $part = mysqli_fetch_assoc($res);
        }
    } elseif (!empty($params['id'])) {
        $partId = (int) $params['id'];
        $q = "SELECT vp.*, m.maker_name, b.brand_name FROM vehicle_parts vp LEFT JOIN maker m ON vp.part_maker = m.maker_id LEFT JOIN brands b ON vp.part_brand = b.brand_id WHERE vp.part_id = $partId LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res) {
            $part = mysqli_fetch_assoc($res);
        }
    } elseif (!empty($params['part_stock_id']) || !empty($params['stock_id'])) {
        $stock = $escape($params['part_stock_id'] ?? $params['stock_id']);
        $q = "SELECT vp.*, m.maker_name, b.brand_name FROM vehicle_parts vp LEFT JOIN maker m ON vp.part_maker = m.maker_id LEFT JOIN brands b ON vp.part_brand = b.brand_id WHERE vp.part_stock_id = '$stock' LIMIT 1";
        $res = mysqli_query($dbc, $q);
        if ($res) {
            $part = mysqli_fetch_assoc($res);
        }
    }

    if (!$part) {
        respondJson(404, [
            'status' => 'error',
            'message' => 'Part not found.'
        ]);
    }

    $partId = (int) $part['part_id'];

    $images = [];
    $imgQ = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = $partId AND images_type = 'part' ORDER BY vehicle_image_featured DESC, order_no ASC");
    while ($ir = mysqli_fetch_assoc($imgQ)) {
        $images[] = normalizeImageUrl($ir['vehicle_image_name']);
    }

    $partData = [
        'id' => $partId,
        'stock_id' => $part['part_stock_id'] ?? null,
        'type' => 'part',
        'maker_name' => $part['maker_name'] ?? null,
        'brand_name' => $part['brand_name'] ?? null,
        'chassis_no' => $part['part_chassis_no'] ?? null,
        'part_no' => $part['part_no'] ?? null,
        'part_cc' => $part['part_cc'] ?? null,
        'part_color' => $part['part_color'] ?? null,
        'part_year' => $part['part_year'] ?? null,
        'part_manu_year' => $part['part_manu_year'] ?? null,
        'part_package' => $part['part_package'] ?? null,
        'part_fob_price' => isset($part['part_fob_price']) ? (float) $part['part_fob_price'] : null,
        'part_transmission' => $part['part_transmission'] ?? null,
        'part_steering' => $part['part_steering'] ?? null,
        'part_fuel' => $part['part_fuel'] ?? null,
        'part_km' => $part['part_km'] ?? null,
        'part_weight' => $part['part_weight'] ?? null,
        'part_note' => $part['part_note'] ?? null,
        'part_condition_remarks' => $part['part_condition_remarks'] ?? null,
        'status' => $part['part_sts'] ?? null,
        'created_at' => $part['part_timestamp'] ?? null,
        'images' => $images,
        'featured_image' => $images[0] ?? null,
    ];

    $similar = [];
    $similarConditions = [];
    if (!empty($part['part_maker'])) {
        $similarConditions[] = 'vp.part_maker = ' . (int) $part['part_maker'];
    }
    if (!empty($part['part_brand'])) {
        $similarConditions[] = 'vp.part_brand = ' . (int) $part['part_brand'];
    }

    if (!empty($similarConditions)) {
        $similarWhere = implode(' OR ', $similarConditions);
        $simQ = mysqli_query($dbc, "SELECT vp.part_id, vp.part_stock_id, vp.part_no, vp.part_fob_price, vp.part_year, vp.part_transmission, vp.part_steering, m.maker_name, b.brand_name FROM vehicle_parts vp LEFT JOIN maker m ON vp.part_maker = m.maker_id LEFT JOIN brands b ON vp.part_brand = b.brand_id WHERE ($similarWhere) AND vp.part_id != $partId AND vp.part_sts = 1 ORDER BY vp.part_id DESC LIMIT 6");
        if ($simQ) {
            while ($row = mysqli_fetch_assoc($simQ)) {
                $simImage = null;
                $imgR = mysqli_query($dbc, "SELECT vehicle_image_name FROM vehicle_images WHERE vehicle_id = " . (int) $row['part_id'] . " AND images_type = 'part' ORDER BY vehicle_image_featured DESC, order_no ASC LIMIT 1");
                if ($imgR && ($ir = mysqli_fetch_assoc($imgR))) {
                    $simImage = normalizeImageUrl($ir['vehicle_image_name']);
                }
                $similar[] = [
                    'id' => (int) $row['part_id'],
                    'stock_id' => $row['part_stock_id'] ?? null,
                    'maker_name' => $row['maker_name'] ?? null,
                    'brand_name' => $row['brand_name'] ?? null,
                    'part_no' => $row['part_no'] ?? null,
                    'part_fob_price' => isset($row['part_fob_price']) ? (float) $row['part_fob_price'] : null,
                    'part_year' => $row['part_year'] ?? null,
                    'part_transmission' => $row['part_transmission'] ?? null,
                    'part_steering' => $row['part_steering'] ?? null,
                    'featured_image' => $simImage,
                ];
            }
        }
    }

    respondJson(200, [
        'status' => 'success',
        'part' => $partData,
        'similar' => $similar,
    ]);
}


// POST /api/catalog/inquiry  — submit a vehicle inquiry
if ($resource === 'inquiry') {
    requireApiToken(true);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respondJson(405, [
            'status' => 'error',
            'message' => 'Method Not Allowed. Use POST.',
        ]);
    }

    // Parse body: supports application/json and application/x-www-form-urlencoded / multipart
    $body = [];
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $body = $decoded;
        }
    } else {
        $body = $_POST;
    }

    // Required field validation
    $required = [
        'fullName' => 'Full Name',
        'vehicle_id' => 'Vehicle ID',
        'email' => 'Email',
        'phoneNumber' => 'Phone Number',
        'country' => 'Country',
        'inquiry_type' => 'Inquiry Type',
        'city' => 'City'
    ];

    $missing = [];
    foreach ($required as $field => $label) {
        if (empty($body[$field])) {
            $missing[] = $label;
        }
    }
    if (!empty($missing)) {
        respondJson(422, [
            'status' => 'error',
            'message' => 'Missing required fields: ' . implode(', ', $missing),
            'fields' => $missing,
        ]);
    }

    // Validate email
    if (!filter_var(trim($body['email']), FILTER_VALIDATE_EMAIL)) {
        respondJson(422, [
            'status' => 'error',
            'message' => 'Invalid email address.',
        ]);
    }

    // Decode vehicle_id (base64-encoded on the frontend, same as legacy code)
    $vehicleId = $body['vehicle_id'];

    $data = [
        'inquiry_name' => trim($body['fullName']),
        'vehicle_id' => trim((string) $vehicleId),
        'inquiry_email' => trim($body['email']),
        'inquiry_phone' => trim($body['phoneNumber']),
        'inquiry_msg' => trim($body['message'] ?? ''),
        'inquiry_country' => trim($body['country']),
        'inquiry_city' => trim($body['city'] ?? ''),
        'inquiry_of' => trim($body['inquiry_type']),
        'inquiry_sts' => 1,
        'inquiry_services' => '',
    ];

    if (apiInsert($dbc, 'pending_inquiry', $data)) {
        respondJson(200, [
            'status' => 'success',
            'message' => 'Inquiry has been submitted successfully.',
        ]);
    } else {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to submit inquiry.',
            'details' => mysqli_error($dbc),
        ]);
    }
}

// POST /api/catalog/contact  — submit a contact form inquiry
if ($resource === 'contact') {
    requireApiToken(true);

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        respondJson(405, [
            'status' => 'error',
            'message' => 'Method Not Allowed. Use POST.',
        ]);
    }

    // Parse body: supports application/json and application/x-www-form-urlencoded / multipart
    $body = [];
    $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
    if (stripos($contentType, 'application/json') !== false) {
        $raw = file_get_contents('php://input');
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) {
            $body = $decoded;
        }
    } else {
        $body = $_POST;
    }

    // Required field validation
    $required = [
        'fullName' => 'Full Name',
        'email' => 'Email',
        'phoneNumber' => 'Phone Number',
        'subject' => 'Subject',
    ];

    $missing = [];
    foreach ($required as $field => $label) {
        if (empty($body[$field])) {
            $missing[] = $label;
        }
    }
    if (!empty($missing)) {
        respondJson(422, [
            'status' => 'error',
            'message' => 'Missing required fields: ' . implode(', ', $missing),
            'fields' => $missing,
        ]);
    }

    // Validate email
    if (!filter_var(trim($body['email']), FILTER_VALIDATE_EMAIL)) {
        respondJson(422, [
            'status' => 'error',
            'message' => 'Invalid email address.',
        ]);
    }


    $data = [
        'inquiry_name' => trim($body['fullName']),
        'vehicle_id' => 0,
        'inquiry_email' => trim($body['email']),
        'inquiry_phone' => trim($body['phoneNumber']),
        'inquiry_msg' => trim($body['message'] ?? ''),
        'inquiry_services' => trim($body['subject']),
        'inquiry_of' => 'contact',
        'inquiry_sts' => 1,
    ];

    if (apiInsert($dbc, 'pending_inquiry', $data)) {
        respondJson(200, [
            'status' => 'success',
            'message' => 'Inquiry has been submitted successfully.',
        ]);
    } else {
        respondJson(500, [
            'status' => 'error',
            'message' => 'Failed to submit inquiry.',
            'details' => mysqli_error($dbc),
        ]);
    }
}
respondJson(404, [
    'status' => 'error',
    'message' => 'Endpoint not found.'
]);

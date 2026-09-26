<?php
include_once "includes/header.php";

$message = '';
$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Fix duplicates action
if ($action === 'fix_duplicates' && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
    // Find all duplicate stock IDs
    $dupQuery = mysqli_query($dbc, "
        SELECT vehicle_stock_id, COUNT(*) as cnt 
        FROM vehicle_info 
        WHERE vehicle_stock_id IS NOT NULL AND vehicle_stock_id != '' 
        GROUP BY vehicle_stock_id 
        HAVING cnt > 1
    ");

    $fixed_count = 0;
    while ($dup = mysqli_fetch_assoc($dupQuery)) {
        $stock_id = $dup['vehicle_stock_id'];
        
        // Extract prefix if available (e.g. HPE-26)
        $prefix = 'TPE-' . date('y');
        if (preg_match('/^([A-Z]{3}-\d{2})/', $stock_id, $m)) {
            $prefix = $m[1];
        }

        // Get all vehicle records sharing this stock_id, ordered by vehicle_id ASC
        $stock_escaped = mysqli_real_escape_string($dbc, $stock_id);
        $vQuery = mysqli_query($dbc, "SELECT vehicle_id FROM vehicle_info WHERE vehicle_stock_id = '$stock_escaped' ORDER BY vehicle_id ASC");
        
        $first = true;
        while ($vRow = mysqli_fetch_assoc($vQuery)) {
            if ($first) {
                // Keep the first vehicle's stock ID as-is
                $first = false;
                continue;
            }

            // Generate a guaranteed new safe unique stock ID for the duplicate
            $new_stock_id = generateSafeVehicleStockId($dbc, $prefix);
            $new_escaped = mysqli_real_escape_string($dbc, $new_stock_id);
            $vid = (int)$vRow['vehicle_id'];

            mysqli_query($dbc, "UPDATE vehicle_info SET vehicle_stock_id = '$new_escaped' WHERE vehicle_id = $vid");
            $fixed_count++;
        }
    }

    $message = "<div class='alert alert-success font-weight-bold'>Successfully updated {$fixed_count} duplicate vehicle record(s) to new unique sequential Stock IDs!</div>";
}

// Fetch all duplicates to display
$dupCheck = mysqli_query($dbc, "
    SELECT vehicle_stock_id, COUNT(*) as cnt, GROUP_CONCAT(vehicle_id ORDER BY vehicle_id ASC) as ids 
    FROM vehicle_info 
    WHERE vehicle_stock_id IS NOT NULL AND vehicle_stock_id != '' 
    GROUP BY vehicle_stock_id 
    HAVING cnt > 1
");

$duplicate_list = [];
$total_duplicates = 0;
while ($row = mysqli_fetch_assoc($dupCheck)) {
    $duplicate_list[] = $row;
    $total_duplicates += ($row['cnt'] - 1);
}
?>

<div class="content-wrapper">
    <div class="container-fluid pt-4 pb-4">
        <div class="card shadow-sm">
            <div class="card-header card-bg text-white">
                <h4 class="m-0 font-weight-bold">Stock ID Duplicate Checker & Fix Tool</h4>
            </div>
            <div class="card-body">
                <?= $message ?>

                <?php if (empty($duplicate_list)): ?>
                    <div class="alert alert-success">
                        <h5 class="m-0"><i class="fa fa-check-circle"></i> Great! No duplicate Stock IDs were found in the database. All vehicle stock IDs are 100% unique.</h5>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">
                        <h5><i class="fa fa-exclamation-triangle"></i> Found <?= count($duplicate_list) ?> Stock ID(s) with duplicates (affecting <?= $total_duplicates ?> vehicle records).</h5>
                        <p class="mb-0">Review the duplicate records below. You can click <strong>"Auto-Fix All Duplicates"</strong> to keep the original vehicle's ID and assign new sequential unique IDs to the duplicate records.</p>
                    </div>

                    <form method="POST" action="fix_duplicate_stock_ids.php" onsubmit="return confirm('Are you sure you want to fix all duplicate stock IDs? This will assign unique sequential IDs to duplicate records.');" class="mb-4">
                        <input type="hidden" name="action" value="fix_duplicates">
                        <button type="submit" class="btn btn-danger font-weight-bold">
                            <i class="fa fa-wrench"></i> Auto-Fix All Duplicates Now
                        </button>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Duplicate Stock ID</th>
                                    <th>Duplicate Count</th>
                                    <th>Vehicle Records (Vehicle ID, Brand, Chassis No)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($duplicate_list as $item): ?>
                                    <tr>
                                        <td class="font-weight-bold text-danger font-size-16"><?= htmlspecialchars($item['vehicle_stock_id']) ?></td>
                                        <td><span class="badge badge-danger"><?= $item['cnt'] ?> vehicles</span></td>
                                        <td>
                                            <?php 
                                            $ids = explode(',', $item['ids']);
                                            foreach ($ids as $idx => $vid):
                                                $vid = (int)$vid;
                                                $vinfo = fetchRecord($dbc, "vehicle_info", "vehicle_id", $vid);
                                                $brand = @fetchRecord($dbc, "brands", "brand_id", $vinfo['vehicle_brand'])['brand_name'] ?? 'N/A';
                                            ?>
                                                <div class="p-2 mb-1 <?= $idx === 0 ? 'bg-light border-left border-success' : 'bg-light border-left border-danger' ?>">
                                                    <strong>Vehicle ID #<?= $vid ?>:</strong>
                                                    Brand: <?= htmlspecialchars($brand) ?> | 
                                                    Chassis: <?= htmlspecialchars($vinfo['vehicle_chassis_no'] ?? 'N/A') ?>
                                                    <?= $idx === 0 ? '<span class="badge badge-success ml-2">Keep Original</span>' : '<span class="badge badge-warning ml-2">Will be Reassigned</span>' ?>
                                                    <a href="trade.php?vehicle_id=<?= $vid ?>" target="_blank" class="btn btn-sm btn-outline-info ml-2">View</a>
                                                </div>
                                            <?php endforeach; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="mt-4">
                    <a href="show_trade.php" class="btn btn-secondary"><i class="fa fa-arrow-left"></i> Back to Trade List</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once "includes/footer.php"; ?>

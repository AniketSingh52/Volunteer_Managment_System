<?php include("../../../../config/connect.php"); ?>
<?php
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
// Query to get data
$sql = "WITH months AS (
    SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL 
    SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL 
    SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL 
    SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
)
SELECT 
    DATE_FORMAT(CONCAT('2024-', m.month, '-01'), '%b') AS month,
    COALESCE(volunteer_count, 0) AS volunteer_count,
    COALESCE(organization_count, 0) AS organization_count
FROM months m
LEFT JOIN (
    SELECT 
        MONTH(registration_date) AS month, 
        COUNT(CASE WHEN user_type = 'V' THEN user_id END) AS volunteer_count,
        COUNT(CASE WHEN user_type = 'O' THEN user_id END) AS organization_count
    FROM user 
    GROUP BY month
) u ON m.month = u.month
ORDER BY m.month;

";

$result = $conn->query($sql);

// Fetch data
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($data);


?>

<?php include("../../../../config/connect.php"); ?>
<?php
ob_clean(); // Cle // Return JSON response
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('display_errors', 0);
ini_set('error_log', 'error_log.txt');
// Query to get data
$sql = "
WITH months AS (
    SELECT 1 AS month UNION ALL SELECT 2 UNION ALL SELECT 3 UNION ALL 
    SELECT 4 UNION ALL SELECT 5 UNION ALL SELECT 6 UNION ALL 
    SELECT 7 UNION ALL SELECT 8 UNION ALL SELECT 9 UNION ALL 
    SELECT 10 UNION ALL SELECT 11 UNION ALL SELECT 12
)
SELECT 
    DATE_FORMAT(CONCAT('2024-', m.month, '-01'), '%b') AS month,
    COALESCE(user_count, 0) AS user_count,
    COALESCE(event_count, 0) AS event_count,
    COALESCE(post_count, 0) AS post_count
FROM months m
LEFT JOIN (
    SELECT 
        MONTH(registration_date) AS month, 
        COUNT(user_id) AS user_count
    FROM user 
    GROUP BY month
) u ON m.month = u.month
LEFT JOIN (
    SELECT 
        MONTH(date_of_creation) AS month, 
        COUNT(event_id) AS event_count
    FROM events 
    GROUP BY month
) e ON m.month = e.month
LEFT JOIN (
    SELECT 
        MONTH(upload_date) AS month, 
        COUNT(picture_id) AS post_count
    FROM pictures 
    GROUP BY month
) p ON m.month = p.month
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

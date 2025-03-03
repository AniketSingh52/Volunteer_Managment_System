<?php
include("../../../config/connect.php");
session_start();
$user_id = $_SESSION['user_id'];
?>
<?php

$sql = "SELECT 
                            u.user_id, 
                            u.name, 
                            u.user_name, 
                            u.profile_picture, 
                            m.text AS latest_message, 
                            m.date_time AS latest_message_time,
                            CASE 
                                WHEN m.from_id = ? THEN 'from' 
                                WHEN m.to_id = ? THEN 'to' 
                                ELSE NULL 
                            END AS message_direction
                        FROM user u
                        LEFT JOIN (
                            -- Get the latest message exchanged between user_id = 12 and each user
                            SELECT m1.*
                            FROM messages m1
                            INNER JOIN (
                                -- Get the latest message date per user (either sent or received by user_id 12)
                                SELECT 
                                    CASE 
                                        WHEN from_id = ? THEN to_id 
                                        ELSE from_id 
                                    END AS user_id,
                                    MAX(date_time) AS latest_time
                                FROM messages
                                WHERE from_id = ? OR to_id = ?
                                GROUP BY user_id
                            ) m2 
                            ON ((m1.from_id = ? AND m1.to_id = m2.user_id) OR (m1.to_id = ? AND m1.from_id = m2.user_id))
                            AND m1.date_time = m2.latest_time
                        ) m ON u.user_id = m.from_id OR u.user_id = m.to_id
                        WHERE u.user_id != ?
                        ORDER BY COALESCE(m.date_time, '0000-00-00 00:00:00') DESC;
                        ";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "iiiiiiii",
    $user_id,
    $user_id,
    $user_id,
    $user_id,
    $user_id,
    $user_id,
    $user_id,
    $user_id
); // "i" for integer
$stmt->execute();

// $stmt = $conn->prepare($query);
// $stmt->execute(['user_id' => $logged_in_user_id]);
// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result2 = $stmt->get_result();

if ($result2->num_rows > 0) {

    $rows = $result2->fetch_all(MYSQLI_ASSOC);
    foreach ($rows as $row) {

        $user_id2 = $row['user_id'];
        $user_name = $row['user_name'];
        $name = $row['name'];
        $profile_img = $row['profile_picture'];
        $profile_img = preg_replace('/^\.\.\//', '', $profile_img);
        // $message_time = date('M d, Y', strtotime($row['latest_message_time']));

        $message_direction = $row['message_direction']; //from,to
        $message = $row['latest_message'];

        // Convert message timestamp
        $message_time = strtotime($row['latest_message_time']);

        // Check if the date is today
        if (date('Y-m-d', $message_time) == date('Y-m-d')) {
            $formatted_time = "Today: " . date('h:i A', $message_time);
        } else {
            $formatted_time = date('M d, Y', $message_time);
        }


?>
        <a class="messag_profile" data-id=" <?= $user_id2 ?>">
            <div class="p-4 hover:bg-gray-100 cursor-pointer border-b">
                <div class="flex justify-between items-start">
                    <div class="flex space-x-3">
                        <div class="relative">
                            <img src=" <?= htmlspecialchars($profile_img) ?>"
                                alt=" <?= htmlspecialchars($user_name) ?>"
                                class="w-12 h-12 rounded-full object-cover">
                            <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white"></div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($name) ?></h3>
                            <p class="text-base font-serif text-gray-600 line-clamp-1">
                                <?= $message ?
                                    ($message_direction == 'from' ? "You: " : "") .
                                    htmlspecialchars($message) :
                                    "No messages yet" ?>
                            </p>
                        </div>
                    </div>
                    <span class="text-xs text-gray-500 mr-2">
                        <?= $message_time ? $formatted_time : '' ?>
                    </span>
                </div>
            </div>
        </a>
<?php

    }
} else {
    echo "<p>No messages</p>";
}
?>
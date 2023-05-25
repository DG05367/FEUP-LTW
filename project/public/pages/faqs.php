<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/check_admin.db.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../templates/common.tpl.php');


$db = getDatabaseConnection();

// Retrieve FAQs from the database
$query = "SELECT * FROM faqs";
$stmt = $db->query($query);
$faqs = $stmt->fetchAll(PDO::FETCH_ASSOC);

drawHeader($session);

// Display FAQs
if ($faqs) {
    foreach ($faqs as $faq) {
        echo "<h3>{$faq['question']}</h3>";
        echo "<p>{$faq['answer']}</p>";
    }
} else {
    echo "No FAQs found.";
}

// Display form for agents
if (checkAgent($db, $session->getId())) {
    ?>
    <h2>Add FAQ</h2>
    <form method="POST" action="/public/actions/action_add_faq.php">
        <label for="question">Question:</label><br>
        <input type="text" name="question" required><br><br>
        
        <label for="answer">Answer:</label><br>
        <textarea name="answer" required></textarea><br><br>
        
        <input type="submit" value="Add FAQ">
    </form>
    <?php
}

drawFooter();

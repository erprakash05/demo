<?php
include 'db.php';

$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);

    if (!empty($name) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO messages (name, message) VALUES (?, ?)");
            $stmt->execute([$name, $message]);
            $success_msg = "ડેટા સફળતાપૂર્વક Supabase માં સેવ થઈ ગયો છે!";
        } catch (Exception $e) {
            $success_msg = "ભૂલ આવી: " . $e->getMessage();
        }
    }
}

// ડેટા મેળવો
try {
    $stmt = $pdo->query("SELECT * FROM messages ORDER BY id DESC");
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $messages = [];
}
?>

<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <title>PHP + Supabase Dynamic App</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; background: #f4f4f9; }
        .container { max-width: 600px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin: auto; }
        input, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        button { background: #28a745; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
        .message-box { background: #e9ecef; padding: 10px; margin-top: 10px; border-radius: 4px; }
        .success { color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h2>PHP અને Supabase (PostgreSQL) પ્રોજેક્ટ</h2>
    
    <?php if(!empty($success_msg)) { echo "<p class='success'>$success_msg</p>"; } ?>

    <form method="POST">
        <label>તમારું નામ:</label>
        <input type="text" name="name" required>
        
        <label>તમારો મેસેજ:</label>
        <textarea name="message" rows="4" required></textarea>
        
        <button type="submit">મેસેજ મોકલો (Save)</button>
    </form>

    <hr>

    <h3>સેવ થયેલા મેસેજ:</h3>
    <?php 
    if (count($messages) > 0) {
        foreach ($messages as $row) {
            echo "<div class='message-box'>";
            echo "<strong>નામ:</strong> " . htmlspecialchars($row['name']) . "<br>";
            echo "<strong>મેસેજ:</strong> " . htmlspecialchars($row['message']);
            echo "</div>";
        }
    } else {
        echo "<p>હજુ કોઈ ડેટા નથી.</p>";
    }
    ?>
</div>

</body>
</html>
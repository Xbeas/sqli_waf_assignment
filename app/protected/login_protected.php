<?php
$servername = "localhost";
$username = "webapp";
$password = "secure_password_123";
$dbname = "vulnerable_app";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if ($_POST['username']) {
        $user_input = $_POST['username'];
        
        // SECURE SQL QUERY - Using prepared statements
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_input]);
        $users = $stmt->fetchAll();
        
        echo "<div style='margin: 50px; font-family: Arial;'>";
        echo "<h3>Login Result:</h3>";
        
        if ($users) {
            foreach ($users as $user) {
                echo "<div style='background: #d4edda; padding: 15px; border: 1px solid #c3e6cb;'>";
                echo "<h4>Login Successful!</h4>";
                echo "<p>Welcome, " . htmlspecialchars($user['username']) . "!</p>";
                echo "</div>";
                break; // Only show first match
            }
        } else {
            echo "<div style='background: #f8d7da; padding: 15px; border: 1px solid #f5c6cb;'>";
            echo "<h4>Login Failed!</h4>";
            echo "<p>Invalid username.</p>";
            echo "</div>";
        }
        
        echo "<br><a href='page2.html'>Back to Login</a>";
        echo "</div>";
    }
} catch(PDOException $e) {
    echo "<div style='margin: 50px; color: red;'>";
    echo "<h3>System Error</h3>";
    echo "<p>Please contact administrator.</p>";
    echo "<a href='page2.html'>Back to Login</a>";
    echo "</div>";
}
?>
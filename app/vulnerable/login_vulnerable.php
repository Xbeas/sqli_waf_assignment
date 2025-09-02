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
        
        // VULNERABLE SQL QUERY - Direct concatenation
        $sql = "SELECT * FROM users WHERE username = '$user_input'";
        
        echo "<div style='margin: 50px; font-family: Arial;'>";
        echo "<h3>Executed Query:</h3>";
        echo "<code style='background: #f0f0f0; padding: 10px; display: block;'>$sql</code>";
        
        $result = $pdo->query($sql);
        $users = $result->fetchAll();
        
        if ($users) {
            echo "<h3>Query Results:</h3>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Email</th></tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user['id']) . "</td>";
                echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                echo "<td>" . htmlspecialchars($user['password']) . "</td>";
                echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No users found.</p>";
        }
        
        echo "<br><a href='page1.html'>Back to Login</a>";
        echo "</div>";
    }
} catch(PDOException $e) {
    echo "<div style='margin: 50px; color: red;'>";
    echo "<h3>Database Error:</h3>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<a href='page1.html'>Back to Login</a>";
    echo "</div>";
}
?>
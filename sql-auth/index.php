<?php
session_start();

try {
    $pdo = new PDO('mysql:host=localhost;dbname=security_auth_db', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Disable emulated prepared statements for demonstration
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST["username"] ?? '';
    $password = $_POST["password"] ?? '';
    
    if (!empty($username) && !empty($password)) {
        // Secure version (commented out)
        /*
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$username]);
        $user = $statement->fetch();
        */
        
        // Vulnerable version - susceptible to SQL injection
        $sql = "SELECT id, username, password FROM users WHERE username = '" . $username . "'";
        echo "<pre>Debug - SQL Query: " . htmlspecialchars($sql) . "</pre>"; // Debug output
        try {
            $statement = $pdo->query($sql);
            // $user = $statement->fetch(); // If it had just been fetch, the hack returns the first user only. We are showing debug information of matched user(s).
            $users = $statement->fetchAll(); // Get all users. We are showing debug information of matched user(s).
            
            if ($users) {
                echo "<pre>Debug - Found users: " . print_r($users, true) . "</pre>"; // Debug output
                // Try to login with the first user that has a matching password
                foreach ($users as $user) {
                    if (password_verify($password, $user['password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];
                        $message = '<div class="success">Login successful as ' . htmlspecialchars($user['username']) . '!</div>';
                        break;
                    }
                }
                if (!isset($_SESSION['user_id'])) {
                    $message = '<div class="error">Invalid password for any matching user</div>';
                }
            } else {
                $message = '<div class="error">No users found</div>';
            }
        } catch (PDOException $e) {
            // error_log("SQL Error: " . $e->getMessage());
            echo("SQL Error: " . $e->getMessage());
            $message = '<div class="error">Database error occurred</div>';
        }
    } else {
        $message = '<div class="error">Please enter both username and password</div>';
    }
}

// Check if user is already logged in
// if (isset($_SESSION['user_id'])) {
//     header("Location: dashboard.php");
//     exit();
// }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .success {
            color: #4CAF50;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #dff0d8;
            border-radius: 4px;
        }
        .error {
            color: #a94442;
            padding: 10px;
            margin-bottom: 15px;
            background-color: #f2dede;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h1>Login</h1>
    <?php echo $message; ?>
    <div class="form-container">
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=security_comments_db', 'root', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["name"] ?? '';
    $comment = $_POST["comment"] ?? '';
    
    if (!empty($name) && !empty($comment)) {
        $sql = "INSERT INTO comments (name, comment) VALUES (?,?)";
        $statement = $pdo->prepare($sql);
        $statement->execute([$name, $comment]);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Comments System</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .form-container {
            margin-bottom: 20px;
        }
        textarea {
            width: 100%;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>SQL Injection Test</h1>
    <div class="form-container">
        <form action="index.php" method="post" id="comment">
            <label for="name">Your name:</label>
            <input type="text" id="name" name="name" required><br><br>
            <label for="comment">Your comment:</label><br>
            <textarea id="comment" name="comment" rows="5" cols="30" required></textarea><br>
            <button type="submit" value="comment">Add a comment</button>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $comments = $pdo->query('SELECT * FROM comments ORDER BY created_at DESC')->fetchAll();
            foreach($comments as $comment) {
                echo "<tr>";
                // echo "<td>".htmlspecialchars($comment['name'])."</td>";
                // echo "<td>".htmlspecialchars($comment['comment'])."</td>";
                echo "<td>".$comment['name']."</td>";
                echo "<td>".$comment['comment']."</td>";
                echo "<td>".$comment['created_at']."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feedback_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
        $message_status = "<p class='success'>✔ Thank you! Your feedback has been submitted.</p>";
    } else {
        $message_status = "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Feedbacks</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f7f8fc;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #2e7d32;
        }

        .success { color: green; text-align:center; }
        .error { color: red; text-align:center; }

        button {
            margin: 20px auto;
            display: block;
            padding: 10px 20px;
            background: #66bb6a;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #4caf50;
        }

        table {
            border-collapse: collapse;
            width: 90%;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #4caf50;
            color: white;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        #tableWrapper {
            display: none;
        }

        .back-button {
            display: block;
            margin: 10px auto 20px auto;
            text-align: center;
            padding: 10px 20px;
            background: #66bb6a;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            max-width: 200px;
        }

        .back-button:hover {
            background: #4caf50;
        }
    </style>
</head>
<body>
    <a href="feedback.html" class="back-button">← Back to Feedback Form</a>
    <h2>All Feedbacks</h2>
    <?php echo $message_status; ?>

    <?php
    $sql = "SELECT * FROM feedback ORDER BY submitted_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<button id='toggleBtn' onclick='toggleTable()'>Show Feedbacks</button>";
        echo "<div id='tableWrapper'>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Email</th><th>Message</th><th>Submitted At</th></tr>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
            echo "<td>" . htmlspecialchars($row["message"]) . "</td>";
            echo "<td>" . $row["submitted_at"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='text-align:center;'>No feedbacks yet!</p>";
    }

    $conn->close();
    ?>

    <script>
    function toggleTable() {
        var wrapper = document.getElementById("tableWrapper");
        var btn = document.getElementById("toggleBtn");
        if (wrapper.style.display === "none") {
            wrapper.style.display = "block";
            btn.innerText = "Hide Feedbacks";
        } else {
            wrapper.style.display = "none";
            btn.innerText = "Show Feedbacks";
        }
    }
    </script>
</body>
</html>

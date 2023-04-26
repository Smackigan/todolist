<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Connecting to DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Mydb";
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
  die("No connection: " . $conn->connect_error);
}

// Adding notes
if (isset($_POST['add'])) {
  $text = $_POST['text'];
  $stmt = $conn->prepare("INSERT INTO mydata (data) VALUES (?)");
  $stmt->bind_param("s", $text);
  $stmt->execute();
  $stmt->close();
  header('Location: /notes_app.v2/index.php');
}

// Remove notes
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $stmt = $conn->prepare("DELETE FROM mydata WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $stmt->close();
}

// Show notes
$sql = "SELECT * FROM mydata";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>To Do List</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
</head>
<body>
  <div class="container">
    <h1>TODO Plans</h1>
  <form action="" method="post">
    <input class="form-control" type="text" name="text" id="list" placeholder="Enter your note">
    <button class="btn btn-danger" type="submit" name="add">Add</button>
  </form>
  <ul>
        <?php while($row = $result->fetch_assoc()) { ?>
            <li>
                <?php echo $row['data']; ?>
                <a href="?delete=<?php echo $row['id']; ?>">Delete</a>
            </li>
        <?php } ?>
    </ul>
  </div>
</body>
</html>


<?php 
// Close DB connection
$conn->close();
?>


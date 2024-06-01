<?php
// 328/grcStudents/index.php

//turn on error reporting
ini_set('display_errors',1);
error_reporting(E_ALL);

echo "GRC Students PP DEMO";

$path = $_SERVER['DOCUMENT_ROOT'].'/../config.php';
require_once $path;

try {
    //instantiate our PDO Database Object
    $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    echo 'Connected to database!';
} catch (PDOException $e){
    die($e->getMessage() );
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $sid = $_POST['sid'];
    $last = $_POST['last'];
    $first = $_POST['first'];
    $birthdate = $_POST['birthdate'];
    $gpa = $_POST['gpa'];
    $advisor = $_POST['advisor'];

    // Define the query
    $sql = 'INSERT INTO student (sid, last, first, birthdate, gpa, advisor)
            VALUES (:sid, :last, :first, :birthdate, :gpa, :advisor)';

    // Prepare the statement
    $statement = $dbh->prepare($sql);

    // Bind the parameters
    $statement->bindParam(':sid', $sid);
    $statement->bindParam(':last', $last);
    $statement->bindParam(':first', $first);
    $statement->bindParam(':birthdate', $birthdate);
    $statement->bindParam(':gpa', $gpa);
    $statement->bindParam(':advisor', $advisor);

    // Execute the query
    if ($statement->execute()) {
        echo "<p>Student $sid was inserted successfully!</p>";
    } else {
        echo "<p>Error inserting student $sid.</p>";
    }
}

// 1. define the query
$sql = "SELECT * FROM student ORDER BY `last`";
// 2. prepare the statement
$statement = $dbh->prepare($sql);
// 3. execute the statement
$statement->execute();
// 4. process the result
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
$count = 1;
echo '<h2>Student List</h2>';
foreach ($result as $row) {
    echo "<p>".$count++.". ".$row['last'].", ".$row['first']."</p>";
}

/*// INSERT INTO query
//PDO 1. define query
$sql = 'INSERT INTO student (sid,last,first,birthdate,gpa,advisor)
        VALUES (:sid, :last, :first, :birthdate, :gpa, :advisor)';
//PDO 2. prepare the statement
$statement = $dbh->prepare($sql);
//PDO 3. bind the parameters
$sid = '614540';
$last = "Tapia";
$first = "Nathan";
$birthdate = "2003-03-28";
$gpa = "3.3";
$advisor = "2";

$statement->bindParam(':sid', $sid);
$statement->bindParam(':last', $last);
$statement->bindParam(':first', $first);
$statement->bindParam(':birthdate', $birthdate);
$statement->bindParam(':gpa', $gpa);
$statement->bindParam(':advisor', $advisor);
//PDO 4. execute the query
$statement->execute();
//PDO (OPTIONAL) 5. process the results
$id = $dbh->lastInsertId();
echo "<p>Student $sid was inserted successfully!</p>";*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h1>Add Student</h1>
    <form action="index.php" method="post">
        <label for="sid">Student ID:</label>
        <input type="text" id="sid" name="sid" required><br><br>

        <label for="last">Last Name:</label>
        <input type="text" id="last" name="last" required><br><br>

        <label for="first">First Name:</label>
        <input type="text" id="first" name="first" required><br><br>

        <label for="birthdate">Birthdate:</label>
        <input type="text" id="birthdate" name="birthdate" required><br><br>

        <label for="gpa">GPA:</label>
        <input type="text" id="gpa" name="gpa" required><br><br>

        <label for="advisor">Advisor:</label>
        <input type="text" id="advisor" name="advisor" required><br><br>

        <input type="submit" value="Add Student">
    </form>
</body>
</html>
<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2024-01-10

    Description:    This is to view the student info card.
 -->



<?php

require_once 'dbconfig.in.php';




echo "<a href='students.php'>Back to student list</a><br><br>";


// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    
    // Get the student ID from the URL
    $studentId = $_GET['id'];

   
    $sql = "SELECT id, name, avarage, department, image, dob, email, telephone, address, city, country FROM student WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
    $stmt->execute();


    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    $student['dob'] = date('d/m/Y', strtotime($student['dob'])); // just to make it look as requested
    $student['telephone'] = "+97".str_replace('-', '', $student['telephone']);// just to make it look as requested
    if ($student) {
       
        echo "<img src='../Assets/images/{$student['image']}' alt='{$student['name']}' style='width: 100px; height: 100px;'>";
        echo "<h1>Student ID: {$student['id']}, Name: {$student['name']}</h1>";
        echo "<ol>";
        echo "<li>Average: {$student['avarage']}</li>";
        echo "<li>Department: {$student['department']}</li>";
        echo "<li>Date of birth: {$student['dob']}</li>";
        echo "</ol>";
        echo "<h2>Contact</h2>";
        echo "<p>Email: <a href='mailto:{$student['email']}'>{$student['email']}</a></p>";
        echo "<p>Telephone: <a href='tel:{$student['telephone']}'>{$student['telephone']}</a></p>";
        echo "<p><i>Address: {$student['address']}, {$student['city']}, {$student['country']}</i></p>";
    } else {
        echo "<p>Error: Student not found.</p>";
    }
} else {

    echo "<p>Error: Student ID not provided.</p>";
}
?>

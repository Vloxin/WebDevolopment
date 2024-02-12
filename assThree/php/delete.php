<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2024-01-10
o
    Description:   This is to delete the student info card.
 -->

<?php

require_once 'dbconfig.in.php';


if (isset($_GET['id'])) {
 
    $studentId = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    
    $sql = "DELETE FROM student WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);

    if ($stmt->execute()) {
       
        echo "Student with ID {$studentId} has been deleted successfully.";
        echo "<a href='students.php'>Back</a>";

    } else {
       
        echo "Error deleting the student. Please try again.";
    }
} else {
    echo "Invalid request. Please provide a valid student ID.";
}
?>

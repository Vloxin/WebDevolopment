<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2024-01-10

    Description:    This displays the list of students. 
                    And it has the option to edit or delete a student's record.
 -->



<?php


require_once 'dbconfig.in.php';

$sql = "SELECT id, name, avarage, department, image FROM student";
$stmt = $pdo->prepare($sql);
$stmt->execute();

// Fetch the result
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


echo "<p>To register a new student, click the following link <a href='register.php'>Register</a></p>";
echo "<p>Or use the actions below to edit or delete a student's record.</p>";

if (count($result) > 0) {
    // Start creating the HTML table
    echo "<table border='1'>";
    echo "<tr><th>Image</th><th>ID</th><th>Name</th><th>Average</th><th>Department</th><th>Actions</th></tr>";

    // Loop through each row in the result set
    foreach ($result as $row) {
        echo "<tr>";
        echo "<td><img src='../Assets/images/{$row['image']}' style='width: 50px; height: 50px;'></td>";
        echo "<td><a href='view.php?id={$row['id']}'>{$row['id']}</a></td>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['avarage']}</td>";
        echo "<td>{$row['department']}</td>";
        echo "<td>
        <a href='edit.php?id={$row['id']}'>
        <button>
        <img src='../Assets/icons/edit.png' > 
        Edit
        </button></a>
       
       

        <a href=\"delete.php?id={$row['id']}\">
        <button onclick=\"event.preventDefault(); window.location.href='delete.php?id={$row['id']}'\">
            <img src=\"../Assets/icons/delete.png\" >
            Delete
        </button>
        </a>
        </td>";
        echo "</tr>";
    }

 
    echo "</table>";
} else {
    echo "<p>No records found in the student table.</p>";
}

?>

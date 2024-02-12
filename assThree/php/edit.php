<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2024-01-10

    Description:   This is to edit the student info card.
 -->


<?php

require_once 'dbconfig.in.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $sql = "SELECT * FROM student WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);


    $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the student with the given ID exists
    if ($studentData) {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     
            $updatedName = $_POST['name'];
            $updatedAvarage = $_POST['avarage'];
            $updatedDepartment = $_POST['department'];
            $updatedAddress = $_POST['address'];
            $updatedCity = $_POST['city'];
            $updatedCountry = $_POST['country'];
            $updatedTelephone = $_POST['telephone'];
            $updatedEmail = $_POST['email'];

            $updateSql = "UPDATE student SET 
            name = ?, 
            avarage = ?, 
            department = ?, 
            address = ?, 
            city = ?, 
            country = ?, 
            telephone = ?, 
            email = ?
        
            WHERE id = ?";
        
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->execute([$updatedName, $updatedAvarage, $updatedDepartment, $updatedAddress, $updatedCity, $updatedCountry, $updatedTelephone, $updatedEmail, $id]);
        
          
            // Redirect to the students page
            echo "student updated successfully <br> <a href='students.php'>Back to students</a>"
            exit();
        }

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit Student</title>
        </head>
        <body>
            <fieldset>
                <legend>Edit Student Information</legend>
                <form action="" method="post">

                    <input type="hidden" name="id" value="<?php echo $studentData['id']; ?>">
                    
                    <label for="name">Name:</label>
                    <input type="text" name="name" pattern="[A-Za-z]+" value="<?php echo $studentData['name']; ?>" required><br>
                  
                    <label for="avarage">Average:</label>
                    <input type="number" name="avarage" step="0.01" max="100" min="0" value="<?php echo $studentData['avarage']; ?>" required><br>

                    <label for="department">Department:</label>
                    <input type="text" name="department" value="<?php echo $studentData['department']; ?>" required><br>

                    <label for="address">Address:</label>
                    <textarea name="address" rows="1" cols="50" required><?php echo $studentData['address']; ?></textarea><br>

                    <label for="city">City:</label>
                    <input type="text" name="city" value="<?php echo $studentData['city']; ?>" required><br>

                    <label for="country">Country:</label>
                    <input type="text" name="country" value="<?php echo $studentData['country']; ?>" required><br>

                    <label for="telephone">Telephone:</label>
                    <input type="text" name="telephone" pattern="^\d{3}-\d{7}$" placeholder="059-4356788" value="<?php echo $studentData['telephone']; ?>" required><br>

                    <label for="Email:">Email</label>
                    <input type="email" name="email" value="<?php echo $studentData['email']; ?>" required><br>
                    
                    <input type="submit" value="Update">
                </form>
            </fieldset>
        </body>
        </html>
        <?php
    } else {
        echo "<p>Student with ID $id not found.</p>";
    }
} else {
    echo "<p>Student ID not provided.</p>";
}
?>

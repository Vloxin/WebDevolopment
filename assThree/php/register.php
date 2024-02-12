<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2024-01-10

    Description:   This is to register a new student.
                    
 -->


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once 'dbconfig.in.php';

    // Define variables and initialize them with empty values
    $id = $name = $gender = $dob = $department = $average =
    $address = $city = $country = $telephone = $email = $imageFileName = "";

    // Collect and sanitize user input
    $id = $_POST["id"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $department = $_POST["department"];
    $average = $_POST["average"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];

    // Check if the file was uploaded successfully
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $imagesFolder = '../Assets/images/';
        $imageFileName = $id . '.jpg';
        

        // Construct the file path
        $imageFilePath = $imagesFolder . $imageFileName;

        // Move the uploaded image to the desired folder
        move_uploaded_file($_FILES["image"]["tmp_name"], $imageFilePath);
    }

    // Prepare and execute the SQL query with prepared statements
    $sql = "INSERT INTO student(id, name, gender, dob, department, avarage, address, city, country, telephone, email, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(1, $id);
    $stmt->bindParam(2, $name);
    $stmt->bindParam(3, $gender);
    $stmt->bindParam(4, $dob);
    $stmt->bindParam(5, $department);
    $stmt->bindParam(6, $average);
    $stmt->bindParam(7, $address);
    $stmt->bindParam(8, $city);
    $stmt->bindParam(9, $country);
    $stmt->bindParam(10, $telephone);
    $stmt->bindParam(11, $email);
    $stmt->bindParam(12, $imageFileName);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Record inserted successfully.";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    // Close the statement and database connection
    $stmt->closeCursor();
    $pdo = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
</head>
<body>
    <a href="students.php">Back</a>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Student form:</legend>

    
            <label for="id">ID:</label>
            <input type="number" name="id" min="0" required><br><br>

        
            <label for="name">Name:</label>
            <input type="text" name="name" pattern="[A-Za-z]+" required><br><br>

   
            <label for="gender">Gender:</label>
            <input type="radio" name="gender" value="male" required> Male
            <input type="radio" name="gender" value="female" required> Female<br><br>

  
            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required><br><br>

            <label for="department">Department:</label>
            <input type="text" name="department" required><br><br>

            <label for="average">Average:</label>
            <input type="number" name="average" step="0.01" max="100" min="0" required><br><br>

            <label for="address">Address:</label>
            <textarea name="address" rows="1" cols="50" required></textarea><br><br>

            <label for="city">City:</label>
            <input type="text" name="city" required>


            <label for="country">Country:</label>
            <input type="text" name="country" required><br><br>


            <label for="telephone">Telephone:</label>
            <input type="text" name="telephone" pattern="^\d{3}-\d{7}$" placeholder="059-4356788" required><br><br>

 
            <label for="email">Email:</label>
            <input type="email" name="email" required><br><br>

     
            <label for="image">Image:</label>
            <input type="file" name="image" accept=".jpeg, .jpg" required><br><br>

            <input type="submit" value="Insert">
        </fieldset>
    </form>
</body>
</html>
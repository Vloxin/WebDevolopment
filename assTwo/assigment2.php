<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2023-12-31

    Description:    This file is the Main file it contains a handler function that handles the form submission
                    and calls the appropriate function from the functions.php file.
                    The functions.php file contains the functions that are used to manipulate the data.
 -->



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assignment 2</title>
</head>

<hr>
<body>
    
    <a href="../index.html">Main Page</a>
    <hr>
    

    <form method="post" action ="" name ="Student Profile" >
    <fieldset>
     <legend>Student Profile</legend> 

        <label for="studentId">Student ID:</label>
        <input type="text" id="studentId" name="studentId"  pattern="[0-9]+"><br><br>

        <label for="firstName">First Name:</label>
        <input type="text" id="firstName" name="firstName"  pattern="[A-Za-z]+">

        <label for="lastName">Last Name:</label>
        <input type="text" id="lastName" name="lastName"  pattern="[A-Za-z]+"><br><br>

        <label for="gender">Gender:</label>
        <input type="radio" id="male" name="gender" value="male" >
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female" >
        <label for="female">Female</label><br><br>

        <label for="dateOfBirth">Date of Birth:</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" ><br><br>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" ><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" ><br><br>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" ><br><br>

        <label for="tel">Tel:</label>
        <input type="tel" id="tel" name="tel" pattern="[0-9]{2}-[0-9]{7}" placeholder="02-2954367"><br><br>

        <button type="submit" name="actionType" value="view">View</button>
        <button type="submit" name="actionType" value="insert">Insert</button>
        <button type="submit" name="actionType" value="update">Update</button>
        <button type="submit" name="actionType" value="clear">Clear</button>
       
    
   
    </fieldset>
    
    

    </form>
    <hr>
</body>

</html>


<?php

include 'functions.php';

$actionType = isset($_POST['actionType']) ? $_POST['actionType'] : '';
handler($actionType);

function handler($actionType) {
    switch ($actionType) {
        case "view":
            if (isset($_POST['studentId'])) {
                $studentId = $_POST['studentId'];
                // Call the function to view the student
                $student = viewStudent($studentId);
                if ($student) {
                    // Display the student information
                    $student->displayInfo();
                } else {
                    echo "<p>Student not found.</p>";
                }
            } else {
                echo "<p>Please enter a student ID.</p>";
            }
            break;

        case "insert":
            // Check if all required fields are set
            if (isset($_POST['studentId'], $_POST['firstName'], $_POST['lastName'], $_POST['gender'], $_POST['dateOfBirth'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['tel'])) {
                // Create a new student object
                $newStudent = new Student(
                    $_POST['studentId'],
                    $_POST['firstName'],
                    $_POST['lastName'],
                    $_POST['gender'],
                    $_POST['dateOfBirth'],
                    $_POST['address'],
                    $_POST['city'],
                    $_POST['country'],
                    $_POST['tel']
                );

                // Call the function to insert the student
                $status = insertStudent($newStudent);
                if ($status === false) {
                    echo "<p>Student already exists.</p>";
                } else {
                    echo "<p>Student inserted successfully.</p>";
                }

            } else {
                echo "Please fill in all required fields.";
            }
            break;

        case "update":
            // Check if all required fields are set
            if (isset($_POST['studentId'], $_POST['firstName'], $_POST['lastName'], $_POST['gender'], $_POST['dateOfBirth'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['tel'])) {
                // Create a new student object
                $updatedStudent = new Student(
                    $_POST['studentId'],
                    $_POST['firstName'],
                    $_POST['lastName'],
                    $_POST['gender'],
                    $_POST['dateOfBirth'],
                    $_POST['address'],
                    $_POST['city'],
                    $_POST['country'],
                    $_POST['tel']
                );

                // Call the function to update the student
                if (updateStudent($updatedStudent)) {
                    echo "<p>Student updated successfully.</p>";
                } else {
                    echo "Student not found for update.";
                }
            } else {
                echo "Please fill in all required fields.";
            }
            break;

        case "clear":
            //posts nothing to the page and clears the form
            break;

        default:

        break;
    }
}
?>
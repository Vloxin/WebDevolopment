<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2023-12-31

    Description:    This file contains the functions that are used to manipulate the data, 
                    it is included in the assigment2.php file.
                    it can be used to insert, view, update and clear the data into/from the data.in.php file.

 -->
<?php
 include 'student.php';
 $studentArray = include 'data.in.php';
 
 function insertStudent($student) {
    global $studentArray;
    // check if student id already exists
        if (isset($studentArray[$student->idNumber])) {
            return false;
        }else{
            $studentArray[$student->idNumber] = $student;
            updateDataFile();
            return true;
        }

 }
 
 function viewStudent($idNumber) {
     global $studentArray;
     return isset($studentArray[$idNumber]) ? $studentArray[$idNumber] : null;
 }
 
 function updateStudent($student) {
     global $studentArray;
     if (isset($studentArray[$student->idNumber])) {
         $studentArray[$student->idNumber] = $student;
         updateDataFile();
         return true;
     }
     return false;
 }
 
 function updateDataFile() {
     global $studentArray;
     file_put_contents('data.in.php', '<?php return ' . var_export($studentArray, true) . ';');
 }
 ?>
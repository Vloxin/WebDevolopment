<!-- 
    Name:   FadiTarazi
    ID:     1190335
    Date:   2023-12-31

    Description:   This file is the student class blueprint, it is included in the functions.php file.
                    it contains the student class definition and the methods to display the student information
                    and to export the object to an array.
 -->
<?php




// Student class definition
class Student {
    public $idNumber;
    public $firstName;
    public $lastName;
    public $gender;
    public $dateOfBirth;
    public $address;
    public $city;
    public $country;
    public $telephone;

    // Constructor to initialize the object with provided values
    public function __construct($idNumber, $firstName, $lastName, $gender, $dateOfBirth, $address, $city, $country, $telephone) {
        $this->idNumber = $idNumber;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->gender = $gender;
        $this->dateOfBirth = $dateOfBirth;
        $this->address = $address;
        $this->city = $city;
        $this->country = $country;
        $this->telephone = $telephone;
    }

    // Method to display student information
    public function displayInfo() {
        echo "ID Number: $this->idNumber<br>";
        echo "First Name: $this->firstName<br>";
        echo "Last Name: $this->lastName<br>";
        echo "Gender: $this->gender<br>";
        echo "Date of Birth: $this->dateOfBirth<br>";
        echo "Address: $this->address<br>";
        echo "City: $this->city<br>";
        echo "Country: $this->country<br>";
        echo "Telephone: $this->telephone<br>";
    }

    // export the object to an array
    public static function __set_state($array) {
        $obj = new self(
            $array['idNumber'],
            $array['firstName'],
            $array['lastName'],
            $array['gender'],
            $array['dateOfBirth'],
            $array['address'],
            $array['city'],
            $array['country'],
            $array['telephone']
        );

        return $obj;
    }
}

?>

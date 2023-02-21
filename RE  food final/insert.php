<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['uname']) &&
        isset($_POST['email']) && isset($_POST['createpassword'])) {
        
        $firstname = $_POST['fname'];
        $lastname = $_POST['lname'];
        $username = $_POST['uname'];
        $email= $_POST['email'];
        $password = $_POST['createpassword'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "re-food";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(fname, lname, uname,email,createpassword) values(?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sssss",$firstname,$lastname,$username,$email,$password);
                if ($stmt->execute()) {
                    echo "NEW RECORD INSERTED SUCESSFULLY";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>
<?php
$email=$_POST['email'];
$password=$_POST['createpassword'];
$con =new mysqli("localhost", "root","","re-food");

if($con->connect_error) {

die("Failed to connect: ".$con->connect_error);

} else {

$stmt = $con->prepare("select * from register where email = ?");

$stmt->bind_param("s", $email);

$stmt->execute();

$stmt_result = $stmt->get_result();

if($stmt_result->num_rows > 0){ 
 
    $data = $stmt_result->fetch_assoc();
    
if($data['createpassword']=== $password) {
echo "<h2>Login sucessfully</h2>";
} else {
echo "<h2>Invalid Email or password</h2>";
}
}else {
    echo "<h2>Invalid Email or password</h2>";
}
 }
?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project353";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$pid=rand(1,70);
$name= $_POST['name'];




    $sql = "INSERT INTO patient(pid, name) VALUES('$pid','$name');";
    
    
    // Prepare statement
    $stmt = $conn->prepare($sql);
    

    // execute the query
    $stmt->execute();
    if ($name==null){
echo "please provide a Patient Name!";
}else{
    // echo a message to say the UPDATE succeeded
    echo $stmt->rowCount() . " records UPDATED successfully";
   }
    }
catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage()."<br>";
    

    }

echo "<br> $pid,$name";
$conn = null;


?>


<br>

<a href="index.php">Return to Dentistry Database</a>

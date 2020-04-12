<?php require "resources/header.php"; ?>

<?php

$patients = array();

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT Bill.*, Receptionist.name as receptionistName 
            FROM Bill, Receptionist
            WHERE paid=0 AND Receptionist.RID=Bill.processedBy";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
        
    if ($result && $statement->rowCount() > 0) { ?>
        <h4>Unpaid bills</h4>
        <?php 
            foreach ($result as $row) { ?>
                <tr>
                    <td>Bill ID: <?php echo $row["BID"]; ?></td>
                    <td>Amount: <?php echo "$" . $row["amount"]; ?></td>
                    <td>Appointment ID: <?php echo $row["AID"]; ?></td>
                    <td>Processed by: <?php echo $row["receptionistName"]; ?></td>
                </tr>
                <br>
            <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<br>

<a href="index.php">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>

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
        <h4 style="margin-left: 25px;">Unpaid bills</h4>
        <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Bill ID</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Appointment ID</th>
                        <th scope="col">Processed by</th>
                    </tr>
                </thead>
            <tbody>
        <?php 
            foreach ($result as $row) { ?>
                <div class="card" style="margin-left: 25px;">
                    <tr>
                        <td><?php echo $row["BID"]; ?></td>
                        <td><?php echo "$" . $row["amount"]; ?></td>
                        <td><?php echo $row["AID"]; ?></td>
                        <td><?php echo $row["receptionistName"]; ?></td>
                    </tr>
                </div>
                <?php } ?>
            </tbody>
            </table>
            <?php
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>

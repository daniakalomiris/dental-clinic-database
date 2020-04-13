<?php require "resources/header.php"; ?>

<?php

$patients = array();

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT Patient.name, Appointment.PID, COUNT(Appointment.attended) as missedAppointments
            FROM Appointment, Patient
            WHERE attended=0 AND Patient.PID=Appointment.PID
            GROUP BY PID";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
        
    if ($result && $statement->rowCount() > 0) { ?>
        <h4>Appointments missed (at least 1)</h4>
        <?php 
            foreach ($result as $row) { ?>
                <tr>
                    <td>Patient: <?php echo $row["name"]; ?></td>
                    <td>Appointments missed: <?php echo $row["missedAppointments"]; ?> </td>
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
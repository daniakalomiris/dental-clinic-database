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
        <h4 style="margin-left: 25px;">Appointments missed (at least 1)</h4>
        <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Patient</th>
                        <th scope="col">Appointments missed</th>
                    </tr>
                </thead>
            <tbody>
        <?php 
            foreach ($result as $row) { ?>
                <div class="card" style="margin-left: 25px;">
                    <tr>
                        <td><?php echo $row["name"]; ?></td>
                        <td><?php echo $row["missedAppointments"]; ?> </td>
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

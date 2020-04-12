<?php require "resources/header.php"; ?>

<?php

$patients = array();

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Patient";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    if ($result && $statement->rowCount() > 0) { ?>
    <br>
    <?php 
        foreach ($result as $row) { 
            $patients[] = $row; ?>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<form method="post" style="margin-left: 25px;">
    <label>Select a patient:</label>
    <select name="selectPatient">
        <?php 
        $counter = 1;
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $patients[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    <input type="submit" name="submit" value="Search">
</form>

<br>

<?php
if (isset($_POST['submit'])) {
    try  {
        $patientID = $_POST['selectPatient'];

        $sql = "SELECT Appointment.*, Clinic.name as clinicName, Dentist.name as dentistName
        FROM Appointment, Clinic, Dentist
        WHERE Appointment.PID=" . $patientID . " AND Clinic.CIC=Appointment.CIC AND Dentist.DID=Appointment.DID";

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
         
        if ($result && $statement->rowCount() > 0) { ?>
            <h4 style="margin-left: 25px;">Appointments for <?php echo $patients[$patientID - 1]["name"]; ?> </h4>
            <?php 
                foreach ($result as $row) { ?>
                    <div class="card" style="margin-left: 25px;">
                        <tr>
                            <td>Appointment ID: <?php echo $row["AID"]; ?></td>
                            <td>Clinic: <?php echo $row["clinicName"]; ?></td>
                            <td>Patient: <?php echo $patients[$patientID-1]["name"]; ?></td>
                            <td>Dentist: <?php echo $row["dentistName"]; ?></td>
                            <td>Patient attended appointment: <?php 
                                if ($row["attended"] == 1) {
                                    echo "Yes";
                                } else {
                                    echo "No";
                                }
                                ?></td>
                            <td>Date: <?php echo $row["date"]; ?></td>
                            <td>Time: <?php echo $row["time"]; ?></td>
                        </tr>
                    </div>
                    <br>
                <?php }
            } else { ?>
                <h4 style="margin-left: 25px;">There are no appointments for <?php echo $patients[$patientID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>

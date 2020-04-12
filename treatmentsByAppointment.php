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

<form method="post">
    <label>Select a patient:</label>
    <select name="selectPatient">
        <?php 
        $counter = 1;
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $patients[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>
    <label for="date">Select a date:</label>
    <input type="date" id="date" name="date">
    <input type="submit" name="submit" value="Search">
</form>

<?php
if (isset($_POST['submit'])) {
    try  {
        $patientID = $_POST['selectPatient'];
        $date = $_POST['date'];

        // if no date is selected, return all appointments for patient
        if (empty($date)) {
            $sql = "SELECT Appointment.*, Dentist.name as dentistName, Clinic.name as clinicName
            FROM Appointment, Dentist, Clinic
            WHERE Appointment.PID=" . $patientID . " AND Dentist.DID=Appointment.DID AND Clinic.CIC=Appointment.CIC";
        } else {
            $sql = "SELECT Appointment.*, Dentist.name as dentistName, Clinic.name as clinicName
            FROM Appointment, Dentistxs, Clinic
            WHERE Appointment.PID=" . $patientID . " AND Dentist.DID=Appointment.DID AND Clinic.CIC=Appointment.CIC AND date='" . $date . "'";
        }

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
         
        if ($result && $statement->rowCount() > 0) { ?>
            <br>
            <h4>Appointments for <?php echo $patients[$patientID - 1]["name"]; ?> </h4>
            <?php 
                foreach ($result as $row) { ?>
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
                        <td>
                            <form method="post">
                                <button name="treatment" type="submit" value="<?php echo $row["AID"] ?>">Treatments</button>
                            </form>
                        </td>
                    </tr>
                    <br>
                <?php }
            } else { ?>
                <h4>There are no appointments for <?php echo $patients[$patientID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<?php
if (isset($_POST['treatment'])) {
    try  {
        $appointmentID = $_POST['treatment'];

        $sql = "SELECT Treatment.*
        FROM Treatment
        WHERE Treatment.AID=" . $appointmentID . " ";

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
         
        if ($result && $statement->rowCount() > 0) { ?>
            <br>
            <?php 
                foreach ($result as $row) { ?>
                    <tr>
                        <td>Treatment: <?php echo $row["treatment"]; ?></td>
                        <td>Executed by: <?php 
                            if ($row["executedByDentist"] == 1) {
                                echo "Dentist";
                            } else {
                                echo "Assistant";
                            }
                            ?></td>
                    </tr>
                    <br>
                <?php }
            } else { ?>
                <h4>There are no treatments for this appointment</h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>

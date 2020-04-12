<?php require "resources/header.php"; ?>

<?php

$clinics = array();

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Clinic";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    if ($result && $statement->rowCount() > 0) { ?>
    <br>
    <?php 
        foreach ($result as $row) { 
            $clinics[] = $row; ?>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<form method="post">
    <label>Select a clinic:</label>
    <select name="selectClinic">
        <option value="1"><?php echo $clinics[0]["name"];?></option>
        <option value="2"><?php echo $clinics[1]["name"];?></option>
        <option value="3"><?php echo $clinics[2]["name"];?></option>
    </select>
    <label for="date">Select a date:</label>
    <input type="date" id="date" name="date">
    <input type="submit" name="submit" value="Search">
</form>

<?php
if (isset($_POST['submit'])) {
    try  {
        $clinicID = $_POST['selectClinic'];
        $date = $_POST['date'];

        // if no week is selected, return all appointments at selected clinic
        if (empty($date)) {
            $sql = "SELECT Appointment.*, Dentist.name as dentistName, Patient.name as patientName
            FROM Appointment, Dentist, Patient
            WHERE Appointment.CIC=" . $clinicID . " AND Dentist.DID=Appointment.DID AND Patient.PID=Appointment.PID";
        } else {
            $sql = "SELECT Appointment.*, Dentist.name as dentistName, Patient.name as patientName
            FROM Appointment, Dentist, Patient
            WHERE Appointment.CIC=" . $clinicID . " AND Dentist.DID=Appointment.DID AND Patient.PID=Appointment.PID AND date='" . $date . "'";
        }

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
         
        if ($result && $statement->rowCount() > 0) { ?>
            <br>
            <h4>Appointments at <?php echo $clinics[$clinicID - 1]["name"]; ?> </h4>
            <?php 
                foreach ($result as $row) { ?>
                    <tr>
                        <td>Appointment ID: <?php echo $row["AID"]; ?></td>
                        <td>Clinic: <?php echo $row["clinicName"]; ?></td>
                        <td>Patient: <?php echo $row["patientName"]; ?></td>
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
                    <br>
                <?php }
            } else { ?>
                <h4>There are no appointments at <?php echo $clinics[$clinicID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>

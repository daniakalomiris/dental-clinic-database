<?php require "resources/header.php"; ?>

<?php

$dentists = array();

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * FROM Dentist";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    if ($result && $statement->rowCount() > 0) { ?>
    <br>
    <?php 
        foreach ($result as $row) { 
            $dentists[] = $row; ?>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<form method="post" style="margin-left: 25px;">
    <label>Select a dentist:</label>
    <select name="selectDentist">
        <?php 
        $counter = 1;
        foreach ($dentists as $dentist) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $dentists[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>
    <label for="week">Select a week:</label>
    <input type="week" id="week" name="week">
    <input type="submit" name="submit" value="Search">
</form>

<br>

<?php
if (isset($_POST['submit'])) {
    try  {
        $dentistID = $_POST['selectDentist'];
        $week = $_POST['week'];

        $year = substr($week, 0, 4); // split week string to get year
        $interval = substr($week, 6);

        // if no week is selected, return all appointments for selected dentist
        if (empty($week)) {
            $sql = "SELECT Appointment.*, Clinic.name as clinicName, Patient.name as patientName
            FROM Appointment, Clinic, Patient
            WHERE Appointment.DID=" . $dentistID . " AND Clinic.CIC=Appointment.CIC AND Patient.PID=Appointment.PID";
        } else {
            $sql = "SELECT Appointment.*, Clinic.name as clinicName, Patient.name as patientName
            FROM Appointment, Clinic, Patient
            WHERE Appointment.DID=" . $dentistID . " AND Clinic.CIC=Appointment.CIC AND Patient.PID=Appointment.PID AND YEARWEEK(date, 1)=" . $year . $interval;
        }

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
         
        if ($result && $statement->rowCount() > 0) { ?>
            <h4 style="margin-left: 25px;">Appointments with <?php echo $dentists[$dentistID - 1]["name"]; ?> </h4>
            <?php 
                foreach ($result as $row) { ?>
                    <div class="card" style="margin-left: 25px;">
                        <tr>
                            <td>Appointment ID: <?php echo $row["AID"]; ?></td>
                            <td>Clinic: <?php echo $row["clinicName"]; ?></td>
                            <td>Patient: <?php echo $row["patientName"]; ?></td>
                            <td>Dentist: <?php echo $dentists[$dentistID-1]["name"]; ?></td>
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
                <h4 style="margin-left: 25px;">There are no appointments with <?php echo $dentists[$dentistID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>

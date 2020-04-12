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

<form method="post">
    <label>Select a dentist:</label>
    <select name="selectDentist">
        <option value="1"><?php echo $dentists[0]["name"];?></option>
        <option value="2"><?php echo $dentists[1]["name"];?></option>
        <option value="3"><?php echo $dentists[2]["name"];?></option>
        <option value="4"><?php echo $dentists[3]["name"];?></option>
        <option value="5"><?php echo $dentists[4]["name"];?></option>
        <option value="6"><?php echo $dentists[5]["name"];?></option>
        <option value="7"><?php echo $dentists[6]["name"];?></option>
        <option value="8"><?php echo $dentists[7]["name"];?></option>
        <option value="9"><?php echo $dentists[8]["name"];?></option>
        <option value="10"><?php echo $dentists[9]["name"];?></option>
    </select>
    <label for="week">Select a week:</label>
    <input type="week" id="week" name="week">
    <input type="submit" name="submit" value="Search">
</form>

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
            <br>
            <h4>Appointments with <?php echo $dentists[$dentistID - 1]["name"]; ?> </h4>
            <?php 
                foreach ($result as $row) { ?>
                    <tr>
                        <td>Appointment ID: <?php echo $row["AID"]; ?></td>
                        <td>Clinic: <?php echo $row["clinicName"]; ?></td>
                        <td>Patient: <?php echo $row["patientName"]; ?></td>
                        <td>Dentist: <?php echo $dentists[$dentistID]; ?></td>
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
                <h4>There are no appointments with <?php echo $dentists[$dentistID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>

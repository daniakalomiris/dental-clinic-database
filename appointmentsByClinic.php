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

<form method="post" style="margin-left: 25px;">
    <label>Select a clinic:</label>
    <select name="selectClinic">
        <?php 
        $counter = 1;
        foreach ($clinics as $clinic) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $clinics[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>
    <label for="date">Select a date:</label>
    <input type="date" id="date" name="date">
    <input type="submit" name="submit" value="Search">
</form>

<br>

<?php
if (isset($_POST['submit'])) {
    try  {
        $clinicID = $_POST['selectClinic'];
        $date = $_POST['date'];

        // if no date is selected, return all appointments at selected clinic
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
            <h4 style="margin-left: 25px;">Appointments at <?php echo $clinics[$clinicID - 1]["name"]; ?> </h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Appointment ID</th>
                        <th scope="col">Clinic</th>
                        <th scope="col">Patient</th>
                        <th scope="col">Dentist</th>
                        <th scope="col">Patient attended appointment</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                    </tr>
                </thead>
            <tbody>
            <?php 
                foreach ($result as $row) { ?>
                    <div class="card" style="margin-left: 25px;">
                        <tr>
                            <td><?php echo $row["AID"]; ?></td>
                            <td><?php echo $clinics[$clinicID-1]["name"]; ?></td>
                            <td><?php echo $row["patientName"]; ?></td>
                            <td><?php echo $row["dentistName"]; ?></td>
                            <td><?php 
                                if ($row["attended"] == 1) {
                                    echo "Yes";
                                } else {
                                    echo "No";
                                }
                                ?></td>
                            <td><?php echo $row["date"]; ?></td>
                            <td><?php echo $row["time"]; ?></td>
                        </tr>
                    </div>
                    <?php } ?>
            </tbody>
            </table>
            <?php } else { ?>
                <h4 style="margin-left: 25px;">There are no appointments at <?php echo $clinics[$clinicID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>

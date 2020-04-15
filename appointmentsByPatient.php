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
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $patient["PID"] ?>"><?php echo $patient["name"];?></option>
            <?php
        } ?>
    <input type="submit" name="submit" value="Search">
</form>

<br>

<?php
if (isset($_POST['submit'])) {
    try  {
        $patientID = $_POST['selectPatient'];

        $sql = "SELECT Appointment.*, Clinic.name as clinicName, Dentist.name as dentistName, Patient.name as patientName
        FROM Appointment, Clinic, Dentist, Patient
        WHERE Appointment.PID=" . $patientID . " AND Patient.PID=Appointment.PID AND Clinic.CIC=Appointment.CIC AND Dentist.DID=Appointment.DID";

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();
         
        if ($result && $statement->rowCount() > 0) { ?>
            <h4 style="margin-left: 25px;">Appointments for <?php echo $result[0]["patientName"]; ?> </h4>
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
                            <td><?php echo $row["clinicName"]; ?></td>
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
                <h4 style="margin-left: 25px;">No appointments were found!</h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>

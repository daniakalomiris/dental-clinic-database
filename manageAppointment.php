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
    <?php 
        foreach ($result as $row) { 
            $patients[] = $row; ?>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php

$dentists = array();

try  {
    $sql = "SELECT * FROM Dentist";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    if ($result && $statement->rowCount() > 0) { ?>
    <?php 
        foreach ($result as $row) { 
            $dentists[] = $row; ?>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<?php

$clinics = array();

try  {
    $sql = "SELECT * FROM Clinic";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    if ($result && $statement->rowCount() > 0) { ?>
    <?php 
        foreach ($result as $row) { 
            $clinics[] = $row; ?>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
?>

<h4 style="margin-left: 25px;">Find an appointment</h4>

<form method="post">
    <label><ul>Select a patient:</ul></label>
    <select name="selectPatient">
        <?php 
        $counter = 1;
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $patients[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>

    <label><ul>Select a dentist:</ul></label>
    <select name="selectDentist">
        <?php 
        $counter = 1;
        foreach ($dentists as $dentist) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $dentists[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>

    <label><ul>Select a clinic:</ul></label>
    <select name="selectClinic">
        <?php 
        $counter = 1;
        foreach ($clinics as $clinic) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $clinics[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>

    <label for="date"><ul>Select a date:</ul></label>
    <input type="date" id="date" name="date">

    <br>
    <ul><button type="submit" name="submit">Search</button></ul>
</form>

<?php
if (isset($_POST['submit'])) {
    try  {
        $clinicID = $_POST['selectClinic'];
        $patientID = $_POST['selectPatient'];
        $dentistID = $_POST['selectDentist'];
        $date = $_POST['date'];

        // if no date is selected, return all appointments for selected dentist
        if (empty($date)) {
            $sql = "SELECT Appointment.*
            FROM Appointment
            WHERE Appointment.PID=" . $patientID . " AND Appointment.CIC=" . $clinicID . " AND Appointment.DID=" . $dentistID . " ";
        } else {
            $sql = "SELECT Appointment.*
            FROM Appointment
            WHERE Appointment.PID=" . $patientID . " AND Appointment.CIC=" . $clinicID . " AND Appointment.DID=" . $dentistID . " AND Appointment.date='" . $date . "'";
        }

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        if ($result && $statement->rowCount() > 0) { ?>
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
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
            <tbody>
            <?php 
                foreach ($result as $row) { ?>
                    <div class="card" style="margin-left: 25px;">
                        <tr>
                            <td><?php echo $row["AID"]; ?></td>
                            <td><?php echo $clinics[$clinicID-1]["name"]; ?></td>
                            <td><?php echo $patients[$patientID-1]["name"]; ?></td>
                            <td><?php echo $dentists[$dentistID-1]["name"]; ?></td>
                            <td><?php 
                                if ($row["attended"] == 1) {
                                    echo "Yes";
                                } else {
                                    echo "No";
                                }
                                ?></td>
                            <td><?php echo $row["date"]; ?></td>
                            <td><?php echo $row["time"]; ?></td>
                            <td><button type="submit" role="button" name="edit" value="<?php echo $row["AID"];?>" class="btn btn-warning">Edit</button></td>
                            <td>
                                <form method="post"> 
                                    <button type="submit" role="button" name="delete" value="<?php echo $row["AID"];?>" class="btn btn-danger">Delete</button>
                                </form>    
                            </td>

                        </tr>
                    </div>
            <?php } ?>
            </tbody>
            </table> 
            <?php } else { ?>
                <h4 style="margin-left: 25px;">No appointments were found.</h4>
            <?php }
    } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">There was an error finding the appointment. Please try again.</div>
    <?php }
} ?>

<?php
if (isset($_POST['delete'])) {
    try  {
        $deleteAID = $_POST['delete'];

        $sql = "DELETE FROM Appointment WHERE AID=" . $deleteAID . " ";

        $statement = $connection->prepare($sql);
        $statement->execute(); ?>
        
        <div class="alert alert-success" role="alert" style="width: 500px; margin-left: 25px;">Appointment <?php echo $deleteAID ?> was succesfully removed!</div>
    <?php } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">There was an error deleting the appointment. Please try again.</div>
    <?php }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>
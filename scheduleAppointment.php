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

<h4 style="margin-left: 25px;">Schedule a new appointment</h4>

<form method="post">
    <label><ul>Select a patient:</ul></label>
    <select name="selectPatient">
        <?php 
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $patient["PID"] ?>"><?php echo $patient["name"];?></option>
            <?php
        } ?>
    </select>

    <label><ul>Select a dentist:</ul></label>
    <select name="selectDentist">
        <?php
        foreach ($dentists as $dentist) {  ?>
            <option value="<?php echo $dentist["DID"] ?>"><?php echo $dentist["name"];?></option>
            <?php
        } ?>
    </select>

    <label><ul>Select a clinic:</ul></label>
    <select name="selectClinic">
        <?php
        foreach ($clinics as $clinic) {  ?>
            <option value="<?php echo $clinic["CIC"] ?>"><?php echo $clinic["name"];?></option>
            <?php
        } ?>
    </select>

    <label for="date"><ul>Select a date:</ul></label>
    <input type="date" id="date" name="date">

    <label for="appt"><ul>Select a time:</ul></label>
    <input type="time" id="time" name="time">

    <br>
    <ul><button type="submit" name="submit">Schedule appointment</button></ul>
</form>

<?php

if (isset($_POST['submit'])) {
    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $clinicID = $_POST['selectClinic'];
        $patientID = $_POST['selectPatient'];
        $dentistID = $_POST['selectDentist'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $appointmentID=rand(1,100);

        $sql = "INSERT INTO Appointment(AID, CIC, PID, DID, date, time) VALUES('$appointmentID','$clinicID','$patientID','$dentistID','$date','$time');";

        $statement = $connection->prepare($sql);
        $statement->execute(); ?>

        <div class="alert alert-success" role="alert" style="width: 500px; margin-left: 25px;">The appointment (Appointent ID: <?php echo $appointmentID; ?>) was succesfully scheduled!</div>
        <?php
    } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">There was an error scheduling the patient. Please try again and do not leave any fields empty.</div>
    <?php }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>
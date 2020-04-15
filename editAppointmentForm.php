<?php require "resources/header.php"; ?>


<?php

$AID = $_GET['id'];

$patients = array();
$dentists = array();
$clinics = array();

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT * 
            FROM Appointment 
            WHERE AID=" . $AID . " ";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $appointment = $result;
    
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

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

try  {
    $sql = "SELECT * FROM Clinic";

    $connection = new PDO($dsn, $username, $password, $options);

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

<h4>Edit appointment</h4> 

<form method="post">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Update clinic</th>            
                <th scope="col">Update patient</th>
                <th scope="col">Update dentist</th>            
                <th scope="col">Did patient attend appointment?</th>
                <th scope="col">Update date</th>            
                <th scope="col">Update time</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <select name="selectClinic">
                        <?php
                        foreach ($clinics as $clinic) {  ?>
                            <option value="<?php echo $clinic["CIC"] ?>"><?php echo $clinic["name"];?></option>
                            <?php
                        } ?>
                    </select>
                </td>
                <td> 
                    <select name="selectPatient">
                        <?php
                        foreach ($patients as $patient) {  ?>
                            <option value="<?php echo $patient["PID"] ?>"><?php echo $patient["name"];?></option>
                            <?php
                        } ?>
                    </select>
                </td>
                <td> 
                    <select name="selectDentist">
                        <?php
                        foreach ($dentists as $dentist) {  ?>
                            <option value="<?php echo $dentist["DID"] ?>"><?php echo $dentist["name"];?></option>
                            <?php
                        } ?>
                    </select>
                </td>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="attended" value="1" checked>
                        <label class="form-check-label" for="exampleRadios1">Yes</label>
                        <input class="form-check-input" type="radio" name="attended" value="0" checked>
                        <label class="form-check-label" for="exampleRadios1">No</label>
                    </div>
                </td>
                <td>
                    <input type="date" id="date" name="date">
                </td>
                <td>
                    <input type="time" id="time" name="time">
                </td>
            </tr>
        </tbody>
    </table>
    <ul><br><button type="submit" class="btn btn-success" name="submit">Update</button></ul>
</form>
 
<?php
if (isset($_POST['submit'])) {
    try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $clinicID = $_POST['selectClinic'];
        $patientID = $_POST['selectPatient'];
        $dentistID = $_POST['selectDentist'];
        $attended = $_POST['attended'];
        $date = $_POST['date'];
        $time = $_POST['time'];

        $sql = "UPDATE Appointment 
                SET CIC=" . $clinicID . ", 
                    PID=" . $patientID . ", 
                    DID=" . $dentistID . ", 
                    attended=" . $attended . ", 
                    date='" . $date . "', 
                    time='" . $time . "' 
                WHERE AID=" . $AID . "";

        $statement = $connection->prepare($sql);
        $statement->execute(); ?>

        <div class="alert alert-success" role="alert" style="width: 500px; margin-left: 25px;">The appointment (Appointent ID: <?php echo $AID; ?>) was succesfully updated!</div>
        <?php
    } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">There was an error updating the appointment. Please try again.</div>
    <?php
    }
} 
?>


<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>

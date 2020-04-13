<?php include "resources/header.php"; ?>
<h1 align = "center">Welcome to the Dental Clinic Database</h1>


<ul>
    <li><a href="dentistDetails.php"><strong>View details of all dentists</strong></a></li>
    <li><a href="appointmentsByDentist.php"><strong>View details of appointments by dentist for a given week</strong></a></li>
    <li><a href="appointmentsByClinic.php"><strong>View details of appointments by clinic for a given date</strong></a></li>
    <li><a href="appointmentsByPatient.php"><strong>View details of appointments by patient</strong></a></li>
    <li><a href="missedAppointments.php"><strong>View number of missed appointments for each patient (only for patients who have missed at least 1 appointment)</strong></a></li>
    <li><a href="treatmentsByAppointment.php"><strong>View details of all treatments by appointment</strong></a></li>
    <li><a href="unpaidBills.php"><strong>View details of all unpaid bills</strong></a></li>
</ul>
<ul>
<br>
    <li><!--<a href="mmmm.php">-->Enter the Patient name you would want to add to the list of patients and a random Patient ID will be generated</li>
</ul>

<br><form action="mmmm.php" method="POST">
<ul><input type="text" name="name" placeholder="Name"></ul>
<ul><br><button type="submit" name="submit"> Add</button></ul>

</form>

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

<ul>
   <li> Make a new appointment:</li>
</ul>
<br><form>
 
<?php

$patients = array();

try  {
    require "config.php";
    

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
    <label><ul>Select a patient:</ul></label>
    <select name="selectPatient">
        <?php 
        $counter = 1;
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $patients[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    <input type="submit" name="submit" value="Search">
</form>

<?php

$dentists = array();

try  {
    require "config.php";
    

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
    <label><ul>Select a dentist:</ul></label>
    <select name="selectDentist">
        <?php 
        $counter = 1;
        foreach ($dentists as $dentist) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $dentists[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select>
</form>



<?php

$clinics = array();

try  {
    require "config.php";
    

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
    <label><ul>Select a clinic:</ul></label>
    <select name="selectClinic">
        <?php 
        $counter = 1;
        foreach ($clinics as $clinic) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $clinics[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>
    </select></ul>


<br><br><ul><label for="date">Select a Date:</label>
    <input type="date" id="date" name="date"></ul>

<br>
<button type="submit" name="submit"> Make Appointment</button><br><br>



</form>


------------------------------------------------------------------------------------------------------------------------



<ul>
   <li> Manage Existing Appointment</li>
</ul>

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
    <select name="selectPatient"><br><br>
     
        <?php
        $counter = 1;
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $patients[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>

?></form>

    



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
                    </tr>
                    
                <?php }
            } else { ?>
                <h4>There are no appointments for <?php echo $patients[$patientID - 1]["name"]; ?> </h4>
            <?php }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

} ?>


----------------------------------------------------------------------
<br><strong>OLD DATE:</strong>
<br><input type="date" id="date3" name="date3">
<br>
<strong>NEW DATE:</strong>
<br><input type="date" id="date4" name="date4">
<br>

<br><button class="w3-btn w3-orange w3-xlarge"><i class="glyphicon glyphicon-user"></i></input></button><br>


--------------------------------------------------------------------------


<p><button class="w3-btn w3-orange w3-xlarge"><i class="glyphicon glyphicon-trash"></i></input></button><!-- USED TO DELETE -->
    
    

<a href = DBA.html>
    <button class="w3-button w3-deep-orange">Access to DBA page </button>
</a>
<?php include "resources/footer.php"; ?>



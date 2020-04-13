<?php include "resources/header.php"; ?>

<div class="jumbotron" align="center">
    <h1 class="display-4">Welcome to the Dental Clinic Database</h1>
</div>

<ul class="list-group" style="margin-left: 25px;">
    <li class="list-group-item"><a href="dentistDetails.php"><strong>View details of all dentists</strong></a></li>
    <li class="list-group-item"><a href="appointmentsByDentist.php"><strong>View details of appointments by dentist for a given week</strong></a></li>
    <li class="list-group-item"><a href="appointmentsByClinic.php"><strong>View details of appointments by clinic for a given date</strong></a></li>
    <li class="list-group-item"><a href="appointmentsByPatient.php"><strong>View details of appointments by patient</strong></a></li>
    <li class="list-group-item"><a href="missedAppointments.php"><strong>View number of missed appointments for each patient (only for patients who have missed at least 1 appointment)</strong></a></li>
    <li class="list-group-item"><a href="treatmentsByAppointment.php"><strong>View details of all treatments by appointment</strong></a></li>
    <li class="list-group-item"><a href="unpaidBills.php"><strong>View details of all unpaid bills</strong></a></li>
</ul>

<ul>
   <u><h3><li> Manage Existing Appointment</li></h3></u>
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
    <ul><label>Select a patient:</label>
    <select name="selectPatient"></ul>
     
        <?php
        $counter = 1;
        foreach ($patients as $patient) {  ?>
            <option value="<?php echo $counter ?>"><?php echo $patients[$counter-1]["name"];?></option>
            <?php $counter++;
        } ?>

</form>

    



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


}
<br><ul><strong>OLD DATE:</strong></ul>
<br><ul><strong>OLD DATE:</strong></ul>
<br><input type="date" id="date3" name="date3">
<br>

<br><br>
<strong>OLD DATE:</strong>
<br><input type="date" id="date3" name="date3"><br>
<br><strong>NEW DATE:</strong>
<br><input type="date" id="date4" name="date4">
<br>






<a class="btn btn-primary" type="submit" href="addPatient.php" role="button" style="margin-left: 25px;">Add a patient</button>

<a class="btn btn-primary" type="submit" href="scheduleAppointment.php" role="button" style="margin-left: 25px;">Schedule an appointment</button>

<a class="btn btn-primary" type="submit" href="manageAppointment.php" role="button" style="margin-left: 25px;">Manage an appointment</button>

<a class="btn btn-warning" type="submit" href="DBA.php" role="button" style="margin-left: 25px;">DBA access</button>

<?php include "resources/footer.php"; ?>
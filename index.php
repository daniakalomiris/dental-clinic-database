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

<a class="btn btn-primary" type="submit" href="addPatient.php" role="button" style="margin-left: 25px;">Add a patient</button>

<a class="btn btn-primary" type="submit" href="scheduleAppointment.php" role="button" style="margin-left: 25px;">Schedule an appointment</button>

<a class="btn btn-primary" type="submit" href="manageAppointment.php" role="button" style="margin-left: 25px;">Manage an appointment</button>

<a class="btn btn-warning" type="submit" href="DBA.php" role="button" style="margin-left: 25px;">DBA access</button>

<?php include "resources/footer.php"; ?>
<?php include "resources/header.php"; ?>
<h1 align = "center">Welcome to the Dentistry Database</h1>

<ul>
    <li><a href="dentistDetails.php"><strong>View details of all dentists</strong></a></li>
    <li><a href="appointmentsByDentist.php"><strong>View details of appointments by dentist for a given week</strong></a></li>
    <li><a href="appointmentsByClinic.php"><strong>View details of appointments by clinic for a given date</strong></a></li>
    <li><a href="appointmentsByPatient.php"><strong>View details of appointments by patient</strong></a></li>
    <li><a href="missedAppointments.php"><strong>View number of missed appointments for each patient (only for patients who have missed at least 1 appointment)</strong></a></li>
    <li><a href="unpaidBills.php"><strong>View details of all unpaid bills</strong></a></li>
</ul>

<!-- 
<h3>
    F. Get details of all the treatments made during a given appointment.
</h3>

<form action = "SHOULD BE THE PHP CODE HERE">
    <select name = "dropdown">
        <option value = "Clinic 1" selected>Clinic 1</option>
        <option value = "Clinic 2">Clinic 2</option>
        <option value = "Clinic 3">Clinic 3</option>
    </select>
    <label for="date">Chose a given apointment at a given clinic:</label>
    <input type="date" id="date2" name="date2">
    <input type="submit">
</form> -->

<!-- <h3>
    Enter the name of the patient you would want to add
</h3>
<form action="SHOULD BE PHP CODE HERE">
    <textarea placeholder="Write down the name of the patient you want to add" name="message" rows="3" cols="20"></textarea>
    <br>
    <input type="submit" value="Add new patient to the database">
</form>
<br>
<h3>
    Select the patient you would like to schedule new appointments, modify, delete existing appointments
</h3>
<form action = "SHOULD BE THE PHP CODE HERE">
    <select name = "dropdown">
        <option value = "Patient 0" selected>-Select Patient-</option>
        <option value = "Patient 1">Alaa</option>
        <option value = "Patient 2">Nedjma</option>
        <option value = "Patient 3">Nani</option>
        <option value = "Patient 4">Zaha</option>
        <option value = "Patient 5">Zalema</option>
        <option value = "Patient 6">Shiri</option>
        <option value = "Patient 7">Kassir</option>
        <option value = "Patient 8">Hend</option>
        <option value = "Patient 9">Nesma</option>
        <option value = "Patient 10">Samir</option>
        <option value = "Patient 11">Samantha</option>
        <option value = "Patient 12">Sami</option>
        <option value = "Patient 13">Samantha</option>
        <option value = "Patient 14">Sandi</option>
        <option value = "Patient 15">Karma</option>
        <option value = "Patient 16">Alaa</option>
        <option value = "Patient 17">Manyal</option>
        <option value = "Patient 18">Amal</option>
        <option value = "Patient 19">Manal</option>
        <option value = "Patient 20">Asma</option>
        <option value = "Patient 21">Nader</option>
        <option value = "Patient 22">Maher</option>
    </select>
    <input type="date" id="date3" name="date3">
    <p><button class="w3-btn w3-orange w3-xlarge"><i class="glyphicon glyphicon-trash"></i></input></button><!-- USED TO DELETE -->
    <!-- <button class="w3-btn w3-orange w3-xlarge"><i class="glyphicon glyphicon-user"></i></input></button><!-- USED TO NEW APPOINTMENTS -->
    <!-- </p>
</form>  -->
<a href = DBA.html>
    <button class="w3-button w3-deep-orange">Access to DBA page </button>
</a>

<?php include "resources/footer.php"; ?>
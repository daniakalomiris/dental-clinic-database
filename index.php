<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
     <title>Dentistry Database</title>
</head>
<body>
<h1 align = "center">Welcome to the Dentistry Database</h1>

<P>
  A.  View details of all dentists in the chosen clinic
</P>

<form method="post">
    <input type="submit" name="all" value="All"/>
    <input type="submit" name="clinic1" value="Clinic 1"/>
    <input type="submit" name="clinic2" value="Clinic 2" />
    <input type="submit" name="clinic3" value="Clinic 3"/>
</form>

<?php

if (isset($_POST['all'])) {
    try  {
       
        require "config.php";
        require "common.php";
    
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT Dentist.name, Dentist.DID, Clinic.name as clinicName, Assistant.name as assistantName
        FROM clinic, Dentist, Assistant
        WHERE Clinic.CIC=Dentist.CIC AND Dentist.DID=Assistant.DID";

        $statement = $connection->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll();

        if ($result && $statement->rowCount() > 0) {
        ?>
            <h3>Results</h3>
        <?php 
            foreach ($result as $row) { ?>
                <tr>
                    <td>Name: <?php echo $row["name"]; ?></td>
                    <td>Dentist ID: <?php echo $row["DID"]; ?></td>
                    <td>Clinic: <?php echo $row["clinicName"]; ?></td>
                    <td>Assistant: <?php echo $row["assistantName"]; ?></td>
                </tr>
                <br>
            <?php }
        }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} ?>

<P>
   B. Get details of all appointments for a given dentist for a specific week.
</P>

<form action = "SHOULD BE THE PHP CODE HERE">
    <select name = "dropdown">
        <option value = "Dentist 1" selected>Schmidt</option>
        <option value = "Dentist 2">Taylor</option>
        <option value = "Dentist 3">Camara</option>
        <option value = "Dentist 3">Telmo</option>
        <option value = "Dentist 3">Smurf</option>
        <option value = "Dentist 3">Snitzl</option>
        <option value = "Dentist 3">Pringles</option>
        <option value = "Dentist 3">Lays</option>
        <option value = "Dentist 3">Davis</option>
        <option value = "Dentist 3">Richards</option>
    </select>
    <select name = "dropdown">
        <option value = "Week 1" selected>Week 1</option>
        <option value = "Week 2">Week 2</option>
        <option value = "Week 3">Week 3</option>
    </select>

    <input type="submit" name="submit" value="Submit">
</form>

<!--
<p> SPACE TO PUT THE ANSWERS OF THE REQUIRED QUERY </p>
 -->
<P>
    C. Get details of all appointments at a given clinic on a specific date.
</P>

<form action = "SHOULD BE THE PHP CODE HERE">
    <select name = "dropdown">
        <option value = "Clinic 1" selected>Clinic 1</option>
        <option value = "Clinic 2">Clinic 2</option>
        <option value = "Clinic 3">Clinic 3</option>
    </select>
    <label for="date">Specific date:</label>
    <input type="date" id="date" name="date">
    <input type="submit">
</form>
<!--
<p> SPACE TO PUT THE ANSWERS OF THE REQUIRED QUERY </p>
 -->
<P>
    D. Get details of all appointments of a given patient.
</P>
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

    <input type="submit" name="submit" value="Submit">
</form>

<!--
<p> SPACE TO PUT THE ANSWERS OF THE REQUIRED QUERY </p>
 -->
<P>
    E. Get the number of missed appointments for each patient (only for patients who have missed at least 1 appointment).
</P>

<form action="SHOULD BE THE PHP CODE HERE" method="get">
    <input type="checkbox" name="patient1" value="patient1">
    <label for="patient1"> Sandi</label><br>
    <input type="checkbox" name="patient2" value="patient2">
    <label for="patient2"> Samir</label><br>
    <input type="checkbox" name="patient3" value="patient3" checked>
    <label for="patient3"> Maher</label><br>
    <input type="checkbox" name="patient1" value="patient1">
    <label for="patient4"> Kassir</label><br>
    <input type="checkbox" name="patient4" value="patient4">
    <label for="patient5"> Sandi</label><br>
    <input type="checkbox" name="patient5" value="patient5">
    <label for="patient6"> Amal</label><br>
    <br>
    <input type="submit" value="Submit">
</form>

<!--
<p> SPACE TO PUT THE ANSWERS OF THE REQUIRED QUERY </p>
 -->

<P>
    F. Get details of all the treatments made during a given appointment.
</P>

<form action = "SHOULD BE THE PHP CODE HERE">
    <select name = "dropdown">
        <option value = "Clinic 1" selected>Clinic 1</option>
        <option value = "Clinic 2">Clinic 2</option>
        <option value = "Clinic 3">Clinic 3</option>
    </select>
    <label for="date">Chose a given apointment at a given clinic:</label>
    <input type="date" id="date2" name="date2">
    <input type="submit">
</form>

<!--
<p> SPACE TO PUT THE ANSWERS OF THE REQUIRED QUERY </p>
 -->
<P>
    G. Get details of all the treatments made during a given appointment by clicking on the button below.
</P>
<button> Check unpaid bills </button>
<br>
Details about unpaid bills: <textarea name="comment" rows="5" cols="40"><?php "CODE HERE"?></textarea>
<P>
    Enter the name of the patient you would want to add
</P>
<form action="SHOULD BE PHP CODE HERE">
    <textarea placeholder="Write down the name of the patient you want to add" name="message" rows="3" cols="20"></textarea>
    <br>
    <input type="submit" value="Add new patient to the database">
</form>
<br>
<P>
    Select the patient you would like to schedule new appointments, modify, delete existing appointments
</P>
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
    <button class="w3-btn w3-orange w3-xlarge"><i class="glyphicon glyphicon-user"></i></input></button><!-- USED TO NEW APPOINTMENTS -->
    </p>
</form>
<a href = DBA.html>
    <button class="w3-button w3-deep-orange">Access to DBA page </button>
</a>
</body>
</html>
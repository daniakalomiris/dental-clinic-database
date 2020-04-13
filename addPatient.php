<?php require "resources/header.php"; ?>

<h4 style="margin-left: 25px;">Enter the Patient name you would want to add to the list of patients and a Patient ID will be generated</h4>

<br><form method="post">
<ul><input type="text" name="name" placeholder="Name"></ul>
<ul><br><button type="submit" name="submit"> Add patient</button></ul>

</form>

<?php

if (isset($_POST['submit'])) {
    try  {
        require "config.php";
        require "common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $name= $_POST['name'];

        $pid=rand(1,100);

        // only execute if a name was entered
        if (empty($_POST['name'])) { ?>
            <div class="alert alert-warning" role="alert" style="width: 250px; margin-left: 25px;">Please enter the patient's name.</div>
        <?php } else {

            $sql = "INSERT INTO patient(pid, name) VALUES('$pid','$name');";

            $statement = $connection->prepare($sql);
            $statement->execute(); ?>
            <div class="alert alert-success" role="alert" style="width: 500px; margin-left: 25px;"><?php echo $name ?> was succesfully added as a patient!</div>

        <?php }
    } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">There was an error adding the patient. Please try again.</div>
    <?php }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>
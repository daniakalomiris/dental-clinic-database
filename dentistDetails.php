<?php require "resources/header.php"; ?>

<?php

try  {
    require "config.php";
    require "common.php";

    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT DISTINCT Dentist.name, Dentist.DID, Clinic.name as clinicName
            FROM Clinic, Dentist
            WHERE Clinic.CIC=Dentist.CIC";

    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();

    if ($result && $statement->rowCount() > 0) { ?>
    <br>
    <?php 
        foreach ($result as $row) { ?>
            <tr>
                <td>Name: <?php echo $row["name"]; ?></td>
                <td>Dentist ID: <?php echo $row["DID"]; ?></td>
                <td>Clinic: <?php echo $row["clinicName"]; ?></td>
            </tr>
            <br>
        <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

?>

<br>

<a href="index.php">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>
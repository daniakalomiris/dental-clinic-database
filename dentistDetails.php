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
        <h4 style="margin-left: 25px;">Dentists</h4>
        <?php 
            foreach ($result as $row) { ?>
                <div class="card" style="margin-left: 25px;">
                    <tr>
                        <td>Name: <?php echo $row["name"]; ?></td>
                        <td>Dentist ID: <?php echo $row["DID"]; ?></td>
                        <td>Clinic: <?php echo $row["clinicName"]; ?></td>
                    </tr>
                </div>
                <br>
            <?php }
    }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>
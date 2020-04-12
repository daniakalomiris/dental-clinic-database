<?php require "resources/header.php"; ?>

<h2 align="center">Welcome to the DBA page!</h2>

<blockquote class="blockquote" align="center">
    <p class="mb-0">Here, you can enter your desired query and view the results of the executed statement.</p>
</blockquote>

<form method="post" style="margin-left: 25px;">
    <textarea placeholder="Enter desired query" name="query" rows="7" cols="70"></textarea>
    <br><br>
    <input type="submit" name="submit">
</form>

<br>

<?php

if (isset($_POST['submit'])) {
    try  {
        require "config.php";
        require "common.php";
    
        $connection = new PDO($dsn, $username, $password, $options);

        // only execute if a query was entered
        if (empty($_POST['query'])) { ?>
            <div class="alert alert-warning" role="alert" style="width: 250px; margin-left: 25px;">Please enter a query.</div>
        <?php } else {
            $sql = " " . htmlspecialchars($_POST['query']) . " ";
            $statement = $connection->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll();

            if ($result && $statement->rowCount() > 0) { ?>
                <div class="alert alert-success" role="alert" style="width: 500px; margin-left: 25px;">Query was succesfully executed!</div>
                <h4 style="margin-left: 25px;">Query results</h4>
                <div class="card" style="margin-left: 25px;">
                <?php foreach ($result as $row) { 
                    print_r($row); ?>
                    <br>
                <?php } ?>
                </div>
            <?php } else {
                echo "There are no results for this query.";
            }
        }    
    } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">You have an error in your SQL syntax. Please enter a valid query.</div>
    <?php }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>
<?php require "resources/header.php"; ?>

<h2 align="center">Welcome to the DBA page!</h2>

<blockquote class="blockquote" align="center">
    <p class="mb-0">Here, you can enter your desired query and view the results of the executed statement.</p>
</blockquote>



<form method="post" style="margin-left: 25px;">
    <select name="queryType">
        <option value="" selected disabled hidden>Select type of query</option>
        <option value="SELECT">SELECT</option>
        <option value="INSERT">INSERT</option>
        <option value="INSERT">UPDATE</option>
        <option value="INSERT">DELETE</option>
    </select>
    <br><br>
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
        if (empty($_POST['query']) || empty($_POST['queryType'])) { ?>
            <div class="alert alert-warning" role="alert" style="width: 350px; margin-left: 25px;">Please select a query type and enter a query.</div>
        <?php } else {
            $sql = " " . htmlspecialchars($_POST['query']) . " ";
            $statement = $connection->prepare($sql);
            $statement->execute();

            if($_POST['queryType'] == 'SELECT') {
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
            } else { ?>
                <div class="alert alert-success" role="alert" style="width: 500px; margin-left: 25px;">Query was succesfully executed!</div>
            <?php }
        }    
    } catch(PDOException $error) { ?>
        <div class="alert alert-danger" role="alert" style="width: 500px; margin-left: 25px;">You have an error in your SQL syntax. Please enter a valid query.</div>
        <?php echo $sql . "<br>" . $error->getMessage(); ?>
    <?php }
} ?>

<br>

<a href="index.php" style="margin-left: 25px;">Back to home</a>

<?php require "resources/footer.php"; ?>
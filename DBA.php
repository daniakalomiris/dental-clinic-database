<?php require "resources/header.php"; ?>

<h2 align="center">Welcome to the DBA page!</h2>

<blockquote class="blockquote" align="center">
    <p class="mb-0">Here, you can enter your desired query and view the results of the executed statement.</p>
</blockquote>

<form method="post" style="margin-left: 25px;">
    <textarea placeholder="Write down the desired query" name="message" rows="7" cols="70"></textarea>
    <br><br>
    <input type="submit">
</form>
<br>

<a href="index.php" style="margin-left: 25px;">Return to Dentistry Database</a>

<?php require "resources/footer.php"; ?>
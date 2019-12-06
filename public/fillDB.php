<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fill database with usable data</title>
</head>
<body>
    <p>Please note that each data should be line separated from the rest.</p>
    <form action="./logic/fill.php" method="POST" enctype="multipart/form-data">
        <label for="db_records">Choose file to import records from: </label>
        <input name="db_records_file" type="file">
        <br>
        <input type="submit" name="fill" value="Fill">
        <!-- <label for="db_table">Choose <b>CORRECT</b> table name to fill: </label><input name="db_table" type="text"> -->
    </form>
</body>
</html>
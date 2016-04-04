<?php

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo 'Текст, отправляемый в том случае,
    если пользователь нажал кнопку Cancel';
    exit;
} else {
    $config = require( "./config/tasks.php" );
    
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    
    //if ( $username != $config["username"] || $password != $config["password"] ) exit("Bad credentials");
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">   
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container" style="margin-top:50px;">
        <legend>Tasks list:</legend>
        <?php foreach( $config["tasks"] as $taskName => $task ) { ?>
        <div class="row">
            <div class="col-md-9">
                <div class="alert alert-info" role="alert"><?php echo $task["description"] ?></div>
            </div>
            <div class="col-md-3">
                <a href="/?task=<?php echo $taskName ?>&password=<?php echo $task["password"] ?>" class="btn btn-primary btn-block big-button">Запустить</a>
            </div>
        </div>
        <?php } ?>
    </div>
</body>
</html>
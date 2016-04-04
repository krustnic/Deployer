<?php

function responseBasicAuth() {
    header('WWW-Authenticate: Basic realm="deployer"');
    header('HTTP/1.0 401 Unauthorized');

    echo "You should specify login/password from config file. Reload page and try again.";
    exit;
}

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    responseBasicAuth();
} else {
    $config = require("./config/tasks.php");
    
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];

    if ( $username != $config["username"] || $password != $config["password"] ) {
        responseBasicAuth();
    };
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="libs/bootstrap.min.css">
    <link rel="stylesheet" href="libs/sweetalert2.css">
    <link rel="stylesheet" href="css/styles.css">

    <script src="libs/jquery-2.2.2.min.js"></script>
    <script src="libs/sweetalert2.min.js"></script>
    <script src="libs/bootstrap.min.js"></script>
</head>
<body>
    <div class="container" style="margin-top:50px;">
        <div id="task-response-div">
            <legend>Task response</legend>

            <div class="row">
                <div class="col-md-12">
                    <pre id="task-response-content">When you run task you will see response here.</pre>
                </div>
            </div>
        </div>

        <br>
        <div>
            <legend>Tasks list:</legend>
            <?php foreach( $config["tasks"] as $taskName => $task ) { ?>
            <div class="row">
                <div class="col-md-9">
                    <div class="alert alert-warning" role="alert"><?php echo $task["description"] ?></div>
                </div>
                <div class="col-md-3">
                    <button data-type="run-task"
                            data-description="<?php echo $task["description"] ?>"
                            data-url="/?task=<?php echo $taskName ?>&password=<?php echo $task["password"] ?>"
                            class="btn btn-primary btn-block big-button">RUN</button>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
        $(function() {
            $("[data-type=run-task]").click(function() {
                var taskUrl         = $(this).attr("data-url");
                var taskDescription = $(this).attr("data-description");

                swal({
                    title: 'Warning!',
                    html : 'Are you sure then you want to run this task:<br>' + taskDescription,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No',
                    closeOnConfirm: false,
                    allowOutsideClick: false
                },
                function() {

                    swal.disableButtons();

                    $.ajax({
                        type : "POST",
                        url : taskUrl
                    }).always(function( response ) {
                        $("#task-response-content").html( response.responseText );
                        $("#task-response-div").show();

                        swal('Task is completed!');
                    });
                })
            });
        })
    </script>

</body>
</html>
<?php

$config = require("./config/tasks.php");

// Get user password
$password = isset($_GET["password"]) ? $_GET["password"] : "";

// Get task name from GET parameters of Webhook
$taskName = isset($_GET["task"]) ? $_GET["task"] : "";
               
if ( !isset($config["tasks"][$taskName]) ) {
    http_response_code(500);
    echo "Unknown task name";
    exit;
}
//
                                                        
$task = $config["tasks"][$taskName];                                                          
                                                        
if ( $password != $task["password"] ) {
    http_response_code(401);
    echo "Bad password";
    exit;
}                                                                                                     
                                                
// Run custom command if specified
if ( isset($task["custom-command"]) && $task["custom-command"] != "" ) {
    $output = shell_exec( $task["custom-command"]  );
    http_response_code(200);
    echo $output;
    exit;
}               
                                                        
// Run git fetch/reset
$cmd = "{$config['git-path']} --git-dir={$task['git-dir']} --work-tree={$task['work-tree']} fetch --all && {$config['git-path']} --git-dir={$task['git-dir']} --work-tree={$task['work-tree']} reset --hard {$task['branch']}";
$output = shell_exec( $cmd );
http_response_code(200);
echo $output;
exit;

?>
<?php
function response( $status, $message ) {
    http_response_code($status);
    echo $message;
    exit;
}

$config = require("./config/tasks.php");

// Get user password
$password = isset($_GET["password"]) ? $_GET["password"] : "";

// Get task name from GET parameters of Webhook
$taskName = isset($_GET["task"]) ? $_GET["task"] : "";
               
if ( !isset($config["tasks"][$taskName]) ) {
    response(500, "Unknown task name: ".$taskName);    
}
//
                                                        
$task = $config["tasks"][$taskName];                                                          
                                                        
if ( $password != $task["password"] ) {
    response(401, "Bad password");    
}                                                                                                     
                                                
// Run custom command if specified
if ( isset($task["custom-command"]) && $task["custom-command"] != "" ) {
    $output = shell_exec( $task["custom-command"]  );
    response(200, $output);    
}    
//

if ( !isset($config['git-path']) || !file_exists($config['git-path']) ) {
    response(500, "Git path not exist: ".$config['git-path']);    
}
 
if ( !isset($task['git-dir']) || !file_exists($task['git-dir']) ) {
    response(500, "Git-dir path not exist: ".$task['git-dir']);    
}

if ( !isset($task['work-tree']) || !file_exists($task['work-tree']) ) {
    response(500, "Git work-tree path not exist: ".$task['work-tree']);    
}

if ( !isset($task['branch']) || $task['branch'] == "" ) {
    response(500, "No branch specified!");    
}

// Run git fetch/reset
$cmd = "{$config['git-path']} --git-dir={$task['git-dir']} --work-tree={$task['work-tree']} fetch --all && {$config['git-path']} --git-dir={$task['git-dir']} --work-tree={$task['work-tree']} reset --hard {$task['branch']}";
$output = shell_exec( $cmd );
response(200, $output);
?>
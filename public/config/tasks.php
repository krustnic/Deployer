<?php
return [
    // Username and password for web panel
    "username" => "deployer",
    "password" => "password",
    
    "git-path" => "/usr/bin/git", // Path to git command
    "tasks"    => [        
        // Task name. Would be used in GET parameter at Webhook URL
        "task1" => [            
            "description" => "Project X deploy", // Description for web panel interface
            "password"  => "password",
            "branch"    => "origin/master", // Branch name to hard reset from
            "git-dir"   => "/var/www/site1/.git", // Path to .git of your project (.git is included)
            "work-tree" => "/var/www/site1", // Path to your project files (in 99% cases it's a previous path without ".git"),            
            "custom-command" => "" // If set - would be executed instead of default git fetch/reset commands
        ]        
    ]
];
?>
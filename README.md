Deployer
========

Simple script to deploy git repositories via Webhook

How it works
------------

Used as virtual host for apache which gives you central url for webhooks to deploy (fetch/reset) any other virtual hosts. 

Example webhook url:

    https://deployer.orgname.com?task=MyProject&password=HttpsSecureGetParanetersToo

**Note! You definitely should use SSL!**


Configuration example:

    [
        "git-path" => "/usr/bin/git", // Path to git command
        "tasks"    => [
            // Task name. Would be used in GET parameter in Webhook URL
            "task1" => [
                "password"  => "password",                                  
                "branch"    => "origin/master", // Branch name to hard reset from            
                "git-dir"   => "/var/www/site1/.git", // Path to .git of your project (.git is included)            
                "work-tree" => "/var/www/site1", // Path to your project files (in 99% cases it's a previous path without ".git"),

                "custom-command" => "" // If set - would be executed instead of default git fetch/reset commands
            ]
        ]
    ];

How to use
----------

1. Clone repository in your web root folder:

        cd /var/www
        git clone https://github.com/krustnic/Deployer.git
    
2. Create new virtual host

    sudo nano /etc/apache2/sites-available/deployer.conf
    
        <VirtualHost *:80>    
            DocumentRoot "/var/www/deployer/public"
            ServerName deployer.orgname.com

            <Directory "/var/www/deployer/public">
                    Options Indexes FollowSymLinks Includes ExecCGI
                    AllowOverride All
                    Require all granted
            </Directory>

            ErrorLog ${APACHE_LOG_DIR}/deployer-error.log
        </VirtualHost>
    
3. Enable virtual host

        sudo a2ensite deployer
    
4. Now edit configuration file at /var/www/deployer/public/config/tasks.php and that's it!

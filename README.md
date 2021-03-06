Deployer
========

Simple script to deploy git repositories via Webhook or web-interface.

How it works
------------

Used as virtual host for apache which gives you central url for webhooks to deploy (fetch/reset) any other virtual hosts. 

Example webhook url:

    https://deployer.orgname.com?task=MyProject&password=HttpsSecureGetParanetersToo

**Note! You definitely should use SSL!**


Configuration example:

    [
        // Username and password for web panel
        "username" => "deployer",
        "password" => "password",

        "git-path" => "/usr/bin/git", // Path to git command
        "tasks"    => [
            // Task name. Would be used in GET parameter in Webhook URL
            "task1" => [
                "description" => "",
                "password"    => "password",
                "branch"      => "origin/master", // Branch name to hard reset from
                "git-dir"     => "/var/www/site1/.git", // Path to .git of your project (.git is included)
                "work-tree"   => "/var/www/site1", // Path to your project files (in 99% cases it's a previous path without ".git"),

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
    
    or with SSL:
    
        <VirtualHost *:443>
            DocumentRoot "/var/www/deployer/public"
            ServerName deployer.orgname.com

            <Directory "/var/www/deployer/public">
                    Options Indexes FollowSymLinks Includes ExecCGI
                    AllowOverride All
                    Require all granted
            </Directory>

            ErrorLog ${APACHE_LOG_DIR}/deployer-error.log

            SSLCertificateFile /etc/letsencrypt/live/deployer.orgname.com/cert.pem
            SSLCertificateKeyFile /etc/letsencrypt/live/deployer.orgname.com/privkey.pem            
            SSLCertificateChainFile /etc/letsencrypt/live/deployer.orgname.com/chain.pem
        </VirtualHost>
        
3. Enable virtual host

        sudo a2ensite deployer
        sudo service apache2 reload

4. Create new tasks.php file: `cp config/tasks.example.php config/tasks.php`

5. Now edit configuration file at /var/www/deployer/public/config/tasks.php and that's it!

Web Interface
-------------

Web interface is available on "/" url with empty task name or on "/web".
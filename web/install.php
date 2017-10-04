<?php

/**
 * INSTALLER
 * 
 * @name        install.php
 * @package     git-framework.local
 * @version     1.0.0
 * @since       02-Oct-2017 16:37:07
 * @author      Jon Thompson
 * @abstract    Script to install the necessary files/folders to the framework
 */

$install = new install();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteName           = trim($_POST['siteName']);
    $adminEmailAddress  = trim($_POST['adminEmailAddress']);
    $adminPassword      = trim($_POST['adminPassword']);
    $installPath        = trim($_POST['installPath']);
    $dbHostname         = trim($_POST['dbHostname']);
    $dbUsername         = trim($_POST['dbUsername']);
    $dbPassword         = trim($_POST['dbPassword']);
    $dbDatabase         = trim($_POST['dbDatabase']);
    
    $errors = array();
    
    /**
     * Make sure we have all the data needed
     */
    if($siteName == "") {
        $errors[] = "Missing site name";
    }
    
    if($adminEmailAddress == "") {
        $errors[] = "Missing admin email address";
    }
    
    if($adminPassword == "") {
        $errors[] = "Missing admin password";
    }
    
    if($installPath == "") {
        $errors[] = "Missing install path";
    }    
    
    if($dbHostname == "") {
        $errors[] = "Missing database hostname";
    }
    
    if($dbUsername == "") {
        $errors[] = "Missing database username";
    }
    
    if($dbPassword == "") {
        $errors[] = "Missing database password";
    }
    
    if($dbDatabase == "") {
        $errors[] = "Missing database name";
    }
    
    /**
     * Check the MySQL connection
     */
    try {
        $db = new \PDO("mysql:dbname=" . $dbDatabase . ";host=" . $dbHostname, $dbUsername, $dbPassword, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
        
        $errors[] = preg_replace("/^.*\]/", "", $e->getMessage());
    }
    
    if(count($errors)) {
        echo "<span class='red'>The following errors have been found:<ul>";
        
        foreach($errors as $error) {
            echo "<li>$error</li>";
        }
        
        echo "</ul></span>";
        exit;
    }
    
    /**
     * We can now continue with the install
     */
    $install->basePath   = dirname(rtrim($installPath, "/"));
    $install->dbHostname = $dbHostname;
    $install->dbUsername = $dbUsername;
    $install->dbPassword = $dbPassword; 
    $install->dbDatabase = $dbDatabase;
    
    /**
     * Create files necessary to run
     */
    file_put_contents($install->basePath . "/web/.htaccess", $install->htaccess());
    file_put_contents($install->basePath . "/web/config.php", $install->config());
    
    /**
     * Create required folders
     */
    include_once($install->basePath . "/web/config.php");
    $class = new ReflectionClass("\config\config");
    $constants = $class->getConstants();
    
    foreach($constants as $key=>$value) {
        if(substr($key, 0, 4) == "DIR_") {
            if(!file_exists($value) && !is_dir($value)) {
                if(!mkdir($value, 0755)) {
                    echo "<span class='red'>Cannot create folder at {$value}";
                    exit;
                }
                
                if(!chmod($value, 0755)) {
                    echo "<span class='red'>Cannot set permissions on {$value}";
                    exit;
                }
            }
        }
    }
    
    echo "<p></p><p><span class='green'>Installation has now completed</span></p>";
    exit;
}


$install->showForm();



class install {
    public $basePath;
    public $adminEmailAddress;
    public $self; 
    public $randomPassword;
    public $siteName;
    public $baseUrl;
    public $currentPath;
    public $dbHostname;
    public $dbUsername;
    public $dbPassword;
    public $dbDatabase;
    
    function __construct() {
        $this->currentPath = realpath(dirname(__FILE__));
        $this->adminEmailAddress = $_SERVER["SERVER_ADMIN"];
        $this->self = basename(__FILE__);
        $this->siteName = ucwords(preg_replace("/[\.-]/", " ", trim($_SERVER["HTTP_HOST"])));
        $this->randomPassword = $this->getRandomPassword();
        $this->baseUrl = "{$_SERVER["REQUEST_SCHEME"]}://{$_SERVER["HTTP_HOST"]}";
    }
    
    /**
     * Generate a random password from my remote API
     * 
     * @return string The random password
     */
    function getRandomPassword() {
        $url = 'https://www.jonthompson.co.uk/api/password';
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, $url);
        curl_setopt($curlSession, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curlSession, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curlSession, CURLOPT_FORBID_REUSE, TRUE);
        curl_setopt($curlSession, CURLOPT_FRESH_CONNECT, TRUE);
        curl_setopt($curlSession, CURLOPT_HEADER, FALSE);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curlSession, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curlSession, CURLOPT_SSL_VERIFYPEER, FALSE);
        $return = curl_exec($curlSession);

        if($return === FALSE || $return == "") {
            $errorMessage = curl_error($curlSession);
            $errorNumber  = curl_errno($curlSession);
            echo "[{$errorNumber}] {$errorMessage}";
            exit;
        }

        // Close the session
        curl_close($curlSession);

        // Return the page
        return $return;
    }
    
    /**
     * Display the installation form
     */
    function showForm() {
        echo <<<EOD
<html>
    <head>
        <meta charset='utf-8'>
        <meta  name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no'>
        <link rel="icon" type="image/png" href="http://remote.jonthompson.co.uk/generic/images/gearIcon.png" sizes="32x32">
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <meta name="description" content="Framework installer">
        <meta name="keywords" content="">
        <meta name="author" content="Jon Thompson">

        <title>:: INSTALLER ::</title>

        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/marx/2.0.7/marx.min.css" />
        <style>
            label {display: block; color: #ABC;}
            input {display: block; border: 1px solid #CCC;padding: 5px; width: 100%;}
            .row {display: block;width: 100%}
            .column1_1 {display: block;width: 100%}
            .column1_2 {display: block;width: 45%; float: left;}
            .column1_2:last-child {float: right;}
            .red {color: #F00;}
            .green {color: #4A2;}
        </style>
        <script>
            $(document).ready(function() { 
                var options = { 
                    target:        '#results',
                    beforeSubmit:  showRequest,
                    success:       showResponse
                }; 

                $('#installForm').ajaxForm(options); 
            });
        
        function showRequest(formData, jqForm, options) { 
            return true; 
        } 
 
        function showResponse(responseText, statusText, xhr, \$form)  { 
              
        }
        </script>
    </head>
    <body>
        <main id='main'>
            <h1><i class="fa fa-cog" aria-hidden="true"></i> Framework Installer</h1>
            <p>Please complete the details below to install this framework. Ensure that the database and user have already been set up. <span class='red'>All fields are required</span></p>
            
            <form id='installForm' method='POST' action='{$this->self}'>
                <div class="row">
                    <div class="column1_2">
                        <h2>Site Details</h2>
                        <label for="siteName">Site Name</label>
                        <input type="text" id="siteName" name="siteName" value="{$this->siteName}" required />
                        <p></p>
                        
                        <label for="adminEmailAddress">Admin Email Address</label>
                        <input type="email" id="adminEmailAddress" name="adminEmailAddress" value="{$this->adminEmailAddress}" required />
                        <p></p>

                        <label for="adminPassword">Admin Password</label>
                        <input type="text" id="adminPassword" name="adminPassword" value="{$this->randomPassword}" required />
                        <p></p>
                        
                        <label for="installPath">Install Path</label>
                        <input type="text" id="installPath" value="{$this->currentPath}" disabled />
                        <input type="hidden" name="installPath" value="{$this->currentPath}" />
                        <p></p>
                    </div>
                    <div class="column1_2">
                        <h2>Database Details</h2>
                        <label for="dbHostname">Hostname</label>
                        <input type="text" id="dbHostname" name="dbHostname" value="localhost" required />
                        <p></p>
                        
                        <label for="dbUsername">Username</label>
                        <input type="text" id="dbUsername" name="dbUsername" value="root" required />
                        <p></p>
                        
                        <label for="dbPassword">Password</label>
                        <input type="text" id="dbPassword" name="dbPassword" value="" required />
                        <p></p>
                        
                        <label for="dbDatabase">Database</label>
                        <input type="text" id="dbDatabase" name="dbDatabase" value="" required />
                        <p></p>
                    </div>
                </div>
                
                <button type="submit">Install</button>
            </form>
            <div id='results'></div>
        </main>
    </body>
</html>
EOD;
    }
    
    /**
     * Return the basic htaccess rules
     * 
     * @return string The text to write to file
     */
    function htaccess() {
        $htaccess = <<<EOD
Options -Indexes

RewriteEngine On

RewriteRule ^index\.php$ - [L]

RewriteCond %{REQUEST_FILENAME} -d
RewriteRule ^(.+[^/])$ $1/ [R]

# Prevent direct access to certain folders unless via a POST
RewriteCond %{REQUEST_FILENAME} -f
RewriteCond %{REQUEST_METHOD} !POST
RewriteCond %{REQUEST_URI} /(core|site|includes)
RewriteRule $.*$ - [R=403,F,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ /index.php/$1 [L]
EOD;
        
        return $htaccess;
    }
    
    /**
     * Build and return the config file based on user input from the installation form
     * 
     * @return string The text to write to file
     */
    function config() {
        $config = <<<EOD
<?php
/**
 * config.php
 * 
 * Configuration
 * 
 * @name        config.php
 * @package     framework.local
 * @version     4.0.0
 * @since       08-May-2017 16:57:40
 * @author      Jon Thompson
 * 
 * The main configuration file for the app. All fields are required
 */

namespace config;

class config {
    /**
     * Database connection details
     */
    const DB_HOSTNAME   = '{$this->dbHostname}';
    const DB_USERNAME   = '{$this->dbUsername}';
    const DB_PASSWORD   = '{$this->dbPassword}';
    const DB_DATABASE   = '{$this->dbDatabase}';
    
    
    /**
     * Paths
     */
    const DIR_BASE     = '{$this->basePath}';
    const DIR_LIBRARY  = self::DIR_BASE . "/app";
    const DIR_WEB      = self::DIR_BASE . '/web';
    const DIR_SITE     = self::DIR_WEB . "/site";
    const DIR_INCLUDES = self::DIR_WEB . "/includes";
    const DIR_TEMPLATES = self::DIR_WEB . "/templates";
    const DIR_PRIVATE  = self::DIR_BASE . '/private';
    const DIR_UPLOADS  = self::DIR_BASE . '/uploads';
    const DIR_LOGS     = self::DIR_BASE . '/logs';
    const DIR_CACHE    = self::DIR_BASE . '/cache';

   
    /**
     * URLs
     */
    const BASE_URL      = '{$this->baseUrl}';
    
    /**
     * Site settings
     */
    const SITE_NAME     = '{$this->siteName}';
    const TEMPLATE      = "default";
    
    
    /**
     * Options (not implemented yet)
     */
    const LOG_ERRORS    = FALSE;
    const NOTIFY_ADMIN  = FALSE;
    const USE_CACHE     = FALSE;
    const DEBUG         = FALSE;
    const USE_HTTPS     = FALSE;
}
EOD;
    
        return $config;
    }
}

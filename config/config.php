<?php

$dbhost = 'localhost';
$dbname = 'real_estate_project';
$dbuser = 'root';
$dbpass = 'vannguyenv12';

try {
    $pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    echo "Connection error :" . $exception->getMessage();
}
define("BASE_URL", "http://real-estate-project.test/");
define("ADMIN_URL", BASE_URL . "admin/");


define("SMTP_HOST", "sandbox.smtp.mailtrap.io");
define("SMTP_PORT", "465");
define("SMTP_USERNAME", "55fd40ae3b8660");
define("SMTP_PASSWORD", "7470e3fa31f25c");
define("SMTP_ENCRYPTION", "tls");
define("SMTP_FROM", "contact@vannguyen.com");

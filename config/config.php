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

// Paypal
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

define('CLIENT_ID', 'AaPMKYRpZiPE5ZQ0IsTKq25yR46CwUib74X12Z2g_9Htk1TGfTwOlS1twS4J-nf-vwIpsyd8j5b_v2eu');
define('CLIENT_SECRET', 'ELURv5NZMBUO6aiPF7T-sa2c3mFon39HbO6Cw29ruCYkbn9hlVaVZrLYBpq8f7fgBjUgeA4aRKkzMV6F');

define('PAYPAL_RETURN_URL', BASE_URL . 'agent-paypal-success.php');
define('PAYPAL_CANCEL_URL', BASE_URL . 'agent-paypal-cancel.php');
define('PAYPAL_CURRENCY', 'USD'); // set your currency here

$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true); //set it to 'false' when go live

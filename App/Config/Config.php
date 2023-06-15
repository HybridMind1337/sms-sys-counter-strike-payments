<?php
/**
 * @class ${FILE}
 * @created 01/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Database connection
 */
const SERVER_HOST = 'localhost';
const DB_NAME = 'amxx';
const DB_USERNAME = 'amxx';
const DB_PASSWORD = 'ch8JQP1]EcUXqJ3]';

/**
 * SYSTEM CONST
 */

const SITE_URL = 'http://localhost/payments/';
const SITE_NAME = 'Payments';

const UNBAN_PRICE = 10;
/**
 * Session time
 * Please don't change it if you don't know exactly what it does.
 */
$timeout = 2419200;
ini_set("session.gc_maxlifetime", $timeout);
ini_set("session.cookie_lifetime", $timeout);
session_set_cookie_params($timeout);
session_start();
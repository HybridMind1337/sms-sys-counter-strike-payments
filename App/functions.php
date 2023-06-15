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

require_once 'services.php';

function checkCsrfToken()
{
    $csrfToken = new \App\CSRFToken();

    $method = strtolower($_SERVER['REQUEST_METHOD'] ?? 'GET');
    if ($method == 'post') {
        $isPassed = true;

        if (isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {
            if (!$csrfToken->check('token', $_SERVER['HTTP_X_CSRF_TOKEN'], '7600', true)) {
                die('CSRF Token has been expired, please refresh the page.');
            }
            return true;
        }

        if (!isset($_SERVER['HTTP_X_CSRF_TOKEN'])) {

            if (!isset($_POST['_token']) || empty($_POST['_token'])) {
                $isPassed = false;
            }
            if (!isset($_SESSION['form_token']) || empty($_SESSION['form_token'])) {
                $isPassed = false;
            }

            if (isset($_POST['_token'])) {
                if (!$csrfToken->check('token', $_POST['_token'])) {
                    $isPassed = false;
                }
            }
            if (!$isPassed) {
                $ref_url = $_SERVER['HTTP_REFERER'] ?? '/';
                redirect($ref_url, 'Невалиден CSRF токен, моля опитайте отново.', 'danger');
                exit();
            }
        }
    }
}

/**
 * @param $location
 * @param false $message
 * @param string $alert
 */
function redirect($location, $message = false, string $alert = 'success')
{
    if ($message != false) {
        $_SESSION['alert'] = [
            'status' => true,
            'message' => $message,
            'alert' => $alert,
        ];
    }
    echo '<script data-cfasync="false">window.location.replace("' . str_replace('&amp;', '&', htmlspecialchars($location)) . '");</script>';
    die();
}

/**
 * @return mixed|string
 */
function getRequestPage()
{
    return $_SERVER['HTTP_REFERER'] ?? '/home';
}

/**
 * @return array|false
 */
function getSessionMessage()
{
    if (isset($_SESSION['alert'])) {
        return [
            'message' => $_SESSION['alert']['message'],
            'alert' => $_SESSION['alert']['alert']
        ];
    }
    return null;
}

/**
 * @param $string
 * @param $toCheck
 * @return string
 */
function checkSelected($string, $toCheck): string
{
    if (is_array($toCheck)) {
        if (in_array($string, $toCheck, true)) {
            return 'selected';
        }
    }
    if ($string == $toCheck) {
        return 'selected';
    }
    return '';
}

function getIP(): string
{
    //HTTP_CF_CONNECTING_IP
    $array = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR',
        'HTTP_CF_CONNECTING_IP'
    ];
    foreach ($array as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip); // just to be safe
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE) !== false) {
                    return $ip;
                }
                return $ip;
            }
        }
    }

    return false;

}

/**
 * @param $date
 * @param string $format
 * @return string
 */
function formatDate($date, string $format = 'd/m/Y'): string
{
    return date($format, $date);
}

/**
 * @param $string
 * @param string $value
 * @return string
 */
function getPost($string, $value = ''): string
{
    if (isset($_POST[$string])) {
        return $_POST[$string];
    }
    return $value;
}

function shorterText($text, $limit = 200, $endOfText = '')
{
    // Check if length is larger than the character limit
    if (strlen($text) > $limit) {
        // If so, cut the string at the character limit
        $new_text = substr(strip_tags($text), 0, $limit);
        // Trim off white space
        $new_text = trim($new_text);
        // Add at end of text ...
        return $new_text . $endOfText;
    }
    //if not just return text as is
    return $text;

}

/**
 * @return string
 */
function csrf_token(): string
{
    $token = $_SESSION['form_token'] ?? '';
    return '<input class="_token" id="_token" name="_token" value="' . $token . '" type="hidden">';
}

/**
 * @return string
 */
function greeting(): string
{
    date_default_timezone_set('Europe/Sofia');
    $hour = date('G');

    if ($hour >= 5 && $hour < 12) {
        return "Добро утро!";
    } elseif ($hour >= 12 && $hour < 18) {
        return "Добър ден!";
    } else {
        return "Добър вечер!";
    }
}

function minutsToWords($dif, $short = false, $server = false): ?string
{
    if ($dif == 0) {
        return $server ? '' : 'Завинаги';
    }
    if ($dif == '-1') {
        return 'Ънбанат';
    }

    $dif = $server ? $dif : $dif * 60;

    if ($dif) {
        $s = '';
        $years = (int)($dif / (60 * 60 * 24 * 365));
        $dif -= ($years * (60 * 60 * 24 * 365));

        if ($years) {
            $s .= "{$years} г.";
        }
        if ($years && $short) {
            return $s;
        }

        $months = (int)($dif / (60 * 60 * 24 * 30));
        $dif -= ($months * (60 * 60 * 24 * 30));
        if ($months) {
            $s .= "{$months} м.";
        }
        if ($months && $short) {
            return $s;
        }

        $weeks = (int)($dif / (60 * 60 * 24 * 7));
        $dif -= ($weeks * (60 * 60 * 24 * 7));

        if ($weeks) {
            $s .= "{$weeks} сед.";
        }

        if ($weeks && $short) {
            return $s;
        }

        $days = (int)($dif / (60 * 60 * 24));
        $dif -= ($days * (60 * 60 * 24));
        if ($days) {
            $s .= "{$days} ден.";
        }
        if ($days && $short) {
            return $s;
        }

        $hours = (int)($dif / (60 * 60));
        $dif -= ($hours * (60 * 60));
        if ($hours) {
            $s .= "{$hours} час.";
        }
        if ($hours && $short) {
            return $s;
        }

        $minutes = (int)($dif / 60);
        $seconds = $dif - ($minutes * 60);
        if ($minutes) {
            $s .= "{$minutes} мин.";
        }
        if ($minutes && $short) {
            return $s;
        }

        if ($short) {
            return "{$seconds} сек.";
        }

        return $s;
    }

    return NULL;
}

function futureDate($days)
{ // Get the current date
    $currentDate = date('d/m/Y');

    // Convert the current date to a DateTime object
    $currentDateTime = DateTime::createFromFormat('d/m/Y', $currentDate);

    // Add specified number of days to the current date
    $currentDateTime->add(new DateInterval('P' . $days . 'D'));

    // Format the future date as a string
    $futureDateFormatted = $currentDateTime->format('d/m/Y');

    // Return the future date
    return $futureDateFormatted;
}
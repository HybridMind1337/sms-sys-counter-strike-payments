<?php
/**
 * @class ${FILE}
 * @created 05/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

function NotAuth()
{
    if (\App\Session::exists('user_id')) {
        redirect(SITE_URL . 'dashboard');
        exit();
    }
}

function Auth()
{
    if (!\App\Session::exists('user_id')) {
        redirect(SITE_URL, 'Моля, влезте в акаунта си за да имате достъп до тази страница', 'error');
        exit();
    }
}

function getUser($string, $user_id = '')
{
    $app = new \App\Kernal();

    if (empty($user_id)) {
        $user_id = $_SESSION['user_id'] ?? 0;
        $data = $app->getDatabase()->getWhere('users', ['id', '=', $user_id])->getFirst();
    } else {
        $data = $app->getDatabase()->getWhere('users', ['id', '=', htmlspecialchars($user_id)])->getFirst();
    }

    if (!$data) {
        return null;
    }

    return $data?->$string;
}

/**
 * @param $user_id
 * @param $service_id
 * @param $code
 * @return bool|string
 */
function smspay_check_code($user_id, $service_id, $code)
{
    $host = 'rcv.smspay.bg';
    $path = sprintf("/users/check_code.php?service_id=%d&code=%s&user_id=%d", $service_id, $code, $user_id);
    $url = 'http://' . $host . $path;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * @return bool
 */
function checkIfBanned(): bool
{
    $app = new \App\Kernal();
    $data = $app->getDatabase()->getWhere('amx_bans', ['player_ip', '=', getIP()])->getFirst();

    if ($data) {
        return true;
    }

    return false;
}

/**
 * @param $amount
 */
function remove_credits($amount)
{
    $app = new \App\Kernal();
    $app->getDatabase()->query('UPDATE users SET balance = balance - ? WHERE id = ?', [$amount, \App\Session::get('user_id')]);
}

/**
 * @param $amount
 */
function set_credits($amount)
{
    $app = new \App\Kernal();
    $app->getDatabase()->query('UPDATE users SET balance = balance + ? WHERE id = ?', [$amount, \App\Session::get('user_id')]);
}

/**
 * @param $service
 * @param $balance
 */
function setTransaction($service, $balance)
{
    $app = new \App\Kernal();
    $app->getDatabase()->query('INSERT INTO transactions (user_id, service, balance, date) VALUES (?, ?, ?, ?)', [\App\Session::get('user_id'), $service, $balance, time()]);
}

/**
 * @param $amount
 * @param $balance
 * @param string $type
 */
function setChronology($amount, $balance, string $type = 'SMS')
{
    $app = new \App\Kernal();
    $app->getDatabase()->query('INSERT INTO chronology (user_id, amount, balance, date, type) VALUES (?, ?, ?, ?, ?)', [\App\Session::get('user_id'), $amount, $balance, time(), $type]);
}
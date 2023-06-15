<?php
/**
 * @class Kernal
 * @created 31/03/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

namespace App;

use App\Database;

class Kernal
{

    protected Database $db;
    public CSRFToken $csrftoken;
    private $logger;

    public function __construct()
    {
        $this->db = new Database(SERVER_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
        $this->csrftoken = new CSRFToken();
    }

    /**
     * @return \App\Database
     */
    public function getDatabase(): \App\Database
    {
        return $this->db;
    }

    /**
     * @param $view
     * @param array $params
     */
    public function renderView($view, array $params = []): void
    {
        $token = $this->csrftoken->generate();
        Session::put($this->csrftoken->session_prefix . 'token', $token);
        $_SERVER['HTTP_X_CSRF_TOKEN'] = $token;

        $view = dirname(__DIR__) . '/public/pages/' . $view . '.php';

        if (file_exists($view)) {
            if ($params) {
                foreach ($params as $key => $value) {
                    $$key = $value;
                }
            }
            require $view;
        } else {
            echo sprintf('Could not find %s.php in %s', $view, 'public/pages');
        }
    }

}
<?php
/**
 * @class Ajax
 * @created 05/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

namespace App\Controllers;

use App\Kernal;

class Ajax extends Kernal
{

    public function flags()
    {
        if (isset($_GET['server_id'])) {
            try {
                $server_id = htmlspecialchars($_GET['server_id']);

                $server_id = filter_var($server_id, FILTER_VALIDATE_INT);
                $server_id = ($server_id !== false) ? $server_id : 0;

                $flags = $this->db->query('SELECT * FROM flags_data WHERE server_id = ?', [$server_id])->getResults();

                if ($flags) {
                    echo '<div class="d-grid gap-2">';
                    foreach ($flags as $flag) {
                        echo '<a href="' . SITE_URL . 'flags/buy/' . $flag->id . '" class="btn btn-primary btn-sm">';
                        echo $flag->name . ' Кредити: ' . $flag->credits . ' Валиден за ' . $flag->valid . ' дни';
                        echo '</a>';
                    }
                    echo '</div>';
                }
                if (empty($flags)) {
                    echo '<div class="alert alert-danger text-center">';
                    echo 'Няма добавени продукти към този сървър';
                    echo '</div>';
                }
            } catch (\Exception $e) {
                echo 'Error occurred: ' . $e->getMessage();
            }
        }
    }
}
<?php
/**
 * @class Unban
 * @created 07/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers\Services;

use App\Kernal;

class Unban extends Kernal
{
    public function index()
    {
        Auth();
        $ban_details = $this->db->getWhere('amx_bans', ['player_ip', '=', getIP()])->getFirst();
        if (!$ban_details) {
            redirect(SITE_URL . 'dashboard', 'Няма намарена информация', 'error');
        }
        $this->renderView('dashboard/services/unban', [
            'ban_details' => $ban_details
        ]);
    }

    public function remove()
    {
        $check = $this->db->getWhere('amx_bans', ['player_ip', '=', getIP()])->getFirst();

        if (!$check) {
            redirect(getRequestPage(), 'Няма намарена информация', 'error');
        }

        if (getUser('balance') >= UNBAN_PRICE) {
            $this->db->query('DELETE FROM amx_bans WHERE player_ip = ?', [getIP()]);
            remove_credits(UNBAN_PRICE);
            setTransaction('Премахване на бан', UNBAN_PRICE);
            redirect(SITE_URL . 'dashboard', 'Вашият бан е премахнат успешно');
        } else {
            redirect(getRequestPage(), 'Нямате достатъчно баланс в акаунта си за да използвате тази услуга', 'error');
        }
    }
}
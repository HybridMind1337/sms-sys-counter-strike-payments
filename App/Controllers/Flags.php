<?php
/**
 * @class Flags
 * @created 10/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers;

use App\Kernal;
use App\Validate;

class Flags extends Kernal
{
    public function index()
    {
        Auth();
        $data = $this->db->query('SELECT * FROM flags_data ORDER by id DESC')->getResults();
        $servers = $this->db->query('SELECT * FROM amx_serverinfo ORDER by id DESC')->getResults();

        $this->renderView('dashboard/flags', [
            'data' => $data,
            'servers' => $servers
        ]);
    }

    /**
     * @param $id
     */
        public function buy(int $id)
    {
        Auth();
        $secured_id = htmlspecialchars($id);
        $flags = $this->db->getWhere('flags_data', ['id', '=', $secured_id])->getFirst();
        $server_info = $this->db->getWhere('amx_serverinfo', ['id', '=', $secured_id])->getFirst();

        if (!$flags || !$server_info) {
            redirect(getRequestPage(), 'Няма намерена информация');
        }

        $this->renderView('dashboard/buy', [
            'flag' => $flags,
            'server_info' => $server_info
        ]);
    }

    public function buyForm($id)
    {
        $flags = $this->db->getWhere('flags_data', ['id', '=', htmlspecialchars($id)])->getFirst();

        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'password' => [
                $validate->required => [
                    'message' => 'Моля, вашата парола за вход в сървър'
                ]
            ],
            'name' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашето име в играта'
                ]
            ],
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            if (getUser('balance') >= $flags->credits) {
                remove_credits($flags->credits);
                setTransaction('Закупуване на ' . $flags->name, $flags->credits);

                $this->db->query('INSERT INTO amx_amxadmins (username, steamid, password, access, flags, nickname, ashow, expired, created, days) VALUES (?,?,?,?,?,?,?,?,?,?)', [
                    getPost('nickname'),
                    getPost('nickname'),
                    getPost('password'),
                    $flags->flags,
                    'a',
                    getPost('nickname'),
                    '1',
                    strtotime('+ ' . $flags->valid . ' days'),
                    time(),
                    $flags->valid
                ]);
                $lastID = $this->db->getLastId();
                $this->db->query('INSERT INTO amx_admins_servers (admin_id, server_id, custom_flags) VALUES (?,?,?)', [$lastID, $flags->server_id, 'b']);

                redirect(getRequestPage(), 'Успешно закупите вашите екстри. След смяната на картата ще ви бъдат добавени');
            } else {
                redirect(getRequestPage(), 'Нямате достатъчно кредити за да закупите този продук');
            }

        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

}

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


namespace App\Controllers\Admin;

use App\Kernal;
use App\Validate;

class Flags extends Kernal
{
    public function index()
    {
        Auth();
        $data = $this->db->query('SELECT * FROM flags_data ORDER by id DESC')->getResults();

        $this->renderView('admin/flags/index', [
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        Auth();
        $data = $this->db->getWhere('flags_data', ['id', '=', htmlspecialchars($id)])->getFirst();
        $servers = $this->db->query('SELECT * FROM amx_serverinfo ORDER by id DESC')->getResults();

        if (!$data) {
            redirect(getRequestPage(), 'Няма намерена информация', 'error');
        }


        $this->renderView('admin/flags/edit', [
            'data' => $data,
            'servers' => $servers
        ]);
    }

    public function editForm($id)
    {
        $data = $this->db->getWhere('flags_data', ['id', '=', htmlspecialchars($id)])->getFirst();

        if (!$data) {
            redirect(getRequestPage(), 'Няма намерена информация', 'error');
        }

        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'server_id' => [
                $validate->required => [
                    'message' => 'Моля, изберете сървър'
                ]
            ],
            'name' => [
                $validate->required => [
                    'message' => 'Моля, въведете името на продукта'
                ]
            ],
            'flags' => [
                $validate->required => [
                    'message' => 'Моля, въведете флаговете за продукта'
                ]
            ],
            'valid' => [
                $validate->required => [
                    'message' => 'Моля, въведете за колко време да е валиден продукта (в дни)'
                ]
            ],
            'credits' => [
                $validate->required => [
                    'message' => 'Моля, въведете за колко да струва продукта'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->update('flags_data', ['id', '=', htmlspecialchars($id)], [
               'server_id' => getPost('server_id'),
                'name' => getPost('name'),
                'flags' => getPost('flags'),
                'valid' => getPost('valid'),
                'credits' => getPost('credits')
            ]);
            redirect(getRequestPage(), 'Успешно е направена промяната');
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

    public function create()
    {
        Auth();
        $servers = $this->db->query('SELECT * FROM amx_serverinfo ORDER by id DESC')->getResults();

        $this->renderView('admin/flags/create', [
            'servers' => $servers
        ]);
    }

    public function createForm()
    {
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'server_id' => [
                $validate->required => [
                    'message' => 'Моля, изберете сървър'
                ]
            ],
            'name' => [
                $validate->required => [
                    'message' => 'Моля, въведете името на продукта'
                ]
            ],
            'flags' => [
                $validate->required => [
                    'message' => 'Моля, въведете флаговете за продукта'
                ]
            ],
            'valid' => [
                $validate->required => [
                    'message' => 'Моля, въведете за колко време да е валиден продукта (в дни)'
                ]
            ],
            'credits' => [
                $validate->required => [
                    'message' => 'Моля, въведете за колко да струва продукта'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->query('INSERT INTO flags_data (server_id, name, flags, valid, credits) VALUES (?,?,?,?,?)', [getPost('server_id'), getPost('name'), getPost('flags'), getPost('valid'), getPost('credits')]);
            redirect(getRequestPage(), 'Успешно създадохте новият продукт!');
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

    public function remove($id)
    {
        Auth();
        $check = $this->db->getWhere('flags_data', ['id', '=', htmlspecialchars($id)])->getFirst();

        if (!$check) {
            redirect(getRequestPage(), 'Няма намерена информация', 'error');
        }

        $this->db->query('DELETE FROM flags_data WHERE id = ?', [$id]);
        redirect(getRequestPage(), 'Успешно е изтрита информацията');
    }
}
<?php
/**
 * @class Users
 * @created 07/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

namespace App\Controllers\Admin;

use App\Kernal;
use App\Validate;

class Users extends Kernal
{

    public function index()
    {
        Auth();
        $data = $this->db->query('SELECT * FROM users ORDER by id DESC')->getResults();

        $this->renderView('admin/users/index', [
            'data' => $data
        ]);
    }

    public function edit($id)
    {
        Auth();
        $data = $this->db->getWhere('users', ['id', '=', htmlspecialchars($id)])->getFirst();

        if (!$data) {
            redirect(getRequestPage(), 'Няма намерен подобен потребител.', 'danger');
        }

        $this->renderView('admin/users/edit', [
            'data' => $data
        ]);
    }

    public function editForm($id)
    {
        $data = $this->db->getWhere('users', ['id', '=', htmlspecialchars($id)])->getFirst();

        if (!$data) {
            redirect(getRequestPage(), 'Няма намерен подобен потребител.', 'danger');
        }
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'balance' => [
                $validate->required => [
                    'message' => 'Моля, въведете колко баланс искате да добавите'
                ],
                $validate->min => [
                    'min' => 1,
                    'message' => 'Може да добавите 1 или повече баланс',
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->update('users', ['id', '=', htmlspecialchars($id)], [
                'balance' => $data->balance + getPost('balance')
            ]);
            redirect(getRequestPage(), 'Успешно бяха добавени '. getPost('balance'). ' кредита към акаунта');
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

}
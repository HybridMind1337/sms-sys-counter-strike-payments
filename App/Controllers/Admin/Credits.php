<?php
/**
 * @class Credits
 * @created 08/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers\Admin;

use App\Kernal;
use App\Validate;

class Credits extends Kernal
{

    public function index()
    {
        Auth();
        $sms_data = $this->db->query('SELECT * FROM sms_data ORDER by id DESC')->getResults();
        $prices_data = $this->db->query('SELECT * FROM prices_data ORDER by id DESC')->getFirst();

        $this->renderView('admin/credits/index', [
            'data' => $sms_data,
            'prices' => $prices_data
        ]);
    }

    public function edit($id)
    {
        Auth();
        $data = $this->db->getWhere('sms_data', ['id', '=', htmlspecialchars($id)])->getFirst();

        if (!$data) {
            redirect(SITE_URL . 'admin/credits', 'Няма намерена информация', 'error');
        }
        $this->renderView('admin/credits/edit', [
            'data' => $data
        ]);
    }

    public function editForm($id)
    {
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'user_id' => [
                $validate->required => [
                    'message' => 'Моля, въведете user ID-то'
                ]
            ],
            'service_id' => [
                $validate->required => [
                    'message' => 'Моля, въведете service ID-то'
                ]
            ],
            'text' => [
                $validate->required => [
                    'message' => 'Моля, въведете текста за SMS-a'
                ]
            ],
            'number' => [
                $validate->required => [
                    'message' => 'Моля, въведете номера на SMS-a'
                ]
            ],
            'credits' => [
                $validate->required => [
                    'message' => 'Моля, въведете колко кредита да дава'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->update('sms_data', ['id', '=', htmlspecialchars($id)], [
                'user_id' => getPost('user_id'),
                'service_id' => getPost('service_id'),
                'text' => getPost('text'),
                'number' => getPost('number'),
                'credits' => getPost('credits'),
            ]);
            redirect(getRequestPage(), 'Информацията е успешно обновена');
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

    public function AdForm()
    {
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'price' => [
                $validate->required => [
                    'message' => 'Моля, въведете колко да струва рекламата'
                ]
            ], 'valid' => [
                $validate->required => [
                    'message' => 'Моля, въведете колко време да е валидна реклмата в дни'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->update('prices_data', ['id', '=', 1], [
                'price' => getPost('price'),
                'valid' => getPost('valid')
            ]);
            redirect(getRequestPage(), 'Информацията е успешно обновена');
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }
}
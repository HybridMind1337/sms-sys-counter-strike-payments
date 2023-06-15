<?php
/**
 * @class Advertising
 * @created 11/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers;

use App\Kernal;
use App\Validate;

class Advertising extends Kernal
{
    public function index()
    {
        Auth();
        $data = $this->db->getWhere('prices_data', ['name', '=', 'banner'])->getFirst();

        $this->renderView('dashboard/ad', [
            'data' => $data
        ]);
    }

    public function buyForm()
    {
        $data = $this->db->getWhere('prices_data', ['name', '=', 'banner'])->getFirst();

        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'sitename' => [
                $validate->required => [
                    'message' => 'Моля, въведето името на вашият уеб сайт'
                ]
            ],
            'url' => [
                $validate->required => [
                    'message' => 'Моля, въведете линка към вашият сайт'
                ]
            ],
            'image' => [
                $validate->required => [
                    'message' => 'Моля, въведете линка към банера на вашият сайт'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            if (getUser('balance') >= $data->price) {
                remove_credits($data->price);
                setTransaction('Закупуване на реклама във форума', $data->price);
                $this->db->query('INSERT INTO banners (name, url, image, expires) VALUES (?,?,?,?)', [getPost('sitename'), getPost('url'), getPost('image'), strtotime('+ ' . $data->valid . ' days')]);

                redirect(getRequestPage(), 'Успешно е закупите реклама в нашият форум');
            } else {
                redirect(getRequestPage(), 'Нямате достатъчно кредити за да закупите този продук');
            }

        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }
}
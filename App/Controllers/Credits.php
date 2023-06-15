<?php
/**
 * @class Credits
 * @created 06/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers;

use App\Kernal;

class Credits extends Kernal
{
    public function smsTemplate()
    {
        Auth();
        $data = $this->db->query('SELECT * FROM sms_data ORDER by id DESC')->getResults();

        $this->renderView('dashboard/credits/sms', [
            'data' => $data
        ]);
    }

    public function sms()
    {
        $data = $this->db->getWhere('sms_data', ['id', '=', getPost('sms_data')])->getFirst();
        $code_check = smspay_check_code($data->user_id, $data->service_id, htmlspecialchars(getPost('sms_code')));

        switch ($code_check) {
            case 'CODE_OK':
                set_credits($data->credits);
                setChronology($data->amount, $data->credits);
                redirect(getRequestPage(), 'Успешно бяха добавени ' . $data->credits . ' към вашият акаунт');
                break;
            case 'CODE_EXPIRED':
                redirect(getRequestPage(), 'Вашият код за достъп е изтекъл!', 'error');
                break;
            case 'CODE_NOT_FOUND':
                redirect(getRequestPage(), 'Въведеният код е грешен!', 'error');
                break;
            case 'INVALID_INPUT':
                redirect(getRequestPage(), 'Данните от страна на администратора не са правилно въведени, моля свържете се с него', 'error');
                break;
        }
    }
}
<?php
/**
 * @class Validate
 * @created 05/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */

namespace App;

use DateTime;

class Validate extends Kernal
{

    private array $errors = [];
    private $passed = false;


    public $required = 'required';
    public $max = 'max';
    public $min = 'min';
    public $numeric = 'numeric';
    public $int = 'int';
    public $price = 'price';
    public $min_number = 'min_number';
    public $max_number = 'max_number';
    public $date = 'date';
    public $is_array = 'is_array';
    public $array_has_one_not_empty = 'array_has_one_not_empty';
    public $array_has_one = 'array_has_one';
    public $in_array = 'in_array';
    public $array_key_exists = 'array_key_exists';
    public $object = 'object';
    public $equal = 'equal';
    public $not_equal = 'not_equal';
    public $domain = 'domain';
    public $html = 'html';
    public $db_not_exists = 'db_not_exists';
    public $db_exists = 'db_exists';
    public $textarea = 'textarea';
    public $commands = 'commands';
    public $servers = 'servers';
    public $greater_than = 'greater_than';
    public $email = 'email';
    public $preg_match = 'preg_match';
    public $only_latin_letters = 'only_latin_letters';
    public $post_match = 'post_match';
    public $post_not_match = 'post_not_match';
    public $is_ip = 'is_ip';


    /**
     * @param $items
     * @param $source
     * @return $this
     */
    public function check($items, $source)
    {
        // Преглед на елементите, които се нуждаят от проверка
        foreach ($items as $item => $rules) {

            foreach ($rules as $rule => $rule_value) {
                $value = $source[$item] ?? '';
                $item = str_replace('&amp;', '&', htmlspecialchars($item, ENT_QUOTES));

                //Проверка дали $rule не е array.
                //Като проверката за array с след else
                if (!in_array($rule, [$this->is_array, $this->array_has_one_not_empty, $this->array_has_one])) {
                    // За всеки случай.
                    // задължително поле
                    if ($rule == $this->required && empty($value)) {
                        // The post array does not include this value, return an error
                        $this->addError([
                            'field' => $item,
                            'rule' => 'required',
                            'value' => $value,
                            'message' => $rule_value['message']
                        ]);
                    }


                    // The post array does include this value, continue validating
                    switch ($rule) {
                        case $this->min:
                            if (mb_strlen($value) < $rule_value['min']) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'min',
                                    'value' => $rule_value['min'],
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;

                        case $this->max:
                            if (mb_strlen($value) > $rule_value['max']) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'max',
                                    'value' => $rule_value['max'],
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->numeric:
                            if (!is_numeric($value)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'numeric',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->int:
                            if (filter_var($value, FILTER_VALIDATE_INT) === false) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'int',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->price:
                            if (!preg_match('/^[\d]*(,\d{2})*?(.\d{2})?$/', $value)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'price',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->min_number:
                            if ($rule_value['min'] > $value) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'min_number',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->max_number:
                            if ($rule_value['max'] < $value) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'max_number',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->date:
                            if (DateTime::createFromFormat(($rule_value['format'] ?? 'Y-m-d'), $value) == false) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'date',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->domain:
                            if (!(preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $value) //valid chars check
                                && preg_match("/^.{1,253}$/", $value) //overall length check
                                && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $value)
                            )) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'domain',
                                    'value' => $rule_value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->html:
                            if ($value == strip_tags($value)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'html',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->db_not_exists:
                            if (!isset($rule_value['check'])) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'db_not_exists',
                                    'value' => $value,
                                    'message' => 'Няма достатъчно предадена информация за проврка в датабазата: ' . $item
                                ]);
                            } else {
                                if ($rule_value['check']) {
                                    $sql = "SELECT * FROM {$rule_value['table']} WHERE {$rule_value['column']} = ?";
                                    $params = [$value];
                                    $result = $this->db->query($sql, $params)->getResults();
                                    if (!$result) {
                                        $this->addError([
                                            'field' => $item,
                                            'rule' => 'db_not_exists',
                                            'value' => $value,
                                            'message' => $rule_value['message']
                                        ]);
                                    }
                                }
                            }
                            break;
                        case $this->db_exists:
                            if (!isset($rule_value['check'])) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'db_exists',
                                    'value' => $value,
                                    'message' => 'Няма достатъчно предадена информация за проврка в датабазата: ' . $item
                                ]);
                            } else {
                                if ($rule_value['check']) {
                                    $sql = "SELECT * FROM {$rule_value['table']} WHERE {$rule_value['column']} = ?";
                                    $params = [$value];
                                    $result = $this->db->query($sql, $params)->getResults();
                                    if ($result) {
                                        $this->addError([
                                            'field' => $item,
                                            'rule' => 'db_exists',
                                            'value' => $value,
                                            'message' => $rule_value['message']
                                        ]);
                                    }
                                }
                            }
                            break;
                        case $this->textarea:
                            if (!strlen(trim($value))) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'textarea',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->in_array:
                            if (!isset($rule_value['in_array'])) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'in_array',
                                    'value' => $value,
                                    'message' => 'Няма достатъчно предадена информация за проврка на масива: ' . $item
                                ]);
                            } else {
                                if (!in_array($value, $rule_value['in_array'])) {
                                    $this->addError([
                                        'field' => $item,
                                        'rule' => 'in_array',
                                        'value' => $value,
                                        'message' => $rule_value['message']
                                    ]);
                                }
                            }
                            break;
                        case $this->array_key_exists:
                            if (!isset($rule_value['keys'])) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'array_key_exists',
                                    'value' => $value,
                                    'message' => 'Няма достатъчно предадена информация за проврка на масива: ' . $item
                                ]);
                            } else {
                                if (!array_key_exists($value, $rule_value['keys'])) {
                                    $this->addError([
                                        'field' => $item,
                                        'rule' => 'array_key_exists',
                                        'value' => $value,
                                        'message' => $rule_value['message']
                                    ]);
                                }
                            }
                            break;
                        case $this->greater_than:
                            if ($value < $source[$rule_value['than']]) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'greater_than',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->email:
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'email',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->equal:
                            if ($value == $rule_value['value']) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'equal',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->not_equal:
                            if ($value != $rule_value['value']) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'equal',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->preg_match:
                            if (!preg_match($rule_value['pattern'], $value)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'preg_match',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->only_latin_letters:
                            if (preg_match('/[^\p{Common}\p{Latin}]/u', $value)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'preg_match',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->post_match:
                            if ($value == $source[$rule_value['value']]) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'post_match',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->post_not_match:
                            if ($value != $source[$rule_value['value']]) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'post_not_match',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->is_ip:
                            $ip = explode(':', $value);
                            if (!$this->validIP($ip[0])) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'is_ip',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                    }

                } else {
                    //Проверка ако $value е array.
                    if ($rule == $this->required) {
                        if (empty($value)) {
                            $this->addError([
                                'field' => $item,
                                'rule' => 'required',
                                'value' => $value,
                                'message' => $rule_value['message']
                            ]);
                        }
                    }
                    switch ($rule) {
                        case $this->is_array:
                            if (!is_array($value)) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'is_array',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->array_has_one_not_empty:
                            if (!is_array($value) || !isset($value[0]) || $value[0] == '') {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'array_has_one_not_empty',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                        case $this->array_has_one:
                            if (!is_array($value) || !isset($value[0])) {
                                $this->addError([
                                    'field' => $item,
                                    'rule' => 'array_has_one_not_empty',
                                    'value' => $value,
                                    'message' => $rule_value['message']
                                ]);
                            }
                            break;
                    }
                }
            }

        }

        if (empty($this->errors)) {
            $this->passed = true;
        }

        return $this;
    }

    public function isValid(): bool
    {
        return $this->passed;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstErrorMessage()
    {
        return $this->errors[0]['message'];
    }

    public function getFirstErrorMessageField()
    {
        return $this->errors[0]['field'];
    }

    public function getFirstErrorMessageRule()
    {
        return $this->errors[0]['rule'];
    }

    public function getFirstErrorMessageValue()
    {
        return $this->errors[0]['value'];
    }



    //           'field' => $item,
    //                                    'rule' => 'is_array',
    //                                    'value' => $value,
    //                                    'message' => $rule_value['message']

    public function getFirstError()
    {
        return $this->errors[0];
    }

    private function addError($error)
    {
        $this->errors[] = $error;
    }

    public function validatePassword($password)
    {
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);

        if (!$number) {
            redirect(getRequestPage(), 'Паролата трябва да съдържа поне една цифра', 'info');
            exit();
        }
        if (!$uppercase) {
            redirect(getRequestPage(), 'Паролата трябва да съдържа поне една главна буква', 'info');
            exit();
        }
        if (!$lowercase) {
            redirect(getRequestPage(), 'Паролата трябва да съдържа поне една малка буква', 'info');
            exit();
        }

        if (strlen($password) < 6) {
            redirect(getRequestPage(), 'Пароалта трябва, да бъде с минимална дължина от 6 знака', 'info');
            exit();
        }
        if (strlen($password) > 64) {
            redirect(getRequestPage(), 'Пароалта трябва, да бъде с максимална дължина от 64 знака', 'info');
            exit();
        }
        return cleanInput($password);
    }


    private function isIP($address): bool
    {
        if (preg_match("/^(\d{1,3})\.$/", $address) || preg_match("/^(\d{1,3})\.(\d{1,3})$/",
                $address) || preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/", $address) ||
            preg_match("/^(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})$/", $address)) {
            $parts = explode(".", $address);
            foreach ($parts as $ip_parts) {
                if (intval($ip_parts) > 255 || intval($ip_parts) < 0)
                    return false; //if number is not within range of 0-255
            }
            return true;
        }
        return false;

    }

    private function isDNS($address): bool
    {
        return (preg_match('' . '/^([a-z0-9]([-a-z0-9]*[a-z0-9])?\\.)+((a[cdefgilmnoqrstuwxz]|aero|arpa)|(b[abdefghijmnorstvwyz]|biz)|(c[acdfghiklmnorsuvxyz]|cat|com|coop)|d[ejkmoz]|(e[ceghrstu]|edu)|f[ijkmor]|(g[abdefghilmnpqrstuwy]|gov)|h[kmnrtu]|(i[delmnoqrst]|info|int)|(j[emop]|jobs)|k[eghimnprwyz]|l[abcikrstuvy]|(m[acdghklmnopqrstuvwxyz]|mil|mobi|museum)|(n[acefgilopruz]|name|net|top)|(om|org)|(om|online)|(p[aefghklmnrstwy]|pro)|qa|r[eouw]|s[abcdeghijklmnortvyz]|(t[cdfghjklmnoprtvwz]|travel)|u[agkmsyz]|v[aceginu]|w[fs]|y[etu]|z[amw])$/i', $address) === 0) ? false : true;
    }

    private function validIP($address)
    {
        // if there is no valid DNS or IP
        if (!$this->isDNS($address) and !$this->isIP($address)) {
            return false;
        }
        // if there is a valid DNS, transform in IPV4 address
        if ($this->isDNS($address)) {
            return gethostbyname($address);
        }

        return true;
    }


}
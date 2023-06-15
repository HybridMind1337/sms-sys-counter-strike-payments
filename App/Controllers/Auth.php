<?php
/**
 * @class Auth
 * @created 04/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers;

use App\Kernal;
use App\Session;
use App\Validate;

class Auth extends Kernal
{
    public function index()
    {
        Auth();
        $user_transactions = $this->db->query('SELECT * FROM transactions WHERE user_id = ? ORDER BY date DESC LIMIT 5', [Session::get('user_id')])->getResults();
        $user_chronology = $this->db->query('SELECT * FROM chronology WHERE user_id = ? ORDER BY date DESC LIMIT 5', [Session::get('user_id')])->getResults();
        $this->renderView('dashboard/index', [
            'transactions' => $user_transactions,
            'chronology' => $user_chronology
        ]);
    }

    public function transactions()
    {
        Auth();
        $transactions = $this->db->getWhere('transactions', ['user_id', '=', Session::get('user_id')])->getResults();

        $this->renderView('dashboard/transactions', [
            'transactions' => $transactions
        ]);
    }

    public function chronology()
    {
        Auth();
        $chronology = $this->db->getWhere('chronology', ['user_id', '=', Session::get('user_id')])->getResults();

        $this->renderView('dashboard/chronology', [
            'chronology' => $chronology
        ]);
    }

    public function login()
    {
        NotAuth();
        $this->renderView('index');
    }

    public function register()
    {
        NotAuth();
        $this->renderView('register');
    }

    public function loginForm()
    {
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'email' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашият е-майл адрес'
                ],
                $validate->email => [
                    'message' => 'Моля, въведете валиден е-майл адрес'
                ]
            ],
            'password' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашата парола'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $data = $this->db->getWhere('users', ['email', '=', htmlspecialchars(getPost('email'))])->getFirst();
            if (password_verify(htmlspecialchars(getPost('password')), $data->password)) {
                Session::put('user_id', $data->id);
                redirect(SITE_URL . 'dashboard', 'Успешен вход в сайта');
            } else {
                redirect(getRequestPage(), 'Грешно потребителско име или парола', 'error');
            }
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

    public function registerForm()
    {
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'email' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашият е-майл адрес'
                ],
                $validate->email => [
                    'message' => 'Моля, въведете валиден е-майл адрес'
                ],
                $validate->db_exists => [
                    'table' => 'users',
                    'column' => 'email',
                    'check' => true,
                    'message' => 'Изглежда, че вече има регистриран такъв е-майл'
                ],
            ],
            'password' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашата парола'
                ],
                $validate->min => [
                    'min' => 6,
                    'message' => 'Паролата е твърде къса.',
                ],
                $validate->not_equal => [
                    'value' => $_POST['confirm-password'],
                    'message' => 'Паролите не съвпадат'
                ],
                $validate->max => [
                    'max' => 50,
                    'message' => 'Паролата е твърде дълга'
                ]
            ],
            'confirm-password' => [
                $validate->required => [
                    'message' => 'Моля, потвърдете вашата парола'
                ],
                $validate->min => [
                    'min' => 6,
                    'message' => 'Паролата е твърде къса.',
                ],
                $validate->max => [
                    'max' => 50,
                    'message' => 'Паролата е твърде дълга'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->insert('users', [
                'email' => getPost('email'),
                'password' => password_hash(getPost('password'), PASSWORD_DEFAULT),
                'ip' => ip2long(getIP()),
                'registered_on' => time(),
            ]);
            redirect(getRequestPage(), 'Успешно направихте вашата регистрация.');
            exit();
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

    public function logout()
    {
        Session::delete('user_id');
        redirect('/', 'Успешно излязохте от акаунта');
    }

    public function forgotPassword()
    {
        NotAuth();
        $this->renderView('forgot-password');
    }

    public function forgotPasswordForm()
    {
        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'email' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашият е-майл адрес'
                ],
                $validate->email => [
                    'message' => 'Моля, въведете валиден е-майл адрес'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $email = getPost('email');
            $token = md5(uniqid(mt_rand(), true));
            $this->db->query('INSERT INTO password_reset_tokens (token, email, expire_at) VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR))', [$token, $email]);

            $message = "Влезте в линка по-надолу за да промените паролата си:\n\n";
            $message .= SITE_URL . "reset-password/" . $token;

            $headers = "From: noreply@cs-paradise.eu" . "\r\n" .
                "Reply-To: noreply@cs-paradise.eu" . "\r\n" .
                "X-Mailer: PHP/" . PHP_VERSION;

            mail($email, "Нулиране на парола", $message, $headers);

            redirect(getRequestPage(), 'Инструкциите са ви изпратени до вашият е-майл адрес');
            exit();
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }

    public function resetPassword($token)
    {
        $tokenCheck = $this->db->query('SELECT * FROM password_reset_tokens WHERE token = ? AND expire_at > NOW()', [htmlspecialchars($token)])->getFirst();

        if (!$tokenCheck) {
            redirect(getRequestPage(), 'Изглежда, че токена е изтекъл или грешен. Моля опитайте отново', 'error');
        }

        $this->renderView('reset-password');
    }

    public function resetPasswordForm($token)
    {
        $tokenCheck = $this->db->query('SELECT * FROM password_reset_tokens WHERE token = ? AND expire_at > NOW()', [htmlspecialchars($token)])->getFirst();

        checkCsrfToken();
        $validate = new Validate();
        $to_validate = [
            'password' => [
                $validate->required => [
                    'message' => 'Моля, въведете вашата парола'
                ],
                $validate->min => [
                    'min' => 6,
                    'message' => 'Паролата е твърде къса.',
                ],
                $validate->not_equal => [
                    'value' => $_POST['confirm-password'],
                    'message' => 'Паролите не съвпадат'
                ],
                $validate->max => [
                    'max' => 50,
                    'message' => 'Паролата е твърде дълга'
                ]
            ],
            'confirm-password' => [
                $validate->required => [
                    'message' => 'Моля, потвърдете вашата парола'
                ],
                $validate->min => [
                    'min' => 6,
                    'message' => 'Паролата е твърде къса.',
                ],
                $validate->max => [
                    'max' => 50,
                    'message' => 'Паролата е твърде дълга'
                ]
            ]
        ];
        $validate->check($to_validate, $_POST);
        if ($validate->isValid()) {
            $this->db->update('users', ['email', '=', $tokenCheck->email], [
                'password' => password_hash(getPost('password'), PASSWORD_DEFAULT),
            ]);

            $this->db->query('DELETE FROM password_reset_tokens WHERE token = ?', [htmlspecialchars($token)]);
            redirect(getRequestPage(), 'Паролата е успешно променена');
            exit();
        } else {
            redirect(getRequestPage(), $validate->getFirstErrorMessage(), 'danger');
            exit();
        }
    }
}


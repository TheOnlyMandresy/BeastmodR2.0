<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\Admin\SystemeTable as App;
use Systeme\Table\Admin\UsersTable as TableAdmin;
use Systeme\Table\UsersTable as Table;
use Systeme\HTML\Users\Look;

class UsersController extends SystemeController
{
    private $page;

    public function __construct ($page)
    {
        $this->compact(['title'], true);

        switch ($page[0])
        {
            case 'register':
                return $this->register();
            case 'login':
                return $this->login();
            case 'logout':
                return $this->logout();
            default:
                break;
        }

        array_shift($page);
        $this->page = $page;

        if (empty($this->page)) {
            return $this->error('404');
        } elseif (isset($this->page[0])) {
            switch ($this->page[0])
            {
                case 'p':
                    $id = (isset($this->page[1]))? $this->page[1] : null;
                    return $this->profil($id);
                case 'parameters':
                    if (isset($this->page[1]) && $this->page[1] === 'b') {
                        $bubble = Table::newBubble($this->page[2]);

                        switch ($bubble) {
                            case 'error-vip':
                                return $this->flash(['type' => 'warning',
                                    'message' => 'vous devez être VIP pour utiliser à cette bulle'
                                ], '/users/parameters');
                            case 'error-staff':
                                return $this->flash(['type' => 'warning',
                                    'message' => 'vous devez être STAFF pour utiliser cette bulle'
                                ], '/users/parameters');
                            case 'error-unknow':
                                return $this->flash(['type' => 'danger',
                                    'message' => 'cette bulle n\'existe pas'
                                ], '/users/parameters');
                            default:
                                break;
                        }

                        return $this->flash(['type' => 'success',
                            'message' => 'paramètres changés'
                        ], '/users/parameters');
                    }
                    return $this->parameters();
                default:
                    return $this->error(404);
            }
        }
    }

    private function parameters ()
    {
        (Table::isLogged() == false)? $this->error(403) : null;
        $idUser = Table::getMyData('id');

        if (!empty($_POST)) {
            if (isset($_POST['param-pref'])) {
                if (strlen($_POST['motto']) > 40) {
                    return $this->flash(['type' => 'warning',
                        'message' => 'Votre humeur est trop longue'
                    ], '/users/parameters');
            }

            Table::generalEdit([
                'datas' => [
                    'motto' => Systeme::security(['text' => $_POST['motto']], 'post'),
                    'radio' => Systeme::security(['text' => $_POST['radio']], 'post')
                ],
                'ids' => [
                    'idUser' => $idUser
                ]
            ], '_settings');
        } elseif (isset($_POST['param-bg'])) {
            $image = Table::generalImage($_FILES);

            switch ($image) {
                case 'error-1':
                    return $this->flash(['type' => 'danger',
                        'message' => 'ce n\'est pas une image'
                    ], '/users/parameters');
                case 'error-2':
                    return $this->flash(['type' => 'danger',
                        'message' => 'trop volumineux'
                    ], '/users/parameters');
                case 'error-3':
                    return $this->flash(['type' => 'danger',
                        'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                    ], '/users/parameters');
                case 'error-4':
                    return $this->flash(['type' => 'danger',
                        'message' => 'une erreur est survenue pendant l\'upload de votre image'
                    ], '/users/parameters');
                default:
                    break;
            }
    
            Table::generalEdit([
                'datas' => ['image' => $image],
                'ids' => ['idUser' => $idUser]
            ], '_settings');
        } elseif (isset($_POST['param-look'])) {
            Table::generalEdit([
                'datas' => [
                    'look' => Systeme::security(['text' => $_POST['look']], 'post')
                ],
                'ids' => [
                    'idUser' => $idUser
                ]
            ], '_settings');
        }

            return $this->flash(['type' => 'success',
            'message' => 'paramètres changés'
        ], '/users/parameters');
        }

        $h1 = 'Mes paramètres';
        $title = Systeme::setTitle($h1);
        $all = Table::getMyDatas($idUser);
        $all->look = Look::load($all->look, ['only' => true, 'headdirection' => 'SE']);
        $all->lookS = Look::load($all->look, ['only' => true, 'headdirection' => 'SE', 'size' => 'XS']);
        $radio = ($all->radio)? '(activé)' : '(désactivé)';
        $radioState = ($all->radio)? true : false;

        $bubbles = App::getBubbles();

        return $this->render('/Users/Parameters', compact($this->compact(['h1', 'all', 'radio', 'radioState', 'bubbles'])));
    }

    private function login ()
    {
        if (isset($_SESSION['user'])) {
            return $this->flash(['type' => 'infos',
                'message' => 'vous êtes déjà connecté'
            ], '/');
        }
        
        if (!empty($_POST) && isset($_POST['login'])) {
            $username = Systeme::security(['text' => $_POST['username']], 'post');
            $password = Systeme::security(['text' => $_POST['password']], 'post');

            if (Table::login($username, $password)) {
                return $this->flash(['type' => 'success',
                    'message' => 'Hello ' .$_SESSION['user']['username']
                ], '/', '!');
            }

            return $this->flash(['type' => 'danger',
                'message' => 'veuillez réessayer'
            ], '/login');
        }

        return header('Location: /');
    }

    private function register ()
    {
        if (isset($_SESSION['user'])) {
            return $this->flash(['type' => 'infos',
                'message' => 'vous êtes déjà connecté'
            ], '/');
        }

        if (!empty($_POST) && isset($_POST['register'])) {
            $username = Systeme::security(['text' => $_POST['username']], 'post');

            $register = TableAdmin::register([
                'general' => [
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'username' => $username,
                    'email' => Systeme::security(['text' => $_POST['email']], 'post'),
                    'password' => Systeme::security(['text' => $_POST['password']], 'post'),
                ],
                'settings' => [
                    'gender' => Systeme::security(['text' => $_POST['gender']], 'post')
                ],
                'checkPass' => Systeme::security(['text' => $_POST['checkPass']], 'post')
            ]);

            if ($register === true) {
                return $this->flash(['type' => 'base',
                    'message' => 'bienvenue parmis nous ' .$username
                ], '/');
            }
        }

        $title = Systeme::setTitle('Inscription');

        return $this->render('/Users/Register', compact($this->compact()));
    }

    private function profil ($username)
    {
        ($username === null || Table::userExist(['username' => $username]) == false)? $this->error(404) : null;

        $user = Table::getUser(Table::getUserData(['username' => $username], 'id'));

        $title = Systeme::setTitle($user->username);

        return $this->render('/Users/Profil', compact($this->compact(['user'])));
    }

    private function logout ()
    {
        if (isset($_SESSION['user'])) {
            unset($_SESSION['user']);
    
            return $this->flash(['type' => 'danger',
                'message' => 'aurevoir'
            ], '/');
        }
    
        return $this->flash(['type' => 'infos',
            'message' => 'vous n\'êtes pas connecté'
        ], '/');
    }
}
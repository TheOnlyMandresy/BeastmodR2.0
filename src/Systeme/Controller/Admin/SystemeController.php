<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\UsersTable as User;

class SystemeController extends \Systeme\Controller\SystemeController
{
    public function __construct ()
    {
        if (User::isLogged() === false || Admin::adminAccess(11) === false) {
            return $this->error(403);
        }
    }

    private function index ()
    {
        $title = Systeme::setTitle();

        return $this->render('/Admin/Index', compact('title'));
    }
}
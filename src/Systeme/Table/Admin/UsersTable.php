<?php

namespace Systeme\Table\Admin;

use Systeme;
use Systeme\Table\Table;
use Systeme\Table\RanksTable as Staff;
use Systeme\Table\Admin\RanksTable as StaffAdmin;
use Systeme\Table\UsersTable as T;

class UsersTable extends Table
{
    protected static $table = 'users';

    public static function isStaff ($id)
    {
        return (Staff::getUser($id))? true : false;
    }

    public static function isManager ($id)
    {
        return (StaffAdmin::isManager($id))? true : false;
    }

    public static function register ($datas)
    {
        $username = $datas['general']['username'];
        $email = $datas['general']['email'];
        $password = $datas['general']['password'];
        $checkPass = $datas['checkPass'];

        $statement = [
            'where' => 'username = ?',
            'att' => $username
        ];
        $user = static::find($statement);

        if ($user) {
            $_SESSION['flash']['type'] = 'warning';
            $_SESSION['flash']['message'] = 'Username déjà utilisé.';
            return false;
        }

        $statement = [
            'where' => 'email = ?',
            'att' => $email
        ];
        $user = static::find($statement);

        if ($user) {
            $_SESSION['flash']['type'] = 'warning';
            $_SESSION['flash']['message'] = 'Email déjà utilisé.';
            return false;
        }

        if ($password !== $checkPass) {
            $_SESSION['flash']['type'] = 'warning';
            $_SESSION['flash']['message'] = 'Les mots de passe ne correspondent pas.';
            return;
        } else {
            $password = Systeme::security(['text' => $password], 'hash');
        }

        $datas['general']['password'] = Systeme::security(['text' => $password], 'password');

        static::generalAdd($datas['general']);
        $datas['settings']['idUser'] = static::lastId();

        T::session($datas['settings']['idUser'], $username);

        static::generalAdd($datas['settings'], '_settings');
        static::generalAdd(['idUser' => $datas['settings']['idUser']], '_palmares');

        return true;
    }
}
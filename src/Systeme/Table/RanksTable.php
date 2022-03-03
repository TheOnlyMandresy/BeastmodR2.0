<?php

namespace Systeme\Table;

use Systeme;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\UsersTable as User;

class RanksTable extends Table
{
    protected static $table = 'ranks';
    protected static $urlProfil = '/users/p/';

    public static function all ()
    {
        $statement = [
            'select' => "
                r.*,
                u.username as username
                ",
            'join' => " as r
                INNER JOIN users u
                    ON r.idUser = u.id
                "
        ];

        return static::find($statement, null, true);
    }

    public static function getUser ($id)
    {
        $statement = [
            'select' => "
                r.*,
                u.username as username
                ",
            'join' => " as r
                INNER JOIN users u
                    ON r.idUser = u.id
                ",
            'where' => 'r.idUser = ?',
            'att' => $id
        ];

        return static::find($statement);
    }

    public static function getUserRights ()
    {
        $statement = [
            'select' => 'idRights',
            'where' => 'idUser = ?',
            'att' => User::getMyData('id')
        ];
        $datas = static::find($statement);
        
        if ($datas) {
            $userRights = explode(',', $datas->idRights);
            $rights = (count($userRights) > 1)? $userRights : [$datas->idRights];
    
            return $rights;
        }

        return false;
    }

    public static function allRights ()
    {
        $datas = static::find(null, '_rights', true);
        $rights = [];

        foreach ($datas as $data) {
            if (Admin::adminAccess($data->id)) {
                $data->category = ($data->category === null)? 'Non listé' : $data->category;

                if (!isset($rights[$data->category])) {
                    $rights[$data->category] = null;
                }

                $rights[$data->category][] = [
                    'id' => $data->id,
                    'name' => $data->name,
                    'description' => $data->description,
                ];
            }
        }

        return $rights;
    }

    public static function getRight ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
        ];

        return static::find($statement, '_rights');
    }

    public static function getStaffs ()
    {
        $statement = [
            'select' => "
                r.*,
                u.username as username,
                us.look as look
            ",
            'join' => " as r
                INNER JOIN users u
                    ON r.idUser = u.id
                INNER JOIN users_settings us
                    ON r.idUser = us.idUser
            "
        ];

        $datas = static::find($statement, null, true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->link = static::$urlProfil . $data->username;
            }
        }

        return $datas;
    }

    public static function getTeam ()
    {
        $superiorId = User::getMyData('id');

        $statement = [
            'select' => "
                r.*,
                u.username as username
                ",
            'join' => " as r
                INNER JOIN users u
                    ON r.idUser = u.id
                ",
            'where' => 'r.idSuperiorUser = ?',
            'att' => $superiorId
        ];

        return static::find($statement, null, true);
    }
}
<?php

namespace Systeme\Table\Admin;

use Systeme;
use Systeme\Table\Table;
use Systeme\Table\RanksTable as T;
use Systeme\Table\UsersTable as User;

class RanksTable extends Table
{
    protected static $table = 'ranks';

    public static function adminAccess ($right)
    {
        $userRights = T::getUserRights();

        if ($userRights && (in_array($right, $userRights) || static::isGod())) {
            return true;
        }

        return false;
    }

    public static function isManager ($id)
    {
        $statement = [
            'select' => 'responsable',
            'where' => 'idUser = ?',
            'att' => $id
        ];
        $user = static::find($statement);

        return ($user)? (($user->responsable > 1)? true : false) : false;
    } 

    public static function isGod ()
    {
        $userRights = T::getUserRights();

        return (in_array('all', $userRights))? true : false;
    }

    /**
     * Is the user a member of your team or not.
     */
    public static function userTeam ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
        ];
        $user = static::find($statement);

        $superiorId = User::getMyData('id');
        $superiorRights = T::getUserRights();

        if (in_array('all', $superiorRights)) {
            return true;
        } elseif ($user && $user->idSuperiorUser === $superiorId) {
            return true;
        }

        return false;
    }

    public static function staffExist ($id)
    {
        $statement = [
            'where' => 'idUser = ?',
            'att' => $id
        ];
        
        return (static::find($statement))? true : false;
    }
}
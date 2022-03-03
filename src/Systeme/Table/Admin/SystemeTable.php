<?php

namespace Systeme\Table\Admin;

use Systeme;
use Systeme\Table\Table;

class SystemeTable extends Table
{
    protected static $table = 'systeme';

    public static function getBubbles ()
    {
        $statement = [
            'where' => 'available = 1'
        ];
        
        return static::find($statement, '_bubbles', true);
    }

    public static function getBubble ($code)
    {
        $statement = [
            'select' => 'category',
            'where' => 'code = ? AND available = 1',
            'att' => $code
        ];
        
        return static::find($statement, '_bubbles');
    }

    public static function getAlerts ()
    {
        $statement = [
            'select' => "s.*,
                u.username as author
            ",
            'join' => " as s
                INNER JOIN users u
                    ON s.idUser = u.id
            ",
            'where' => 'available = 1',
            'order' => 'id DESC'
        ];

        $alert = static::find($statement, '_alert');

        if ($alert) {
            $alert->createAt = Systeme::dateFormat('full', $alert->createAt);
        }

        return $alert;
    }

    public static function getLogs ()
    {
        $statement = [
            'order' => 'id DESC'
        ];

        return static::find($statement, '_logs', true);
    }
}
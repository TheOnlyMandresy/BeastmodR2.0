<?php

namespace Systeme\Table;

use Systeme;

class GamesTable extends Table
{
    protected static $table = 'games';

    public static function all ()
    {
        $statement = [
            'select' => "
                g.*,
                u.username as username
                ",
            'join' => " as g
                INNER JOIN users u
                    ON g.idUser = u.id
                "
        ];

        return static::find($statement, null, true);
    }

    public static function getGame ($id)
    {
        $statement = [
            'select' => "
                g.*,
                u.username as username
                ",
            'join' => " as g
                INNER JOIN users u
                    ON g.idUser = u.id
                ",
            'where' => 'g.id = ?',
            'att' => $id
        ];
        
        return static::find($statement);
    }

    public function getUrl ()
    {
        return '/events/' .$this->id;
    }
}
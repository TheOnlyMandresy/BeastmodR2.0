<?php

namespace Systeme\Table\Admin;

use Systeme\Table\Table;

class PostsTable extends Table
{
    protected static $table = 'posts';
    
    public static function getRequests ()
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
            'order' => 'createAt DESC'
        ];

        return static::find($statement, '_requests', true);
    }
}
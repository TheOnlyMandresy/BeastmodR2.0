<?php

namespace Systeme\Table\Admin;

use Systeme\Table\Table;

class TicketsTable extends Table
{
    protected static $table = 'tickets';

    public static function deleteTicket ($id)
    {
        $statement = [
            'where' => 'idTicket = ?',
            'att' => $id
        ];
        static::delete($statement, '_chat');
        
        return static::generalDelete($id);
    }
}
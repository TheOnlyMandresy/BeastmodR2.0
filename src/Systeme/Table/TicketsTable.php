<?php

namespace Systeme\Table;

use Systeme;

class TicketsTable extends Table
{
    protected static $table = 'tickets';

    public static function all ()
    {
        $statement = [
            'select' => "
                t.*,
                u.username as username,
                us.look as look
                ",
            'join' => " as t
                INNER JOIN users u
                    ON t.idUser = u.id
                INNER JOIN users_settings us
                    ON t.idUser = us.idUser
                "
        ];

        return static::find($statement, null, true);
    }

    public static function getMyTickets ($id)
    {
        $statement = [
            'where' => 'idUser = ?',
            'att' => $id
        ];

        return static::find($statement, null, true);
    }

    public static function getMyTicket ($id, $idUser)
    {
        $statement = [
            'select' => "
                t.*,
                us.look as look
                ",
            'join' => " as t
                INNER JOIN users_settings us
                    ON t.idUser = us.idUser
                ",
            'where' => 't.id = ? AND t.idUser = ?',
            'att' => [$id, $idUser]
        ];
        
        return static::find($statement);
    }

    public static function getTicket ($id)
    {
        $statement = [
            'select' => "
                t.*,
                u.username as username,
                us.look as look
                ",
            'join' => " as t
                INNER JOIN users u
                    ON t.idUser = u.id
                INNER JOIN users_settings us
                    ON t.idUser = us.idUser
                ",
            'where' => 't.id = ?',
            'att' => $id
        ];
        
        return static::find($statement);
    }

    public static function getTicketChat ($id)
    {
        $statement = [
            'select' => "
                t.*,
                u.username as username,
                us.look as look
                ",
            'join' => " as t
                INNER JOIN users u
                    ON t.idUser = u.id
                INNER JOIN users_settings us
                    ON t.idUser = us.idUser
                ",
            'order' => 'createAt DESC',
            'where' => 't.idTicket = ?',
            'att' => $id
        ];
        
        return static::find($statement, '_chat', true);
    }
    
    /**
     * @param int $id
     * @param string $state Close | Send | Waiting | Answer 
     */
    public static function stateTickets ($datas)
    {
        switch ($datas['datas']['state']) {
            case 'close':
                $datas['datas']['state'] = 0;
                break;
            case 'send':
                $datas['datas']['state'] = 1;
                break;
            case 'waiting':
                $datas['datas']['state'] = 2;
                break;
            case 'answer':
                $datas['datas']['state'] = 3;
                break;
        }

        return static::generalEdit($datas);
    }

    public function getUrl ()
    {
        return '/tickets/' .$this->id;
    }
}
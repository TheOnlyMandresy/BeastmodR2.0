<?php

namespace Systeme\Table\Admin;

use Systeme\Table\Table;
use Systeme\Table\EventsTable as T;
use Systeme\Table\UsersTable;
use Systeme\Table\PostsTable;

class EventsTable extends Table
{
    protected static $table = 'events';

    public static function addEvent ($datas)
    {
        $statement = [
            'insert' => $datas['post'],
            'att' => $datas['post']
        ];
        PostsTable::insert($statement);

        $datas['event']['idPost'] = static::lastId();

        $statement = [
            'insert' => $datas['event'],
            'att' => $datas['event']
        ];
        static::insert($statement);

        $datas['rewards']['idEvent'] = static::lastId();
        
        $statement = [
            'insert' => $datas['rewards'],
            'att' => $datas['rewards']
        ];

        return static::insert($statement, '_rewards');
    }

    public static function editEvent ($datas)
    {
        $datasPost = $datas['post'];
        $attPost = $datas['post'];
        $attPost['id'] = $datas['ids']['idPost'];

        $datasEvent = $datas['event'];
        $attEvent = $datas['event'];
        $attEvent['idEvent'] = $datas['ids']['idEvent'];

        $datasRewards = $datas['rewards'];
        $attRewards = $datas['rewards'];
        $attRewards['idEvent'] = $datas['ids']['idEvent'];

        $statement = [
            'where' => 'id = ?',
            'set' => $datasPost,
            'att' => $attPost
        ];
        PostsTable::update($statement);

        $statement = [
            'where' => 'id = ?',
            'set' => $datasEvent,
            'att' => $attEvent
        ];
        static::update($statement);

        $statement = [
            'where' => 'idEvent = ?',
            'set' => $datasRewards,
            'att' => $attRewards
        ];

        return static::update($statement, '_rewards');
    }

    public static function addWinners ($datas)
    {
        $datas['idFirstUser'] = UsersTable::getUserData(['username' => $datas['idFirstUser']]);
        $datas['idSecondUser'] = UsersTable::getUserData(['username' => $datas['idSecondUser']]);
        $datas['idThirdUser'] = UsersTable::getUserData(['username' => $datas['idThirdUser']]);

        $statement = [
            'insert' => $datas,
            'att' => $datas
        ];
        
        return static::insert($statement, '_winners');
    }

    public static function editWinners ($datas)
    {
        $datas['datas']['idFirstUser'] = UsersTable::getUserData(['username' => $datas['datas']['idFirstUser']]);
        $datas['datas']['idSecondUser'] = UsersTable::getUserData(['username' => $datas['datas']['idSecondUser']]);
        $datas['datas']['idThirdUser'] = UsersTable::getUserData(['username' => $datas['datas']['idThirdUser']]);

        $winners = $datas['datas'];
        $attWinners = $datas['datas'];
        $attWinners['idEvent'] = $datas['idEvent'];

        $statement = [
            'where' => 'idEvent = ?',
            'set' => $winners,
            'att' => $attWinners
        ];
        return static::update($statement, '_winners');
    }

    public static function deleteEvent ($id)
    {
        $event = T::getEvent($id);
        $statement = [
            'where' => 'id = ?',
            'att' => [$event->post_id]
        ];
        PostsTable::delete($statement);

        $statement = [
            'where' => 'id = ?',
            'att' => [$id]
        ];
        static::delete($statement);

        $statement = [
            'where' => 'idEvent = ?',
            'att' => [$id]
        ];

        return static::delete($statement, '_rewards');
    }
}
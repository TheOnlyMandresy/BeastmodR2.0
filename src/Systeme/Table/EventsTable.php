<?php

namespace Systeme\Table;

use Systeme;
use Systeme\Table\UsersTable as Users;

class EventsTable extends Table
{
    protected static $table = 'events';
    protected static $urlBackground = '/img/backgrounds/events/';
    protected static $urlLink = '/events/';

    public static function all ()
    {
        $statement = [
            'select' => "e.*,
                p.title as title, p.image as image",
            'join' => " as e 
                INNER JOIN posts p
                    ON e.idPost = p.id
                ",
            'order' => 'e.startAt DESC'
        ];
        $datas = static::find($statement, null, true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->background = static::$urlBackground . $data->image;
                $data->link = static::$urlLink . $data->id;
            }
        }
        
        return $datas;
    }

    public static function getEvent ($id)
    {
        if (static::getWinners($id) !== false) {
            $statement = [
                'select' => "e.*,
                    p.title as title, p.content as content, p.image as image,
                    er.content as rewards, er.first as first, er.second as second, er.third as third, er.others as others,
                    fp.username as firstPlaceUsername, fps.look as firstPlaceLook,
                    sp.username as secondPlaceUsername, sps.look as secondPlaceLook,
                    tp.username as thirdPlaceUsername, tps.look as thirdPlaceLook",
                'join' => " as e 
                    INNER JOIN posts p
                        ON e.idPost = p.id
                    INNER JOIN events_rewards er
                        ON e.id = er.idEvent
                    INNER JOIN events_winners ew
                        ON e.id = ew.idEvent
                    INNER JOIN users as fp
                        ON ew.idFirstUser = fp.id
                    INNER JOIN users_settings as fps
                        ON ew.idFirstUser = fps.idUser
                    INNER JOIN users as sp
                        ON ew.idSecondUser = sp.id
                    INNER JOIN users_settings as sps
                        ON ew.idSecondUser = sps.idUser
                    INNER JOIN users as tp
                        ON ew.idThirdUser = tp.id
                    INNER JOIN users_settings as tps
                        ON ew.idThirdUser = tps.idUser
                    ",
                'where' => 'e.id = ?',
                'att' => $id
            ];
        } else {
            $statement = [
                'select' => "e.*,
                    p.title as title, p.content as content, p.image as image,
                    er.content as rewards, er.first as first, er.second as second, er.third as third, er.others as others",
                'join' => " as e 
                    INNER JOIN posts p
                        ON e.idPost = p.id
                    INNER JOIN events_rewards er
                        ON e.id = er.idEvent
                    ",
                'where' => 'e.id = ?',
                'att' => $id
            ];
        }

        $datas = static::find($statement);
        if ($datas !== false) {
            $datas->startAt = Systeme::dateFormat('datetime', $datas->startAt);
            $datas->endAt = Systeme::dateFormat('datetime', $datas->endAt);
            $datas->content = Systeme::security(['text' => $datas->content], 'decode');
            $datas->rewards = Systeme::security(['text' => $datas->rewards], 'decode');
            $datas->first = Systeme::security(['text' => $datas->first], 'decode');
            $datas->second = Systeme::security(['text' => $datas->second], 'decode');
            $datas->third = Systeme::security(['text' => $datas->third], 'decode');
            $datas->others = Systeme::security(['text' => $datas->others], 'decode');
            $datas->background = static::$urlBackground . $datas->image;
            $datas->link = static::$urlLink . $datas->id;
        }

        return $datas;
    }

    public static function getEventsOnly ($number)
    {   
        $statement = [
            'select' => "e.*,
                p.title as title, p.image as image",
            'join' => " as e 
                INNER JOIN posts p
                    ON e.idPost = p.id
                ",
            'limit' => ['start' => $number],
            'order' => 'e.startAt DESC'
        ];
        $datas = static::find($statement, null, true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->background = static::$urlBackground . $data->image;
                $data->link = static::$urlLink . $data->id;
            }
        }

        return $datas;
    }

    public static function getWinners ($id)
    {
        $statement = [
            'where' => 'idEvent = ?',
            'att' => $id
        ];

        return static::find($statement, '_winners');
    }

    public static function getTop ($count = 10)
    {
        $order = ($count === 10)? 'monthEvents' : 'allEvents';

        $statement = [
            'select' => "
                p.allEvents, p.monthEvents,
                u.username as username, u.id as idUser,
                us.look as look
            ",
            'join' => " as p
                INNER JOIN users u
                    ON p.idUser = u.id
                INNER JOIN users_settings us
                    ON p.idUser = us.idUser
            ",
            'order' => $order .' DESC',
            'limit' => ['start' => $count]
        ];

        $datas = Users::find($statement, '_palmares', true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->link = Users::getLink('profil') . $data->idUser;
            }
        }

        return $datas;
    }
}
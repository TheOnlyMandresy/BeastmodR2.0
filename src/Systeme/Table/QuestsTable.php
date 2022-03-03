<?php

namespace Systeme\Table;

use Systeme;

class QuestsTable extends Table
{
    protected static $table = 'quests';
    protected static $urlBackground = '/img/backgrounds/quests/';

    public static function all ()
    {
        $datas = static::find(null, null, true);

        // foreach ($datas as $data) {
        //     $data->startAt = Systeme::dateFormat('fullConcat', $data->startAt)
        //                     .' à '
        //                     .Systeme::dateFormat('time', $data->startAt);
        //     $data->endAt = Systeme::dateFormat('fullConcat', $data->endAt)
        //                     .' à '
        //                     .Systeme::dateFormat('time', $data->endAt);
        // }

        return $datas;
    }

    public static function getOwned ($id)
    {
        $statement = [
            'where' => 'idUser = ? AND idStep = 0',
            'att' => $id
        ];
        $datas = static::find($statement, '_progress', true);

        $owned = [];

        foreach ($datas as $data) {
            $statement = [
                'where' => 'id = ?',
                'att' => $data->idQuest
            ];
            $quest = static::find($statement);
            ($quest)? $owned[] = $quest : null;
        }

        return $owned;
    }

    public static function getQuest ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
        ];

        return static::find($statement);
    }

    public static function getSteps ($id)
    {
        $statement = [
            'where' => 'idQuest = ?',
            'att' => $id
        ];

        return static::find($statement, '_steps', true);
    }

    public static function getStep ($id, $code)
    {
        $statement = [
            'where' => 'idQuest = ? AND code =?',
            'att' => [$id, $code]
        ];

        return static::find($statement, '_steps');
    }

    public static function getProgress ($questId, $userId, $stepId = null)
    {
        if ($stepId) {
            $statement = [
                'select' => "
                    s.name as name,
                    s.content as content
                ",
                'join' => " as p
                    INNER JOIN quests_steps s
                        ON p.idStep = s.id
                ",
                'order' => 'createAt DESC',
                'where' => 'p.idQuest = ? AND p.idUser = ? AND idStep = ?',
                'att' => [$questId, $userId, $stepId]
            ];
    
            return static::find($statement, '_progress');
        }

        $statement = [
            'select' => "
                s.name as name,
                s.content as content
            ",
            'join' => " as p
                INNER JOIN quests_steps s
                    ON p.idStep = s.id
            ",
            'order' => 'createAt DESC',
            'where' => 'p.idQuest = ? AND p.idUser = ?',
            'att' => [$questId, $userId]
        ];

        return static::find($statement, '_progress', true);
    }

    public static function getWinners ($id)
    {
        $statement = [
            'select' => "
                q.*,
                u.username as username,
                us.look as look
            ",
            'join' => " as q
                INNER JOIN users u
                    ON q.idUser = u.id
                INNER JOIN users_settings us
                    ON q.idUser = us.idUser
            ",
            'order' => 'createAt',
            'where' => 'idQuest = ?',
            'att' => $id
        ];
        $datas = static::find($statement, '_winners', true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->createAt = Systeme::dateFormat('fullConcat', $data->createAt)
                                .' à '
                                .Systeme::dateFormat('time', $data->createAt);
            }
        }

        return $datas;
    }
}
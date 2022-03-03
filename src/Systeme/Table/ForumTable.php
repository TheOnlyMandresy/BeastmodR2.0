<?php

namespace Systeme\Table;

use Systeme;
use Systeme\Table\UsersTable;
use Systeme\HTML\Users\Look;

class ForumTable extends Table
{
    protected static $table = 'forum';
    protected static $urlBackground = '/img/backgrounds/forum/';
    protected static $urlLink = '/forum/';
    protected static $urlLinkEdit = '/forum/e/';
    protected static $urlLinkClose = '/forum/c/';
    protected static $urlLinkOpen = '/forum/o/';
    protected static $urlLinkSection = '/forum/s/';

    public static function all ()
    {
        $statement = [
            'select' => "
                f.*,
                u.username as username
            ",
            'join' => " as f
                INNER JOIN users u
                    ON f.idUser = u.id
            ",
            'order' => 'createAt DESC'
        ];
        $datas = static::find($statement, null, true);
        
        if ($datas) {
            foreach ($datas as $data) {
                $data->background = '/img/backgrounds/forum/' .$data->image;
                $data->since = Systeme::dateFormat('since', $data->createAt);
                $data->link = static::$urlLink . $data->id;
            }
        }

        return $datas;
    }

    public static function allSections ()
    {
        $datas = static::find(null, '_sections', true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->link = static::$urlLinkSection . $data->id;
            }
            return $datas;
        }

        return null;
    }

    public static function getSection ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
        ];
        $datas = static::find($statement, '_sections');

        return $datas;
    }

    public static function getAllSection ($id)
    {
        $statement = [
            'select' => "
                f.*,
                u.username as username
            ",
            'join' => " as f
                INNER JOIN users u
                    ON f.idUser = u.id
            ",
            'where' => 'f.idSection = ?',
            'att' => $id,
            'order' => 'f.createAt DESC'
        ];
        $datas = static::find($statement, null, true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->since = Systeme::dateFormat('since', $data->createAt);
                $data->link = static::$urlLink . $data->id;
            }
        }

        return $datas;
    }

    public static function getTopic ($id)
    {
        $statement = [
            'select' => "
                f.*,
                u.username as username, u.id as idUser,
                us.look as look
            ",
            'join' => " as f
                INNER JOIN users u
                    ON f.idUser = u.id
                INNER JOIN users_settings us
                    ON f.idUser = us.idUser
            ",
            'where' => 'f.id = ?',
            'att' => $id
        ];
        $data = static::find($statement);

        if ($data) {
            $data->background = '/img/backgrounds/forum/' .$data->image;
            $data->lookD = Look::load($data->look, ['face' => 'speak']);
            $data->lookH = Look::load($data->look, ['size' => 'XS', 'only' => true]);
            $data->since = Systeme::dateFormat('since', $data->createAt);
            $data->link = static::$urlLink . $data->id;
            $data->profil = UsersTable::getLink('profil') . $data->idUser;
        }
        
        return $data;
    }

    public static function getAllComments ($id)
    {
        $statement = [
            'select' => "
                c.*,
                u.username as username,
                us.look as look
            ",
            'join' => " as c
                INNER JOIN users u
                    ON c.idUser = u.id
                INNER JOIN users_settings us
                    ON c.idUser = us.idUser
            ",
            'where' => 'c.idTopic = ?',
            'att' => $id
        ];
        
        return static::find($statement, '_comments', true);
    }

    public static function getComments ($id, $limitation = null)
    {
        
        $statement = [
            'select' => "
                c.*,
                u.username as username,
                us.look as look
            ",
            'join' => " as c
                INNER JOIN users u
                    ON c.idUser = u.id
                INNER JOIN users_settings us
                    ON c.idUser = us.idUser
            ",
            'where' => 'c.idTopic = ? AND idMention = 0',
            'oder' => 'c.createAt',
            'att' => $id
        ];

        (!is_null($limitation))? $statement['limit'] = $limitation : null;
        
        return static::find($statement, '_comments', true);
    }

    public static function getResponses ($id, $idMention)
    {
        $statement = [
            'select' => "
                c.*,
                a.username as username,
                a_s.look as look
                ",
            'join' => " as c
                INNER JOIN users a
                    ON c.idUser = a.id
                INNER JOIN users_settings a_s
                    ON c.idUser = a_s.idUser
                ",
            'where' => 'c.idTopic = ? AND idMention = ?',
            'order' => 'createAt',
            'att' => [$id, $idMention]
        ];

        return static::find($statement, '_comments', true);
    }

    public static function getMyTopics ()
    {
        $statement = [
            'where' => 'idUser = ?',
            'order' => 'createAt DESC',
            'att' => UsersTable::getMyData('id')
        ];
        $datas = static::find($statement, null, true);
        
        if ($datas) {
            foreach ($datas as $data) {
                $data->since = Systeme::dateFormat('since', $data->createAt);
                $data->link = static::$urlLink . $data->id;
                $data->edit = static::$urlLinkEdit . $data->id;
                $data->close = static::$urlLinkClose . $data->id;
                $data->open = static::$urlLinkOpen . $data->id;
            }
        }

        return $datas;
    }

    public static function getMyTopicsFollowed ()
    {
        $statement = [
            'select' => "
                f.*,
                t.id as idTopic, t.title as title, t.createAt as createAt, t.state as state
            ",
            'join' => " as f
                INNER JOIN forum t
                    ON f.idTopic = t.id
            ",
            'where' => 'f.idUser = ?',
            'order' => 'f.id',
            'att' => UsersTable::getMyData('id')
        ];
        $datas = static::find($statement, '_followed', true);
        
        if ($datas) {
            foreach ($datas as $data) {
                $data->since = Systeme::dateFormat('since', $data->createAt);
                $data->link = static::$urlLink . $data->idTopic;
            }
            return $datas;
        }

        return false;
    }

    public static function getMyTopicsCommented ()
    {
        $idsTopic = [];
        $topics = [];
        $idUser = UsersTable::getMyData('id');
        $followed = static::getMyTopicsFollowed();

        $statement = [
            'select' => 'idTopic',
            'where' => 'idUser = ?',
            'att' => $idUser
        ];
        $datas = static::find($statement, '_comments', true);

        foreach ($datas as $data) {
            if (!in_array($data->idTopic, $idsTopic)) $idsTopic[] = $data->idTopic;
        }

        for ($i = 0; $i < count($idsTopic); $i++) {
            $datas = static::getTopic($idsTopic[$i]);

            if ($datas->idUser !== $idUser) $topics[] = static::getTopic($idsTopic[$i]);
        }
        
        if ($followed) {
            for ($i = 0; $i < count($topics); $i++) {
                foreach ($followed as $data) {
                    if ($topics[$i]->id == $data->idTopic) unset($topics[$i]);
                }
            }
        }

        return array_values($topics);
    }
}
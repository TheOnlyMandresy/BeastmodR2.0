<?php

namespace Systeme\Table;

use Systeme;

class PostsTable extends Table
{
    protected static $table = 'posts';
    protected static $urlBackground = '/img/backgrounds/posts/';
    protected static $urlLink = '/posts/';
    protected static $urlLinkSection = '/posts/s/';

    public static function all ($all = false)
    {
        $where = ($all === false)? ' AND state = 2' : null;
        
        $statement = [
            'select' => 'p.*, ps.name as section ',
            'join' => " as p 
                INNER JOIN posts_sections ps
                    ON p.idSection = ps.id
                ",
            'where' => 'idSection <> 2' .$where,
            'order' => 'createAt DESC'
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

    public static function getPost ($id)
    {
        $statement = [
            'select' => "
                p.*,
                ps.name as section,
                u.username as authorUsername,
                us.look as authorLook,
                ur.name as authorRole
                ",
            'join' => " as p
                INNER JOIN posts_sections ps
                    ON p.idSection = ps.id
                INNER JOIN users u
                    ON p.idAuthorUser = u.id
                    INNER JOIN users_settings us
                        ON p.idAuthorUser = us.idUser
                    INNER JOIN ranks ur
                        ON p.idAuthorUser = ur.idUser
                ",
            'where' => 'p.id = ?',
            'att' => $id
        ];
        $datas = PostsTable::find($statement, null);

        if ($datas->idCorrectorUser > 0) {
            $statement = [
                'select' => "
                    p.*,
                    ps.name as section,
                    u.username as authorUsername,
                    us.look as authorLook,
                    ur.name as authorRole,
                    c.username as correctorUsername,
                    cs.look as correctorLook,
                    cr.name as correctorRole
                    ",
                'join' => " as p
                    INNER JOIN posts_sections ps
                        ON p.idSection = ps.id
                    INNER JOIN users u
                        ON p.idAuthorUser = u.id
                        INNER JOIN users_settings us
                            ON p.idAuthorUser = us.idUser
                        INNER JOIN ranks ur
                            ON p.idAuthorUser = ur.idUser
                    INNER JOIN users c
                        ON p.idCorrectorUser = c.id
                        INNER JOIN users_settings cs
                            ON p.idCorrectorUser = cs.idUser
                        INNER JOIN ranks cr
                            ON p.idCorrectorUser = cr.idUser
                    ",
                'where' => 'p.id = ?',
                'att' => $id
            ];
            $datas = PostsTable::find($statement, null);
        }

        if ($datas) {
            $datas->content = Systeme::security(['text' => $datas->content], 'decode');
            $datas->createAt = Systeme::dateFormat('full', $datas->createAt);
            $datas->editAt = Systeme::dateFormat('full', $datas->editAt);
            $datas->background = static::$urlBackground . $datas->image;
            $datas->link = static::$urlLink . $datas->id;
        }

        return $datas;
    }

    public static function getPostsCategory ($id, $idSection)
    {
        $statement = [
            'where' => 'idSection = ? AND state = 2 AND id <> ?',
            'limit' => ['start' => 3, 'end' => null],
            'order' => 'RAND()',
            'att' => [$idSection, $id]
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

    public static function getPostsNew ($id)
    {
        $statement = [
            'where' => 'state = 2 AND idSection <> 2 AND id <> ?',
            'limit' => ['start' => 3, 'end' => null],
            'order' => 'createAt DESC',
            'att' => $id
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

    public static function getOnly ($number)
    {   
        $statement = [
            'select' => 'p.*, ps.name as section ',
            'join' => " as p 
                INNER JOIN posts_sections ps
                    ON p.idSection = ps.id
                ",
            'where' => 'idSection <> 2 AND state = 2',
            'limit' => ['start' => $number],
            'order' => 'createAt DESC'
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

    public static function getSections ()
    {
        $statement = ['where' => 'id <> 2'];
        $datas = static::find($statement, '_sections', true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->link = static::$urlLinkSection . $data->id;
            }
        }

        return $datas;
    }

    public static function getSection ($id)
    {
        $statement = [
            'where' => 'id = ?',
            'att' => $id
        ];
        $datas = static::find($statement, '_sections', false);

        if ($datas) {
            $datas->link = static::$urlLinkSection . $datas->id;
        }

        return $datas;
    }

    public static function getPostsSection ($id)
    {
        $statement = [
            'select' => 'p.*, ps.name as section ',
            'join' => " as p 
                INNER JOIN posts_sections ps
                    ON p.idSection = ps.id
                ",
            'where' => 'idSection = ? AND state = 2',
            'order' => 'createAt DESC',
            'att' => $id
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

    public static function getAllPostComments ($id)
    {
        $statement = [
            'select' => 'c.*, u.username as username, us.look as look',
            'join' => " as c 
                INNER JOIN users u
                    ON c.idUser = u.id
                INNER JOIN users_settings us
                    ON c.idUser = us.idUser
                ",
            'where' => 'c.idPost = ?',
            'att' => $id
        ];

        return static::find($statement, '_comments', true);
    }

    public static function getComments ($id, $limitation = null)
    {
        $statement = [
            'select' => 'c.*, u.username as username, us.look as look',
            'join' => " as c 
                INNER JOIN users u
                    ON c.idUser = u.id
                INNER JOIN users_settings us
                    ON c.idUser = us.idUser
                ",
            'where' => 'c.idPost = ? AND idMention = 0',
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
            'where' => 'c.idPost = ? AND idMention = ?',
            'order' => 'createAt',
            'att' => [$id, $idMention]
        ];

        return static::find($statement, '_comments', true);
    }
}
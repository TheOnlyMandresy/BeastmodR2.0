<?php

namespace Systeme\Table;

use Systeme;
use Systeme\Table\Admin\UsersTable as Admin;
use Systeme\Table\Admin\SystemeTable as Structure;

class UsersTable extends Table
{
    protected static $table = 'users';
    protected static $urlBackground = '/img/backgrounds/users/';
    private static $urlProfil = '/users/p/';

    public static function getLink ($name)
    {
        switch ($name){
            case 'background':
                return static::$urlBackground;
            case 'profil':
                return static::$urlProfil;
            default:
                break;
        }
    }

    public static function all ()
    {
        $statement = [
            'select' => "
                u.*,
                us.gender as gender,
                us.look as look,
                us.motto as motto,
                us.vip as vip,
                us.certified as certified,
                us.lastConnexion as last
            ",
            'join' => " as u
                INNER JOIN users_settings us
                    ON u.id = us.idUser
            "
        ];
        $datas = static::find($statement, null, true);

        if ($datas) {
            foreach ($datas as $data) {
                $data->link = static::$urlProfil . $data->username;
            }

            return $datas;
        }
        
        return false;
    }

    public static function research ($word)
    {
        $datas = static::all();
        $word = strtolower($word);

        if ($datas == false) { return null; }

        foreach ($datas as $key => $data) {
            $found = strtolower($data->username);

            if (strpos($found, $word) === false) {
                unset($datas[$key]);
            }
        }

        return $datas;
    }

    public static function getUser ($id)
    {
        $statement = [
            'select' => "
                u.*,
                us.gender as gender,
                us.look as look,
                us.motto as motto,
                us.image as image,
                us.vip as vip,
                us.certified as certified,
                us.lastConnexion as last
            ",
            'join' => " as u
                INNER JOIN users_settings us
                    ON u.id = us.idUser
            ",
            'where' => 'u.id = ?',
            'att' => $id
        ];
        $datas = static::find($statement);
        
        if ($datas) {
            $datas->background = static::$urlBackground . $datas->image;
            $datas->link = static::$urlProfil . $datas->username;
        }

        return $datas;
    }

    public static function userExist ($datas)
    {
        $where = null;
        $att = null;
        $count = count($datas);

        if ($count > 1) {
            foreach ($datas as $key => $data) {
                if ($key === array_key_last($datas)) {
                    $where .= $key. ' = ?';
                } else {
                    $where .= $key. ' = ? AND ';
                }
                $att[$key] .= $data;
            }
        } else {
            $where = array_key_first($datas). ' = ?';
            $att = array_values($datas)[0];
        }

        $statement = [
            'where' => $where,
            'att' => $att
        ];
        $datas = static::find($statement);

        return ($datas)? true : false;
    }

    public static function getUserData ($datas, $get = null)
    {
        $where = null;
        $att = null;
        $count = count($datas);

        if ($count > 1) {
            foreach ($datas as $key => $data) {
                if ($key === array_key_last($datas)) {
                    $where .= $key. ' = ?';
                } else {
                    $where .= $key. ' = ? AND ';
                }
                $att[$key] .= $data;
            }
        } else {
            $where = array_key_first($datas). ' = ?';
            $att = array_values($datas)[0];
        }

        $statement = [
            'where' => $where,
            'att' => $att
        ];
        $datas = static::find($statement);
        
        $datas->background = static::$urlBackground . $datas->image;
        $datas->link = static::$urlProfil . $datas->username;

        return $datas->$get;
    }

    public static function getMyId ()
    {
        if (static::isLogged()) {
            return $_SESSION['user']['id'];
        }

        return false;
    }

    public static function getMyDatas ($id)
    {
        if (Admin::isStaff($id)) {
            $statement = [
                'select' => "
                    u.*,
                    us.gender as gender,
                    us.look as look,
                    us.motto as motto,
                    us.beastCoins as coins,
                    us.vip as vip,
                    us.certified as certified,
                    us.lastConnexion as last,
                    us.radio as radio,
                    us.image as image,
                    us.bubble as bubble,
                    r.name as rank,
                    r.description as rankDesc,
                    r.responsable as manager
                ",
                'join' => " as u
                    INNER JOIN users_settings us
                        ON u.id = us.idUser
                    INNER JOIN ranks r
                        ON u.id = r.idUser
                ",
                'where' => 'u.id = ?',
                'att' => $id
            ];
        } else {
            $statement = [
                'select' => "
                    u.*,
                    us.gender as gender,
                    us.look as look,
                    us.motto as motto,
                    us.beastCoins as coins,
                    us.vip as vip,
                    us.certified as certified,
                    us.lastConnexion as last,
                    us.radio as radio,
                    us.image as image,
                    us.bubble as bubble
                ",
                'join' => " as u
                    INNER JOIN users_settings us
                        ON u.id = us.idUser
                ",
                'where' => 'u.id = ?',
                'att' => $id
            ];
        }
        
        $datas = static::find($statement);

        $datas->last = Systeme::dateFormat('since', $datas->last);
        $datas->createAt = Systeme::dateFormat('fullConcat', $datas->createAt);
        $datas->sub = static::isVIP($datas->id);
        $datas->link = static::$urlProfil . $datas->username;
        $datas->background = static::$urlBackground . $datas->image;

        if (Admin::isStaff($id)) {
            $datas->manager = Admin::isManager($id);
        }

        return $datas;
    }

    public static function newBubble ($code)
    {
        $bubble = Structure::getBubble($code);

        if ($bubble->category === 'VIP' && static::getMyData('vip') == 0 && Admin::isStaff(static::getMyData('id')) == false) {
            return 'error-vip';
        }

        if ($bubble->category === 'Staff' && Admin::isStaff(static::getMyData('id')) == false) {
            return 'error-staff';
        }

        if ($bubble == false) {
            return 'error-unknow';
        }

        $idUser = static::getMyData('id');

        $datas = [
            'datas' => ['bubble' => $code],
            'ids' => ['idUser' => $idUser]
        ];

        return static::generalEdit($datas, '_settings');
    }

    public static function getMyData ($data)
    {
        $datas = static::login($_SESSION['user']['username'], null);

        if ($data !== 'password') {
            return (isset($datas->$data))? $datas->$data : null;
        }
    }

    public static function login ($username, $password = null)
    {
        $statement = [
            'select' => "
                u.*,
                us.gender as gender,
                us.look as look,
                us.vip as vip,
                us.radio as radio,
                us.bubble as bubble,
                us.image as image,
                us.certified as certified
            ",
            'join' => " as u
                INNER JOIN users_settings us
                    ON u.id = us.idUser
            ",
            'where' => 'u.username = ?',
            'att' => $username
        ];

        $user = static::find($statement);
    
        if (static::isLogged()) { return $user; }

        if ($user) {
            $hash = Systeme::security(['text'=> $password], 'hash');

            if (password_verify($hash, $user->password)) {
                static::session($user->id, $username);

                static::generalEdit([
                    'datas' => ['lastConnexion' => Systeme::dateFormat('sql', time())],
                    'ids' => ['idUser' => $user->id]
                ], '_settings');

                return true;
            }
        }

        return false;
    }

    public static function session ($id, $username)
    {
        $_SESSION['user'] = ['id' => $id, 'username' => $username];
    }

    public static function isLogged ()
    {
        return isset($_SESSION['user']);
    }

    public static function isVIP ($id)
    {
        $currentDate = time();
        $VIPdate = time();
        $link = '<a href="/shop/vip">Abonnez-vous >></a>';

        $statement = [
            'where' => 'idUser = ?',
            'att' => $id,
            'order' => 'id DESC'
        ];
        $datas = static::find($statement, '_subscription');

        if ($datas) {
            $VIPdate = Systeme::dateFormat('timestamp', $datas->end);
            $VIPFinal = Systeme::dateFormat('fullConcat', $datas->end);
        }

        return ($VIPdate > $currentDate)? "Fin le: " .$VIPFinal : $link;
    }

    public static function friends ($friendId)
    {
        $id = static::getMyData('id');
        $statement = [
            'where' => "
                (idSenderUser = ? AND idReceiverUser = ?)
                OR (idSenderUser = ? AND idReceiverUser = ?)
                AND request = 1
            ",
            'att' => [$id, $friendId, $friendId, $id]
        ];
        
        return static::find($statement, '_friends');
    }

    public function getProfilUrl ()
    {
        return '/users/profil/' .$this->username;
    }
}
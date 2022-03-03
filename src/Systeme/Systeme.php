<?php
use Systeme\Settings;
use Systeme\Database;

class Systeme extends Settings
{    
    private static $database;
    private $page;

    public function __construct ()
    {
        $page = $_SERVER['REQUEST_URI'];

        if (str_contains($page, '?')) {
            $pageExplode = explode('?', $page);
            $page = $pageExplode[0];
        }

        if ($page === '/') {
            $page = '/index';
        }
        
        $this->page = explode('/', $page);
        $extract = array_shift($this->page);

        if (reset($this->page) === 'admin') {
            return $this->pageAdmin();
        }
        return $this->page();
    }

    public static function root ($back = 2)
    {
        return realpath( dirname( __FILE__ , $back) ).'/';
    }

    private function page ()
    {
        $page = reset($this->page);
        $count = count($this->page);

        if ($count === 1) {
            $load = $page;

            switch ($page)
            {
                case 'index':
                    $controller = new \Systeme\Controller\SystemeController($this->page);
                    break;
                case 'login':
                case 'logout':
                case 'register':
                    $controller = new \Systeme\Controller\UsersController($this->page);
                    break;
                default:
                    $new = '\Systeme\Controller\\' .ucfirst($page). 'Controller';
                    $controller = new $new($this->page);
                    break;
            }
        } else {
            $new = '\Systeme\Controller\\' .ucfirst($page). 'Controller';
            $load = end($this->page);
            $controller = new $new($this->page);
        }

        // $controller->$load();
        
        // if ($this->pageController('/posts', 1)) {
        //     $controller = new \Systeme\Controller\PostsController();

        //     if (isset($_GET['id'])) {
        //         if ($this->pageController('/section')) {
        //             $controller->sections();
        //         } else {
        //             $controller->read();
        //         }
        //     } else {
        //         $controller->index();
        //     }
        // } elseif ($this->pageController('/users', 1)) {
        //     $controller = new \Systeme\Controller\UsersController();

        //     if ($this->pageController('/login')) {
        //         $controller->login();
        //     } elseif ($this->pageController('/logout')) {
        //         $controller->logout();
        //     } elseif ($this->pageController('/profil')) {
        //         $controller->profil();
        //     } elseif ($this->pageController('/parameters')) {
        //         $controller->parameters();
        //     }
        // } elseif ($this->pageController('/admin', 1)) {
        //     if ($this->pageController('/posts')) {
        //         $controller = new \Systeme\Controller\Admin\PostsController();
                
        //         if ($this->pageController('/posts', 2)) {
        //             $controller->index();
        //         }
        //     }
        // } else {
        //     $convert = explode('/', $this->page);
        //     $name = $convert[1];
        //     $controller = new \Systeme\Controller\SystemeController();
        //     $controller->$name();
        // }
    }

    private function pageAdmin ()
    {
        $extract = array_shift($this->page);
        $page = (reset($this->page) !== null)? reset($this->page) : 'index';
        $load = ($page === 'index')? $page : end($this->page);

        if ($page === 'index') {
            $new = new \Systeme\Controller\Admin\SystemeController();
        } else {
            $new = '\Systeme\Controller\Admin\\' .ucfirst($page). 'Controller';
        }

        new $new($this->page);
    }

    public static function setTitle ($name = null)
    {
        if ($name != null) {
            return self::WEBSITE. ': ' .$name;
        } else {
            return self::WEBSITE;
        }
    }

    public static function getSystemInfos ($name)
    {
        $load = strtoupper($name);
        $r = new ReflectionClass(__CLASS__);

        return $r->getConstant($load);
    }

    public static function getDb ()
    {
        if (self::$database === null) self::$database = new Database(self::DB_NAME, self::DB_HOST, self::DB_USER, self::DB_PASS);

        return self::$database;
    }

    /**
     * @param string $type since | fullConcat | full | day | mth | year | num | time | sql | timestamp | datetime
     * @return string Formated date
     */
    public static function dateFormat ($type = null, $date)
    {
        $time = (is_int($date))? $date : strtotime($date);

        switch($type)
        {
            case 'since':
                return static::dateSince($date);
            case 'fullConcat':
                return date('d/m/Y', $time);
            case 'full':
                return date('l d F Y', $time);
            case 'day':
                return date('l', $time);
            case 'mth':
                return date('F', $time);
            case 'year':
                return date('Y', $time);
            case 'num':
                return date('H:i:s', $time); 
            case 'time':
                return date('H', $time). 'h' .date('i', $time); 
            case 'sql':
                return date('Y-m-d H:i:s', $time);
            case 'timestamp':
                return strtotime($date);
            case 'datetime':
                return date('Y-m-d', $time). 'T' .date('H:i', $time); 
            default:
                return date('d/m/Y', $time);

        }
    }

    private static function dateSince ($created)
    {
        $now = new DateTime;
        $ago = new DateTime($created);
        $diff = $now->diff($ago);
        
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'an',
            'm' => 'mois',
            'w' => 'semaine',
            'd' => 'jour',
            'h' => 'heure',
            'i' => 'minute',
            // 's' => 'seconde'
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 && $k !== 'm' ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (isset($string['y'])) {
            return $string['y'];
        } elseif (isset($string['m'])) {
            return $string['m'];
        } elseif (isset($string['w'])) {
            return $string['w'];
        } elseif (isset($string['d'])) {
            return $string['d'];
        } else {
            return $string ? implode(', ', $string) : 'maintenant';
        }
    }

    public static function security ($code, $type = 'post')
    {
        switch ($type)
        {
            case 'post':
                return htmlentities(htmlspecialchars(trim($code['text'])));

            case 'decode':
                return html_entity_decode($code['text']);

            case 'get':
                return htmlspecialchars($code['text']);

            case 'hash':
                return md5(sha1($code['text']));

            case 'password':
                return password_hash($code['text'], PASSWORD_DEFAULT);

            case 'verify':
                $encode = self::security(['text' => $code['text']], 'hash');
                return password_verify($encode, $code['verify']);
        }
    }

    public static function specialUcFirst ($str, $encode = 'UTF-8') {

        $start = mb_strtoupper(mb_substr($str, 0, 1, $encode), $encode);
        $end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encode), $encode), $encode);
    
        $str = $start.$end;
        return $str;
    }
}
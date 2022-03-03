<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\PostsTable;
use Systeme\Table\UsersTable as User;
use Systeme\Table\EventsTable;
use Systeme\Table\Admin\SystemeTable;

class SystemeController
{   
    protected $compact = [];

    public function __construct ($page)
    {
        $load = $page[0];
        return $this->$load();
    }

    protected function render ($name, $variables = [], $template = true)
    {
        
        ob_start();
            $isLogged = User::isLogged();
            $myDatas = ($isLogged)? User::getMyDatas(User::getMyId()) : null;
            $alerts = static::alerts();
            extract($variables);
        $page = ob_end_clean();

        require_once Systeme::root(). 'Systeme/Views' .$name. '.php';
        
        $js = $this->loadJS(PAGE);

        ($template)? require_once Systeme::root(). 'Systeme/Views/Templates/Template' .TEMPLATE. '.php' : null;

        unset($_SESSION['flash']);
    }

    /**
     * @param int $code 403 | 404
     */
    protected function error ($code)
    {
        switch ($code)
        {
            case 403:
                header('HTTP/1.0 403 forbidden');
                die('Acces interdit');
            case 404:
                header('HTTP/1.0 404 Not Found');
                die('Page introuvable');
        }
    }

    protected function compact ($array = null, $delete = false)
    {
        if ($delete === true) {
            $this->compact = [];
        }

        if ($array !== null) {
            foreach ($array as $var) {
                $this->compact[] = $var;
            }
        }

        return $this->compact;
    }

    private function index ()
    {
        $title = Systeme::setTitle();
        $postsTitle = Systeme::specialUcFirst('articles');
        $eventsTitle = Systeme::specialUcFirst('Les événements');

        $posts = PostsTable::getOnly(3);
        $events = EventsTable::getEventsOnly(3);

        return $this->render('/Index', compact($this->compact(['title', 'postsTitle', 'eventsTitle', 'posts', 'events'])));
    }

    protected function flash ($datas, $link, $ponctuation = '.')
    {
        $_SESSION['flash'] = [
            'type' => $datas['type'],
            'message' => Systeme::specialUcFirst($datas['message']). $ponctuation
        ];

        return header('Location: ' .$link);
    }

    protected function alerts ()
    {
        $datas = SystemeTable::getAlerts();

        return ($datas)? $datas : false;
    }

    protected function isOnline ($link = null)
    {
        if (!isset($_SESSION['user'])) {
            return $this->flash([
                'type' => 'danger',
                'message' => 'vous êtes déconnecté'
            ], $link);
        }

        return null;
    }

    private function loadJS ($page)
    {
        if (str_contains($page, '-')) {
            $jsFile = explode('-', $page);
            $jsFile = ($jsFile[0] === "admin")? 'admin/' .$jsFile[1]. '.js' : $jsFile[0]. '.js';
        } else {
            $jsFile = $page. '.js';
        }

        return '<script type = "text/javascript" src="/js/' .$jsFile. '"></script>';
    }
}
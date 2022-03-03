<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\GamesTable;

class GamesController extends SystemeController
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1'], true);
        array_shift($page);

        if (empty($page)) {
            return $this->index();
        }
    }
    
    private function index ()
    {
        $title = Systeme::setTitle();
        $h1 = 'Liste jeux';

        $all = GamesTable::all();

        return $this->render('/Others/Games', compact($this->compact(['all'])));
    }
}
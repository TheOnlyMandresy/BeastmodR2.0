<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\PartnersTable;

class PartnersController extends SystemeController
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
        $title = Systeme::setTitle('Partenariats');
        $h1 = 'Nos partenariats';

        $all = PartnersTable::all();

        return $this->render('/Website/Partners', compact($this->compact(['all'])));
    }
}
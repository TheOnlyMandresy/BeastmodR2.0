<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\Admin\SystemeTable;

class ChangelogController extends SystemeController
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
        $title = Systeme::setTitle('Changelog');
        $h1 = 'Les changements de '. Systeme::getSystemInfos('website');
        $datas = SystemeTable::getLogs();
        $dates = [];

        foreach ($datas as $data) {
            (!in_array($data->date, $dates))? $dates[] = $data->date : null;
        }

        return $this->render('/Website/Changelog', compact($this->compact(['datas', 'dates'])));
    }
}
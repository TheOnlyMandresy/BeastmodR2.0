<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\RanksTable;
use Systeme\Controller\SystemeController;
use Systeme\HTML\Users\Look;

class StaffsController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        $this->compact(['title'], true);
        array_shift($page);
        $this->page = $page;

        if (empty($this->page)) {
            return $this->index();
        } else {
            $this->error(404);
        }
    }

    private function index ()
    {
        $title = Systeme::setTitle('Équipe');

        $all = RanksTable::getStaffs();

        foreach ($all as $data) {
            if ($data->responsable) {
                $data->look = Look::load($data->look, [
                    'only' => true,
                    'size' => 'XS'
                ]);

                $data->teammates = 0;

                foreach ($all as $teammate) {
                    $data->teammates = ($teammate->idSuperiorUser === $data->idUser)? ++$data->teammates : $data->teammates;
                }

                // $data->teammates = $count;
            } else {
                $data->look = Look::load($data->look, [
                    'only' => true
                ]);
            }

        }

        return $this->render('/Website/Staffs', compact($this->compact(['all'])));
    }
}
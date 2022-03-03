<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\EventsTable as Table;
use Systeme\HTML\Users\Look;
use \ChrisKonnertz\BBCode\BBCode;

class EventsController extends SystemeController
{
    public function __construct ($page)
    {
        $this->compact(['title', 'h1'], true);
        array_shift($page);

        if (empty($page)) {
            return $this->index();
        } elseif (is_int(intval($page[0]))) {
            return $this->read($page[0]);
        }

        return $this->error(404);
    }
    
    private function index ()
    {
        $title = Systeme::setTitle();
        $h1 = 'Liste des événements';

        $all = Table::all();
        $allMighty = Table::getTop(3);
        $allMonth = Table::getTop();

        foreach ($all as $data) {
            $data->startAt = Systeme::dateFormat('fullConcat', $data->startAt). ' à ' .Systeme::dateFormat('time', $data->startAt);
            $data->endAt = Systeme::dateFormat('timestamp', $data->endAt);
        }

        $count = count($allMighty);
        
        for ($i = 0; $i < $count; $i++) {
            switch ($i) {
                case 0:
                    $allMighty[$i]->look = Look::load($allMighty[$i]->look, [
                        'bodydirection' => 'S', 'headdirection' => 'S',
                        'face' => 'smile',
                        'action' => 'wave'
                    ]);
                    break;
                case 1:
                    $allMighty[$i]->look = Look::load($allMighty[$i]->look, [
                        'headdirection' => 'S',
                        'face' => 'smile'
                    ]);
                    break;
                case 2:
                    $allMighty[$i]->look = Look::load($allMighty[$i]->look, [
                        'bodydirection' => 'SW', 'headdirection' => 'S',
                        'face' => 'smile',
                        'action' => 'sit'
                    ]);
                    break;
            }
        }

        foreach ($allMonth as $data) {
            $data->look = Look::load($data->look, [
                'bodydirection' => 'SW', 'headdirection' => 'SW',
                'face' => 'smile']);
        }

        return $this->render('/Others/Events/Index', compact($this->compact(['all', 'allMighty', 'allMonth'])));
    }

    private function read ($id)
    {
        $data = Table::getEvent($id);

        ($data == false)? $this->error(404) : null;

        $title = Systeme::setTitle($data->title);
        $h1 = $data->title;
        $bbcode = new BBCode();
        $data->content = $bbcode->render($data->content);

        $start = Systeme::dateFormat('timestamp', $data->startAt);
        $end = Systeme::dateFormat('timestamp', $data->endAt);

        $data->startAt = Systeme::dateFormat('full', $data->startAt)
                            . ' à '
                            .Systeme::dateFormat('time', $data->startAt);
        $data->endAt = Systeme::dateFormat('full', $data->endAt)
                        . ' à '
                        .Systeme::dateFormat('time', $data->endAt);

        if (isset($data->firstPlaceUsername)) {
            $data->firstPlaceLook = Look::load($data->firstPlaceLook, ['only' => true, 'size' => 'XS', 'headdirection' => 'SW']);
            $data->secondPlaceLook = Look::load($data->secondPlaceLook, ['only' => true, 'size' => 'XS', 'headdirection' => 'SW']);
            $data->thirdPlaceLook = Look::load($data->thirdPlaceLook, ['only' => true, 'size' => 'XS', 'headdirection' => 'SW']);
        }

        return $this->render('/Others/Events/Read', compact($this->compact(['data', 'start', 'end'])));
    }
}
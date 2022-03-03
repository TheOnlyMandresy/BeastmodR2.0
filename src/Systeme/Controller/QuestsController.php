<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\QuestsTable as TableAdmin;
use Systeme\Table\QuestsTable as Table;
use \ChrisKonnertz\BBCode\BBCode;

class QuestsController extends SystemeController
{
    private $page;

    public function __construct ($page)
    {
        $this->compact(['title', 'h1'], true);
        array_shift($page);
        $this->page = $page;

        if (empty($this->page)) {
            return $this->index();
        } elseif (!isset($this->page[1])) {
            return $this->readQuest($this->page[0]);
        } elseif (isset($this->page[1])) {
            switch ($this->page[1])
            {
                case 'accept':
                    (User::isLogged() == false)? $this->error(403) : null;
                    return $this->acceptQuest($this->page[0]);
            }
        }

        return $this->error(404);
    }
    
    private function index ()
    {
        $title = Systeme::setTitle('Quêtes');
        $h1 = 'Le tableau de quêtes';

        $all = Table::all();
        if ($all) {
            foreach ($all as $data) {
                $data->content = substr($data->content, 0, 200). '...';
            }
        }

        if (User::isLogged()) {
            $owned = Table::getOwned(User::getMyData('id'));
            if (!empty($owned)) {
                $ids = [];
                for ($i = 0; $i < count($owned); $i++) {
                    $owned[$i]->content = substr($owned[$i]->content, 0, 200). '...';
                    $ids[] = $owned[$i]->id;
                }
                
                $this->compact(['ids']);
            } else {
                $owned = 'Aucune quêtes acceptées.';
            }
            $this->compact(['owned']);
        }

        return $this->render('/Others/Quests/Index', compact($this->compact(['all'])));
    }

    private function readQuest ($id)
    {
        $data = Table::getQuest($id);
        $end = Systeme::dateFormat('timestamp', $data->endAt);
        ($data == false)? $this->error(404) : null;

        if (!empty($_POST)) {
            if ($end <= time()) {
                return $this->flash(['type' => 'warning',
                    'message' => 'vous ne pouvez plus avancez dans cette quête. Elle est arrivée a échance'
                ], '/quests/' .$id);
            }
        
            $code = Systeme::security(['text' => $_POST['code']], 'post');
            return $this->codeQuest($id, $code);
        }

        $h1 = 'Quête - ' .$data->name;
        $title = Systeme::setTitle($h1);
        $bbcode = new BBCode();
        $data->content = $bbcode->render($data->content);

        if (User::isLogged()) {
            $owned = Table::getOwned(User::getMyData('id'));
            if (!empty($owned)) {
                $ids = []; 
                for ($i = 0; $i < count($owned); $i++) {
                    $ids[] = $owned[$i]->id;
                }
                $this->compact(['ids']);
            }
            $this->compact(['owned']);
        }

        if (isset($ids) && in_array($data->id, $ids)) {
            $steps = table::getProgress($id, User::getMyData('id'));
            $this->compact(['steps']);
        }

        return $this->render('/Others/Quests/Read', compact($this->compact(['data', 'end'])));
    }

    private function acceptQuest ($id)
    {
        $data = Table::getQuest($id);
        $end = Systeme::dateFormat('timestamp', $data->endAt);

        if ($end <= time()) {
            return $this->flash(['type' => 'infos',
                'message' => 'cette quête n\'est plus disponible'
            ], '/quests/' .$id);
        }
        
        TableAdmin::generalAdd([
            'idQuest' => $id,
            'idUser' => User::getMyData('id')
        ], '_progress');

        return $this->flash([
            'type' => 'success',
            'message' => 'quête acceptée'
        ], '/quests');
    }

    private function codeQuest ($id, $code)
    {
        $data = Table::getStep($id, $code);

        if ($data) {
            $state = Table::getProgress($id, User::getMyData('id'), $data->id);

            if ($state) {
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'vous possédez déjà cet indice'
                ], '/quests/'. $id);
            }

            TableAdmin::generalAdd([
                'idQuest' => $id,
                'idUser' => User::getMyData('id'),
                'idStep' => $data->id
            ], '_progress');

            if ($data->last == 1) {
                TableAdmin::generalAdd([
                    'idUser' => User::getMyData('id'),
                    'idQuest' => $id
                ], '_winners');

                return $this->flash([
                    'type' => 'success',
                    'message' => 'félicitation tu as trouvé le dernier indice'
                ], '/quests/'. $id);
            }

            return $this->flash([
                'type' => 'success',
                'message' => 'félicitation tu as trouvé un nouvel indice'
            ], '/quests/'. $id);
        }

        return $this->flash([
            'type' => 'danger',
            'message' => 'dommage, ce code est incorrect'
        ], '/quests/'. $id);
    }
}
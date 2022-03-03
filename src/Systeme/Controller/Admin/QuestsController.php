<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\QuestsTable as TableAdmin;
use Systeme\Table\QuestsTable as Table;

class QuestsController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1'], true);
        ((Admin::adminAccess(23) || Admin::adminAccess(22)) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            return $this->index();
        } elseif (isset($this->page[0])) {
            switch ($this->page[0]) {
                case 'new':
                    (Admin::adminAccess(22) == false)? $this->error(403) : null;
                    return $this->new();

                case 'e':
                    return $this->edit($this->page[1]);
            }
        }
    }

    private function index ()
    {
        $h1 = 'Les quêtes';
        $title = Systeme::setTitle('[A] ' .$h1);

        $all = Table::all();

        return $this->render('/Admin/Others/Quests/Index', compact($this->compact(['all'])));
    }

    private function new ()
    {
        if (!empty($_POST) && isset($this->page[1])) {
            $image = Table::generalImage($_FILES);

            switch ($image) {
                case 'error-1':
                    return $this->flash(['type' => 'danger',
                        'message' => 'ce n\'est pas une image'
                    ], '/admin/quests/new/');
                case 'error-2':
                    return $this->flash(['type' => 'danger',
                        'message' => 'trop volumineux'
                    ], '/admin/quests/new/');
                case 'error-3':
                    return $this->flash(['type' => 'danger',
                        'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                    ], '/admin/quests/new/');
                case 'error-4':
                    return $this->flash(['type' => 'danger',
                        'message' => 'une erreur est survenue pendant l\'upload de votre image'
                    ], '/admin/quests/new/');
                default:
                    break;
            }

            TableAdmin::generalAdd([
                'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                'image' => $image,
                'reward' => Systeme::security(['text' => $_POST['reward']], 'post'),
                'startAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['startAt']], 'post')),
                'endAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['endAt']], 'post')),
            ]);
    
            return $this->flash([
                'type' => 'success',
                'message' => 'quête ajouté'
            ], '/admin/quests');
        }

        $title = Systeme::setTitle('[A] Nouvelle quête');
        $h1 = 'Ajout de nouvelle quête';

        return $this->render('/Admin/Others/Quests/New', compact($this->compact()));
    }
    
    private function edit ($id)
    {
        if (isset($this->page[2])) {
            if ($this->page[2] === 'edit') {
                (Admin::adminAccess(22) == false)? $this->error(403) : null;
                $image = Table::generalImage($_FILES);
                $datas = [
                    'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                    'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                    'reward' => Systeme::security(['text' => $_POST['reward']], 'post'),
                    'startAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['startAt']], 'post')),
                    'endAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['endAt']], 'post'))
                ];
    
                switch ($image) {
                    case 'error-1':
                        return $this->flash(['type' => 'danger',
                            'message' => 'ce n\'est pas une image'
                        ], '/admin/quests/edit/' .$id);
                    case 'error-2':
                        return $this->flash(['type' => 'danger',
                            'message' => 'trop volumineux'
                        ], '/admin/quests/edit/' .$id);
                    case 'error-3':
                        return $this->flash(['type' => 'danger',
                            'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                        ], '/admin/quests/edit/' .$id);
                    case 'error-4':
                        return $this->flash(['type' => 'danger',
                            'message' => 'une erreur est survenue pendant l\'upload de votre image'
                        ], '/admin/quests/edit/' .$id);
                    default:
                        break;
                }
    
                (!is_null($image))? $datas['image'] = $image : null;

                TableAdmin::generalEdit([
                    'datas' => $datas,
                    'id' => $id
                ]);
    
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'quête modifié'
                ], '/admin/quests');
            } elseif ($this->page[2] === 'step') {
                if (!isset($this->page[3])) {
                    TableAdmin::generalAdd([
                        'idQuest' => $id,
                        'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                        'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                        'code' => Systeme::security(['text' => $_POST['code']], 'post'),
                        'last' => (isset($_POST['last']))? 1 : 0
                    ], '_steps');
    
                    return $this->flash([
                        'type' => 'success',
                        'message' => 'étape de quête ajouté'
                    ], '/admin/quests/e/' .$id);
                } else {
                    TableAdmin::generalEdit([
                        'datas' => [
                            'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                            'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                            'code' => Systeme::security(['text' => $_POST['code']], 'post'),
                            'last' => (isset($_POST['last']))? 1 : 0
                        ],
                        'id' => $this->page[3]
                    ], '_steps');
    
                    return $this->flash([
                        'type' => 'infos',
                        'message' => 'étape de quête modifié'
                    ], '/admin/quests/e/' .$id);
                }
            } elseif ($this->page[2] === 'delete') {
                (Admin::adminAccess(23) == false)? $this->error(403) : null;

                TableAdmin::generalDelete($id);
    
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'quête supprimé'
                ], '/admin/quests');
            }
        }

        $data = Table::getQuest($id);
        $datas = Table::getSteps($id);
        if (Table::getWinners($id)) {
            $winners = Table::getWinners($id);
            $this->compact(['winners']);
        }


        $title = Systeme::setTitle('[A] Modification quête');
        $h1 = 'Modification : ' .$data->name;

        return $this->render('/Admin/Others/Quests/Edit', compact($this->compact(['data', 'datas'])));
    }
}
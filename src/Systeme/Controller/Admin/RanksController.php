<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\Admin\RanksTable as TableAdmin;
use Systeme\Table\RanksTable as Table;
use Systeme\Table\UsersTable as User;

class RanksController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1'], true);
        (TableAdmin::adminAccess(21) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            return $this->indexRanks();
        } elseif (isset($this->page[0])) {
            switch ($this->page[0]) {
                case 'new':
                    (TableAdmin::adminAccess(5) == false)? $this->error(403) : null;
                    
                    return $this->newRanks();
                case 'e':
                    return $this->editRanks($this->page[1]);
                case 'rights':
                    (TableAdmin::adminAccess(10) == false)? $this->error(403) : null;

                    if (isset($this->page[1]) && $this->page[1] === 'e') {
                        return $this->editRights($this->page[2]);
                    }
                    
                    return $this->indexRights();
            }
        }
    }

    private function indexRanks ()
    {
        $h1 = 'L\'équipe';
        $title = Systeme::setTitle('[A] ' .$h1);

        $all = Table::all();
        $team = (Table::getTeam())? Table::getTeam() : null;

        return $this->render('/Admin/Website/Ranks/Index', compact($this->compact(['all', 'team'])));
    }

    private function newRanks ()
    {
        if (!empty($_POST) && isset($this->page[1])) {

            if (User::userExist(['username' => Systeme::security(['text' => $_POST['idUser']], 'post')]) === false) {
                return $this->flash(['type' => 'warning',
                    'message' => 'cet utilisateur n\'existe pas'
                ], '/admin/ranks/new');
            }

            if (is_array($_POST['idRights'])) {
                foreach ($_POST['idRights'] as $rightId) {
                    if (TableAdmin::adminAccess(10) == false) {
                        return $this->flash(['type' => 'danger',
                            'message' => 'Tu ne peux pas attribuer ce droit'
                        ], '/admin/ranks');
                    }
                }
            }

            if (Systeme::security(['text' => $_POST['responsable']], 'post') > 0) {
                return (TableAdmin::isManager(User::getMyData('id')) || TableAdmin::isGod())? null : $this->flash(['type' => 'danger',
                    'message' => 'Tu ne peux pas attribuer ce droit'
                ], '/admin/ranks');
            }

            $idUser = User::getUserData(['username' => Systeme::security(['text' => $_POST['idUser']], 'post')], 'id');
            $rightsId = (is_array($_POST['idRights']))? implode(',', $_POST['idRights']) : Systeme::security(['text' => $_POST['responsable']], 'post');
            
            if (TableAdmin::staffExist($idUser)) {
                return $this->flash(['type' => 'warning',
                    'message' => 'joueur déjà staff'
                ], '/admin/ranks');
            }

            TableAdmin::generalAdd([
                'idSuperiorUser' => User::getMyData('id'),
                'idUser' => $idUser,
                'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                'responsable' => Systeme::security(['text' => $_POST['responsable']], 'post'),
                'idRights' => $rightsId
            ]);
    
            return $this->flash([
                'type' => 'success',
                'message' => 'fontions attribués au joueur'
            ], '/admin/ranks');
        }

        $title = Systeme::setTitle('[A] Nouveau membre dans l\'équipe');
        $h1 = 'Ajout d\'un membre dans l\'équipe';

        $rights = Table::allRights();

        return $this->render('/Admin/Website/Ranks/New', compact($this->compact(['rights'])));
    }
    
    private function editRanks ($id)
    {
        (TableAdmin::userTeam($id) == false)? $this->error(403) : null;

        if (isset($this->page[2])) {
            if ($this->page[2] === 'edit') {
                (TableAdmin::adminAccess(5) == false)? $this->error(403) : null;

                $rightsId = (is_array($_POST['idRights']))? implode(',', $_POST['idRights']) : Systeme::security(['text' => $_POST['responsable']], 'post');

                TableAdmin::generalEdit([
                    'datas' => [
                        'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                        'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                        'responsable' => Systeme::security(['text' => $_POST['responsable']], 'post'),
                        'idRights' => $rightsId
                    ],
                    'id' => $id
                ]);
    
                return $this->flash([
                    'type' => 'warning',
                    'message' => 'droits du joueur modifiés'
                ], '/admin/ranks');
            } elseif ($this->page[2] === 'delete') {
                (TableAdmin::adminAccess(6) == false)? $this->error(403) : null;
                TableAdmin::generalDelete($id);
    
                return $this->flash([
                    'type' => 'success',
                    'message' => 'joueur retiré de ses fonctions'
                ], '/admin/ranks');
            }
        }

        $data = Table::getUser($id);
        $resp = ($data->responsable == 1)? true : false;
        $data->idRights = explode(',', $data->idRights);

        $title = Systeme::setTitle('[A] Modification membre équipe');
        $h1 = 'Modification : ' .$data->username;
        $edit = true;

        $rights = Table::allRights();

        return $this->render('/Admin/Website/Ranks/New', compact($this->compact(['data', 'resp', 'rights', 'edit'])));
    }

    private function indexRights ()
    {
        if (!empty($_POST) && isset($this->page[1])) {
            TableAdmin::generalAdd([
                'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                'category' => Systeme::security(['text' => $_POST['category']], 'post')
            ], '_rights');
    
            return $this->flash([
                'type' => 'success',
                'message' => 'droit ajouté'
            ], '/admin/ranks/rights');
        }

        $h1 = 'Les droits';
        $title = Systeme::setTitle('[A] ' .$h1);

        $all = Table::allRights();

        return $this->render('/Admin/Website/Ranks/IndexRights', compact($this->compact(['all'])));
    }

    private function editRights ($id)
    {
        if (isset($this->page[3])) {
            if ($this->page[3] === 'edit') {
                TableAdmin::generalEdit([
                    'datas' => [
                        'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                        'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                        'category' => Systeme::security(['text' => $_POST['category']], 'post')
                    ],
                    'id' => $id
                ], '_rights');
    
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'droit modifié'
                ], '/admin/ranks/rights');
            } elseif ($this->page[3] === 'delete') {
                TableAdmin::generalDelete($id, '_rights');
    
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'droit supprimé'
                ], '/admin/ranks/rights');
            }
        }
        
        $title = Systeme::setTitle('[A] Modification de droit');

        $right = Table::getRight($id);
        $h1 = 'Modification : ' .$right->name;

        return $this->render('/Admin/Website/Ranks/EditRights', compact($this->compact(['right'])));
    }
}
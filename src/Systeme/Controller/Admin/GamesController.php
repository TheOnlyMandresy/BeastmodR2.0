<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\GamesTable as TableAdmin;
use Systeme\Table\GamesTable as Table;
use Systeme\Table\UsersTable;

class GamesController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1'], true);
        (Admin::adminAccess(20) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            return $this->index();
        } elseif (isset($this->page[0])) {
            switch ($this->page[0]) {
                case 'new':
                    (Admin::adminAccess(16) == false)? $this->error(403) : null;

                    return $this->new();
                case 'e':
                    return $this->edit($this->page[1]);
            }
        }
    }

    private function index ()
    {
        $h1 = 'Les jeux';
        $title = Systeme::setTitle('[A] ' .$h1);

        $games = Table::all();

        return $this->render('/Admin/Others/Games/Index', compact($this->compact(['games'])));
    }

    private function new ()
    {
        if (!empty($_POST) && isset($this->page[1])) {
            if (UsersTable::userExist(['username' => Systeme::security(['text' => $_POST['idUser']], 'post')]) === false) {
                return $this->flash(['type' => 'warning',
                    'message' => 'cet utilisateur n\'existe pas'
                ], '/admin/games/new');
            }

            TableAdmin::generalAdd([
                'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                'idUser' => UsersTable::getUserData(['username' => Systeme::security(['text' => $_POST['idUser']], 'post')], 'id'),
                'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                'url' => Systeme::security(['text' => $_POST['url']], 'post'),
                'image' => Systeme::security(['text' => $_POST['image']], 'post')
            ]);
    
            return $this->flash([
                'type' => 'success',
                'message' => 'jeu ajouté'
            ], '/admin/games');
        }

        $title = Systeme::setTitle('[A] Nouveau jeu');
        $h1 = 'Ajout d\'un jeu';

        return $this->render('/Admin/Others/Games/nNew', compact($this->compact()));
    }
    
    private function edit ($id)
    {
        if (isset($this->page[2])) {
            if ($this->page[2] === 'edit') {
                (Admin::adminAccess(16) == false)? $this->error(403) : null;

                if (UsersTable::userExist(['username' => Systeme::security(['text' => $_POST['idUser']], 'post')]) === false) {
                    return $this->flash(['type' => 'warning',
                        'message' => 'cet utilisateur n\'existe pas'
                    ], '/admin/games/e/' .$id);
                }

                TableAdmin::generalEdit([
                    'datas' => [
                        'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                        'idUser' => UsersTable::getUserData(['username' => Systeme::security(['text' => $_POST['idUser']], 'post')], 'id'),
                        'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                        'url' => Systeme::security(['text' => $_POST['url']], 'post'),
                        'image' => Systeme::security(['text' => $_POST['image']], 'post')
                    ],
                    'id' => $id
                ]);
    
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'jeu modifié'
                ], '/admin/games');
            } elseif ($this->page[2] === 'delete') {
                (Admin::adminAccess(17) == false)? $this->error(403) : null;

                TableAdmin::generalDelete($id);
    
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'jeu supprimé'
                ], '/admin/games');
            }
        }

        $game = Table::getGame($id);

        $title = Systeme::setTitle('[A] Modification de jeu');
        $h1 = 'Modification : ' .$game->name;
        $edit = true;


        return $this->render('/Admin/Others/Games/New', compact($this->compact(['game', 'edit'])));
    }
}
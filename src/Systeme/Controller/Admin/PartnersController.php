<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\PartnersTable as TableAdmin;
use Systeme\Table\PartnersTable as Table;

class PartnersController extends SystemeController
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
        $h1 = 'Les partenariats';
        $title = Systeme::setTitle('[A] ' .$h1);

        $partners = Table::all();

        return $this->render('/Admin/Website/Partners/Index', compact($this->compact(['partners'])));
    }

    private function new ()
    {
        if (!empty($_POST) && isset($this->page[1])) {
            TableAdmin::generalAdd([
                'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                'author' => Systeme::security(['text' => $_POST['author']], 'post'),
                'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                'url' => Systeme::security(['text' => $_POST['url']], 'post'),
                'logo' => Systeme::security(['text' => $_POST['logo']], 'post')
            ]);
    
            return $this->flash([
                'type' => 'success',
                'message' => 'partenariat ajouté'
            ], '/admin/partners');
        }

        $title = Systeme::setTitle('[A] Nouveau partenariat');
        $h1 = 'Ajout de nouveau partenariat';

        return $this->render('/Admin/Website/Partners/New', compact($this->compact()));
    }
    
    private function edit ($id)
    {
        if (isset($this->page[2])) {
            if ($this->page[2] === 'edit') {
                (Admin::adminAccess(22) == false)? $this->error(403) : null;

                TableAdmin::generalEdit([
                    'datas' => [
                        'name' => Systeme::security(['text' => $_POST['name']], 'post'),
                        'author' => Systeme::security(['text' => $_POST['author']], 'post'),
                        'description' => Systeme::security(['text' => $_POST['description']], 'post'),
                        'url' => Systeme::security(['text' => $_POST['url']], 'post'),
                        'logo' => Systeme::security(['text' => $_POST['logo']], 'post')
                    ],
                    'id' => $id
                ]);
    
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'partenariat modifié'
                ], '/admin/partners');
            } elseif ($this->page[2] === 'delete') {
                (Admin::adminAccess(23) == false)? $this->error(403) : null;

                TableAdmin::generalDelete($id);
    
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'partenariat supprimé'
                ], '/admin/partners');
            }
        }

        $partner = Table::getPartner($id);

        $title = Systeme::setTitle('[A] Modification partenariat');
        $h1 = 'Modification : ' .$partner->name;
        $edit = true;

        return $this->render('/Admin/Website/Partners/New', compact($this->compact(['partner', 'edit'])));
    }
}
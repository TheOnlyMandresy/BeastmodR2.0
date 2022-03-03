<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\ForumTable as TableAdmin;
use Systeme\Table\ForumTable as Table;

class ForumController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1', 'p'], true);
        (Admin::adminAccess(19) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            // return $this->index();
        } elseif (isset($this->page[0])) {
            switch ($this->page[0]) {
                case 'new':
                    (Admin::adminAccess(12) == false)? $this->error(403) : null;
                    
                    // return $this->new();
                case 'e':
                    // return $this->edit($this->page[1]);
            }
        }
    }
}
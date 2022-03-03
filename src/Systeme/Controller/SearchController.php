<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\UsersTable as Table;
use Systeme\HTML\Users\Look;

class SearchController extends SystemeController
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
        if (!empty($_POST)) {
            $word = Systeme::security(['text' => $_POST['username']], 'post');
            $result = Table::research($word);

            if ($result) {
                foreach ($result as $data) {
                    $data->look = Look::load($data->look, ['face' => 'smile', 'headdirection' => 'S']);
                    $data->last = Systeme::dateFormat('fullConcat', $data->last);
                }
                $this->compact(['result']);
            } else {
                return $this->flash(['type' => 'warning',
                    'message' => 'aucun résultat pour "' .$word. '"'
                ], '/users');
            }
        }

        $title = Systeme::setTitle('Communauté');
        $h1 = 'Toute la communauté de ' .Systeme::getSystemInfos('website');

        $datas = Table::all();

        if ($datas) {
            foreach ($datas as $data) {
                $data->look = Look::load($data->look, ['face' => 'smile', 'headdirection' => 'S']);
                $data->last = Systeme::dateFormat('fullConcat', $data->last);
            }
        }

        return $this->render('/Community/Search', compact($this->compact(['h1', 'datas'])));
    }
}
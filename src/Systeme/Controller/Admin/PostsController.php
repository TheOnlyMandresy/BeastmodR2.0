<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\PostsTable as TableAdmin;
use Systeme\Table\PostsTable as Table;

class PostsController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1'], true);
        (Admin::adminAccess(18) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            return $this->postIndex();
        } elseif (isset($this->page[0])) {
            switch ($this->page[0]) {
                case 'new':
                    (Admin::adminAccess(1) == false)? $this->error(403) : null;
                    return $this->postNew();

                case 'requests':
                    (Admin::adminAccess(34) == false)? $this->error(403) : null;

                    if (!isset($this->page[2])) {
                        return $this->requestIndex();
                    }
                    return $this->requestEdit($this->page[2]);
                    
                case 'e':
                    return $this->postEdit($this->page[1]);
            }
        }
    }

    private function postIndex ()
    {
        $h1 = 'Les articles';
        $title = Systeme::setTitle('[A] ' .$h1);
        $posts = Table::all(true);
        $myId = User::getMyData('id');
        $requests = TableAdmin::getRequests();

        ($requests)? $this->compact(['requests']) : null;

        return $this->render('/Admin/Posts/Index', compact($this->compact(['posts', 'myId'])));
    }

    private function postNew ()
    {
        if (!empty($_POST) && isset($this->page[1])) {
            $image = Table::generalImage($_FILES);

            switch ($image) {
                case 'error-1':
                    return $this->flash(['type' => 'danger',
                        'message' => 'ce n\'est pas une image'
                    ], '/admin/posts/new/');
                case 'error-2':
                    return $this->flash(['type' => 'danger',
                        'message' => 'trop volumineux'
                    ], '/admin/posts/new/');
                case 'error-3':
                    return $this->flash(['type' => 'danger',
                        'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                    ], '/admin/posts/new/');
                case 'error-4':
                    return $this->flash(['type' => 'danger',
                        'message' => 'une erreur est survenue pendant l\'upload de votre image'
                    ], '/admin/posts/new/');
                default:
                    break;
            }

            TableAdmin::generalAdd([
                'idAuthorUser' => User::getMyData('id'),
                'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                'teaser' => Systeme::security(['text' => $_POST['teaser']], 'post'),
                'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                'image' => $image,
                'idSection' => Systeme::security(['text' => $_POST['idSection']], 'post'),
                'state' => ($this->page[1] === 'save')? 0 : 1
            ]);
                
            if ($this->page[1] === 'save') {
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'article sauvegardé'
                ], '/admin/posts');
            } 

            return $this->flash([
                'type' => 'success',
                'message' => 'article créé'
            ], '/admin/posts');
        }

        $title = Systeme::setTitle('[A] Création d\'article');
        $h1 = 'Création d\'article';

        $sections = Table::getSections();
        foreach ($sections as $option) {
            $options[] = [$option->id => $option->name];
        }
        $opt = ['Catégorie de l\'article' => $options];

        return $this->render('/Admin/Posts/New', compact($this->compact(['opt'])));
    }

    private function postEdit ($id)
    {
        $post = Table::getPost($id);

        if (isset($this->page[2])) {
            if ($this->page[2] === 'send') {
                ((Admin::adminAccess(2) || $post->idUser !== User::getMyData('id')) == false)? $this->error(403) : null;

                if (!empty($_POST)) {
                    $image = Table::generalImage($_FILES);
                    $datas = [
                        'idCorrectorUser' => User::getMyData('id'),
                        'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                        'teaser' => Systeme::security(['text' => $_POST['teaser']], 'post'),
                        'idSection' => Systeme::security(['text' => $_POST['idSection']], 'post'),
                        'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                        'state' => 1,
                        'editAt' => Systeme::dateFormat('sql', time())
                    ];
                    switch ($image) {
                        case 'error-1':
                            return $this->flash(['type' => 'danger',
                                'message' => 'ce n\'est pas une image'
                            ], '/forum/e/' .$id);
                        case 'error-2':
                            return $this->flash(['type' => 'danger',
                                'message' => 'trop volumineux'
                            ], '/forum/e/' .$id);
                        case 'error-3':
                            return $this->flash(['type' => 'danger',
                                'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                            ], '/forum/e/' .$id);
                        case 'error-4':
                            return $this->flash(['type' => 'danger',
                                'message' => 'une erreur est survenue pendant l\'upload de votre image'
                            ], '/forum/e/' .$id);
                        default:
                            break;
                    }
        
                    (!is_null($image))? $datas['image'] = $image : null;

                    TableAdmin::generalEdit([
                        'datas' => $datas,
                        'id' => $id
                    ]);
                } else {
                    TableAdmin::generalEdit([
                        'datas' => [
                            'state' => 1
                        ],
                        'id' => $id
                    ]);
                }

                return $this->flash([
                    'type' => 'success',
                    'message' => 'article envoyé'
                ], '/admin/posts');
            } elseif ($this->page[2] === 'save') {
                ((Admin::adminAccess(2) || $post->idUser !== User::getMyData('id')) == false)? $this->error(403) : null;

                if (!empty($_POST)) {
                    $image = Table::generalImage($_FILES);
                    $datas = [
                        'idCorrectorUser' => User::getMyData('id'),
                        'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                        'teaser' => Systeme::security(['text' => $_POST['teaser']], 'post'),
                        'idSection' => Systeme::security(['text' => $_POST['idSection']], 'post'),
                        'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                        'state' => $post->state,
                        'editAt' => Systeme::dateFormat('sql', time())
                    ];
                    switch ($image) {
                        case 'error-1':
                            return $this->flash(['type' => 'danger',
                                'message' => 'ce n\'est pas une image'
                            ], '/forum/e/' .$id);
                        case 'error-2':
                            return $this->flash(['type' => 'danger',
                                'message' => 'trop volumineux'
                            ], '/forum/e/' .$id);
                        case 'error-3':
                            return $this->flash(['type' => 'danger',
                                'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                            ], '/forum/e/' .$id);
                        case 'error-4':
                            return $this->flash(['type' => 'danger',
                                'message' => 'une erreur est survenue pendant l\'upload de votre image'
                            ], '/forum/e/' .$id);
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
                        'message' => 'article modifié'
                    ], '/admin/posts');
                }
            } elseif ($this->page[2] === 'publish') {
                (Admin::adminAccess(4) == false)? $this->error(403) : null;

                TableAdmin::generalEdit([
                    'datas' => [
                        'state' => 2,
                        'createAt' => Systeme::dateFormat('sql', time()),
                        'editAt' => Systeme::dateFormat('sql', time())
                    ],
                    'id' => $id
                ]);

                return $this->flash([
                    'type' => 'success',
                    'message' => 'article rendu public'
                ], '/admin/posts');
            } elseif ($this->page[2] === 'unpublish') {
                (Admin::adminAccess(4) == false)? $this->error(403) : null;
                
                TableAdmin::generalEdit([
                    'datas' => [
                        'state' => 1
                    ],
                    'id' => $id
                ]);

                return $this->flash([
                    'type' => 'warning',
                    'message' => 'article rendu privé'
                ], '/admin/posts');
            } elseif ($this->page[2] === 'delete') {
                ((Admin::adminAccess(3) || $post->idUser !== User::getMyData('id')) == false)? $this->error(403) : null;
                
                TableAdmin::generalDelete($id);

                return $this->flash([
                    'type' => 'danger',
                    'message' => 'article supprimé'
                ], '/admin/posts');
            }
        }

        $title = Systeme::setTitle('[A] Édition d\'article');
        $edit = true;
        
        $post = Table::getPost($id);
        $sections = Table::find(null, '_sections', true);

        foreach ($sections as $option)
        {
            if ($option->name !== 'events') {
                $options[] = [$option->id => $option->name];
            }
        }
        $opt = ['Catégorie de l\'article' => $options];

        $h1 = 'Modification : ' .$post->title;
        
        return $this->render('/Admin/Posts/New', compact($this->compact(['edit', 'post', 'opt'])));
    }

    private function requestIndex ()
    {
        if (!empty($_POST)) {
            TableAdmin::generalAdd([
                'idUser' => User::getMyData('id'),
                'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                'content' =>  Systeme::security(['text' => $_POST['content']], 'post')
            ], '_requests');

            return $this->flash([
                'type' => 'success',
                'message' => 'requête ajoutée'
            ], '/admin/posts/requests');
        }

        $h1 = 'Les requêtes';
        $title = Systeme::setTitle('[A] ' .$h1);

        $all = TableAdmin::getRequests();

        return $this->render('/Admin/Posts/Requests/Index', compact($this->compact(['all'])));
    }

    private function requestEdit ($id)
    {
        if (!empty($_POST)) {
            if ($this->page[3] === 'edit') {
                TableAdmin::generalEdit([
                    'datas' => [
                        'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                        'content' =>  Systeme::security(['text' => $_POST['content']], 'post')
                    ],
                    'id' => $id
                ], '_requests');
    
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'requête modifiée'
                ], '/admin/posts/requests');

            } elseif ($this->page[3] === 'delete') {
                TableAdmin::generalDelete($id, '_requests');
    
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'requête supprimée'
                ], '/admin/posts/requests');
            }
        }
    }
}
<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\ForumTable as TableAdmin;
use Systeme\Table\ForumTable as Table;
use Systeme\HTML\Users\Look;
use \ChrisKonnertz\BBCode\BBCode;

class ForumController extends SystemeController
{
    private $page;

    public function __construct ($page)
    {
        $this->compact(['title', 'h1'], true);
        array_shift($page);
        $this->page = $page;

        if (empty($this->page)) {
            return $this->indexForum();
        } else {
            switch ($this->page[0])
            {
                case 's':
                    return (isset($this->page[1]))? $this->indexForum($this->page[1]) : $this->indexForum();
                case 'new':
                    $this->isOnline('/Forum');
                    return (isset($this->page[1]))? $this->newForum($this->page[1]) : $this->newForum();
                case 'e':
                    $this->isOnline('/Forum');
                    return (isset($this->page[1]))? $this->editForum($this->page[1]) : $this->error(404);
        
                default:
                    $id = $this->page[0];
                    $pagination = (isset($this->page[1]))? $this->page[1] : 1;
                    return $this->readForum($id, $pagination);
            }
        }
    }
    
    private function indexForum ($id = null)
    {
        $title = Systeme::setTitle();
        $h1 = 'Les derniers topics';
        $all = Table::all();
        $allSec = Table::allSections();

        if (User::isLogged()) {
            $myTopics = Table::getMyTopics();
            $myTopicsFollowed = Table::getMyTopicsFollowed();
            $myTopicsCommented = Table::getMyTopicsCommented();
            
            $this->compact(['myTopics', 'myTopicsFollowed', 'myTopicsCommented']);
        }

        if ($id) {
            $section = Table::getSection($id);
            $name = 'Forum: ' .$section->name;
            $title = Systeme::setTitle($name);
            $h1 = $name;
            $all = Table::getAllSection($id);

            for ($i = 0; $i < count($allSec); $i++) {
                if ($allSec[$i]->id == $id) {
                    unset($allSec[$i]);
                }
            }

            $this->compact(['section']);
        }

        return $this->render('/Community/Forum/Index', compact($this->compact(['all', 'allSec'])));
    }

    private function readForum ($id, $pagination)
    {
        if (!empty($_POST)) {
            if (!isset($_POST['forum-comment'])) {
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'Une erreur est survenue'
                ], '/posts/' .$id);
            }

            TableAdmin::generalAdd([
                'idUser' => User::getMyData('id'),
                'idTopic' => $id,
                'message' => Systeme::security(['text' => $_POST['message']], 'post'),
                'idBubble' => User::getMyData('bubble'),
                'idMention' => Systeme::security(['text' => $_POST['answerTo']], 'post')
            ], '_comments');

            return $this->flash([
                'type' => 'success',
                'message' => 'réponse ajoutée'
            ], '/forum/' .$id);
        }

        $data = Table::getTopic($id);

        ($data == false)? $this->error(404) : null;

        $title = Systeme::setTitle($data->title);
        $h1 = $data->title;
        
        $bbcode = new BBCode();
        $data->content = $bbcode->render($data->content);
        $data->createAt = Systeme::dateFormat('full', $data->createAt)
                        . ' à '
                        .Systeme::dateFormat('time', $data->createAt);

        $comments = count(Table::getComments($id));

        return $this->render('/Community/Forum/Read', compact($this->compact(['data', 'comments', 'pagination'])));
    }

    private function editForum ($id)
    {
        if (!empty($_POST)) {
            
            $image = Table::generalImage($_FILES);
            $datas = [
                'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                'idSection' => Systeme::security(['text' => $_POST['idSection']], 'post')
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
                'ids' => [
                    'id' => $id,
                    'idUser' => User::getMyData('id')
                ]
            ]);

            return $this->flash([
                'type' => 'infos',
                'message' => 'topic modifié'
            ], '/forum/' .$id);
        }

        $sections = Table::allSections();
        foreach ($sections as $data) {
            $datas[] = [$data->id => $data->name];
        }
        $opt = ['Catégorie du topic' => $datas];

        $edit = true;
        $data = Table::getTopic($id);
        $title = Systeme::setTitle('Forum');
        $h1 = 'Édition de topic';

        $myTopics = Table::getMyTopics();
        $myTopicsFollowed = Table::getMyTopicsFollowed();
        $myTopicsCommented = Table::getMyTopicsCommented();

        return $this->render('/Community/Forum/New', compact($this->compact(['data', 'opt', 'edit', 'myTopics', 'myTopicsFollowed', 'myTopicsCommented'])));
    }

    private function newForum ($id = null)
    {
        if (!empty($_POST)) {
            $sectionId = Systeme::security(['text' => $_POST['idSection']], 'post');
            $image = Table::generalImage($_FILES);

            switch ($image) {
                case 'error-1':
                    return $this->flash(['type' => 'danger',
                        'message' => 'ce n\'est pas une image'
                    ], '/forum/new/' .$id);
                case 'error-2':
                    return $this->flash(['type' => 'danger',
                        'message' => 'trop volumineux'
                    ], '/forum/new/' .$id);
                case 'error-3':
                    return $this->flash(['type' => 'danger',
                        'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                    ], '/forum/new/' .$id);
                case 'error-4':
                    return $this->flash(['type' => 'danger',
                        'message' => 'une erreur est survenue pendant l\'upload de votre image'
                    ], '/forum/new/' .$id);
                default:
                    break;
            }

            TableAdmin::generalAdd([
                'idUser' => User::getMyData('id'),
                'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                'image' => $image,
                'idSection' => $sectionId
            ]);
            

            return $this->flash([
                'type' => 'success',
                'message' => 'topic ajouté'
            ], '/forum/s/' .$sectionId);
        }

        $title = Systeme::setTitle('Forum - Création');
        $h1 = 'Créer un nouveau topic';

        $sections = Table::allSections();
        foreach ($sections as $data) {
            $datas[] = [$data->id => $data->name];
        }
        $opt = ['Catégorie du topic' => $datas];

        $myTopics = Table::getMyTopics();
        $myTopicsFollowed = Table::getMyTopicsFollowed();
        $myTopicsCommented = Table::getMyTopicsCommented();

        return $this->render('/Community/Forum/New', compact($this->compact(['opt', 'id', 'myTopics', 'myTopicsFollowed', 'myTopicsCommented'])));
    }
}
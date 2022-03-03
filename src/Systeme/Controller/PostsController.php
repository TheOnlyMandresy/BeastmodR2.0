<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\PostsTable;
use Systeme\Table\UsersTable;
use Systeme\HTML\Users\Look;
use \ChrisKonnertz\BBCode\BBCode;

class PostsController extends SystemeController
{
    private $page;

    public function __construct ($page)
    {
        array_shift($page);
        $this->page = $page;

        if (empty($this->page)) {
            return $this->index();
        } else {
            switch ($this->page[0]) {
                case 's':
                    if (isset($this->page[1]) && !empty($this->page[1])) {
                        $id = $this->page[1];
                        return $this->section($id);
                    }
                    return $this->index();
                default: 
                    $id = $this->page[0];
                    $pagination = (isset($this->page[1]))? $this->page[1] : 1;
                    return $this->read($id, $pagination);
            }
        }
    }
    
    private function index ()
    {
        $title = Systeme::setTitle();
        $h1 = 'Tous les articles';

        $all = PostsTable::all();
        $sections = PostsTable::getSections();

        if ($all) {
            foreach ($all as $data) {
                $data->createAt = Systeme::dateFormat('fullConcat', $data->createAt);
            }
        }

        return $this->render('/Posts/Index', compact('title', 'h1', 'all', 'sections'));
    }

    private function section ($id)
    {
        $section = PostsTable::getSection($id);
        ($section)? null : $this->error(404);

        $all = PostsTable::getPostsSection($id);
        $sections = PostsTable::getSections();

        $title = Systeme::setTitle($section->name);
        $h1 = 'Articles de la catégorie ' .$section->name;
        
        foreach ($all as $data) {
            $data->createAt = Systeme::dateFormat('fullConcat', $data->createAt);
        }

        return $this->render('/Posts/Index', compact($this->compact(['title', 'h1', 'section', 'all', 'sections'])));
    }

    private function read ($id, $pagination = 1)
    {
        $post = PostsTable::getPost($id);

        ($post == false || $post->state != 2)? $this->error(404) : null;

        if (!empty($_POST)) {
            if (!isset($_POST['post-comment'])) {
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'Une erreur est survenue'
                ], '/posts/' .$id);
            }

            PostsTable::generalAdd([
                'idUser' => UsersTable::getMyData('id'),
                'idPost' => $id,
                'message' => Systeme::security(['text' => $_POST['message']], 'post'),
                'idBubble' => UsersTable::getMyData('bubble'),
                'idMention' => Systeme::security(['text' => $_POST['answerTo']], 'post')
            ], '_comments');

            return $this->flash([
                'type' => 'success',
                'message' => 'commentaire ajouté'
            ], '/posts/' .$id);
        }
        
        $title = Systeme::setTitle($post->title);
        $h1 = $post->title;
        $post->authorLook = Look::load($post->authorLook, ['headDirection' => 'SE', 'face' => 'speak']);
        $boxInfos = "two";
        $comments = count(PostsTable::getAllPostComments($id));

        if ($post->idCorrectorUser > 0) {
            $boxInfos = "three";
            $post->correctorLook = Look::load($post->correctorLook, ['only' => null, 'headDirection' => 'SE', 'face' => 'speak', 'size' => 'XS']);
        }

        if (isset($_SESSION['user'])) {
            $user = ['id' => UsersTable::getMyData('id')];

            if ($user['id'] !== $post->idAuthorUser) {
                $user['author_friend'] = UsersTable::friends($post->idAuthorUser);
            }

            if ($user['id'] !== $post->idCorrectorUser) {
                $user['corrector_friend'] = UsersTable::friends($post->idCorrectorUser);
            }

            $this->compact(['user']);
        }
        $bbcode = new BBCode();
        $post->content = $bbcode->render($post->content);
        
        return $this->render('/Posts/Read', compact($this->compact(['title', 'h1', 'pagination', 'post', 'comments', 'boxInfos'])));
    }
}
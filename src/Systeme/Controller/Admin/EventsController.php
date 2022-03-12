<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\EventsTable as TableAdmin;
use Systeme\Table\EventsTable as Table;

class EventsController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1'], true);
        (Admin::adminAccess(19) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            return $this->index();
        } elseif (isset($this->page[0])) {
            switch ($this->page[0]) {
                case 'new':
                    (Admin::adminAccess(12) == false)? $this->error(403) : null;
                    
                    return $this->new();
                case 'e':
                    return $this->edit($this->page[1]);
            }
        }
    }

    private function index ()
    {
        $h1 = 'Les événements';
        $title = Systeme::setTitle('[A] ' .$h1);
        
        $events = Table::all();

        return $this->render('/Admin/Others/Events/Index', compact($this->compact(['events'])));
    }
    
    private function new ()
    {
        if (!empty($_POST)) {
            $image = Table::generalImage($_FILES);

            switch ($image) {
                case 'error-1':
                    return $this->flash(['type' => 'danger',
                        'message' => 'ce n\'est pas une image'
                    ], '/admin/events/new/');
                case 'error-2':
                    return $this->flash(['type' => 'danger',
                        'message' => 'trop volumineux'
                    ], '/admin/events/new/');
                case 'error-3':
                    return $this->flash(['type' => 'danger',
                        'message' => 'désolé seuls les fichiers : JPG, JPEG, PNG & GIF sont acceptés'
                    ], '/admin/events/new/');
                case 'error-4':
                    return $this->flash(['type' => 'danger',
                        'message' => 'une erreur est survenue pendant l\'upload de votre image'
                    ], '/admin/events/new/');
                default:
                    break;
            }

            TableAdmin::addEvent([
                'post' => [
                    'idAuthorUser' => User::getMyData('id'),
                    'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                    'content' => Systeme::security(['text' => $_POST['content']], 'post'),
                    'image' => $image
                ],
                'event' => [
                    'appartUrl' => Systeme::security(['text' => $_POST['appartUrl']], 'post'),
                    'image' => Systeme::security(['text' => $_POST['image']], 'post'),
                    'startAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['startAt']], 'post')),
                    'endAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['endAt']], 'post'))
                ],
                'rewards' => [
                    'content' => (isset($_POST['rewards']))? Systeme::security(['text' => $_POST['rewards']], 'post') : null,
                    'first' => Systeme::security(['text' => $_POST['rewardFirst']], 'post'),
                    'second' => Systeme::security(['text' => $_POST['rewardSecond']], 'post'),
                    'third' => Systeme::security(['text' => $_POST['rewardThird']], 'post'),
                    'others' => (isset($_POST['rewardOthers']))? Systeme::security(['text' => $_POST['rewardOthers']], 'post') : null
                ]
            ]);
    
            return $this->flash([
                'type' => 'success',
                'message' => 'événement ajouté'
            ], '/admin/events');
        }

        $title = Systeme::setTitle('[A] Nouvel événement');
        $h1 = 'Ajouter un nouvel événement';

        return $this->render('/Admin/Others/Events/New', compact($this->compact()));
    }

    private function edit ($id)
    {
        $event = Table::getEvent($id);
        ($event === false)? $this->error(404) : null;
        
        if (isset($this->page[2])) {
            $idUser = User::getMyData('id');

            if ($this->page[2] === 'event') {
                (Admin::adminAccess(13) == false)? $this->error(403) : null;
                $image = Table::generalImage($_FILES);
                $datasPost = [
                    'idAuthorUser' => $idUser,
                    'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                    'content' => Systeme::security(['text' => $_POST['content']], 'post')
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
    
                (!is_null($image))? $datasPost['image'] = $image : null;
                
                TableAdmin::editEvent([
                    'post' => $datasPost,
                    'event' => [
                        'appartUrl' => Systeme::security(['text' => $_POST['appartUrl']], 'post'),
                        'image' => Systeme::security(['text' => $_POST['image']], 'post'),
                        'startAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['startAt']], 'post')),
                        'endAt' => Systeme::dateFormat('sql', Systeme::security(['text' => $_POST['endAt']], 'post'))
                    ],
                    'rewards' => [
                        'content' => (isset($_POST['rewards']))? Systeme::security(['text' => $_POST['rewards']], 'post') : null,
                        'first' => Systeme::security(['text' => $_POST['rewardFirst']], 'post'),
                        'second' => Systeme::security(['text' => $_POST['rewardSecond']], 'post'),
                        'third' => Systeme::security(['text' => $_POST['rewardThird']], 'post'),
                        'others' => (isset($_POST['rewardOthers']))? Systeme::security(['text' => $_POST['rewardOthers']], 'post') : null
                    ],
                    'ids' => [
                        'idEvent' => $id,
                        'idPost' => $event->idPost
                    ]
                ]);
    
                return $this->flash([
                    'type' => 'infos',
                    'message' => 'événement modifiée'
                ], '/admin/events/e/' .$id);

            } elseif ($this->page[2] === 'winners') {
                (Admin::adminAccess(15) == false)? $this->error(403) : null;
                
                $firstPlace = Systeme::security(['text' => $_POST['idFirstUser']], 'post');
                $secondPlace = Systeme::security(['text' => $_POST['idSecondUser']], 'post');
                $thirdPlace = Systeme::security(['text' => $_POST['idThirdUser']], 'post');

                if (Table::getWinners($id)) {
                    TableAdmin::editWinners([
                        'datas' => [
                            'idFirstUser' => $firstPlace,
                            'idSecondUser' => $secondPlace,
                            'idThirdUser' => $thirdPlace
                        ], 
                        'idEvent' => $id
                    ]);
    
                    return $this->flash([
                        'type' => 'warining',
                        'message' => 'gagnant d\'événement modifié'
                    ], '/admin/events');
                } else {
                    TableAdmin::addWinners([
                        'idEvent' => $id,
                        'idFirstUser' => $firstPlace,
                        'idSecondUser' => $secondPlace,
                        'idThirdUser' => $thirdPlace
                    ]);
    
                    return $this->flash([
                        'type' => 'success',
                        'message' => 'gagnants d\'événement ajouté'
                    ], '/admin/events');
                }
            } elseif ($this->page[2] === 'delete') {
                (Admin::adminAccess(14) == false)? $this->error(403) : null;
                
                TableAdmin::deleteEvent($id);
    
                return $this->flash([
                    'type' => 'danger',
                    'message' => 'événement supprimé'
                ], '/admin/events');
            }

            return header('Location: /admin/events');
        }

        $title = Systeme::setTitle('[A] Modification d\'événement');
        $h1 = 'Modification : ' .$event->title;
        $edit = true;

        $firstPlace = (isset($event->firstPlaceUsername))? $event->firstPlaceUsername : null;
        $secondPlace = (isset($event->secondPlaceUsername))? $event->secondPlaceUsername : null;
        $thirdPlace = (isset($event->thirdPlaceUsername))? $event->thirdPlaceUsername : null;

        return $this->render('/Admin/Others/Events/Edit', compact($this->compact(['edit', 'id', 'event', 'firstPlace', 'secondPlace', 'thirdPlace'])));
    }
}
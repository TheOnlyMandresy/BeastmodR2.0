<?php

namespace Systeme\Controller;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\TicketsTable as TableAdmin;
use Systeme\Table\TicketsTable as Table;

class SupportController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        (User::isLogged() == false)? $this->error(403) : null;

        $this->compact(['title', 'h1', 'all'], true);
        array_shift($page);
        $this->page = $page;

        if (empty($this->page)) {
            return $this->index();
        } elseif (isset($this->page[0])) {
            return $this->read($this->page[0]);
        } else {
            $this->error(404);
        }
    }

    private function index ()
    {
        if (isset($_POST['new'])) {
            TableAdmin::generalAdd([
                'idUser' => User::getMyData('id'),
                'idBubble' => User::getMyData('bubble'),
                'title' => Systeme::security(['text' => $_POST['title']], 'post'),
                'message' => Systeme::security(['text' => $_POST['message']], 'post'),
            ]);

            return $this->flash([
                'type' => 'success',
                'message' => 'nouveau ticket créer'
            ], '/support');
        }

        $h1 = 'Les tickets';
        $title = Systeme::setTitle('[A] ' .$h1);

        $all = Table::getMyTickets(User::getMyData('id'));

        foreach ($all as $data) {
            $data->createAt = Systeme::dateFormat('fullConcat', $data->createAt). ' - ' .Systeme::dateFormat('time', $data->createAt);
        }

        return $this->render('/Users/Support', compact($this->compact()));
    }

    private function read ($id)
    {
        $me = User::getMyData('id');
        (Table::getMyTicket($id, $me) == false)? $this->error(404) : null;

        $ticket = Table::getMyTicket($id, $me);

        if (isset($_POST['answer'])) {
            if ($ticket != 0) {
                TableAdmin::generalAdd([
                    'message' => Systeme::security(['text' => $_POST['message']], 'post'),
                    'idUser' => $me,
                    'idTicket' => $id,
                    'idBubble' => User::getMyData('bubble')
                ], '_chat');

                Table::stateTickets([
                    'datas' => ['state' => 'waiting'],
                    'id' => $id
                ]);
        
                return $this->flash([
                    'type' => 'success',
                    'message' => 'réponse envoyé'
                ], '/support/' .$id);
            }
        
            return $this->flash([
                'type' => 'warning',
                'message' => 'ce ticket est fermé'
            ], '/support/' .$id);
        }

        $h1 = 'Les tickets';
        $ticket->createAt = Systeme::dateFormat('full', $ticket->createAt). ' à ' .Systeme::dateFormat('time', $ticket->createAt);

        $title = Systeme::setTitle('Ticket ' .$ticket->id);

        $chat = (table::getTicketChat($id))? table::getTicketChat($id) : [];

        if (!empty($chat)) {
            foreach ($chat as $data) {
                $data->createAt = Systeme::dateFormat('full', $data->createAt). ' à ' .Systeme::dateFormat('time', $data->createAt);
            }
        }

        $all = Table::getMyTickets($me);

        foreach ($all as $data) {
            $data->createAt = Systeme::dateFormat('fullConcat', $data->createAt). ' - ' .Systeme::dateFormat('time', $data->createAt);
        }

        return $this->render('/Users/Support', compact($this->compact(['ticket', 'chat', 'me'])));
    }

    private function stateTicket ($close = true, $id)
    {
        if ($close) {
            Table::stateTickets([
                'datas' => [
                    'state' => 'close'
                ],
                'id' => $id
            ]);
    
            return $this->flash([
                'type' => 'warning',
                'message' => 'ticket fermé'
            ], '/admin/tickets');
        } else {
            Table::stateTickets([
                'datas' => [
                    'state' => 'waiting'
                ],
                'id' => $id
            ]);
    
            return $this->flash([
                'type' => 'infos',
                'message' => 'ticket réouvert'
            ], '/admin/tickets');
        }
    }

    private function delete ($id)
    {
        TableAdmin::deleteTicket($id);
    
        return $this->flash([
            'type' => 'danger',
            'message' => 'ticket supprimé'
        ], '/admin/ranks');
    }
}
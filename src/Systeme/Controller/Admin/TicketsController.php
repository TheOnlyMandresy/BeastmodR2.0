<?php

namespace Systeme\Controller\Admin;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\Admin\RanksTable as Admin;
use Systeme\Table\Admin\TicketsTable as TableAdmin;
use Systeme\Table\TicketsTable as Table;

class TicketsController extends SystemeController
{
    private $page;
    
    public function __construct ($page)
    {
        parent::__construct();
        array_shift($page);
        $this->page = $page;
        $this->compact(['title', 'h1'], true);
        (Admin::adminAccess(24) == false)? $this->error(403) : null;

        if (empty($this->page)) {
            return $this->indexTicket();
        } elseif (isset($this->page[0])) {
            $id = $this->page[0];
            if (isset($this->page[1])) {
                switch ($this->page[1]) {
                    case 'close':
                        (Admin::adminAccess(26) == false)? $this->error(403) : null;
                        return $this->stateTicket(true, $id);
                    case 'open':
                        (Admin::adminAccess(26) == false)? $this->error(403) : null;
                        return $this->stateTicket(false, $id);
                    case 'delete':
                        (Admin::adminAccess(27) == false)? $this->error(403) : null;
                        return $this->delete($id);
                }
            }

            (Admin::adminAccess(25) == false)? $this->error(403) : null;
            return $this->chatTicket($id);
        }
    }

    private function indexTicket ()
    {
        $h1 = 'Les tickets';
        $title = Systeme::setTitle('[A] ' .$h1);

        $all = Table::all();

        foreach ($all as $data) {
            $data->createAt = Systeme::dateFormat('full', $data->createAt). ' à ' .Systeme::dateFormat('time', $data->createAt);
        }

        return $this->render('/Admin/Community/Tickets/Index', compact($this->compact(['all'])));
    }

    private function chatTicket ($id)
    {
        if (!empty($_POST)) {
            TableAdmin::generalAdd([
                'message' => Systeme::security(['text' => $_POST['message']], 'post'),
                'idUser' => User::getMyData('id'),
                'idTicket' => $id,
                'idBubble' => User::getMyData('bubble')
            ], '_chat');

            if (isset($_POST['answer'])) {
                Table::stateTickets([
                    'datas' => ['state' => 'answer'],
                    'id' => $id
                ]);

                return $this->flash([
                    'type' => 'success',
                    'message' => 'ticket repondu'
                ], '/admin/tickets/' .$id);

            } elseif (isset($_POST['close'])) {
                Table::stateTickets([
                    'datas' => ['state' => 'close'],
                    'id' => $id
                ]);

                return $this->flash([
                    'type' => 'success',
                    'message' => 'ticket repondu et fermer'
                ], '/admin/tickets');
            }
    
        }

        $ticket = Table::getTicket($id);
        $ticket->createAt = Systeme::dateFormat('full', $ticket->createAt). ' à ' .Systeme::dateFormat('time', $ticket->createAt);

        $title = Systeme::setTitle('[A] Ticket ' .$ticket->id);
        $h1 = 'Question : ' .$ticket->title;

        $chat = (table::getTicketChat($id))? table::getTicketChat($id) : [];

        if (!empty($chat)) {
            foreach ($chat as $data) {
                $data->createAt = Systeme::dateFormat('full', $data->createAt). ' à ' .Systeme::dateFormat('time', $data->createAt);
            }
        }

        return $this->render('/Admin/Community/Tickets/Read', compact($this->compact(['ticket', 'chat'])));
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
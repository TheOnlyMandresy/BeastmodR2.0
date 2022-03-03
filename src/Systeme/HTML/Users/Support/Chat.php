<?php

namespace Systeme\HTML\Users;

use Systeme\Table\UsersTable as User;
use Systeme\Table\TicketsTable as Table;
use Systeme\HTML\Bubble;

class Support {
    private $idTopic;
    private $total;
    private $page;

    public function __construct ($idTopic, $total = 0, $page = 1)
    {
        $this->idTopic = $idTopic;
        $this->total = $total;
        $this->page = $page;

        $statement = [
            'select' => "
                c.*,
                a.username as username,
                a_s.look as look
                ",
            'join' => " as c
                INNER JOIN users a
                    ON c.idUser = a.id
                INNER JOIN users_settings a_s
                    ON c.idUser = a_s.idUser
                ",
            'where' => 'c.idTicket = ?',
            'order' => 'createAt DESC',
            'limit' => $this->limitation(),
            'att' => $this->idTopic
        ];
        $comments = Table::find($statement, '_chat', true);

        return $this->loadComment($comments);
    }

    private function loadComment ($array)
    {
        $idUser = (User::isLogged())? User::getMyData('id') : null;

        for ($i = 0; $i < count($array); $i++) {
            if (isset($idUser) && $array[$i]->idUser === $idUser) {
                $me = true;
            } else {
                $me = false;
            }

            echo $this->wrap(Bubble::load($array[$i]->idBubble, [
                'message' => $array[$i]->message,
                'type' => 'comment',
                'me' => $me,
                'src' => $array[$i]->look
            ]), $array[$i]->id);
        }
    }

    private function wrap($bubble, $id)
    {

        $html = '<div class="comment">';
        $html .= $bubble;
        $html .= '</div>';

        return $html;
    }

    private function loadPagination ($pages)
    {
        $html = '<div class="button-success reload" onClick="reloadComments()">';
        $html .= '<img src="/img/1053__-2AF.png" /></div>';
        
        if ($pages > 1) {
            if ($this->page > 1) {
                $html .= '<a href="/posts/' .$this->idTopic. '/' .ceil($this->page - ($this->page - 1)). '" class="first button-base"><img src="/img/2394__-2MnE.png" /></a>';
                $html .= '<a href="/posts/' .$this->idTopic. '/' .ceil($this->page - 1). '" class="next button-base"><img src="/img/2394__-2Mn.png" /></a>';
            } else {
                $html .= '<a class="first button-base active"><img src="/img/2394__-2MnE.png" /></a>';
                $html .= '<a class="next button-base active"><img src="/img/2394__-2Mn.png" /></a>';
            }

            $html .= '<div class="pages">';

            if ($pages >= 12) {
                if (($this->page + 12) > $pages) {
                    for ($i = $pages - 11; $i <= $pages; $i++) {
                        $active = ($this->page == $i) ? 'active' : null;
                        if ($active) {
                            $html .= "<a class='button-base active'>
                                ";
                        } else {
                            $html .= "<a href='/posts/" .$this->idTopic. "/" .$i. "'
                                class='button-base'>
                                ";
                        }
                        $html .= $i;
                        $html .= '</a>';
                    }
                } else {
                    for ($i = $this->page; $i <= ($this->page + 5); $i++) {
                        $active = ($this->page == $i) ? 'active' : null;
                        if ($active) {
                            $html .= "<a class='button-base active'>
                                ";
                        } else {
                            $html .= "<a href='/posts/" .$this->idTopic. "/" .$i. "'
                                class='button-base'>
                                ";
                        }
                        $html .= $i;
                        $html .= '</a>';
                    }
    
                    $html .= '_';
                    
                    for ($i = $pages - 5; $i <= $pages; $i++) {
                        $active = ($this->page == $i) ? 'active' : null;
                        if ($active) {
                            $html .= "<a class='button-base active'>
                                ";
                        } else {
                            $html .= "<a href='/posts/" .$this->idTopic. "/" .$i. "'
                                class='button-base'>
                                ";
                        }
                        $html .= $i;
                        $html .= '</a>';
                    }
                }
            } else {
                for ($i = 1; $i <= $pages; $i++) {
                    $active = ($this->page == $i) ? 'active' : null;

                    if ($active) {
                        $html .= "<a class='button-base active'>
                            ";
                    } else {
                        $html .= "<a href='/posts/" .$this->idTopic. "/" .$i. "'
                            class='button-base'>
                            ";
                    }
                    $html .= $i;
                    $html .= '</a>';
                }
            }

            $html .= '</div>';

            if ($this->page < $pages) {
                $html .= '<a href="/posts/' .$this->idTopic. '/' .ceil($this->page + 1). '" class="prev button-base"><img src="/img/2394__-2Mn.png" /></a>';
                $html .= '<a href="/posts/' .$this->idTopic. '/' .$pages. '" class="last button-base"><img src="/img/2394__-2MnE.png" /></a>';
            } else {
                $html .= '<a class="prev button-base active"><img src="/img/2394__-2Mn.png" /></a>';
                $html .= '<a class="last button-base active"><img src="/img/2394__-2MnE.png" /></a>';
            }
        }

        return $html; 
    }

    public function pagination ()
    {
        $count = 7;
        $pages = ceil($this->total / $count);

        return $this->loadPagination($pages);
    }

    private function limitation () {
        $count = 7;
        $firstList = ($this->page * $count) - $count;
        
        $pagination = [
            'start' => $firstList,
            'end' => $count
        ];

        return $pagination;
    }
}
<?php

namespace Systeme\HTML\Posts\Dependencies;

use Systeme;
use Systeme\Table\UsersTable as User;
use Systeme\Table\PostsTable as Table;
use Systeme\HTML\Bubble;

class Comments {
    private $idPost;
    private $total = 0;
    private $byPages = 7;
    private $page;

    public function __construct ($idPost, $page = 1)
    {
        $this->idPost = $idPost;
        $this->total = count(Table::getComments($idPost));
        $this->page = $page;
        $comments = Table::getComments($idPost, $this->limitation());

        return $this->loadComment($comments);
    }

    private function loadComment ($array)
    {
        $idUser = (User::isLogged())? User::getMyData('id') : null;

        for ($i = 0; $i < count($array); $i++) {
            $me = (isset($idUser) && $array[$i]->idUser === $idUser)? true : false;

            echo $this->wrap(Bubble::load($array[$i]->idBubble, [
                'message' => $array[$i]->message,
                'type' => 'comment',
                'me' => $me,
                'src' => $array[$i]->look
            ], $array[$i]->username), $array[$i]);
        }
    }

    private function wrap($bubble, $datas)
    {
        $html = '<div class="comment">';
        $html .= $bubble;
        $html .= $this->responses($datas->id, $datas->username, $datas->createAt);
        $html .= '</div>';

        return $html;
    }

    private function responses($id, $username, $date)
    {
        $datas = Table::getResponses($this->idPost, $id);
        if ($datas === false) { return null; }

        $idUser = (User::isLogged())? User::getMyData('id') : null;
        $count = count($datas);
        $dropdown = uniqid();

        $html = $this->buttons($dropdown, $count, $id, $username, $date);

        if ($count > 0) {
            $html .= '<div class="dropdown-' .$dropdown. '">';
            $html .= '<div class="responses">';
            for ($i = 0; $i < $count; $i++) {
                if (isset($idUser) && $datas[$i]->idUser === $idUser) {
                    $me = true;
                } else {
                    $me = false;
                }
    
                $html .= Bubble::load($datas[$i]->idBubble, [
                    'message' => $datas[$i]->message,
                    'type' => 'comment',
                    'me' => $me,
                    'src' => $datas[$i]->look
                ], $datas[$i]->username);
            }
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }

    private function buttons ($dropdown, $count, $id, $username, $date)
    {
        $html = '<div class="answer">';
        $html .= '<p class="date">' .Systeme::dateFormat('since', $date). '</p>';
        if ($count > 0) {
            $html .= '<p class="button-base dropdown-open-' .$dropdown. '">Réponses (' .$count. ')</p>';
        }
        if (User::isLogged()) {
            $html .= '<p class="button-infos answerTo-' .$id. '-' .$username.'" onClick="answer(' .$id. ',\'' .$username. '\')">Répondre</p>';
        }
        $html .= '</div>';

        return $html;
    }

    private function loadPagination ($pages)
    {
        $html = '<div class="pagination">';

        if ($pages > 1) {
            $html .= '<div class="buttons">';
            if ($this->page > 1) {
                $html .= '<a href="/posts/' .$this->idPost. '/' .ceil($this->page - ($this->page - 1)). '" class="first button-base"><img src="/img/2394__-2MnE.png" /></a>';
                $html .= '<a href="/posts/' .$this->idPost. '/' .ceil($this->page - 1). '" class="next button-base"><img src="/img/2394__-2Mn.png" /></a>';
            } else {
                $html .= '<a class="first button-base active"><img src="/img/2394__-2MnE.png" /></a>';
                $html .= '<a class="next button-base active"><img src="/img/2394__-2Mn.png" /></a>';
            }

            if ($this->page < $pages) {
                $html .= '<a href="/posts/' .$this->idPost. '/' .ceil($this->page + 1). '" class="prev button-base"><img src="/img/2394__-2Mn.png" /></a>';
                $html .= '<a href="/posts/' .$this->idPost. '/' .$pages. '" class="last button-base"><img src="/img/2394__-2MnE.png" /></a>';
            } else {
                $html .= '<a class="prev button-base active"><img src="/img/2394__-2Mn.png" /></a>';
                $html .= '<a class="last button-base active"><img src="/img/2394__-2MnE.png" /></a>';
            }
            $html .= '</div>';

            $html .= '<div class="pages">';
            if ($pages >= 12) {
                if (($this->page + 12) > $pages) {
                    for ($i = $pages - 11; $i <= $pages; $i++) {
                        $active = ($this->page == $i) ? 'active' : null;
                        if ($active) {
                            $html .= "<a class='button-base active'>
                                ";
                        } else {
                            $html .= "<a href='/posts/" .$this->idPost. "/" .$i. "'
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
                            $html .= "<a href='/posts/" .$this->idPost. "/" .$i. "'
                                class='button-base'>
                                ";
                        }
                        $html .= $i;
                        $html .= '</a>';
                    }
    
                    $html .= '<a class="center">...</a>';
                    
                    for ($i = $pages - 5; $i <= $pages; $i++) {
                        $active = ($this->page == $i) ? 'active' : null;
                        if ($active) {
                            $html .= "<a class='button-base active'>
                                ";
                        } else {
                            $html .= "<a href='/posts/" .$this->idPost. "/" .$i. "'
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
                        $html .= "<a href='/posts/" .$this->idPost. "/" .$i. "'
                            class='button-base'>
                            ";
                    }
                    $html .= $i;
                    $html .= '</a>';
                }
            }
            $html .= '</div>';
        }

        $html .= '</div>';

        return $html; 
    }

    public function pagination ()
    {
        $pages = ceil($this->total / $this->byPages);

        return ($this->total > $this->byPages)? $this->loadPagination($pages) : null;
    }

    private function limitation () {
        $firstList = ($this->page * $this->byPages) - $this->byPages;
        
        $pagination = [
            'start' => $firstList,
            'end' => $this->byPages
        ];

        return $pagination;
    }
}
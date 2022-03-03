<?php

namespace Systeme\HTML\Posts\Dependencies;

use Systeme;
use Systeme\Table\PostsTable;

class See
{
    public static function inCategory ($idPost, $idSection)
    {
        $html = null;
        $title = 'Dans la catégorie';

        $datas = PostsTable::getPostsCategory($idPost, $idSection);

        foreach ($datas as $data) {
            $html .= '<a href="' .$data->link. '" class="hover">';
            $html .= '<div class="random">';
            $html .= '<div class="img" style="background-image: url(' .$data->background. ');"></div>';
            $html .= '<p class="texts">';
            $html .= '<span class="title">' .Systeme::specialUcFirst($data->title). '</span>';
            $html .= '<span class="text">' .Systeme::specialUcFirst($title). '</span>';
            $html .= '</p>';
            $html .= '</div>';
            $html .= '</a>';
        }

        return $html;
    }

    public static function inNewest ($idPost)
    {
        $html = null;
        $title = 'Dans les nouveautés';

        $datas = PostsTable::getPostsNew($idPost);

        foreach ($datas as $data) {
            $html .= '<a href="' .$data->link. '" class="hover">';
            $html .= '<div class="box-new" style="background-image: url(' .$data->background. ');">';
            $html .= '<p class="texts">';
            $html .= '<span class="title">' .Systeme::specialUcFirst($data->title). '</span>';
            $html .= '<span class="text">' .Systeme::specialUcFirst($title). '</span>';
            $html .= '</p>';
            $html .= '</div>';
            $html .= '</a>';
        }

        return $html;
    }

    public static function buttons ($idPost, $idSection)
    {
        $html = null;
        $titles = [
            'prev' => 'Précédent',
            'next' => 'Suivant'
        ];

        $statement = [
            'select' => 'id',
            'where' => 'id < ? AND idSection = ? AND state = 2',
            'order' => 'id DESC',
            'att' => [$idPost, $idSection]
        ];
        $prev = PostsTable::find($statement);

        $statement = [
            'select' => 'id',
            'where' => 'id > ? AND idSection = ? AND state = 2',
            'order' => 'id ASC',
            'att' => [$idPost, $idSection]
        ];
        $next = PostsTable::find($statement);

        foreach ($titles as $type => $name) {
            if ($type === 'prev') {
                if ($prev) {
                    $html .= '<a href="/posts/' .$prev->id. '">';
                    $html .= '<div class="button-base prev">';
                } else {
                    $html .= '<a>';
                    $html .= '<div class="button-base prev active">';
                }
            } elseif ($type === 'next') {
                if ($next) {
                    $html .= '<a href="/posts/' .$next->id. '">';
                    $html .= '<div class="button-base next">';
                } else {
                    $html .= '<a>';
                    $html .= '<div class="button-base next active">';
                }
            }

            $html .= '<img src="/img/2394__-2Mn.png" />';
            $html .= '</div>';
            $html .= '</a>';
        }

        return $html;
    }
}
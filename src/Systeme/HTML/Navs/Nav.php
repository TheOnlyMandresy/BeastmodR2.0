<?php

namespace Systeme\HTML\Navs;

use Systeme;
use Systeme\Table\PostsTable as Posts;

class Nav
{
    private array $titles = [
        'others' => 'divertissement',
        'community' => 'communauté',
        'website' => 'Site',
        'posts' => 'articles',
        'users' => 'utilisateurs',
        'index' => 'accueil'
    ];

    public function __construct ($page)
    {
        $section = $page;
        $currentPage = $page;

        $this->titles['website'] = Systeme::getSystemInfos('website');

        if (str_contains($page, '-')) {
            $section = explode('-', $page)[0];
            $currentPage = explode('-', $page)[1];
        }
        
        $nav = [
            'section' => $section,
            'currentPage' => $currentPage,
            'inAdmin' => false
        ];

        if (str_contains($page, 'admin')) {
            $nav = [
                'section' => "index",
                'currentPage' => null,
                'inAdmin' => true
            ];
        }

        return $this->loadNav($nav);
    }

    private function loadNav($nav)
    {
        
        $currentSection = $nav['section'];

        $html = ($nav['inAdmin'] == true)? '<div class="nav-principal inAdmin">' : '<div class="nav-principal">';
        $html .= '<div class="panel-principal">';

        $html .= '<div class="options">';
        foreach ($this->titles as $sec => $title) {
            if ($sec !== 'users') {
            $open = ($currentSection === $sec)? $sec : null;        
            $currentpage = ($currentSection === $sec)? $nav['currentPage'] : null;

            $html .= $this->panelNav($sec, $open, $currentpage);
            }
        }
        $html .= '</div>';

            $html .= '<ul class="sections">';
            $html .= $this->loadSections($currentSection);
            $html .= '</ul>';
        $html .= '</div>';

        $html .= '<p class="section-principal">';
        if ($nav['inAdmin'] == false) $html .= $this->titles[$currentSection];
        $html .= '</p>';

        $html .= '</div>';

        echo $html;
    }

    private function panelNav ($section, $open = null, $currentPage = null)
    {
        $open = ($open !== null)? 'open' : null;
        $loadOptions = $section. 'Li';

        $html = '<ul class="options-' .$section. ' ' .$open. '">';
            $html .= $this->$loadOptions($currentPage);
        $html .= '</ul>';

        return $html;
    }

    private function loadSections ($open)
    {
        $html = null;
        foreach ($this->titles as $sec => $title) {
            if ($sec !== 'users') {
            $html .= '<li class="section-' .$sec;
            $html .= ($open === $sec)? ' open' : null;
            $html .= ' navbar-principal-' .$sec. '" ';
            $html .= 'title="' .$title. '"';
            $html .= '></li>';
            }
        }

        return $html;
    }

    private function generateLi ($sections, $currentPage = null)
    {
        $html = null;
        foreach ($sections as $page => $title) {
            $current = ($currentPage === $page)? ' class="current"' : null;
            $html .= '<li' .$current. '>';
            $html .= '<a href="/' .$page. '">';
            $html .= '<p>' .Systeme::specialUcFirst($title). '</p>';
            $html .= '</a>';
            $html .= '</li>';
        }

        return $html;
    }

    private function indexLi ($currentPage = null)
    {
        $li = [
            'index' => 'accueil',
            'changelog' => 'Mises à jour'
        ];

        return $this->generateLi($li, $currentPage);
    }
    private function usersLi ($currentPage = null)
    {
        $li = [
            'index' => 'accueil'
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function postsLi ($currentPage = null)
    {
        $id = (isset($section) && $currentPage === 'index')? $section->id : false;
        $sections = Posts::getSections();
        $html = null;

        $html .= (($currentPage === 'index' && $id === false))? '<li class="current">' : '<li>';
        $html .= '<a href="/posts">';
        $html .= '<p>' .Systeme::specialUcFirst('tous'). '</p>';
        $html .= '</a>';
        $html .= '</li>';

        foreach ($sections as $section) {
            $html .= ($id && $currentPage === 'index' && $id === $section->id)? '<li class="current">' : '<li>';
            $html .= '<a href="' .$section->link. '">';
            $html .= '<p>' .Systeme::specialUcFirst($section->name). '</p>';
            $html .= '</a>';
            $html .= '</li>';
        }

        return $html;
    }

    private function communityLi ($currentPage = null)
    {
        $li = [
            'forum' => 'forum',
            'search' => 'recherche',
            'ranking' => 'classement'
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function websiteLi ($currentPage = null)
    {
        $li = [
            'staffs' => 'équipe',
            'partners' => 'partenaires'
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function othersLi ($currentPage = null)
    {
        $li = [
            'games' => 'jeux',
            'events' => 'événements',
            'quests' => 'quêtes'
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function forumLi ($currentPage = null)
    {
        $li = [
            'isLogged' => [
                'forum/new' => 'Créer'
            ],
            'forum' => 'Tous',
            'quests' => 'quêtes'
        ];

        return $this->generateLi($li, $currentPage);
    }

}
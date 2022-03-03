<?php

namespace Systeme\HTML\Navs\Dependencies;

use Systeme;
use Systeme\Table\Admin\RanksTable as Admin;

class NavAdmin
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

        if (!str_contains($page, 'admin')) {
            $nav = [
                'section' => "index",
                'currentPage' => null,
                'inWebsite' => true
            ];
        } elseif (str_contains($page, '-')) {
            $page = explode('-', $page);
            array_shift($page);
            $section = $page[0];
            $currentPage = $page[1];

            $nav = [
                'section' => $section,
                'currentPage' => $currentPage,
                'inWebsite' => false
            ];
        }

        return $this->loadNav($nav);
    }

    private function loadNav($nav)
    {
        $currentSection = $nav['section'];

        $html = ($nav['inWebsite'] == true)? '<div class="nav-admin inWebsite">' : '<div class="nav-admin">';
        $html .= '<div class="panel-admin">';
        
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

        $html .= '<p class="section-admin">';
        if ($nav['inWebsite'] == false) $html .= $this->titles[$currentSection];
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
            $html .= ' navbar-admin-' .$sec. '" ';
            $html .= 'title="' .$title. '"';
            $html .= '></li>';
            }
        }

        return $html;
    }

    private function generateLi ($sections, $currentPage = null)
    {
        $html = null;
        foreach ($sections as $page => $section) {
            $current = ($currentPage === $page)? ' class="current"' : null;
            $html .= '<li' .$current. '>';
            $html .= (is_null($current))? '<a href="/admin/' .$page. '">' : null;
            $html .= '<p>' .Systeme::specialUcFirst($section['name']). '</p>';
            $html .= (is_null($current))? '</a>' : null;
            $html .= '</li>';
        }

        return $html;
    }

    private function indexLi ($currentPage = null)
    {
        $li = [
            '' => [
                'name' => 'accueil',
                'access' => Admin::adminAccess(11)
            ]
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function postsLi ($currentPage = null)
    {
        $li = [
            'posts' => [
                'name' => 'articles',
                'access' => Admin::adminAccess(18)
            ],
            'posts/new' => [
                'name' => 'nouvel article',
                'access' => Admin::adminAccess(1)
            ],
            'posts/requests' => [
                'name' => 'Requête',
                'access' => Admin::adminAccess(34)
            ]
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function communityLi ($currentPage = null)
    {
        $li = [
            'tickets' => [
                'name' => 'Support technique',
                'access' => Admin::adminAccess(24)
            ],
            'forum' => [
                'name' => 'Forum',
                'access' => Admin::adminAccess(35)
            ]
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function websiteLi ($currentPage = null)
    {
        $li = [
            'ranks' => [
                'name' => 'équipe',
                'access' => Admin::adminAccess(21)
            ],
            'ranks/rights' => [
                'name' => 'droits',
                'access' => Admin::adminAccess(10)
            ],
            'partners' => [
                'name' => 'partenariats',
                'access' => Admin::adminAccess(28)
            ],
            'changelog' => [
                'name' => 'changelogs',
                'access' => Admin::adminAccess(10)
            ]
        ];

        return $this->generateLi($li, $currentPage);
    }

    private function othersLi ($currentPage = null)
    {
        $li = [
            'games' => [
                'name' => 'jeux',
                'access' => Admin::adminAccess(20)
            ],
            'events' => [
                'name' => 'événements',
                'access' => Admin::adminAccess(19)
            ],
            'quests' => [
                'name' => 'quêtes',
                'access' => Admin::adminAccess(10)
            ]
        ];

        return $this->generateLi($li, $currentPage);
    }

}
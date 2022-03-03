<?php

namespace Systeme\HTML;

use Systeme;
use Systeme\HTML\Users\Look;
use \ChrisKonnertz\BBCode\BBCode;

class Bubble
{
    private static string $code;

    /**
     * @param int $code Bubble code
     * @param array $settings [str 'MESSAGE', str 'SRC', str 'TYPE', bool 'ME'] [type: comment, dedi, chat]
     */
    public static function load ($code = 1, $settings = [], $username = "unset")
    {
        $encode = new Bubble();
        $type = $settings['type'];
        self::$code = $code;

        return $encode->$type($username, $settings['message'], $settings['src'], $settings['me']);
    }

    private function comment ($username, $message, $src, $me = false)
    {   
        $bbcode = new BBCode();
        $message = $bbcode->render($message);

        if ($me === false) {
            $look = Look::load($src, ['only' => null, 'headDirection' => 'SE']);
            $lookS = Look::load($src, ['only' => null, 'headDirection' => 'SE', 'size' => 'XS']);

            $html = '<div class="bubble bbl-' .self::$code. '">';
            $html .= '<div class="head" style="background-image: url(' .$look. '), url(' .$lookS. ');">';
            $html .= '</div>';
            $html .= '<p class="message">';
            $html .= '<span>' .$username. ': </span>' .$message;
            $html .= '</p>';
            $html .= '</div>';
        } else {
            $look = Look::load($src, ['only' => null, 'headDirection' => 'SW']);
            $lookS = Look::load($src, ['only' => null, 'headDirection' => 'SW', 'size' => 'XS']);

            $html = '<div class="bubble-me bbl-' .self::$code. '">';
            $html .= '<p class="message">';
            $html .= $message;
            $html .= '</p>';
            $html .= '<div class="head" style="background-image: url(' .$look. '), url(' .$lookS. ');">';
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }

    // private function dedication ($code)
    // {

    // }
}
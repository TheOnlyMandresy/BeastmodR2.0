<?php

namespace Systeme\HTML\Users;

class Look
{    
    private static $src = 'https://habbo.fr/habbo-imaging/avatarimage?figure=';

    /**
     * @param string $look Code look
     * @param array $settings [str 'BODYDIRECTION', str 'HEADDIRECTION', str 'FACE', str 'ACTION', str 'SIZE', null 'ONLY']
     */
    public static function load ($look, $settings = null)
    {
        $encode = new Look();
        $code = self::$src . $look;

        if ($settings) {
            foreach ($settings as $param => $infos) {
                $code .= $encode->$param($infos);
            }
        }
        return $code;
    }

    private function bodyDirection ($direction = 'N')
    {
        switch ($direction)
        {
            case 'N':
                return '&direction=7';
            case 'NE':
                return '&direction=8';        
            case 'E':
                return '&direction=1';
            case 'SE':
                return '&direction=2';
            case 'S':
                return '&direction=3';
            case 'SW':
                return '&direction=4';
            case 'W':
                return '&direction=5';
            case 'NW':
                return '&direction=6';
        }
    }

    private function headDirection ($direction = 'N')
    {
        switch ($direction)
        {
            case 'N':
                return '&head_direction=7';
            case 'NE':
                return '&head_direction=8';        
            case 'E':
                return '&head_direction=1';
            case 'SE':
                return '&head_direction=2';
            case 'S':
                return '&head_direction=3';
            case 'SW':
                return '&head_direction=4';
            case 'W':
                return '&head_direction=5';
            case 'NW':
                return '&head_direction=6';
        }
    }

    private function only ()
    {
        return '&headonly=1';
    }

    private function face ($expression)
    {
        switch ($expression)
        {
            case 'smile':
                return '&gesture=sml';
            case 'speak':
                return '&gesture=spk';
            case 'blink':
                return '&gesture=eyb';
            case 'surprised':
                return '&gesture=srp';
            case 'angry':
                return '&gesture=agr';
            case 'sad':
                return '&gesture=sad';
            default:
                return '&gesture=nor';
        }
    }

    private function action ($action)
    {
        switch ($action)
        {
            case 'walk':
                return '&action=wlk';
            case 'lay':
                return '&action=lay';
            case 'sit':
                return '&action=sit';
            case 'wave':
                return '&action=wav';
            case 'hold':
                return '&action=crr=0';
            case 'drink':
                return '&action=drk=0';
        }
    }

    private function size ($size)
    {
        switch ($size)
        {
            case 'XL':
                return '&size=l';
            case 'XS':
                return '&size=s';
        }
    }
}
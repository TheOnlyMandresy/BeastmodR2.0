<?php use Systeme\Table\Admin\RanksTable as Admin; 

if (Admin::adminAccess(11)) new \Systeme\HTML\Navs\Dependencies\NavAdmin(PAGE);
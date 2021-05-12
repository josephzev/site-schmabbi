<?php namespace Joseph\Portfolio;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {

    	return[

    		'Joseph\Portfolio\Components\Designs' => 'designs'

    	];
    }

    public function registerSettings()
    {
    }
}

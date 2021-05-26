<?php namespace Joseph\Portfolio;

use System\Classes\PluginBase;

use Input;

class Plugin extends PluginBase
{
    public function registerComponents()
    {

    	return[

    		'Joseph\Portfolio\Components\Designs' => 'designs',
    		'Joseph\Portfolio\Components\Photos' => 'photos'

    	];
    }

    public function registerSettings()
    {
    }
}

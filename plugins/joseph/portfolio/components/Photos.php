<?php namespace Joseph\Portfolio\Components;

use  CMS\Classes\ComponentBase;

use Joseph\Portfolio\Models\Gallery;

class Photos extends ComponentBase
{

	public function componentDetails(){
		return[

			'name' => 'Gallery all',
			'description' => 'Gallery display'

		];
	}

	public function onRun(){

		$this->gallery = $this->loadGallery();



	}

	protected function loadGallery(){

		$gallery = Gallery::all();


		return $gallery;


	}

	public $gallery;



}
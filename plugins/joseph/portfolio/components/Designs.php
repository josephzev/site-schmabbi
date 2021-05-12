<?php namespace Joseph\Portfolio\Components;

use  CMS\Classes\ComponentBase;

use Joseph\Portfolio\Models\Design;

class Designs extends ComponentBase
{

	public function componentDetails(){
		return[

			'name' => 'Designs pagination',
			'description' => 'paginates designs'

		];
	}

	public function onRun(){

		$slug = $this->param('slug');

		$designs = $this->loadDesigns();

		$length = count($designs);

		$id = $designs->firstWhere('slug',$slug)->id;

		
		
		if( $id == 1 ){
             
             $this->previous = $slug;
		}
		else{

            $this->previous = $designs->firstWhere('id', $id-1)->slug;
		}   

		if( $id == $length){
			$this->next = $slug;
		}  
		else{
			$this->next = $designs->firstWhere('id', $id+1)->slug;
		}
       
	}

	protected function loadDesigns(){

		return Design::all();

	}

	public $previous;
	public $next;



}
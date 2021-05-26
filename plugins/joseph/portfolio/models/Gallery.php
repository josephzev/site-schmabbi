<?php namespace Joseph\Portfolio\Models;

use Model;

/**
 * Model
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    public $belongsToMany = [

        'categories' =>[

            'Joseph\Portfolio\Models\Category',

            'table' => 'joseph_portfolio_gallery_categories',

            'order' => 'name'

        ]
    ];

    public $attachOne = [
         
         'photo' => 'System\Models\File'

    ];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'joseph_portfolio_gallery';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public function scopeListFrontEnd($query, $options = []){
        extract(array_merge([
            
            'page' => 1,
            'perPage' => 10,
            'categories' => ""
         ], $options ));

        /*if($Category !== null){
            $query->whereHas('categories',function($q) use ($category){
                $q->where('id', '=', $Category);
            });
            $query->
        }*/

        if($categories !== "") {

            if(!is_array($categories)){
                $categories = [$categories];
            }

            foreach ($categories as $category){
                $query->whereHas('categories', function($q) use ($category){
                    $q->where('id', '=', $category);
                });
            }

        }

        return $query->paginate($perPage,$page);
    }
}

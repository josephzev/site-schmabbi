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
}

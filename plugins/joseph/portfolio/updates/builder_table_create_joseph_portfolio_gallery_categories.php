<?php namespace Joseph\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateJosephPortfolioGalleryCategories extends Migration
{
    public function up()
    {
        Schema::create('joseph_portfolio_gallery_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('gallery_id');
            $table->integer('category_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('joseph_portfolio_gallery_categories');
    }
}

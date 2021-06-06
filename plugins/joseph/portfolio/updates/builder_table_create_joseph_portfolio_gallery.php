<?php namespace Joseph\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateJosephPortfolioGallery extends Migration
{
    public function up()
    {
        Schema::create('joseph_portfolio_gallery', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('joseph_portfolio_gallery');
    }
}

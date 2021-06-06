<?php namespace Joseph\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateJosephPortfolioCategories extends Migration
{
    public function up()
    {
        Schema::create('joseph_portfolio_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('joseph_portfolio_categories');
    }
}

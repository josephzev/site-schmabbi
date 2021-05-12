<?php namespace Joseph\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateJosephPortfolio extends Migration
{
    public function up()
    {
        Schema::create('joseph_portfolio_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('slug');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('joseph_portfolio_');
    }
}

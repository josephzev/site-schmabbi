<?php namespace Joseph\Portfolio\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateJosephPortfolioCategories extends Migration
{
    public function up()
    {
        Schema::table('joseph_portfolio_categories', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::table('joseph_portfolio_categories', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}

<?php

use App\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateWebServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Utils::tb('web_service'), function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->integer('value');
        });
        DB::table(Utils::tb('web_service'))->insert(['key' => 'woe', 'value' => 0]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Utils::tb('web_service'));
    }
}

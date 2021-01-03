<?php

use App\Utils;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create(Utils::tb('user_configs'), function (Blueprint $table) {
            $table->engine = "InnoDB";
			$table->unsignedInteger('account_id');
            $table->string('world_name');
//            $table->json('data');

            $table->index('account_id');
            $table->index('world_name');
            $table->unique(['account_id', 'world_name']);
        });

        try {
            Schema::table(Utils::tb('user_configs'), function (Blueprint $table) {
                $table->json('data')->after('account_id');
            });
        } catch (Exception $e) {
            // If above fails, use LONGTEXT instead
            Schema::table(Utils::tb('user_configs'), function (Blueprint $table) {
                $table->longText('data')->after('account_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Utils::tb('user_configs'));
    }
}

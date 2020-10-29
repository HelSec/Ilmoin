<?php

use App\Users\GlobalBlock;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeGlobalBlockExpiryNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('global_blocks', function (Blueprint $table) {
            $table->dateTime('expires_at')
                ->nullable(true)
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        GlobalBlock::where('expires_at', null)
            ->update(['expires_at' => '2100-01-01 00:00:00']);

        Schema::table('global_blocks', function (Blueprint $table) {
            $table->dateTime('expires_at')
                ->nullable(false)
                ->change();
        });
    }
}

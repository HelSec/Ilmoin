<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventRegistrationOptionRequiredGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_registration_option_required_groups', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('event_registration_option_id');
            $table->foreign('event_registration_option_id', 'event_reg_option_groupreq_option_id_foreign')
                ->references('id')
                ->on('event_registration_options')
                ->onDelete('cascade');

            $table->unsignedBigInteger('organization_group_id');
            $table->foreign('organization_group_id', 'event_reg_option_groupreq_group_id_foreign')
                ->references('id')
                ->on('organization_groups')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_registration_option_required_groups');
    }
}

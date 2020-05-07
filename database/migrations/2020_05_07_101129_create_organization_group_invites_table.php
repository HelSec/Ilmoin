<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationGroupInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_group_invites', function (Blueprint $table) {
            $table->id();

            $table->foreignId('organization_group_id');
            $table->foreign('organization_group_id')
                ->references('id')
                ->on('organization_groups')
                ->onDelete('CASCADE');

            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('CASCADE');

            $table->boolean('approved_by_group')->default(false);
            $table->boolean('approved_by_user')->default(false);

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
        Schema::dropIfExists('organization_group_invites');
    }
}

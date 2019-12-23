<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPublicityFlagsToOrganizationGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_groups', function (Blueprint $table) {
            $table->boolean('is_public')
                ->default(true);
            $table->boolean('is_member_list_public')
                ->default(true);
            $table->boolean('is_member_list_shown_to_other_members')
                ->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_groups', function (Blueprint $table) {
            $table->dropColumn([
                'is_public',
                'is_member_list_public',
                'is_member_list_shown_to_other_members',
            ]);
        });
    }
}

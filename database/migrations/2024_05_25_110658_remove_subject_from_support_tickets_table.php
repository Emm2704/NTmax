<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSubjectFromSupportTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropColumn('subject');
        });
    }

    public function down()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->string('subject')->nullable(false);
        });
    }
}

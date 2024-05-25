<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectToSupportTicketsTable extends Migration
{
    public function up()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->string('subject')->after('description')->nullable(false);
        });
    }

    public function down()
    {
        Schema::table('support_tickets', function (Blueprint $table) {
            $table->dropColumn('subject');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('bank_name')->nullable()->after('open_hours');
            $table->string('bank_account')->nullable()->after('bank_name');
            $table->string('bank_owner')->nullable()->after('bank_account');
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account', 'bank_owner']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeleteToUsersTable extends Migration
{
    private $currentTableName = 'users';
    private $newTableName = 'table_user';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable($this->currentTableName)) Schema::rename($this->currentTableName, $this->newTableName);
        Schema::table($this->newTableName, function (Blueprint $table) {
            if(Schema::hasColumn($this->newTableName, 'name')) $table->dropColumn('name');
            $table->integer('created_by')->nullable()->after('created_at');
            $table->integer('updated_by')->nullable()->after('updated_at');
            $table->softDeletes();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->newTableName, function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}

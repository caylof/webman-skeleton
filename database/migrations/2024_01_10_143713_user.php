<?php

use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Blueprint;

return new class {

    public function up(Builder $schema): void
    {
        $schema->create('user', function(Blueprint $table) {
            $table->id();
            $table->string('username', 20)->unique()->comment('用户名');
            $table->string('password')->comment('密码');
            $table->string('nickname', 20)->nullable()->comment('昵称');
            $table->string('avatar', 255)->nullable()->comment('头像');
            $table->datetimes();

            $table->comment('用户表');
        });
    }

    public function down(Builder $schema): void
    {
        $schema->dropIfExists('user');
    }
};
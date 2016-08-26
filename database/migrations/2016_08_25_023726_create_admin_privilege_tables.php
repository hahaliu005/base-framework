<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminPrivilegeTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adm_roles', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
            $table->softDeletes();


        });
        Schema::create('adm_permissions', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
        Schema::create('adm_permission_role', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->unique(['permission_id', 'role_id']);
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('adm_role_admin', function(Blueprint $table){
            $table->engine = 'InnoDB';
            $table->integer('role_id')->unsigned();
            $table->integer('admin_id')->unsigned();
            $table->unique(['role_id', 'admin_id']);
            $table->timestamps();
            $table->softDeletes();
        });

        //init roles
        $roles = [
            'root' => '超级管理员',
            'admin' => '管理员',
            'customer' => '普通用户'
        ];
        foreach($roles as $role => $label){
            \App\AdmRole::create([
                'name' => $role,
                'label' => $label
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adm_permission_role');
        Schema::dropIfExists('adm_role_user');
        Schema::dropIfExists('adm_role_admin');
        Schema::dropIfExists('adm_roles');
        Schema::dropIfExists('adm_permissions');
    }
}

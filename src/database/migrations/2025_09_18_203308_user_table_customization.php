<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('email_verified_at');
            $table->integer('role_ids')->nullable()->after('password');
            $table->integer('area_manager')->nullable()->after('role_ids');
            $table->string('extension')->nullable()->after('area_manager')->comment('Anexo');
            $table->integer('employee_id')->nullable()->after('extension')->comment('ID Empleado');
            $table->string('branch')->nullable()->after('employee_id')->comment('Sucursal');
            $table->string('area_name')->nullable()->after('branch');
            $table->string('position')->nullable()->after('area_name')->comment('Cargo');
            $table->string('banch_name', 500)->nullable()->after('position')->comment('nombre de la sucursal');
            $table->integer('u_created_at')->nullable();
            $table->integer('u_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'role_ids',
                'area_manager',
                'extension',
                'employee_id',
                'branch',
                'area_name',
                'position',
                'banch_name',
                'u_created_at',
                'u_updated_at',
            ]);
        });
    }
};

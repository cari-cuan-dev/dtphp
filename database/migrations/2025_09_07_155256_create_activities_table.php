<?php

use App\Models\Role;
use App\Models\User;
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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class)
                ->constrained((new Role)->getTable())
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->unsignedSmallInteger('year');
            $table->string('code');
            $table->string('label');
            $table->double('volume');
            $table->string('unit');

            // addtional
            $table->text('description')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained((new User)->getTable())
                ->onDelete('set null');
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained((new User)->getTable())
                ->onDelete('set null');
            $table->foreignId('deleted_by')
                ->nullable()
                ->constrained((new User)->getTable())
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};

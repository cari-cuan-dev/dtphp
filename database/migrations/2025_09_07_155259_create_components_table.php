<?php

use App\Models\Activity;
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
        Schema::create('components', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Activity::class)
                ->constrained((new Activity)->getTable())
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->string('code');
            $table->string('label');
            $table->double('volume')->default(0);
            $table->string('unit');

            // allocation
            $table->double('allocation_total')->default(0);
            $table->double('allocation_capital')->default(0);
            $table->double('allocation_good')->default(0);
            $table->double('allocation_employee')->default(0);
            $table->double('allocation_social')->default(0);

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
        Schema::dropIfExists('components');
    }
};

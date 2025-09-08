<?php

use App\Models\Component;
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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Component::class)
                ->constrained((new Component)->getTable())
                ->noActionOnUpdate()
                ->noActionOnDelete();
            $table->tinyInteger('month');

            // realization physical
            $table->double('physical_volume')->default(0);
            $table->string('physical_unit');
            $table->double('physical_real')->nullable();
            $table->string('physical_real_unit')->nullable();
            $table->enum('physical_category', ['main', 'secondary'])->default('secondary');
            $table->boolean('physical_status')->default(false);

            // realization
            $table->double('realization_capital')->default(0);
            $table->double('realization_good')->default(0);
            $table->double('realization_employee')->default(0);
            $table->double('realization_social')->default(0);

            // implementation
            $table->double('implementation_progress')->default(0);
            $table->double('implementation_category')->default(0);
            $table->text('implementation_description')->nullable();

            // issue
            $table->boolean('issue_solved')->default(false);
            $table->text('issue_description')->nullable();

            // supporting evidence
            $table->string('support_document_path')->nullable();
            $table->string('support_photo_path')->nullable();
            $table->string('support_video_path')->nullable();

            // verified
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')
                ->nullable()
                ->constrained((new User)->getTable())
                ->onDelete('set null');
            $table->text('verified_notes')->nullable();

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
        Schema::dropIfExists('reports');
    }
};

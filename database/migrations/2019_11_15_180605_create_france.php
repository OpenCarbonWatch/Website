<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->string('id');
            $table->unique('id');
            $table->string('name');
            $table->integer('min_staff')->nullable();
            $table->integer('max_staff')->nullable();
            $table->integer('population')->nullable();
            $table->string('city_id')->nullable();
            $table->string('organization_type_id');
            $table->integer('regulation')->nullable();
        });
        Schema::create('organization_types', function (Blueprint $table) {
            $table->string('id');
            $table->unique('id');
            $table->string('label_3');
            $table->string('label_2');
            $table->string('label_1');
        });
        Schema::create('assessments', function (Blueprint $table) {
            $table->string('id');
            $table->unique('id');
            $table->integer('reporting_year');
            $table->float('total_scope_1')->nullable();
            $table->float('total_scope_2')->nullable();
            $table->float('total_scope_3')->nullable();
            $table->boolean('action_plan');
            $table->float('reductions_scope_1_2')->nullable();
            $table->float('reductions_scope_1')->nullable();
            $table->float('reductions_scope_2')->nullable();
            $table->float('reductions_scope_3')->nullable();
			$table->boolean('is_draft');
            $table->string('source_url');
        });
        Schema::create('assessment_organization', function (Blueprint $table) {
            $table->string('organization_id');
            $table->string('assessment_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assessment_organization');
        Schema::dropIfExists('assessments');
        Schema::dropIfExists('organization_types');
        Schema::dropIfExists('organizations');
    }
}

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
        Schema::create('activities', function (Blueprint $table) {
            $table->string('id_1');
            $table->string('label_1');
            $table->string('id_2');
            $table->string('label_2');
            $table->string('id_3');
            $table->string('label_3');
            $table->string('id_4');
            $table->string('label_4');
            $table->string('id_5');
            $table->string('label_5');
        });
        Schema::create('cities', function (Blueprint $table) {
            $table->string('id');
            $table->string('city_name');
            $table->string('department_name');
            $table->string('region_name');
        });
        Schema::create('legal_types', function (Blueprint $table) {
            $table->string('id_1');
            $table->string('label_1');
            $table->string('id_2');
            $table->string('label_2');
            $table->string('id_3');
            $table->string('label_3');
        });
        Schema::create('organizations', function (Blueprint $table) {
            $table->string('id');
            $table->unique('id');
            $table->string('name');
            $table->integer('min_staff')->nullable();
            $table->integer('max_staff')->nullable();
            $table->integer('population')->nullable();
            $table->string('city_id')->nullable();
            $table->string('legal_type_id');
            $table->integer('regulation')->nullable();
            $table->string('activity_id');
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
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('legal_types');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('activities');
    }
}

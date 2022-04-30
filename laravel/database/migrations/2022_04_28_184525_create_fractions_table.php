<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fractions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('textfile');
            $table->timestamps();
        });

        \App\Models\fractions::create([
            'name' => 'Verwaltung',
            'textfile' => 'Verwaltung',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fractions');
    }
};

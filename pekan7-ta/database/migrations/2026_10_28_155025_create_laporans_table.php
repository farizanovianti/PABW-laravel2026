<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();                                 
            $table->string('nama_pelapor');                
            $table->string('no_hp', 15);                    
            $table->string('lokasi');                       
            $table->string('kecamatan', 50);                
            $table->unsignedInteger('tinggi_air');          
            $table->text('keterangan')->nullable();         
            $table->string('foto')->nullable();             
            $table->string('status', 20)->default('Menunggu'); 
            $table->timestamps();                           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};

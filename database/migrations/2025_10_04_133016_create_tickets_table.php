<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->enum('ticket_type', ['Open', 'close']);
            $table->enum('complaint_type', ['normal', 'hard']);
            $table->time('jam');
            $table->date('tanggal');
            $table->enum('source', ['helpdesk', 'Tim Support', 'Tim Dev']);
            $table->string('company');
            $table->string('branch');
            $table->string('kota_cabang');
            $table->enum('priority', ['Premium', 'full service', 'lainnya']);
            $table->enum('application', [
                'aplikasi kasir',
                'aplikasi web merchant',
                'hardware',
                'Aplikasi web internal',
                'Aplikasi Attendance'
            ]);
            $table->enum('category', [
                'assistance',
                'General Question',
                'application bugs'
            ]);
            $table->string('sub_category');
            $table->text('info_kendala');
            $table->text('pengecekan')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('solving')->nullable();
            $table->string('pic_merchant');
            $table->string('jabatan');
            $table->string('nama_helpdesk');
            $table->enum('status', ['open', 'progress', 'close'])->default('open');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};

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
            $table->enum('ticket_type', ['Open', 'Close']);
            $table->enum('complaint_type', ['Normal', 'Hard']);
            $table->time('jam');
            $table->date('tanggal');
            $table->enum('source', ['Help Desk', 'Team Sales', 'Team Support']);
            $table->string('company');
            $table->string('branch');
            $table->string('kota_cabang');
            $table->enum('priority', ['Premium', 'Full Service', 'Lainnya', 'Corporate']);
            $table->enum('application', [
                'Aplikasi Kasir',
                'Aplikasi Web Merchant',
                'Hardware',
                'Aplikasi Mobile',
                'Aplikasi Web Internal',
                'Aplikasi Attendance'
            ]);
            $table->enum('category', [
                'Assistances',
                'General Questions',
                'Application Bugs',
                'Request Features'
            ]);
            $table->string('sub_category');
            $table->enum('status_qris', [
                'Sukses',
                'Pending/Expired',
                'Gagal',
                'None'
            ])->default('none');
            $table->text('info_kendala');
            $table->text('pengecekan')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('solving')->nullable();
            $table->enum('assigned', [
                'Helpdesk',
                'Development',
                'Marketing',
                'Team Support',
                'Gudang',
                'Team PAC'
            ]);
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

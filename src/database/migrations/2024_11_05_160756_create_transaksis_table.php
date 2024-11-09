<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client');
            $table->integer('invoice');
            $table->integer('total_harga');
            $table->timestamps();
        });

        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaksi');
            $table->integer('id_list');
            $table->integer('jumlah');
            $table->integer('harga_satuan');
            $table->timestamps();
        });

        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaksi');
            $table->integer('total_bayar');
            $table->text('bukti_bayar1');
            $table->text('bukti_bayar2');
            $table->text('bukti_bayar3');
            $table->text('bukti_bayar4');
            $table->text('bukti_bayar5');
            $table->timestamps();
        });

        Schema::create('trackings', function (Blueprint $table) {
            $table->id();
            $table->integer('id_transaksi');
            $table->string('deskripsi');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksis');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tracking;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'index']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksis = Transaksi::all();

        return response()->json([
            'data' => $transaksis
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_client' => 'required',
            // 'invoice' => 'required',
            // 'total_harga' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        $transaksi = Transaksi::create($input);

        for ($i = 0; $i < count($input['id_list']); $i++) {
            TransaksiDetail::creat([
                'id_transaksi' => $transaksi['id'],
                'id_list' => $input['id_list'][$i],
                'jumlah' => $input['jumlah'][$i],
                'harga_satuan' => $input['harga_satuan'][$i],
            ]);
        }

        Pembayaran::create([
            'id_transaksi' => $transaksi['id'],
            'total_bayar' => 0,
            'bukti_bayar1' => '0',
            'bukti_bayar2' => '0',
            'bukti_bayar3' => '0',
            'bukti_bayar4' => '0',
            'bukti_bayar5' => '0',
        ]);

        for ($j = 0; $j < count($input['id_list']); $j++) {
            Tracking::creat([
                'id_transaksi' => $transaksi['id'],
                'id_list' => $input['id_list'][$j],
                'deskripsi' => '0',
                'status' => 0,
            ]);
        }

        return response()->json([
            'data' => $transaksi
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validator = Validator::make($request->all(), [
            'id_client' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(),
                422
            );
        }

        $input = $request->all();

        $transaksi->update($input);

        TransaksiDetail::where('id_transaksi', $transaksi['id'])->delete();

        for ($i = 0; $i < count($input['id_list']); $i++) {
            TransaksiDetail::creat([
                'id_transaksi' => $transaksi['id'],
                'id_list' => $input['id_list'][$i],
                'jumlah' => $input['jumlah'][$i],
                'harga_satuan' => $input['harga_satuan'][$i],
            ]);
        }

        Pembayaran::create([
            'id_transaksi' => $transaksi['id'],
            'total_bayar' => 0,
            'bukti_bayar1' => '0',
            'bukti_bayar2' => '0',
            'bukti_bayar3' => '0',
            'bukti_bayar4' => '0',
            'bukti_bayar5' => '0',
        ]);

        for ($j = 0; $j < count($input['id_list']); $j++) {
            Tracking::creat([
                'id_transaksi' => $transaksi['id'],
                'id_list' => $input['id_list'][$j],
                'deskripsi' => '0',
                'status' => 0,
            ]);
        }

        return response()->json([
            'message' => 'success',
            'data' => $transaksi
        ]);
    }

    public function ubah_status(Request $request, Transaksi $transaksi)
    {
        $transaksi->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'success',
            'data' => $transaksi
        ]);
    }

    public function dikonfirmasi()
    {
        $transaksis = Transaksi::where('status', 'Dikonfirmasi')->get();

        return response()->json([
            'data' => $transaksis
        ]);
    }
    public function dikemas()
    {
        $transaksis = Transaksi::where('status', 'dikemas')->get();

        return response()->json([
            'data' => $transaksis
        ]);
    }
    public function dikirim()
    {
        $transaksis = Transaksi::where('status', 'dikirim')->get();

        return response()->json([
            'data' => $transaksis
        ]);
    }
    public function diterima()
    {
        $transaksis = Transaksi::where('status', 'diterima')->get();

        return response()->json([
            'data' => $transaksis
        ]);
    }
    public function selesai()
    {
        $transaksis = Transaksi::where('status', 'selesai')->get();

        return response()->json([
            'data' => $transaksis
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }
}

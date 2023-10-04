<?php

namespace App\Http\Controllers;

use App\Models\areaModels;
use App\Models\kendaraanModels;
use App\Models\oddoInModels;
use App\Models\oddoOutModels;
use App\Models\OddoHistoryModels;
use App\Models\safetyToolsModels;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class oddoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('user.OddoOption');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function addOddoIn(){

        $users_id = auth()->id();

        $area = areaModels::all();


        return view('user.oddoInView', compact(
            'area',
        ));

    }

    public function addOddoOut(){

        $kendaraan = kendaraanModels::all();
        $area = areaModels::all();
        $safety = safetyToolsModels::all();

        return view('user.oddoOutView', compact(
            'kendaraan',
            'area',
            'safety',
        ));
    }

    public function oddoOutPost(Request $request){

        $userId = auth()->id();

        $riwayatOddo = OddoHistoryModels::where('users_id', $userId)
                ->whereNull('oddoin_id')
                ->first();

            if ($riwayatOddo) {
                // Jika tidak ada catatan "Oddo In" yang kosong, alihkan pengguna ke halaman Oddo In terlebih dahulu
                return redirect()->route('oddoInView')->with('error', 'Anda harus melakukan Oddo In terlebih dahulu.');
            }

        $validatedData = $request->validate([
            'oddo_meter_out' => 'required',
            'vehicles_id' => 'required',
            'areas_id' => 'required|array',
            'safetytools_id' => 'required|array',
        ]);

        // Menggabungkan nilai dari elemen <select> menjadi string
        $areasvalue = implode(',', $validatedData['areas_id']);
        $safetyvalue = implode(',', $validatedData['safetytools_id']);


        // Menyimpan data ke dalam database
        $model = new oddoOutModels();
        $model->fill($validatedData);
        $model->areas_id = $areasvalue;
        $model->safetytools_id = $safetyvalue;
        $model->save();

        $vehiclesaId = $model->vehicles_id;

        // Menambahkan is_pickup ke KendaraanModels
        KendaraanModels::where('id', $vehiclesaId)
            ->update([
                'is_pickup' => '1',
                'is_available' => '0'
            ]);

        $riwayatOddo = new OddoHistoryModels();
        $riwayatOddo->users_id = $userId;
        $riwayatOddo->oddoOut_id = $model->id;
        $riwayatOddo->vehicles_id = $model->vehicles_id;
        $riwayatOddo->save();

        return redirect('/app');
    }

    public function oddoInPost(Request $request)
    {
        $users_id = auth()->id();

        $riwayatTransaksi = OddoHistoryModels::where('users_id', $users_id)
            ->whereNull('oddoin_id') // Pastikan tidak ada transaksi "Oddo In"
            ->first();

        $lastOddoHistory = OddoHistoryModels::where('users_id', $users_id)
            ->orderBy('created_at', 'desc')
            ->first();

        $lastOddo = $lastOddoHistory->vehicles_id;

        if ($riwayatTransaksi) {
            $validatedData = $request->validate([
                'oddo_meter_in' => 'required',
                'areas_id' => 'required',
                'image' =>'required'
            ]);

            $oddoMeterIn = $validatedData['oddo_meter_in'];

            // Simpan gambar ke direktori "public/uploads" menggunakan Storage
            $image = $request->file('image');

            // Mengurangi kualitas gambar sebelum menyimpannya
            $img = Image::make($image);
            $img->resize(800, 600); // Mengubah dimensi menjadi 2000x1000 pixel
            $img->encode('jpg', 80); // Mengurangi kualitas menjadi 80%


            $fileName = uniqid() . '.jpg'; // Nama file yang unik
            $filePath = 'uploads/' . $fileName;

            // Simpan gambar menggunakan Storage::disk ke dalam storage/app/public/uploads
            Storage::disk('public')->put($filePath, $img->stream());

            // Menyimpan data ke dalam database
            $model = new OddoInModels(); // Pastikan nama model sesuai dengan kebutuhan Anda
            $model->fill($validatedData);
            $model->foto_oddo_in = $filePath;
            $model->save();

            // Mengupdate riwayatTransaksi dengan ID dari model yang baru disimpan
            $riwayatTransaksi->oddoin_id = $model->id;
            $riwayatTransaksi->save();

            // Memperbarui nilai last_oddo pada KendaraanModels
            KendaraanModels::where('id', $lastOddo)
                ->update([
                    'last_oddo' => $oddoMeterIn,
                    'is_pickup' => '0',
                    'is_available' => '1'
            ]);

            return redirect('/app');
        }
    }
}

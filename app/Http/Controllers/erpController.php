<?php

namespace App\Http\Controllers;

use App\Models\areaModels;
use App\Models\kendaraanModels;
use App\Models\OddoHistoryModels;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;


class erpController extends Controller
{
    public function index()
    {
        $kendaraan = kendaraanModels::all()->count();
        $user = user::all()->count();
        $area = areaModels::all()->count();

        $kendaraanavailable = kendaraanModels::where('is_available','=','1')->count();
        $oddohistory = OddoHistoryModels::with(['vehicles','oddoin','users'])->orderBy('updated_at','desc')->take('5')->get();

        return view('erp.erpDashboard', compact(
            'kendaraan',
            'user',
            'kendaraanavailable',
            'oddohistory',
            'area'
        ));
    }

    public function oddoHistoryview()
    {
        return view('erp.oddoHistory');
    }

    public function oddoHistoryAjax(Request $request)
    {
        return $request->ajax()
            ? $this->getDataTableResponse($request)
            : abort(404);
    }

    private function getDataTableResponse(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = OddoHistoryModels::with(['users', 'oddoout', 'oddoin', 'vehicles'])
            ->orderByDesc('created_at'); // Urutkan berdasarkan tanggal terbaru

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $data = $query->take(100)->get(); // Ambil 100 data terbaru

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sequence', '')
            ->addColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i:s'))
            ->addColumn('updated_at', fn($row) => $row->updated_at->format('Y-m-d H:i:s'))
            ->addColumn('action', function ($row) {
                if ($row->oddoin && $row->oddoin->foto_oddo_in) {
                    // If oddoin is not null and foto_oddo_in is not null
                    $photoUrl = asset('storage/' . $row->oddoin->foto_oddo_in);
                    return '<a href="' . $photoUrl . '" class="edit btn btn-success btn-sm">Link Foto</a>';
                } else {
                    // If oddoin is null or foto_oddo_in is null
                    return '<button class="btn btn-danger btn-sm" disabled>Belum Update</button>';
                }
            })
            ->addColumn('details', function ($row) {
                return '<button class="btn btn-primary" id="modal-2">Detail Full</button>';
            })
            ->rawColumns(['action', 'sequence','details'])
            ->make(true);
    }

    public function vehiclesview(){
        return view('erp.vehiclesData');
    }

    public function vehiclesAjax(Request $request)
    {
        return $request->ajax()
            ? $this->getDatatableVehicles($request)
            : abort(404);
    }

    private function getDatatableVehicles(Request $request)
    {
        $data = kendaraanModels::all();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('sequence', '')
            ->addColumn('details', function ($row) {
                return '<button class="btn btn-primary" id="modal-2">Detail Full</button>';
            })
            ->rawColumns(['details'])
            ->make(true);
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lot;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;

class LotController extends Controller
{
    /**
     * Display a listing of the lot records.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Build a basic query filtering by the logged-in user.
        $query = Lot::where('user_id', $request->user()->id);
        
        // Optionally filter by date range if provided.
        if ($request->filled('fdate')) {
            $query->where('lots_date', '>=', $request->get('fdate'));
        }
        if ($request->filled('tdate')) {
            $query->where('lots_date', '<=', $request->get('tdate'));
        }

        $lots = $query->orderBy('lots_date', 'asc')->get();

        // Calculate total lot volume.
        $totalLots = $lots->sum('lots');

        return view('user.lots.index', [
            'query_string' => $request->getQueryString() ? '?' . $request->getQueryString() : '',
            'table_data'   => $lots,
            'totalLots'    => $totalLots,
        ]);
    }

    /**
     * Show the form for creating a new lot record.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('user.lots.create');
    }

    /**
     * Store a newly created lot record in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request.
        $data = $request->validate([
            'lots'      => 'required|numeric',
            'lots_date' => 'required|date',
        ]);

        // Add user_id from the current logged user.
        $data['user_id'] = $request->user()->id;

        $lot = Lot::create($data);

        if ($lot) {
            $request->session()->flash('success', 'Lot successfully added');
        } else {
            $request->session()->flash('error', 'Error occurred, please try again!');
        }

        return redirect()->route('lots.index');
    }

    /**
     * Remove the specified lot record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lot = Lot::findOrFail($id);

        if ($lot) {
            $lot->delete();
            session()->flash('success', 'Lot successfully deleted');
        } else {
            session()->flash('error', 'Error while deleting lot');
        }
        return redirect()->route('lots.index');
    }

    /**
     * Export the filtered lot records to an Excel file.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        // Use similar filtering as in index.
        $query = Lot::where('user_id', $request->user()->id);
        
        if ($request->filled('fdate')) {
            $query->where('lots_date', '>=', $request->get('fdate'));
        }
        if ($request->filled('tdate')) {
            $query->where('lots_date', '<=', $request->get('tdate'));
        }
        $table_data = $query->orderBy('lots_date', 'asc')->get();

        return Excel::download(new MembersExport($table_data), 'lots-' . Carbon::now()->format('YmdHis') . '.xlsx');
    }
}

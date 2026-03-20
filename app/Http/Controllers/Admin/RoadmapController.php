<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roadmap;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;  // Assuming you are using the same export class

class RoadmapController extends Controller
{
    /**
     * Display a listing of the lot records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    // Start a query on the Lot model and eager-load the 'user' relationship.
    $query = Roadmap::query();

    // --- 2) Filter by start date (fdate) and end date (tdate) ---
    if ($request->filled('roadmap_date')) {
        $query->where('date', '>=', $request->get('fdate'));
    }
    if ($request->filled('roadmap_date')) {
        $query->where('date', '<=', $request->get('tdate'));
    }



    // Order the list by lots_date and retrieve.
    $roadmaps = $query->orderBy('date', 'asc')->get();

    // Return the view (you could also return JSON, etc.).
    return view('backend.roadmap.index', [
        'roadmaps' => $roadmaps,
    ]);
}






    public function create()
    {
        // Return the create view with the users data.
        return view('backend.roadmap.create');
    }

    /**
     * Store a newly created lot in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validatedData = $request->validate([
            'usd_amount'      => 'required|numeric',
            'position_id'      => 'required|numeric',
            'date' => 'required|date',
        ]);

        // Create the Lot record using the validated data.
        Roadmap::create($validatedData);

        // Redirect to the lot index with a success message.
        return redirect()->route('roadmap.index')->with('success', 'Roadmap created successfully.');
    }

    /**
     * Remove the specified lot record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $roadmap = Roadmap::findOrFail($id);

        if ($roadmap) {
            $roadmap->delete();
            session()->flash('success', 'Roadmap successfully deleted');
        } else {
            session()->flash('error', 'Error while deleting roadmap');
        }

        return redirect()->route('roadmap.index');
    }

    /**
     * Export the filtered lot records to an Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        // Apply same filters as in the index method.
        $query = Roadmap::query();

        
        if ($request->filled('fdate')) {
            $query->where('roadmap_date', '>=', $request->get('fdate'));
        }
        if ($request->filled('tdate')) {
            $query->where('roadmap_date', '<=', $request->get('tdate'));
        }

        $table_data = $query->orderBy('roadmap_date', 'asc')->get();

        return Excel::download(new MembersExport($table_data), 'roadmaps-' . Carbon::now()->format('YmdHis') . '.xlsx');
    }
}

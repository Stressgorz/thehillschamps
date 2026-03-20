<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lot;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;  // Assuming you are using the same export class

class LotController extends Controller
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
    $query = Lot::with('user');

    // --- 1) Filter by user_id if provided ---
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->get('user_id'));
    }

    // --- 2) Filter by start date (fdate) and end date (tdate) ---
    if ($request->filled('fdate')) {
        $query->where('lots_date', '>=', $request->get('fdate'));
    }
    if ($request->filled('tdate')) {
        $query->where('lots_date', '<=', $request->get('tdate'));
    }

    // --- 3) Filter by client_name (applied to the related User's firstname OR lastname) ---
    if ($request->filled('ib_name')) {
        $searchTerm = $request->get('ib_name');
        $query->whereHas('user', function ($q) use ($searchTerm) {
            $q->where('firstname', 'like', "%{$searchTerm}%")
              ->orWhere('lastname', 'like', "%{$searchTerm}%");
        });
    }

    // --- 4) Filter by client_email (applied to the related User's email) ---
    if ($request->filled('ib_email')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('email', 'like', '%' . $request->get('ib_email') . '%');
        });
    }

    // Order the list by lots_date and retrieve.
    $lots = $query->orderBy('lots_date', 'asc')->get();

    // Return the view (you could also return JSON, etc.).
    return view('backend.lots.index', [
        'lots' => $lots,
    ]);
}






    public function create()
    {
        // Retrieve all users to populate the dropdown.
        $users = User::where('status', 1)->get();
        
        // Return the create view with the users data.
        return view('backend.lots.create', compact('users'));
    }

    /**
     * Store a newly created lot in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validatedData = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'self'      => 'required|numeric',
            'lots'      => 'required|numeric',
            'group'      => 'required|numeric',
            'lots_date' => 'required|date',
        ]);

        // Create the Lot record using the validated data.
        Lot::create($validatedData);

        // Redirect to the lot index with a success message.
        return redirect()->route('lot.index')->with('success', 'Lot created successfully.');
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

        return redirect()->route('lot.index');
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
        $query = Lot::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }
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

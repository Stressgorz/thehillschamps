<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wtt;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;  // Assuming you are using the same export class

class WttController extends Controller
{
    /**
     * Display a listing of the wtt records.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    // Start a query on the Wtt model and eager-load the 'user' relationship.
    $query = Wtt::with('user');

    // --- 1) Filter by user_id if provided ---
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->get('user_id'));
    }

    // --- 2) Filter by start date (fdate) and end date (tdate) ---
    if ($request->filled('fdate')) {
        $query->where('wtt_date', '>=', $request->get('fdate'));
    }
    if ($request->filled('tdate')) {
        $query->where('wtt_date', '<=', $request->get('tdate'));
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

    // Order the list by wtt_date and retrieve.
    $wtt = $query->orderBy('wtt_date', 'asc')->get();

    // Return the view (you could also return JSON, etc.).
    return view('backend.wtt.index', [
        'wtt' => $wtt,
    ]);
}






    public function create()
    {
        // Retrieve all users to populate the dropdown.
        $users = User::where('status', 1)->get();
        
        // Return the create view with the users data.
        return view('backend.wtt.create', compact('users'));
    }

    /**
     * Store a newly created wtt in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data.
        $validatedData = $request->validate([
            'user_id'   => 'required|exists:users,id',
            'wtt'      => 'required|numeric',
            'wtt_date' => 'required|date',
        ]);

        // Create the Wtt record using the validated data.
        Wtt::create($validatedData);

        // Redirect to the wtt index with a success message.
        return redirect()->route('wtt.index')->with('success', 'Wtt created successfully.');
    }

    /**
     * Remove the specified wtt record from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $wtt = Wtt::findOrFail($id);

        if ($wtt) {
            $wtt->delete();
            session()->flash('success', 'Wtt successfully deleted');
        } else {
            session()->flash('error', 'Error while deleting wtt');
        }

        return redirect()->route('wtt.index');
    }

    /**
     * Export the filtered wtt records to an Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(Request $request)
    {
        // Apply same filters as in the index method.
        $query = Wtt::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }
        if ($request->filled('fdate')) {
            $query->where('wtt_date', '>=', $request->get('fdate'));
        }
        if ($request->filled('tdate')) {
            $query->where('wtt_date', '<=', $request->get('tdate'));
        }

        $table_data = $query->orderBy('wtt_date', 'asc')->get();

        return Excel::download(new MembersExport($table_data), 'wtt-' . Carbon::now()->format('YmdHis') . '.xlsx');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Roadmap;
use App\Models\Position;

class RoadmapController extends Controller
{
    public function index(Request $request)
    {
        if (empty($request->query('position_id'))) {
            $request->request->add([
                'position_id' => $request->query('position_id'),
            ]);
        }

        $table_data = $this->filter($request);
        $positions = Position::where('status', Position::$status['active'])->get();

        return view('backend.roadmap.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'positions' => $positions,
        ]);
    }

    public static function filter(Request $filters)
    {
        $query = DB::table('roadmap')
                    ->leftJoin('positions', 'roadmap.position_id', '=', 'positions.id')
                    ->select(
                        'roadmap.*',
                        'positions.name as position_name'
                    )
                    ->orderBy('roadmap.date', 'DESC')
                    ->orderBy('roadmap.id', 'DESC');

        $params = [
            'roadmap' => [
                'date' => 'date',
            ],
            'positions' => [
                'position_id' => 'id',
            ],
        ];

        foreach ($params as $table => $columns) {
            foreach ($columns as $field => $param) {
                if ($field == 'date') {
                    if ($filters->query('fdate')) {
                        $query->where($table.'.'.$param, '>=', $filters->query('fdate'));
                    }
                    if ($filters->query('tdate')) {
                        $query->where($table.'.'.$param, '<=', $filters->query('tdate'));
                    }
                } elseif (is_array($filters->query($field)) && !empty($filters->query($field))) {
                    $query->whereIn($table.'.'.$param, $filters->query($field));
                } else {
                    if (!empty($filters->query($field))) {
                        if (in_array($field, ['position_id'])) {
                            $query->where($table.'.'.$param, '=', $filters->query($field));
                        } else {
                            $query->where($table.'.'.$param, 'LIKE', '%'.$filters->query($field).'%');
                        }
                    }
                }
            }
        }

        return $query->get();
    }

    public function create()
    {
        $positions = Position::where('status', Position::$status['active'])->get();

        return view('backend.roadmap.create', [
            'positions' => $positions,
        ]);
    }

    public function store(Request $request)
    {
        $data = static::roadmapStoreValidation($request);

        $roadmap = Roadmap::create([
            'position_id' => $data['position_id'],
            'usd_amount' => $data['usd_amount'],
            'date' => $data['date'],
        ]);

        if ($roadmap) {
            request()->session()->flash('success', 'Roadmap successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('roadmap.index');
    }

    public static function roadmapStoreValidation($request)
    {
        $data[] = $request->validate([
            'position_id' => ['required',
                function ($attribute, $value, $fail) {
                    $position = Position::where('id', $value)
                        ->where('status', Position::$status['active'])
                        ->first();
                    if (empty($position)) {
                        $fail('Rank does not exist');
                    }
                }
            ],
            'usd_amount' => ['required', 'numeric'],
            'date' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }

        return $validated;
    }

    public function show($id)
    {
        $roadmap = Roadmap::with('position')->findOrFail($id);

        return view('backend.roadmap.show', [
            'roadmap' => $roadmap,
        ]);
    }

    public function edit($id)
    {
        $roadmap = Roadmap::findOrFail($id);
        $positions = Position::where('status', Position::$status['active'])->get();

        return view('backend.roadmap.edit', [
            'roadmap' => $roadmap,
            'positions' => $positions,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = static::roadmapUpdateValidation($request, $id);

        $updateData = [
            'position_id' => $data['position_id'],
            'usd_amount' => $data['usd_amount'],
            'date' => $data['date'],
        ];

        $roadmap = Roadmap::findOrFail($id);

        if ($roadmap) {
            $roadmap->fill($updateData)->save();
            request()->session()->flash('success', 'Roadmap successfully updated');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }

        return redirect()->route('roadmap.index');
    }

    public static function roadmapUpdateValidation($request, $id)
    {
        $data[] = $request->validate([
            'position_id' => ['required',
                function ($attribute, $value, $fail) {
                    $position = Position::where('id', $value)
                        ->where('status', Position::$status['active'])
                        ->first();
                    if (empty($position)) {
                        $fail('Rank does not exist');
                    }
                }
            ],
            'usd_amount' => ['required', 'numeric'],
            'date' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }

        return $validated;
    }

    public function destroy($id)
    {
        $roadmap = Roadmap::findOrFail($id);

        if ($roadmap) {
            Roadmap::where('id', $id)->delete();
            request()->session()->flash('success', 'Roadmap successfully deleted');
        } else {
            request()->session()->flash('error', 'Error while deleting Roadmap');
        }

        return redirect()->route('roadmap.index');
    }
}

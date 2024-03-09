<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Client;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Position;
use App\Models\UserKpi;
use App\Models\Kpi;
use App\Models\KpiAnswer;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MembersExport;
use Carbon\Carbon;
use App\User;

class UserKpiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $now = Carbon::now();

        if (empty($request->query('fdate'))) {
            $request->request->add([
                'fdate' => $request->query('fdate'),
            ]);
        }
        if (empty($request->query('tdate'))) {
            $request->request->add([
                'tdate' =>$request->query('tdate'),
            ]);
        }

        $table_data = $this->filter($request);

        return view('user.user_kpi.index', [
            'query_string' => $request->getQueryString() ? '?'.$request->getQueryString() : '',
            'table_data' => $table_data,
            'user_kpi_status' => UserKpi::$status,
            'brokers' => Sale::$broker,
        ]);
    }

    
    public static function filter(Request $filters)
    {
        $query = DB::table('user_kpi')
                    ->where('user_id', $filters->user()->id)
		        	->select('*'
                    )
                    ->orderBy('id','ASC');

        $params = [
            'user_kpi' => [
                'fdate' => 'created_at',
                'tdate' => 'created_at',
            ],
        ];

        foreach ($params as $table => $columns) {
        	foreach ($columns as $field => $param) {
	            if ($field == 'created_at') {
	                if ($filters->get('fdate')) {
	                    $query->where($table.'.'.$param, '>=',  $filters->get('fdate'));
	                }
	                if ($filters->get('tdate')) {
	                    $query->where($table.'.'.$param, '<=', ($filters->get('tdate').' 23:59:59'));
	                }
	            } elseif (is_array($filters->query($field)) && ! empty($filters->query($field))) { 
	                // If is array and not empty
	                $query->whereIn($table.'.'.$param, $filters->query($field));
	            } else {
                    if (! empty($filters->query($field))) {
                        if (in_array($field, ['status', 'type'])) { 
                            $query->where($table.'.'.$param, '=',  $filters->query($field));
                        } else {
                            $query->where($table.'.'.$param, 'LIKE',  '%'.$filters->query($field).'%');
                        }
                    }
	            }
        	}
        }
        return $query->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $position_id = $request->user()->position_id;
        $kpi_question = [];
        if($position_id){
            $questions = Kpi::where('position_id', $position_id)
                            ->where('status', Kpi::$status['active'])
                            ->orderBy('sort')
                            ->get();

            foreach($questions as $question_index => $question){

                $answers = KpiAnswer::where('kpi_id', $question->id)
                                    ->where('status', KpiAnswer::$status['active'])
                                    ->orderBy('sort')
                                    ->get();

                foreach($answers as $answer_index => $answer){
                    $kpi_question[$question->sort][$question->name][$answer->sort]['answer'] = $answer->name;
                    $kpi_question[$question->sort][$question->name][$answer->sort]['points'] = $answer->points;
                }
            }
        }

        return view('user.user_kpi.create', [
            'kpi_question' => $kpi_question,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = static::userKpiStoreValidation($request);

        foreach ($data['attachment'] as $attachment) {
            $path = UserKpi::$path.'/';
            if (isset($attachment)) {
                $filename = $attachment->getClientOriginalName();
                $attachment->storeAs($path, $filename, 'public');
                $image[] = $filename;
            }
    	}   
        $comment = $data['comment'];
        unset($data['attachment']);
        unset($data['comment']);

        foreach($data as $name => $detail){
            $name = str_replace("kpi_answer_", "", $name);

            $json_data['kpi_answer'][$name] = $detail;
        }
        
        $position_name = $request->user()->position->name;

        $user_kpi = UserKpi::create([
            'user_id' => $request->user()->id,
            'type' => $position_name,
            'data' => json_encode($json_data),
            'final_data' => json_encode($json_data),
            'comment' => $comment,
            'status' => UserKpi::$status['pending'],
            'attachment' => json_encode($image),
        ]);

        if($user_kpi){
            request()->session()->flash('success','Kpi successfully added');
        } else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('user-kpi.index');
    }

    public static function userKpiStoreValidation($request){

        $position_id = $request->user()->position_id;

        $kpis = Kpi::where('position_id', $position_id)
                    ->where('status', Kpi::$status['active'])
                    ->select('sort')
                    ->get();

        foreach($kpis as $kpi){
            $validation_name = 'kpi_answer_'.$kpi->sort;

            $data[] = $request->validate([
                $validation_name => ['required'],
            ]);
        }

        $data[] = $request->validate([
            'comment' => ['nullable'],
            'attachment' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }

        return $validated;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $user_kpi = UserKpi::find($id);
        $position = Position::where('name', $user_kpi->type)->first();
        $position_id = $position->id;
        $total_points = 0;
        $kpi_question = [];
        if($position_id){
            $original_kpi = json_decode($user_kpi->data, true);

            $final_kpi = json_decode($user_kpi->final_data, true);

            $original_data = $original_kpi['kpi_answer'];

            $final_data = $final_kpi['kpi_answer'];
            
            $questions = Kpi::where('position_id', $position_id)
                            ->where('status', Kpi::$status['active'])
                            ->orderBy('sort')
                            ->get();
            foreach($questions as $question_index => $question){

                foreach($original_data as $question_sort => $answer_sort){
                    if($question_sort == $question->sort){
                        $answer = KpiAnswer::where('kpi_id', $question->id)
                                            ->where('status', KpiAnswer::$status['active'])
                                            ->where('sort', $answer_sort)
                                            ->first();

                        $kpi_question[$question->sort][$question->name]['original'][$answer->sort]['answer'] = $answer->name;
                        $kpi_question[$question->sort][$question->name]['original'][$answer->sort]['points'] = $answer->points;
                    }
                }

                foreach($final_data as $question_sort => $answer_sort){
                    if($question_sort == $question->sort){
                        $answer = KpiAnswer::where('kpi_id', $question->id)
                                            ->where('status', KpiAnswer::$status['active'])
                                            ->where('sort', $answer_sort)
                                            ->first();
                        if($answer_sort != $original_data[$question_sort]){
                            $kpi_question[$question->sort][$question->name]['final'][$answer->sort]['answer'] = $answer->name;
                            $kpi_question[$question->sort][$question->name]['final'][$answer->sort]['points'] = $answer->points;
                        }
                        $total_points = $total_points + $answer->points;
                    }
                }
            }
        }

        $kpis = json_decode($user_kpi->attachment);
        $kpi_image = [];
        foreach($kpis as $index => $kpi){
            $kpi_image[$index] = 'storage/'.UserKpi::$path.'/'.$kpi;
        }
        return view('user.user_kpi.show', [
            'user_kpi' => $user_kpi,
            'kpi_question' => $kpi_question ?? [],
            'kpi_image' => $kpi_image,
            'total_points' => $total_points,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);

        $slips = json_decode($sale->slip);
        $slip_image = [];
        foreach($slips as $index => $slip){
            $slip_image[$index] = 'storage/'.Sale::$path.'/'.$slip;
        }

        return view('user.sales.edit', [
            'sales' => $sale,
            'sales_status' => Sale::$sales_status,
            'sales_broker' => Sale::$broker,
            'slip_image' => $slip_image,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $data = static::saleUpdateValidation($request, $id);
        $image = [];
    	foreach ($data['slip'] as $slip) {

            $path = Sale::$path.'/'.$id;
            if (isset($slip)) {
                $filename = $slip->getClientOriginalName();
                $slip->storeAs($path, $filename, 'public');
                $image[] = $filename;
            }
    	}   

        $updateData = [
            'amount' => $data['amount'],
            'mt4_id' => $data['mt4_id'],
            'mt4_pass' => $data['mt4_pass'],
            'broker_type' => $data['broker_type'],
            'sales_status' => $data['sales_status'],
            'slip' => $image,
            'reason' => $data['reason'],
            'remark' => $data['remark'],
            'date' => $data['date'],
        ];

        $sale=Sale::findOrFail($id);

        if($sale){
            $sale->fill($updateData)->save();
            request()->session()->flash('success','Sales successfully updated');
        }else {
            request()->session()->flash('error','Error occurred, Please try again!');
        }

        return redirect()->route('sales.index');
    }

    public static function saleUpdateValidation($request, $id){

        $data[] = $request->validate([
            'amount' => ['required'],
            'mt4_id' => ['required'],
            'mt4_pass' => ['required'],
            'broker_type' => ['required'],
            'sales_status' => ['required'],
            'slip' => ['required'],
            'reason' => ['nullable'],
            'remark' => ['nullable'],
            'date' => ['required'],
        ]);

        $validated = [];
        foreach ($data as $value) {
            $validated = array_merge($validated, $value);
        }

        return $validated;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale=Sale::findOrFail($id);

        if($sale){
            // return $child_cat_id;
            $sale = Sale::where('id', $id)->update([
                'status' => Sale::$status['inactive'],
            ]);

            request()->session()->flash('success','Sales successfully deleted');
        } else {
            request()->session()->flash('error','Error while deleting Sales');
        }
        return redirect()->route('sales.index');
    }
    
}

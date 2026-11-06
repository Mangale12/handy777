<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityStatus;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActivityStatusController extends Controller
{

    public function index()
    {
        $activity_status = ActivityStatus::orderBy('status','asc')->get();
        return view('newLayout.activityStatus.index', compact('activity_status'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        if(isset($data['id'])){
            $activity_status = ActivityStatus::findOrFail($request->id);
            $activity_status->update(['status' => $data['status']]);
        }else{
            ActivityStatus::create($data);
        }
        Session::flash('success', 'Data Stored Successfully');
        return redirect()->route('activity.status.index');
    }

    public function delete($id)
    {
        $activity_status = ActivityStatus::findOrFail($id);
        $activity_status->delete();
        Session::flash('success', 'Data Deleted Successfully');
        return redirect()->route('activity.status.index');
    }

    public function changeActivityStatus(Request $request)
    {
        $forms = Form::with('activityStatus')->find($request->id);
        if(isset($forms)){
            $forms->update(['status_id' => $request->status]);
            return response()->json(['status' => 'ok', 'message' => 'Status Updated', 'data' => $forms], 200);
        }else{
            return response()->json(['status' => 'failed', 'message' => 'Status Update Failed.'], 422);
        }
    }
}

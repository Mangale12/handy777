<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

class ParticipantController extends Controller
{
    public function index(){
        $_panel = "participant";
        $_base_route = 'participants.';
        $participants = Participant::orderByDesc('id')->get();
        return view('participant.index', compact('_panel', '_base_route', 'participants'));
    }
    public function spinner(){
        dd('spinner');
        $participants = Participant::latest()->first();
        dd($participants);
        return view('participant.spinner', compact('participants'));
    } 
    public function create(){
        $_panel = "participant";
        return view('participant.form', compact('_panel'));
    }
    public function store(Request $request){
        $request->validate([
            'participants' =>'required',
            'winner' => 'required',
            
        ]);
        $participants = new Participant();
        $participants->participants = $request->participants;
        $participants->winner = $request->winner;
        $participants->save();
        return redirect()->route('participants.index')->with('success', 'Participant created successfully');
    }
    public function show(){
        // $participants = Participant::latest()->first();
        $participants = Participant::orderBy('id', 'desc')->first();
       
        return view('participant.spinner', compact('participants'));
    }
    public function edit($id){
        $participant = Participant::find($id);
        return view('participant.edit', compact('participant'));
    }
    public function update(Request $request, $id){
        $request->validate([
            'name' =>'required',
           
        ]);
        Participant::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'game_id' => $request->game_id,
            'balance' => $request->balance,
        ]);
        return redirect()->route('participants')->with('success', 'Participant updated successfully');
    }
    public function destroy($id){
        Participant::find($id)->delete();
        return redirect()->route('participants')->with('success', 'Participant deleted successfully');
    }
    public function participants(Request $request){
        
        $participants = new Participant();
        $participants->participants = $request->participants;
        $participants->winner = $request->winner;
        $participants->save();
        return response()->json(['success' => true]);
    }
    public function gameData() {
        $participants = Participant::latest()->first();
        return response()->json([
            'participants' => $participants->participants, 
            'winner' => $participants->winner
        ]);
    }
    

}

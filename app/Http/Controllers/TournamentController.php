<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tournament;
use App\Http\Requests\TournamentRequest;
use App\Http\Requests\TournamentUpdateRequest;
use Carbon\Carbon;
use DataTables;

class TournamentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $tournament = Tournament::orderBy('id','desc')->get();

            return Datatables::of($tournament)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action_buttons = '<a href="' . route("tournamentEdit", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-success" data-toggle="tooltip" data-placement="right" title="Edit Tournament" style="color:#fff !important" >Edit<i class="fas fa-edit" ></i></a><a href="' . route("tournamentdelete", $row->id) . '" data-id="' . $row->id . '" class="text-dark btn btn-danger" data-toggle="tooltip" data-placement="right" title="Delete Tournament" style="color:#fff !important" >Delete<i class="fas fa-trash" ></i></a>';
                    return $action_buttons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('tournament.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tournament = new Tournament;
        $action     = "0";
        return view('tournament.create',compact('tournament','action'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(TournamentRequest $request)
    {
        $todayTime    = Carbon::now();
        $tournament = new Tournament;
            $tournament->tournament_name        = $request->tournament_name;
            $tournament->bet_amount             = $request->bet_amount;
            $tournament->commission             = $request->commission;
            $tournament->no_players             = $request->no_players;
            $tournament->no_of_winners          = $request->no_of_winners;
            $tournament->two_player_winning     = ($request->no_players == 2 && $request->two_player_winning != '' ? $request->two_player_winning : null);
            $tournament->four_player_winning_1  = ($request->no_players == 4 && $request->four_player_winning_1 != '' ? $request->four_player_winning_1 : null);
            $tournament->four_player_winning_2  = ($request->no_players == 4 && $request->four_player_winning_2 != '' ? $request->four_player_winning_2 : null);
            $tournament->four_player_winning_3  = ($request->no_players == 4 && $request->four_player_winning_3 != '' ? $request->four_player_winning_3 : null);
       
            $tournament->start_time             = $todayTime->format("H:m:s");
            $tournament->tournament_interval    = $request->tournament_interval;
        $tournament->save();

        if($tournament->id){
            notify()->success("Tournament is Created successfully","Success","topRight");
            return view('/tournament/list');
            // return redirect('/tournament/list')->with(['Success'=>'Tournament is created successfully']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tournament = Tournament::where('id',$id)->first();
        $action            = "1";
        return view('tournament.create',compact('tournament','action'));
    }

    public function delete($id)
    {
        $tournament = Tournament::where('id',$id)->delete();
        // $action            = "1";
        return view('/tournament/list');
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(TournamentUpdateRequest $request,$id){


        if($request->no_players == 2 && $request->two_player_winning != ''){
            $commission         = $request->bet_amount - $request->two_player_winning;
        }
        if($request->no_players == 4 && ($request->four_player_winning_1 != '' || $request->four_player_winning_2 != '' || $request->four_player_winning_3 != '')){
            $winning_amt = $request->four_player_winning_1 + $request->four_player_winning_2 +$request->four_player_winning_3;
            $commission         = $request->bet_amount - $winning_amt;
        }

        $tournament = Tournament::where('id', $id)->update([
            'tournament_name'       => $request->tournament_name,
            'bet_amount'            => $request->bet_amount,
           
            'no_players'            => $request->no_players,
            'no_of_winners'         => $request->no_of_winners,
            'two_player_winning'    => ($request->no_players == 2 && $request->two_player_winning != '' ? $request->two_player_winning : null),
            'four_player_winning_1'  => ($request->no_players == 4 && $request->four_player_winning_1 != '' ? $request->four_player_winning_1 : null),
            'four_player_winning_2'  => ($request->no_players == 4 && $request->four_player_winning_2 != '' ? $request->four_player_winning_2 : null),
            'four_player_winning_3'  => ($request->no_players == 4 && $request->four_player_winning_3 != '' ? $request->four_player_winning_3 : null),
            'tournament_interval'   => $request->tournament_interval
        ]);

        if($tournament){
            notify()->success("Tournament is Update successfully","Success","topRight");
            return view('/tournament/list');
            // return redirect('/tournament/list')->with(['Success'=>'Tournament is Update successfully']);
        }
    }

}

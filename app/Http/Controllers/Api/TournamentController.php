<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tournament;
use Carbon\Carbon;
use App\Models\TournamentRegistartion;
use Illuminate\Support\Facades\Validator;
use App\Models\WalletDetail;
use App\Models\WalletTranscationDetails;
use App\Models\BonusWalletDetail;
use App\Models\BonusWalletTranscationDetail;

class TournamentController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tournamentList()
    {
        $tournament = Tournament::get();
        $todayTime = Carbon::now();
        //     $todayTime  = Carbon::createFromFormat('Y-m-d H:i:s', $some_date, 'UTC')
        // ->setTimezone('America/Los_Angeles')

        foreach ($tournament as $key => $value) {
            $start = $todayTime->format("Y-m-d") . ' ' . $value->start_time;
            $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
            $end = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes($value->tournament_interval);

            $totalmin = $todayTime->diff($end)->format('%I');
            $totalsec = $todayTime->diff($end)->format('%S');
            $totalDuration = $totalmin * 60 + $totalsec;
            // dd($startTime,$end,$totalDuration);

            $data[$key]['id'] = $value->id;
            $data[$key]['tournament_name'] = $value->tournament_name;
            $data[$key]['bet_amount'] = $value->bet_amount;
            $data[$key]['commission'] = $value->commission;
            $data[$key]['no_players'] = $value->no_players;
            $data[$key]['start_time'] = $value->start_time;
            $data[$key]['end_time'] = $value->end_time;
            $data[$key]['tournament_interval'] = $value->tournament_interval;
            $data[$key]['pending_time'] = $totalDuration;
            $data[$key]['status'] = $value->tournament_interval;
            $data[$key]['two_player_winning'] = $value->two_player_winning;
            $data[$key]['no_of_winners'] = $value->no_of_winners;
            $data[$key]['four_player_winning_1'] = $value->four_player_winning_1;
            $data[$key]['four_player_winning_2'] = $value->four_player_winning_2;
            $data[$key]['four_player_winning_3'] = $value->four_player_winning_3;

        }

        $response = ['status' => 'Success', 'message' => 'Tournament Listed Successfully', 'data' => $data];
        return response($response, 200, $data);
    }

    /**
     * Show the form for Update a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tournamentUpdate(Request $request)
    {
        $todayTime = Carbon::now();
        $tournament = Tournament::where('id', $request->id)->first();
        $start = $todayTime->format("Y-m-d") . ' ' . $tournament->start_time;
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes($tournament->tournament_interval);
        $totalmin = $todayTime->diff($end)->format('%I');
        $totalsec = $todayTime->diff($end)->format('%S');
        $totalDuration = $totalmin * 60 + $totalsec;
        $tournamentcount = TournamentRegistartion::where('tournament_id', $request->id)->get()->count();
        $tournamentregisterchecks = TournamentRegistartion::where('player_id', $request->player_id)->where('tournament_id', $request->id)->get()->count();
        $tournamentregistercheck = TournamentRegistartion::where('player_id', $request->player_id)->where('tournament_id', $request->id)->first();
        if ($tournamentregistercheck) {
            $operator = $tournamentregistercheck->type;
            $p_money = $tournamentregistercheck->play_money;
            $b_money = $tournamentregistercheck->bonus_money;
        } else {
            $operator = '';
            $p_money = '';
            $b_money = '';
        }

        $response = ['status' => 'Success', 'data' => $tournament, 'remainingtime' => $totalDuration, 'count' => $tournamentcount, 'registered' => $tournamentregisterchecks, 'operator' => $operator, 'playmoney' => $p_money, 'bonusmoney' => $b_money];
        return response($response, 200);
    }

    /**
     * Show the form for Update a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tournament15Min()
    {
        $todayTime = Carbon::now();

        $tournament = Tournament::where('tournament_interval', '3')->first();
        // $end = Carbon::createFromFormat('Y-m-d H:i:s', $tournament->start_time)->addMinutes($tournament->tournament_interval);
        //$end=$tournament->end_time;

        $start = $todayTime->format("Y-m-d") . ' ' . $tournament->start_time;
        $startTime = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes($tournament->tournament_interval);
        $totalmin = $todayTime->diff($end)->format('%I');
        $totalsec = $todayTime->diff($end)->format('%S');
        $totalDuration = $totalmin * 60 + $totalsec;
        //  $duration_match=$tournament->tournament_interval;

        $tournament1 = Tournament::where('tournament_interval', '5')->first();
        // $end = Carbon::createFromFormat('Y-m-d H:i:s', $tournament->start_time)->addMinutes($tournament->tournament_interval);
        //$end=$tournament->end_time;

        $start1 = $todayTime->format("Y-m-d") . ' ' . $tournament1->start_time;
        $startTime1 = Carbon::createFromFormat('Y-m-d H:i:s', $start1);
        $end1 = Carbon::createFromFormat('Y-m-d H:i:s', $start1)->addMinutes($tournament1->tournament_interval);
        $totalmin1 = $todayTime->diff($end1)->format('%I');
        $totalsec1 = $todayTime->diff($end1)->format('%S');
        $totalDuration1 = $totalmin1 * 60 + $totalsec1;
        // $duration_match1=$tournament1->tournament_interval;




        $response = ['status' => 'Success', '3min' => $totalDuration, '5min' => $totalDuration1];
        return response($response, 200);
    }
    /**
     * Show the form for Update a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tournament30Min(Request $request)
    {
        $todayTime = Carbon::now();
        $start = $todayTime->format("Y-m-d H:i:s");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(1);
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(30);

        $tournament = Tournament::where('tournament_interval', 30)->update([
            'end_time' => $end_time,
            'start_time' => $end,
        ]);
        $tournament = Tournament::where('tournament_interval', 30)->get();

        foreach ($tournament as $tour) {
            $register = TournamentRegistartion::where('tournament_id', $tour->id)->delete();

        }


        $response = ['status' => 'Success', 'message' => 'Tournament Completed ', 'data' => $tournament];
        return response($response, 200);
    }



    public function tournament1Min()
    {
        $todayTime = Carbon::now();
        $start = $todayTime->format("Y-m-d H:i:s");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(1);

        $tournament = Tournament::where('tournament_interval', 1)->update([
            'end_time' => $end_time,
            'start_time' => $end,
        ]);
        $tournament = Tournament::where('tournament_interval', 1)->get();

        foreach ($tournament as $tour) {
            $register = TournamentRegistartion::where('tournament_id', $tour->id)->delete();

        }


        $response = ['status' => 'Success', 'message' => 'Tournament Completed ', 'data' => $tournament];
        return response($response, 200);
    }
    public function tournament3Min()
    {
        $todayTime = Carbon::now();
        $start = $todayTime->format("Y-m-d H:i:s");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(3);

        $tournament = Tournament::where('tournament_interval', 3)->update([
            'end_time' => $end_time,
            'start_time' => $end,
        ]);
        $tournament = Tournament::where('tournament_interval', 3)->get();

        foreach ($tournament as $tour) {
            $register = TournamentRegistartion::where('tournament_id', $tour->id)->delete();

        }

        $response = ['status' => 'Success', 'message' => 'Tournament Completed ', 'data' => $tournament];
        return response($response, 200);
    }
    public function tournament5Min()
    {
        $todayTime = Carbon::now();
        $start = $todayTime->format("Y-m-d H:i:s");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(5);
        $tournament = Tournament::where('tournament_interval', 5)->update([
            'end_time' => $end_time,
            'start_time' => $end,
        ]);
        $tournament = Tournament::where('tournament_interval', 5)->get();
        foreach ($tournament as $tour) {
            $register = TournamentRegistartion::where('tournament_id', $tour->id)->delete();
        }


        $response = ['status' => 'Success', 'message' => 'Tournament Completed ', 'data' => $tournament];
        return response($response, 200);
    }


    public function tournament8Min()
    {
        $todayTime = Carbon::now();
        $start = $todayTime->format("Y-m-d H:i:s");
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(1);
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $start)->addMinutes(8);

        $tournament = Tournament::where('tournament_interval', 8)->update([
            'end_time' => $end_time,
            'start_time' => $end,
        ]);
        $tournament = Tournament::where('tournament_interval', 8)->get();

        foreach ($tournament as $tour) {
            $register = TournamentRegistartion::where('tournament_id', $tour->id)->delete();

        }


        $response = ['status' => 'Success', 'message' => 'Tournament Completed ', 'data' => $tournament];
        return response($response, 200);
    }
    /**
     * Show the form for Update a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tournamentRegistartion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
            'tournament_id' => 'required',
            'use_of' => 'required',
            'notes' => 'required',
            'play_amount' => 'required',

        ]);
        $todayTime = Carbon::now();
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        if ($request->refund != null) {

            $walletDetail = WalletDetail::where('player_id', $request->player_id)->first();
            if ($walletDetail != null && $request->play_amount != '0') {
                $walletSaveDetail = WalletDetail::where('player_id', $request->player_id)->update([
                    'total_amt_load' => $walletDetail->total_amt_load + $request->play_amount,
                    'current_amount' => $walletDetail->current_amount + $request->play_amount,
                    'no_of_load' => $walletDetail->no_of_load + 1,
                    'last_load_date' => $todayTime->format("Y-m-d"),
                ]);


                $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id = $request->player_id;
                $transcationDetail->wallet_id = $walletDetail->id;
                $transcationDetail->type = 'credit';
                $transcationDetail->use_of = $request->use_of;
                $transcationDetail->notes = $request->notes;
                $transcationDetail->trans_date = $todayTime->format("Y-m-d");
                $transcationDetail->amount = $request->play_amount;
                $transcationDetail->wallet_type = 'play_balance';
                $transcationDetail->save();

                $data = $transcationDetail;
            }
            $walletDetail = BonusWalletDetail::where('player_id', $request->player_id)->first();

            if ($walletDetail != null && $request->bonus_amount != '0') {
                $walletSaveDetail = BonusWalletDetail::where('player_id', $request->player_id)->update([
                    'total_amt_added' => $walletDetail->total_amt_added + $request->bonus_amount,
                    'current_amount' => $walletDetail->current_amount + $request->bonus_amount,
                    'last_added_date' => $todayTime->format("Y-m-d"),
                ]);

                $bonustranscationDetail = new WalletTranscationDetails;
                $bonustranscationDetail->player_id = $request->player_id;
                $bonustranscationDetail->wallet_id = $walletDetail->id;
                $bonustranscationDetail->type = 'credit';
                $bonustranscationDetail->amount = $request->bonus_amount;
                $bonustranscationDetail->trans_date = $todayTime->format("Y-m-d");
                $bonustranscationDetail->use_of = $request->use_of;
                $bonustranscationDetail->notes = $request->notes;
                $bonustranscationDetail->wallet_type = 'bonus_balance';
                $bonustranscationDetail->save();

                $bonusdata = $bonustranscationDetail;


            }

            $response = ['status' => 'refunded'];
            return response($response, 200);
        } else {
            $todayTime = Carbon::now();
            // $tour_registration = TournamentRegistartion::where('register_date',$todayTime->format("Y-m-d"))->orderBy('id', 'DESC')->first();

            $tour_registration = TournamentRegistartion::where('tournament_id', $request->tournament_id)->where('register_date', $todayTime->format("Y-m-d"))->orderBy('id', 'DESC')->first();

            if ($tour_registration == null) {
                $type = 'creater';

                $room_no = 1;
            } else {
                $room = $tour_registration->room_no;
                if ($request->players == '2') {
                    if ($tour_registration->type == 'creater') {
                        $type = 'joiner';
                        $room_no = $room;
                    } else {
                        $type = 'creater';
                        $room_no = $room + 1;
                    }

                } else {
                    $room = $tour_registration->room_no;
                    if ($tour_registration->type == 'creater') {
                        $type = 'joiner_1';
                        $room_no = $room;
                    } else if ($tour_registration->type == 'joiner_1') {
                        $type = 'joiner_2';
                        $room_no = $room;
                    } else if ($tour_registration->type == 'joiner_2') {
                        $type = 'joiner_3';
                        $room_no = $room;
                    } else if ($tour_registration->type == 'joiner_3') {
                        $type = 'creater';
                        $room_no = $room + 1;
                    }



                }

            }

            $tournament = TournamentRegistartion::create([
                'player_id' => $request->player_id,
                'tournament_id' => $request->tournament_id,
                'type' => $type,
                'register_date' => $todayTime->format("Y-m-d"),
                'play_money' => $request->play_amount,
                'bonus_money' => $request->bonus_amount,
                'room_no' => $room_no
            ]);

            $walletDetail = WalletDetail::where('player_id', $request->player_id)->first();
            if ($walletDetail != null && $request->play_amount != '' && $request->play_amount != '0') {
                $walletSaveDetail = WalletDetail::where('player_id', $request->player_id)->update([
                    'total_amt_withdraw' => $walletDetail->total_amt_withdraw + $request->play_amount,
                    'current_amount' => $walletDetail->current_amount - $request->play_amount,
                    'no_of_withdraw' => $walletDetail->no_of_withdraw + 1,
                    'last_withdraw_date' => $todayTime->format("Y-m-d"),
                ]);


                $transcationDetail = new WalletTranscationDetails;
                $transcationDetail->player_id = $request->player_id;
                $transcationDetail->wallet_id = $walletDetail->id;
                $transcationDetail->type = 'debit';
                $transcationDetail->use_of = $request->use_of;
                $transcationDetail->notes = $request->notes;
                $transcationDetail->trans_date = $todayTime->format("Y-m-d");
                $transcationDetail->amount = $request->play_amount;
                $transcationDetail->wallet_type = 'play_balance';
                $transcationDetail->save();

                $data = $transcationDetail;

            }
            $bonuswalletDetail = BonusWalletDetail::where('player_id', $request->player_id)->first();


            if ($bonuswalletDetail != null && $request->bonus_amount != '' && $request->bonus_amount != '0') {
                $bonuswalletSaveDetail = BonusWalletDetail::where('player_id', $request->player_id)->update([
                    'total_amt_used' => $bonuswalletDetail->total_amt_used + $request->bonus_amount,
                    'current_amount' => $bonuswalletDetail->current_amount - $request->bonus_amount,
                    'last_used_date' => $todayTime->format("Y-m-d"),
                ]);


                $bonustranscationDetail = new WalletTranscationDetails;
                $bonustranscationDetail->player_id = $request->player_id;
                $bonustranscationDetail->wallet_id = $walletDetail->id;
                $bonustranscationDetail->type = 'debit';
                $bonustranscationDetail->amount = $request->bonus_amount;
                $bonustranscationDetail->trans_date = $todayTime->format("Y-m-d");
                $bonustranscationDetail->use_of = $request->use_of;
                $bonustranscationDetail->notes = $request->notes;
                $bonustranscationDetail->wallet_type = 'bonus_balance';
                $bonustranscationDetail->save();

                $bonusdata = $bonustranscationDetail;


            }

            $response = ['status' => 'Success', 'operator' => $type, 'room_no' => $room_no];
            return response($response, 200);
        }
    }

    public function tournamentRegistartionList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'player_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $todayTime = Carbon::now();
        $tournament = TournamentRegistartion::where('player_id', $request->player_id)->where('register_date', $todayTime->format("Y-m-d"))->get();
        $response = ['status' => 'Success', 'message' => 'Tournament Registered ', 'data' => $tournament];
        return response($response, 200);
    }

    public function tournamentRegistartionOverallList(Request $request)
    {
        $todayTime = Carbon::now();

        $tournament = TournamentRegistartion::where('register_date', $todayTime->format("Y-m-d"))->get();
        $response = ['status' => 'Success', 'message' => 'Tournament Registered List', 'data' => $tournament];
        return response($response, 200);
    }

    public function tournamentRegistartionCount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tournament_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }

        $tournament = TournamentRegistartion::where('tournament_id', $request->tournament_id)->get()->count();
        $response = ['status' => 'Success', 'message' => 'Tournament Registered Count', 'data' => $tournament];
        return response($response, 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlayersDetail;
use App\User;
use App\Models\BonusWalletDetail;
use App\Models\WalletDetail;
use App\Models\WalletTranscationDetails;
use App\Models\BonusWalletTranscationDetail;
use App\Models\WithdrawTranscationDetail;
class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $players = PlayersDetail::with('user')->get();
        //dd($players);
        $count = '1';
        return view('players.list', compact('players', 'count'));
    }

    public function create()
    {
        return view('players.edit');
    }

    public function edit($id)
    {
        $player = PlayersDetail::where('id', $id)->with('user', 'wallet_id', 'bonus_wallet_id')->first();
        // dd($player);    
        return view('players.edit', compact('player'));
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
        $player = PlayersDetail::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'no_of_participate' => $request->no_of_participate,
            'no_of_loose' => $request->no_of_loose,
            'no_of_total_win' => $request->no_of_total_win,
            'no_of_2win' => $request->no_of_2win,
            'no_of_4win' => $request->no_of_4win,
            'device_type' => $request->device_type,
            'banned' => $request->banned
        ]);
        if ($player) {
            notify()->success("Updated Successfully!", "Success", "topRight");
            //return view('/player/list');
            // alert()->success('Updated Successfully!','Success')->autoclose(10000);
            return redirect()->route('player.list');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $userId = PlayersDetail::where('id', $id)->first();
        $wallet = WalletDetail::where('player_id', $userId->user_id)->delete();

        $bonusWallet = BonusWalletDetail::where('player_id', $userId->user_id)->delete();

        $record = PlayersDetail::where('id', $id)->delete();
        $user = User::where('id', $userId->user_id)->delete();
        $wallettxn = WalletTranscationDetails::where('player_id', $userId->user_id)->delete();
        $bonusWallettxn = BonusWalletTranscationDetail::where('player_id', $userId->user_id)->delete();
        $withdrawtxn = WithdrawTranscationDetail::where('player_id', $userId->user_id)->delete();
        notify()->success("Deleted Successfully!", "Error", "topRight");
        return redirect()->route('player.list');
    }

    public function playerDetail($id)
    {
        $playerDetail = PlayersDetail::where('id', $id)->with('user', 'wallet_id', 'bonus_wallet_id')->get();
        return redirect()->route('player.list', compact('playerDetail'));

    }
    public function listPlayers()
    {
        $players = PlayersDetail::with('user')->get();  // Ensure 'user' relationship exists
        return view('index', compact('players'));
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function get_player_view(Request $request)
    {
        $Player = PlayersDetail::with('user', 'wallet')->where('id', $request->id)->first();

        if (!$Player) {
            return response()->json(['message' => 'Player not found'], 404);
        }

        // Now it's safe to access properties
        return response()->json(['wallet_id' => $Player->wallet_id]);
        $user_detail = $Player->user;

        $html = "<div class='center'>
                <img src='" . asset('/player/images/' . $Player->profile_image) . "' height='100px;' width='100px;' style='float:left;'>
                <p class='center-text'><b>$Player->first_name $Player->last_name <b></p>
            </div>
            
        <table class='table table-bordered'>                                      
                    <tr>
                        <td><b>Email</b></td>
                        <td>$user_detail->email</td>
                    </tr>
                    <tr>
                        <td><b>Mobile Number</b></td>
                        <td>$user_detail->mobile_no</td>
                    </tr>
                    <tr>
                        <td><b>2 Player Matches won</b></td>
                        <td>$Player->no_of_2win</td>
                    </tr>
                    <tr>
                        <td><b>4 Player Matches won</b></td>
                        <td>$Player->no_of_4win</td>
                    </tr>
                    <tr>
                        <td><b>Matches Won</b></td>
                        <td>$Player->no_of_total_win</td>
                    </tr>
                    <tr>
                        <td><b>Matches Lost</b></td>
                        <td>$Player->no_of_loose</td>
                    </tr>
                    <tr>
                        <td><b>Wallet Balance</b></td>
                        <td>$wallet_detail->current_amount</td>
                    </tr>
                    <tr>
                        <td><b>Amount Withdrawn</b></td>
                        <td>$wallet_detail->total_amt_withdraw</td>
                    </tr>  
                                     
                </table>";

        return response()->json($html);
    }

}

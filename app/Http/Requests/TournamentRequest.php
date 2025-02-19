<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TournamentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {  
        return [
            'tournament_name'            =>  'required',
            'bet_amount'                 =>  'required',
            // 'commission'                 =>  'required',
            'no_players'                  =>  'required',
            'tournament_interval'        =>  'required|max:255',
            'status'                    =>  'required|boolean',
        ];
       
    }

    public function messages()
    {
        return [
            'tournament_name.required'          =>  'Select the branch name is required',
            'bet_amount.required'                 =>  'Please the enter Menu name in english',
            // 'commission.required'               =>  'Please the enter barcode is required',
            'no_players.required'               =>  'Menu name in English is already exist',
            'tournament_interval.required'      =>  'Menu Barcode is already exist',
            'status.required'                   =>  'Menu Barcode is already exist',
        ];
    }
}

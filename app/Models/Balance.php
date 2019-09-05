<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\User;

class Balance extends Model
{
    public $timestamps = false;

    public function deposit(float $value): array
    {
        DB::beginTransaction();

        $totalBefore =  $this->amount ? $this->amount : 0;
        $this->amount += number_format($value, 2, '.', ',');
        $retirada = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' =>  $this->amount,
            'date' => date('Ymd'),
        ]);

        if ($retirada && $historic) {

            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao recarregar'
            ];
        } else {

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao carregar'
            ];
        }
    }

    public function withdraw(float $value): array
    {

        if ($this->amount <= $value) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente',
            ];
        }
        DB::beginTransaction();

        $totalBefore =  $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', ',');
        $retirada = $this->save();

        $historic = auth()->user()->historics()->create([
            'type' => 'O',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' =>  $this->amount,
            'date' => date('Ymd'),
        ]);

        if ($retirada && $historic) {

            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao retirar'
            ];
        } else {

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao retirar'
            ];
        }
    }

    public function transfer(float $value, User $sender): array
    {

        if ($this->amount <= $value) {
            return [
                'success' => false,
                'message' => 'Saldo insuficiente',
            ];
        }
        DB::beginTransaction();

        /*****************************************************
         * Atualiza o póprio saldo
         *****************************************************/

        $totalBefore =  $this->amount ? $this->amount : 0;
        $this->amount -= number_format($value, 2, '.', ',');
        $transfer = $this->save();
        //dd($sender->id);
        $historic = auth()->user()->historics()->create([
            'type' => 'T',
            'amount' => $value,
            'total_before' => $totalBefore,
            'total_after' =>  $this->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => $sender->id,
        ]);

        /*****************************************************
         * Atualiza o saldo do recebedor
         *****************************************************/
        $senderBalance = $sender->balance()->firstOrCreate([]); //o metodo firstOrCreate serve epara criar o registrop na tabela caso ainda não tenha sido feito este procedimento antes
        $sendertotalBefore =  $senderBalance->amount ? $senderBalance->amount : 0;
        $senderBalance->amount += number_format($value, 2, '.', ',');
        $senderTransfer = $senderBalance->save();

        $senderHistoric = auth()->user()->historics()->create([
            'type' => 'I',
            'amount' => $value,
            'total_before' => $sendertotalBefore,
            'total_after' =>  $senderBalance->amount,
            'date' => date('Ymd'),
            'user_id_transaction' => auth()->user()->id,
        ]);

        if ($transfer && $historic && $senderTransfer && $senderHistoric) {

            DB::commit();

            return [
                'success' => true,
                'message' => 'Sucesso ao tranferir'
            ];
        } else {

            DB::rollback();

            return [
                'success' => false,
                'message' => 'Falha ao transferir'
            ];
        }
    }
}

<?php

namespace App\Http\Repository;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Log; 

class TransationRepository
{
    /**
     * Realiza um depósito para o próprio usuário.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function depositar(Request $request)
    {
        $valorInput = $request->input('valor_deposito');
        $valorInput = str_replace('.', '', $valorInput); // Remove os pontos (separadores de milhares)
        $valorInput = str_replace(',', '.', $valorInput); // Substitui a vírgula (separador decimal) por ponto
        $request->merge(['valor_deposito' => $valorInput]);

        $request->validate([
            'valor_deposito' => 'required|numeric|min:0.01',
        ]);


        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não autenticado.');
        }
        $valorDeposito = (float) $request->input('valor_deposito');
        DB::beginTransaction();

        try {
            $user->saldo = $user->saldo + $valorDeposito;
            $user->save();

            $user->sentTransactions()->create([
                'tipo' => 'deposito',
                'valor' => $valorDeposito,
                'status' => 'concluida',
                'recebedor_user_id' => null,
            ]);

            DB::commit();
            return redirect()->route('home')->with('success', 'Depósito realizado com sucesso!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Erro ao realizar depósito para ' . ($user ? $user->email : 'usuário desconhecido') . ': ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->route('home')
                             ->withInput()
                             ->with('error', 'Não foi possível realizar o depósito. Por favor, tente novamente mais tarde.');
        }
    }
    /**
     * Realiza a transferência de valores de uma conta para outra.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transferir(Request $request)
    {
        //  Processar o valor da transferência (remover milhares e converter vírgula para ponto)
        $valorInput = $request->input('valor_transferencia');
        $valorInput = str_replace('.', '', $valorInput); 
        $valorInput = str_replace(',', '.', $valorInput); 
        $request->merge(['valor_transferencia' => $valorInput]);

        //  Validação dos dados
        $request->validate([
            'valor_transferencia' => 'required|numeric|min:0.01',
            'conta_destinatario' => 'required|integer|exists:users,conta',
        ]);

        $remetente = Auth::user(); // O usuário logado é o remetente
        $valorTransferencia = (float) $request->input('valor_transferencia');
        $contaDestinatario = $request->input('conta_destinatario');

        //  Encontrar o usuário destinatário pelo número da conta 'conta'
        $destinatario = User::where('conta', $contaDestinatario)->first();

        //  Validações adicionais de negócio
        if (!$remetente || !$destinatario) {
            return redirect()->back()->with('error', 'Erro: Usuário remetente ou destinatário não encontrado.');
        }

        // Verifica se o número da conta do remetente é o mesmo do destinatário (usando $remetente->conta)
        if ($remetente->conta === $destinatario->conta) {
            return redirect()->back()->withInput()->with('error', 'Não é possível transferir para a própria conta.');
        }

        if ($remetente->saldo < $valorTransferencia) {
            return redirect()->back()->withInput()->with('error', 'Saldo insuficiente para realizar a transferência.');
        }

        //  Iniciar uma transação de banco de dados para garantir atomicidade
        DB::beginTransaction();

        try {
            //  Debitar do saldo do remetente
            $remetente->saldo -= $valorTransferencia;
            $remetente->save();

            //  Creditar no saldo do destinatário
            $destinatario->saldo += $valorTransferencia;
            $destinatario->save();

            //  Registrar as duas transações (uma para o remetente e outra para o destinatário)
            $remetente->sentTransactions()->create([
                'user_id' => $remetente->id,
                'tipo' => 'transferencia_enviada',
                'valor' => $valorTransferencia,
                'status' => 'concluida',
                'recebedor_user_id' => $destinatario->id,
            ]);

            $destinatario->receivedTransactions()->create([
                'user_id' => $destinatario->id,
                'tipo' => 'transferencia_recebida',
                'valor' => $valorTransferencia,
                'status' => 'concluida',
                'remetente_user_id' => $remetente->id,
            ]);

            //  Confirmar a transação no banco de dados
            DB::commit();

            // Ajustar mensagem de sucesso para incluir o número da conta ou nome
            return redirect()->route('home')->with('success', 'Transferência de R$ ' . number_format($valorTransferencia, 2, ',', '.') . ' para a conta ' . $destinatario->conta . ' (' . $destinatario->nome . ') realizada com sucesso!');

        } catch (Exception $e) {
            //  Reverter a transação em caso de erro
            DB::rollBack();

            // Ajustar mensagem de log para usar 'conta'
            Log::error('Erro ao realizar transferência de conta ' . $remetente->conta . ' para conta ' . $destinatario->conta . ': ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Não foi possível realizar a transferência. Por favor, tente novamente mais tarde.');
        }
    }
  
}
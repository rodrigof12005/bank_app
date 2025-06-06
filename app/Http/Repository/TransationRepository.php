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
        // 1. **AJUSTE AQUI: Remover separador de milhares E DEPOIS converter vírgula para ponto**
        $valorInput = $request->input('valor_deposito');
        $valorInput = str_replace('.', '', $valorInput); // Remove os pontos (separadores de milhares)
        $valorInput = str_replace(',', '.', $valorInput); // Substitui a vírgula (separador decimal) por ponto
        $request->merge(['valor_deposito' => $valorInput]);
             


        // 2. Validação do valor do depósito
        $request->validate([
            'valor_deposito' => 'required|numeric|min:0.01',
        ]);


        // 3. Obter o usuário logado
        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Usuário não autenticado.');
        }

        $valorDeposito = (float) $request->input('valor_deposito');

        // 4. Iniciar uma transação de banco de dados
        DB::beginTransaction();

        try {
            // 5. Atualizar o saldo do usuário
            $user->saldo = $user->saldo + $valorDeposito;
            $user->save();

            // 6. Registrar a transação na tabela 'transactions'
            $user->sentTransactions()->create([
                'tipo' => 'deposito',
                'valor' => $valorDeposito,
                'status' => 'concluida',
                'recebedor_user_id' => null,
            ]);

            // 7. Confirmar a transação no banco de dados
            DB::commit();

            return redirect()->route('home')->with('success', 'Depósito realizado com sucesso!');

        } catch (Exception $e) {
            // 8. Reverter a transação em caso de erro
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
        // 1. Processar o valor da transferência (remover milhares e converter vírgula para ponto)
        $valorInput = $request->input('valor_transferencia');
        $valorInput = str_replace('.', '', $valorInput); // Remove os pontos (separadores de milhares)
        $valorInput = str_replace(',', '.', $valorInput); // Substitui a vírgula (separador decimal) por ponto
        $request->merge(['valor_transferencia' => $valorInput]);

        // 2. Validação dos dados
        $request->validate([
            'valor_transferencia' => 'required|numeric|min:0.01',
            // AJUSTE AQUI: Validar a coluna 'conta'
            // O tipo 'integer' ou 'numeric' é mais adequado para bigInteger
            // Se tiver um tamanho fixo, pode usar 'digits:X' ou 'digits_between:X,Y'
            'conta_destinatario' => 'required|integer|exists:users,conta',
        ]);

        $remetente = Auth::user(); // O usuário logado é o remetente
        $valorTransferencia = (float) $request->input('valor_transferencia');
        // AJUSTE AQUI: Pegar o número da conta do destinatário. Usarei 'conta_destinatario' como nome do campo do formulário.
        $contaDestinatario = $request->input('conta_destinatario');

        // 3. Encontrar o usuário destinatário pelo número da conta 'conta'
        $destinatario = User::where('conta', $contaDestinatario)->first();

        // 4. Validações adicionais de negócio
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

        // 5. Iniciar uma transação de banco de dados para garantir atomicidade
        DB::beginTransaction();

        try {
            // 6. Debitar do saldo do remetente
            $remetente->saldo -= $valorTransferencia;
            $remetente->save();

            // 7. Creditar no saldo do destinatário
            $destinatario->saldo += $valorTransferencia;
            $destinatario->save();

            // 8. Registrar as duas transações (uma para o remetente e outra para o destinatário)
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

            // 9. Confirmar a transação no banco de dados
            DB::commit();

            // Ajustar mensagem de sucesso para incluir o número da conta ou nome
            return redirect()->route('home')->with('success', 'Transferência de R$ ' . number_format($valorTransferencia, 2, ',', '.') . ' para a conta ' . $destinatario->conta . ' (' . $destinatario->nome . ') realizada com sucesso!');

        } catch (Exception $e) {
            // 10. Reverter a transação em caso de erro
            DB::rollBack();

            // Ajustar mensagem de log para usar 'conta'
            Log::error('Erro ao realizar transferência de conta ' . $remetente->conta . ' para conta ' . $destinatario->conta . ': ' . $e->getMessage(), ['exception' => $e]);

            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Não foi possível realizar a transferência. Por favor, tente novamente mais tarde.');
        }
    }
  
}
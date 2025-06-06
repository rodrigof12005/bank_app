@extends('layouts.sistema.layout-padrao')

@section('title', 'Visão Geral da Conta')

@section('content')
    {{-- Bloco para mensagens de sucesso, erro e info --}}
    @if (session('success'))
        <div id="autoDismissSuccessAlert" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        {{-- ID  DO ERRO --}}
        <div id="autoDismissErrorAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="mb-4 text-primary">Bem-vindo(a), {{ Auth::user()->nome  }}!</h1>
    <p class="lead">Esta é a visão geral da sua conta.</p>

    <div class="row mt-5">
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card highlight-card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-muted">Saldo Disponível</h5>
                    <p class="card-text fs-1 fw-bold text-success">
                        R$ {{ number_format(Auth::user()->saldo ?? 0, 2, ',', '.') }} {{-- Exibe o saldo --}}
                    </p>
                    <small class="text-muted">Atualizado em: {{ now()->format('d/m/Y H:i') }}</small>
                </div>
            </div>
        </div>

       

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    Acesso Rápido
                </div>
                <div class="card-body">
    <div class="d-flex flex-wrap gap-2">
        <a href="{{route ('novo-deposito')}}" class="btn btn-outline-success d-flex flex-column align-items-center p-3">
            <i class="bi bi-wallet fs-3"></i> 
            <span>Depositar</span> 
        </a>
        <a href="{{route('nova-transferencia')}}" class="btn btn-outline-primary d-flex flex-column align-items-center p-3">
            <i class="bi bi-arrow-right-short fs-3"></i> 
            <span>Transferir</span> 
        </a>
    </div>
</div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('autoDismissSuccessAlert');
        const errorAlert = document.getElementById('autoDismissErrorAlert'); // NOVO: Seleciona o alerta de erro

        // Função para auto-desaparecer um alerta
        function autoDismissAlert(alertElement, delay = 5000) { // Default de 5 segundos
            if (alertElement) {
                setTimeout(function() {
                    alertElement.classList.remove('show'); // Inicia o fade out

                    // Remove o elemento do DOM após a transição
                    alertElement.addEventListener('transitionend', function() {
                        alertElement.remove();
                    }, { once: true });
                }, delay);
            }
        }

        // Aplica a função ao alerta de sucesso (5 segundos)
        autoDismissAlert(successAlert);

        // Aplica a função ao alerta de erro (você pode definir um tempo diferente, ex: 9 segundos)
        autoDismissAlert(errorAlert, 9000); // Mensagens de erro geralmente precisam de mais tempo para serem lidas
    });
</script>
@endpush
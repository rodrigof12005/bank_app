@extends('layouts.sistema.layout-padrao')

@section('title', 'Realizar Transferência')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                   
                    <span class="fs-5 flex-grow-1 text-center">Realizar Transferência</span>
                    <span class="ms-auto invisible"></span>
                </div>
                <div class="card-body p-4">
                    {{-- Mensagens de sucesso ou erro do servidor --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div id="cancelMessage" class="alert alert-danger alert-dismissible fade d-none" role="alert">
                        Você cancelou a operação de transferência. 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form id="transferForm" action="{{ route('transferir') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="conta_destinatario" class="form-label">Número da Conta do Destinatário:</label>
                            <input
                                type="text"
                                class="form-control @error('conta_destinatario') is-invalid @enderror"
                                id="conta_destinatario"
                                name="conta_destinatario"
                                placeholder="Ex: 123456789"
                                value="{{ old('conta_destinatario') }}"
                                required
                            >
                            @error('conta_destinatario')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="valor_transferencia" class="form-label">Valor da Transferência:</label>
                            <input
                                type="text"
                                class="form-control @error('valor_transferencia') is-invalid @enderror"
                                id="valor_transferencia"
                                name="valor_transferencia"
                                placeholder="Ex: 150,00"
                                value="{{ old('valor_transferencia') }}"
                                required
                            >
                            @error('valor_transferencia')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Transferir</button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputContaDestinatario = document.getElementById('conta_destinatario');
        const inputValorTransferencia = document.getElementById('valor_transferencia');
        const transferForm = document.getElementById('transferForm'); // Seleciona o formulário
        const cancelMessage = document.getElementById('cancelMessage');

        // Máscara para Valor da Transferência (igual ao depósito)
        inputValorTransferencia.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Remove tudo que não for dígito
            value = value.replace(/(\d)(\d{2})$/, '$1,$2'); // Adiciona vírgula antes dos últimos 2 dígitos
            value = value.replace(/(?=(\d{3})+(\D))\B/g, '.'); // Adiciona pontos para milhares
            e.target.value = value;
        });

        // Máscara para Número da Conta do Destinatário (apenas dígitos)
        inputContaDestinatario.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, ''); 
        });

        // MUDANÇA PRINCIPAL: Anexe o listener ao evento 'submit' do FORMULÁRIO
        transferForm.addEventListener('submit', function(e) {
            e.preventDefault(); // <--  Impede a submissão padrão do formulário

            const valor = inputValorTransferencia.value;
            const conta = inputContaDestinatario.value;

            const confirmacao = confirm(`Você confirma a transferência de R$ ${valor} para a conta ${conta}?`);

            if (confirmacao) {
                this.submit(); 
            } else {
                cancelMessage.classList.remove('d-none');
                cancelMessage.classList.add('show');

                setTimeout(() => {
                    window.location.href = '{{ route('home') }}';
                }, 1000);
            }
        });
    });
</script>
@endpush
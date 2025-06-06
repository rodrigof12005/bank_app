@extends('layouts.sistema.layout-padrao')

@section('title', 'Realizar Depósito')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
    <div class="col-md-7 col-lg-5">
                <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    
                    
                    <span class="fs-5 flex-grow-1 text-center">Realizar Depósito</span>
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
                        Você cancelou a operação de depósito. 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form id="depositForm" action="{{ route('depositar') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="valor_deposito" class="form-label">Valor do Depósito:</label>
                            <input
                                type="text"
                                class="form-control @error('valor_deposito') is-invalid @enderror"
                                id="valor_deposito"
                                name="valor_deposito"
                                placeholder="Ex: 150,00"
                                value="{{ old('valor_deposito') }}"
                                required
                            >
                            @error('valor_deposito')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Depositar</button>
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
        const inputValor = document.getElementById('valor_deposito');
        const depositForm = document.getElementById('depositForm'); // Seleciona o formulário
        const cancelMessage = document.getElementById('cancelMessage');

        // Máscara de input 
        inputValor.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d)(\d{2})$/, '$1,$2');
            value = value.replace(/(?=(\d{3})+(\D))\B/g, '.');
            e.target.value = value;
        });

        //  Anexando o listener ao evento 'submit' do FORMULÁRIO
        depositForm.addEventListener('submit', function(e) {
            e.preventDefault(); // <--  Impede a submissão padrão do formulário

            const valor = inputValor.value;
            
            const confirmacao = confirm(`Você confirma o depósito de R$ ${valor}?`);

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
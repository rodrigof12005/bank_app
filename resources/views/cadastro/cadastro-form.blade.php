@extends('layouts.cadastro.cadastro-layout') 

@section('title', 'Formulário de Cadastro')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card shadow p-4">
                <h2 class="mb-4">Formulário de Cadastro</h2>

                {{-- Bloco para exibir mensagens de SUCESSO (se houver) --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Bloco para exibir mensagens de ERRO GERAIS (do try-catch no backend) --}}
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Bloco para exibir ERROS DE VALIDAÇÃO (vindos do $errors->any()) --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Ops!</strong> Houve um problema com o seu cadastro.
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form method="POST" action="{{route('cadastrar')}}">
                    @csrf

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome Completo:</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" id="nome" name="nome" placeholder="Seu nome completo" value="{{ old('nome') }}" required>
                        @error('nome')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF:</label>
                        <input type="text" class="form-control @error('cpf') is-invalid @enderror" id="cpf" name="cpf" placeholder="000.000.000-00" value="{{ old('cpf') }}" required pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" title="Formato: 000.000.000-00">
                        <small class="form-text text-muted">Formato: 000.000.000-00</small>
                        @error('cpf')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="seuemail@exemplo.com" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Senha:</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Sua senha" required minlength="8">
                        <small class="form-text text-muted">Mínimo de 8 caracteres.</small>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                   
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirme a Senha:</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme sua senha" required>
                        
                    </div>

                    <button type="submit" class="btn btn-success">Criar Conta</button>
                    <a href="{{route('login')}}" class="btn btn-secondary">Cancelar</a>                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var cpfInput = document.getElementById('cpf');

        cpfInput.addEventListener('input', function(e) {
            var value = e.target.value.replace(/\D/g, ''); // Remove tudo que não é dígito
            var formattedValue = '';

            if (value.length > 0) {
                formattedValue += value.substring(0, 3);
            }
            if (value.length > 3) {
                formattedValue += '.' + value.substring(3, 6);
            }
            if (value.length > 6) {
                formattedValue += '.' + value.substring(6, 9);
            }
            if (value.length > 9) {
                formattedValue += '-' + value.substring(9, 11);
            }

            e.target.value = formattedValue;
        });
    });
</script>
@endpush

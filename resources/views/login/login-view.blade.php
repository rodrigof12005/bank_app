@extends('layouts.login.layout_login') 

@section('title', 'Sistema') 

@section('form_content') {{-- Conteúdo para a seção do formulário --}}

    <div class="text-center">
       
        <h4 class="mt-1 mb-5 pb-1">Bank App </h4>
    </div>

    {{-- BLOCO PARA EXIBIR MENSAGENS DE SUCESSO (ex: após o cadastro) --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BLOCO PARA EXIBIR MENSAGENS DE ERRO GERAIS  --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- BLOCO PARA EXIBIR ERROS DE VALIDAÇÃO (do $errors->any()) --}}
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Ops!</strong> Verifique os dados informados:
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <form method="POST" action="logon"> 
        @csrf 
        <p>Entre com os dados de acesso</p>

        <div data-mdb-input-init class="form-outline mb-4">
            {{-- Adicionado @error e old() para o campo 'nome' --}}
            <input type="text" id="form2Example11" class="form-control @error('nome') is-invalid @enderror"
            placeholder="Informe seu Login" name="email"  required /> 
            <label class="form-label" for="form2Example11">Email</label>
            @error('nome')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div data-mdb-input-init class="form-outline mb-4">
            {{-- Adicionado @error para o campo 'password' --}}
            <input type="password" id="form2Example22"  class="form-control @error('password') is-invalid @enderror" placeholder="Informe sua Senha" name="password" required /> 
            <label class="form-label" for="form2Example22">Senha</label>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="text-center pt-1 mb-5 pb-1">
            <button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Acessar</button> 
            
        </div>

        <div class="d-flex align-items-center justify-content-center pb-4">
            <p class="mb-0 me-2">Não possui uma conta? </p>
            <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-custom-blue" onclick="window.location='{{ route('novo-cadastro') }}'">Criar uma conta ></button>
        </div>
    </form>
@endsection

@section('gradient_text_content') 
    <h4 class="mb-4">Nós somos mais que um banco</h4>
    <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
@endsection
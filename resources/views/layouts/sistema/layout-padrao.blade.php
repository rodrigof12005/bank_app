<!DOCTYPE html>
<html lang="pt-br" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Meu Banco')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
   
    <style>
        
        .highlight-card {
            background-color: #f8f9fa; /* Um cinza claro para destaque */
            border-left: 5px solid #007bff; /* Linha azul para indicar importância */
        }
       
        .btn-outline-secondary:hover i.text-success {
            color: #fff !important;
        }
        /* E para o span (label) */
        .btn-outline-secondary:hover span.text-success {
            color: #fff !important;
        }
        
    </style>
</head>
<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary"> {{-- Navbar primária azul --}}
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">Meu Banco</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Visão Geral</a>
                        </li>
                        
                        
                    </ul>
                    <ul class="navbar-nav ms-auto">
                      
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-flex"> 
                                @csrf
                                <button type="submit" class="btn btn-danger">Encerrar Sessão</button> 
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-shrink-0 py-4"> {{-- Padding top/bottom --}}
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container text-center">
        <p>&copy; {{ date('Y') }} Meu Banco. Todos os direitos reservados.</p>
        <a href="https://www.linkedin.com/in/rodrigo-duarte-461a99165/" target="_blank">Desenvolvido por Rodrigo Duarte</a>
    </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>
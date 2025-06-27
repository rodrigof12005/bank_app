<!DOCTYPE html>
<html lang="pt-br" class="h-100"> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Formulário de Cadastro')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

{{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}</head>
<body class="d-flex flex-column h-100"> {{-- Transforma o body em flexbox para layout sticky footer --}}
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark  bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Bank APP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/novo-cadastro">Cadastro</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    
    <main class="flex-grow-1 d-flex align-items-center py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer class="footer mt-auto py-3 bg-light"> {{-- 'mt-auto' empurra o footer para baixo --}}
        <div class="container text-center">
            <p>&copy; {{ date('Y') }} Bank APP. Todos os direitos reservados.</p>
        </div>
    </footer>
   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @stack('scripts') 
</body>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bank APP - @yield('title', 'Página Principal')</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   
    
    <style>
        .gradient-custom-2 {
    background: #2575fc; /* Cor inicial como fallback */

    background: -webkit-linear-gradient(to right, #2575fc, #6a11cb);

    background: linear-gradient(to right, #2575fc, #6a11cb); /*  roxo */
}
.btn-outline-custom-blue {
            /* Define a cor padrão do texto e da borda do botão */
            --bs-btn-color: #2575fc; 
            --bs-btn-border-color: #2575fc;

            /* Define a cor do texto e do fundo no estado HOVER (passar o mouse) */
            --bs-btn-hover-color: #fff; /* Texto branco no hover */
            --bs-btn-hover-bg: #2575fc; /* Fundo azul no hover */
            --bs-btn-hover-border-color: #2575fc; /* Borda azul no hover */

            /* Define a cor do texto e do fundo no estado ACTIVE (clicado) */
            --bs-btn-active-color: #fff; /* Texto branco quando ativo */
            --bs-btn-active-bg: #1a5ac7; /* Fundo um pouco mais escuro quando ativo */
            --bs-btn-active-border-color: #1a5ac7; /* Borda um pouco mais escura quando ativo */

        }

        @media (min-width: 768px) {
            .gradient-form {
                height: 100vh !important;
            }
        }
        @media (min-width: 769px) {
            .gradient-custom-2 {
                border-top-right-radius: .3rem;
                border-bottom-right-radius: .3rem;
            }
        }
    </style>
</head>
<body>
    {{-- A seção principal do seu tema, que incluirá o formulário de login --}}
    <section class="h-100 gradient-form" style="background-color: #eee;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            {{-- Conteúdo da seção esquerda (formulário de login, etc.) --}}
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    @yield('form_content') 
                                </div>
                            </div>
                            {{-- Conteúdo da seção direita com gradiente --}}
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                                    @yield('gradient_text_content') 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
</body>
</html>
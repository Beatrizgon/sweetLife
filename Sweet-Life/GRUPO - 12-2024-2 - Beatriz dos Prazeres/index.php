<?php
session_start();
?>

<!doctype html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sweet Life | Saúde e sabor em um só lugar!</title>
    <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <nav class="navbar col-12 position-fixed navbar-expand-lg navbar-light bg-light border border-grey"
        style="z-index: 999;">
        <div class="container-fluid col-11 m-auto">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <figure><a href="index.php">
                    <img src="img/SFLogo.png" id="Logo">
                </a>
            </figure>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#sucos" style="color: rgb(0, 0, 0);">Sucos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="#sobrenos" style="color: rgb(0, 0, 0);">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contatos" style="color: rgb(0, 0, 0);">Contatos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="erro.php" style="color: rgb(0, 0, 0);">Novidades</a>
                    </li>

                    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] == 'master'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="mer.php" style="color: rgb(0, 0, 0);">MER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="consultaUsuario.php" style="color: rgb(0, 0, 0);">Consulta Usuário</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logTeste.php" style="color: rgb(0, 0, 0);">Ações</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-gear"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="registrar_prod.php">Registrar Produto</a></li>
                                <li><a class="dropdown-item" href="estoque.php">Estoque</a></li>
                                <li><a class="dropdown-item" href="alterar_precos.php">Alterar Preços</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>

                
                <div class="d-flex align-items-center">
                    <a href="cart.php" class="nav-link me-3">
                        <i class="bi bi-cart-fill" style="font-size: 1.5rem;"></i>
                        <span id="cart-count" class="badge bg-danger" style="position: absolute; top: 25px; right: 14rem;">!</span>
                    </a>

                    <?php if (isset($_SESSION['username'])): ?>
                        <div class="nav-item">
                            <span class="nav-link">Bem-vindo, <?php echo $_SESSION['username']; ?>!</span>
                        </div>
                        <div class="nav-item">
                            <a class="nav-link" href="logout.php"> Encerrar Sessão</a>
                        </div>
                    <?php endif; ?>


                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                            <?php if (!isset($_SESSION['username'])): ?>
                                <div class="container2">
                                    <li class="nav-item" id="Cadastro">
                                        <a class="nav-link" aria-current="page" href="Cadastro.php">Cadastrar-se</a>
                                    </li>
                                </div>
                                <div class="container3">
                                    <li class="nav-item" id="Login">
                                        <a class="nav-link" aria-current="page" href="Login.php">Login</a>
                                    </li>
                                </div>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
    </nav><br><br><br><br>

    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <a href="#sobrenos">
                    <img src="img/pag2.png" class="d-block w-100" alt="...">
                </a>

            </div>
            <div class="carousel-item">
                <a href="#sucos">
                    <img src="img/laranja.png" class="d-block w-100" alt="...">
                </a>

            </div>
            <div class="carousel-item">
                <a href="Cadastro.php">
                    <img src="img/pag3.png" class="d-block w-100" alt="...">
                </a>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div><br><br><br><br><br>
    <div class="container-fluid"><br>
        <h1 class="text-center" id="sucos">Sucos</h1>
    </div>
    <div class="row row-cols-1 row-cols-md-4 g-4 col-11 m-auto">
        <div class="col">
            <div class="card">
                <img src="img/alianca-uva.jpeg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="text-align:left;">Suco de Uva Integral Sweet Life 500ml<h5 class="text-danger" style="font-size: 18px;">R$ 14,99</h5>
                    </h5>
                    <p class="card-text" style="text-align:left;">Feito com uvas frescas, nosso suco oferece
                        uma explosão de sabor intenso, capturando a essência vibrante da fruta em sua forma mais pura
                    </p>
                    <a href="#">
                        <button type="button" class="btn btn-success" onclick="addToCart('Suco de Uva Integral Sweet Life 500ml', 14.99)">Adicionar ao carrinho</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="img/suco-de-maça.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="text-align:left;">Suco de Maçã Integral Sweet Life 500ml <h5 class="text-danger" style="font-size: 18px;">R$ 16,95</h5>
                    </h5>
                    <p class="card-text" style="text-align:left;">Produzido com maçãs frescas, nosso suco
                        oferece um sabor doce e revigorante, capturando a verdadeira essência da fruta em cada gole</p>
                    <a href="#">
                        <button type="button" class="btn btn-success" onclick="addToCart('Suco de Maçã Integral Sweet Life 500ml', 16.95)">Adicionar ao carrinho</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="img/suco de morango.webp" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="text-align:left;">Suco de Morango Integral Sweet Life 500ml <h5 class="text-danger" style="font-size: 18px;">R$ 21,99</h5>
                    </h5>
                    <p class="card-text" style="text-align:left;">Feito com morangos frescos, nosso suco oferece um deleite doce e refrescante, capturando a essência pura da fruta em cada gole</p>
                    <a href="#">
                        <button type="button" class="btn btn-success" onclick="addToCart('Suco de Morango Integral Sweet Life 500ml', 21.99)">Adicionar ao carrinho</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="img/suco-de-laranja.webp" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title" style="text-align:left;">Suco de Laranja Integral Sweet Life 500ml <h5 class="text-danger" style="font-size: 18px;">R$15,99</h5>
                    </h5>
                    <p class="card-text" style="text-align:left;">Feito com laranjas suculentas, nosso suco é um
                        mix de frescor e vitamina C, capturando a essência revigorante da fruta em sua forma mais pura
                    </p>
                    <a href="#">
                        <button type="button" class="btn btn-success" onclick="addToCart('Suco de Laranja Integral Sweet Life', 15.99)">Adicionar ao carrinho</button>
                    </a>
                </div>
            </div>
        </div>
    </div><br><br><br><br><br><br>
    <hr>
    <div class="col-10 m-auto">
        <h2 class="text-center" id="sobrenos">Bem-vindo à <h1 class="text-center">Sweet Life!</h1>
        </h2><br>
        <p class="text-center">Desde nossa fundação, em 2024, na Sweet Life temos um propósito claro: oferecer sucos integrais, que não são apenas deliciosos, mas também repletos de vitalidade e benefícios. Acreditamos que a verdadeira qualidade começa com a escolha dos melhores ingredientes!</p>
        <p class="text-center">Nosso compromisso é com a excelência em cada etapa, desde a seleção das frutas frescas até a entrega final do produto. Cada suco que oferecemos é cuidadosamente elaborado para preservar todos os nutrientes e sabores naturais. Assim, garantimos uma ótima experiência e nutrição aos nossos clientes.</p>
        <p class="text-center">Na Sweet Life, não prezamos apenas pela qualidade, mas também pela sustentabilidade! Trabalhamos para minimizar nosso impacto ambiental, utilizando práticas ecologicamente corretas.
        <p class="text-center">Estamos aqui para transformar o simples ato de beber suco em um momento de prazer genuíno e nutritivo. </p>
        <p class="text-center">Agradecemos por escolher a Sweet Life e por fazer parte da nossa jornada.</p>
        </p>
    </div><br>
    <hr><br><br><br><br><br><br><br><br><br>
    <footer class="page-footer font-small blue p-5">
        <div class="text-center" style="color:white">
            <div class="col-11 m-auto">
                <h2 id="contatos">Contatos</h2>
                <p>Nos siga nas redes sociais e fique por dentro das novidades</p>
                <div class="col-md-15">
                    <a href="https://twitter.com/"><i class="fab fa-twitter" style="color: white; "></i></a>
                    <a href="https://www.facebook.com/"><i class="fab fa-facebook-f" style="color: white;"></i></a>
                    <a href="https://www.instagram.com/"><i class="fab fa-instagram" style="color: white;"></i></a>
                    <a href="https://br.pinterest.com/"><i class="fab fa-pinterest" style="color: white;"></i></a>
                </div><br><br>
                <div class="copyright">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-md-15">
                                <div class="copy-text">
                                    <p>&copy; <a href="index.php">Sweet Life</a> - Todos os Direitos Reservados.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="copyright">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-md-15">
                                    <div class="copy-text">
                                        <p style="color: rgba(255, 255, 255, 0.765);">Projeto Back-End 2024.2</p>
                                    </div>
                                </div>
                            </div>
                        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        let cart = [];

        function addToCart(name, price) {
            const existingItem = cart.find(item => item.name === name);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({
                    name,
                    price,
                    quantity: 1
                });
            }
            updateCart();
        }

        function updateCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
            document.getElementById('cart-count').innerText = cart.length;
        }
    </script>


</body>

</html>
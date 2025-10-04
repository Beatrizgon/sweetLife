<!doctype html>
<html lang="pt-BR" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Carrinho Sweet Life</title>
    <link rel="shortcut icon" href="img/SFLogo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/cart.css">
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
                        <a class="nav-link" aria-current="page" href="index.php" style="color: rgb(0, 0, 0);">Início</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                    <div id="user-greeting" class="nav-link" style="color: rgb(0, 0, 0); display: none;">
                        Olá, <span id="username">[Nome do Usuário]</span>
                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-auto">
                            <div class="container2">
                                <li class="nav-item" id="Cadastro">
                                    <a class="nav-link" aria-current="page" href="Cadastro.php">Cadastrar-se</a>
                                </li>
                            </div><br>

                    </div>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <div class="container3">
                                <li class="nav-item" id="Login">
                                    <a class="nav-link" aria-current="page" href="Login.php">Login</a>
                                </li>
                            </div>

                    </div>

                </div>
            </div>
    </nav><br><br><br><br><br><br><br>
    <div class="container">
        <div class="border border-2 border-black py-4 ps-5 pe-5">
            <h1 class="text-center">Carrinho de Compras</h1><br><br>
            <div id="cart-items"></div><br><br>
            <h3 id="cart-total">Total: R$ 0.00</h3>
            <div class="text-center mt-4">
                <button id="buy-button" class="btn btn-primary me-2" onclick="finalizePurchase()">Comprar</button>
                <button id="clear-cart-button" class="btn btn-danger" onclick="clearCart()">Limpar Carrinho</button>
            </div>
        </div>


    </div><br><br><br><br><br><br><br><br><br><br><br><br>

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
                                        <p style="color: rgba(255, 255, 255, 0.765);">Projeto Front-End - 2024</p>
                                    </div>
                                </div>
                            </div>
                        </div>
    </footer>
    <script src="JS.js"></script>

    <script>
        function loadCart() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            const cartItemsContainer = document.getElementById('cart-items');
            cartItemsContainer.innerHTML = '';

            cart.forEach((item, index) => {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'd-flex justify-content-between align-items-center';

                itemDiv.innerHTML = `
                    <span>${item.name} - R$ ${item.price.toFixed(2)} x ${item.quantity}</span>
                    <div>
                        <button onclick="changeQuantity(${index}, 1)" class="btn btn-success btn-sm mb-2" class="">+</button>
                        <button onclick="changeQuantity(${index}, -1)" class="btn btn-success btn-sm mb-2">-</button>
                        <button onclick="removeItem(${index})" class="btn btn-danger btn-sm mb-2">Excluir</button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemDiv);
            });

            updateTotal(cart);
        }

        function changeQuantity(index, amount) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart[index].quantity += amount;

            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }

            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function removeItem(index) {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            loadCart();
        }

        function updateTotal(cart) {
            const cartTotal = cart.reduce((total, item) => total + (item.price * item.quantity), 0);
            document.getElementById('cart-total').innerText = `Total: R$ ${cartTotal.toFixed(2)}`;
        }

        window.onload = loadCart;

        function finalizePurchase() {
            const cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                alert('Seu carrinho está vazio!');
            } else {
                alert('Compra realizada com sucesso!');
                localStorage.removeItem('cart');
                loadCart();
            }
        }

        function clearCart() {
            const confirmClear = confirm('Tem certeza de que deseja limpar o carrinho?');
            if (confirmClear) {
                localStorage.removeItem('cart');
                loadCart();
            }
        }
    </script>
</body>

</html>
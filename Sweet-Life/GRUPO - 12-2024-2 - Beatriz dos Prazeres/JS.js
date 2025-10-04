class Validator {
    constructor() {
        this.validations = [
            'data-min-length',
            'data-max-length',
            'data-only-letters',
            'data-email-validate',
            'data-required',
            'data-equal',
            'data-password-validate',
        ];
    }


    validate(form) {

        let currentValidations = document.querySelectorAll('form .error-validation');
        if (currentValidations.length) {
            this.cleanValidations(currentValidations);
        }


        let inputs = form.getElementsByTagName('input');
        let inputsArray = [...inputs];

        let isValid = true;


        inputsArray.forEach((input) => {
            for (let i = 0; this.validations.length > i; i++) {
                if (input.getAttribute(this.validations[i]) != null) {
                    let method = this.validations[i].replace("data-", "").replace("-", "");
                    let value = input.getAttribute(this.validations[i]);


                    if (!this[method](input, value)) {
                        isValid = false;
                    }
                }
            }
        });

        return isValid;
    }


    minlength(input, minValue) {
        let inputLength = input.value.length;
        let errorMessage = `O campo precisa ter pelo menos ${minValue} caracteres`;

        if (inputLength < minValue) {
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }


    maxlength(input, maxValue) {
        let inputLength = input.value.length;
        let errorMessage = `O campo precisa ter menos que ${maxValue} caracteres`;

        if (inputLength > maxValue) {
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }

    // método para validar strings que só contem letras
    onlyletters(input) {
        let re = /^[A-Za-z]+$/;
        let inputValue = input.value;
        let errorMessage = `Este campo não aceita números nem caracteres especiais`;

        if (!re.test(inputValue)) {
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }

    // método para validar e-mail
    emailvalidate(input) {
        let re = /\S+@\S+\.\S+/;
        let email = input.value;
        let errorMessage = `Insira um e-mail válido`;

        if (!re.test(email)) {
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }


    equal(input, inputNome) {
        let inputToCompare = document.getElementsByName(inputNome)[0];
        let errorMessage = `Este campo precisa estar igual ao ${inputNome}`;

        if (input.value !== inputToCompare.value) {
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }


    required(input) {
        let inputValue = input.value;

        if (inputValue === '') {
            let errorMessage = `Este campo é obrigatório`;
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }

    // validando o campo de senha
    passwordvalidate(input) {
        let charArr = input.value.split("");
        let uppercases = 0;
        let numbers = 0;

        for (let i = 0; charArr.length > i; i++) {
            if (charArr[i] === charArr[i].toUpperCase() && isNaN(parseInt(charArr[i]))) {
                uppercases++;
            } else if (!isNaN(parseInt(charArr[i]))) {
                numbers++;
            }
        }

        if (uppercases === 0 || numbers === 0) {
            let errorMessage = `A senha precisa ter um caractere maiúsculo e um número`;
            this.printMessage(input, errorMessage);
            return false;
        }

        return true;
    }


    printMessage(input, msg) {
        let errorsQty = input.parentNode.querySelector('.error-validation');

        if (errorsQty === null) {
            let template = document.querySelector('.error-validation').cloneNode(true);
            template.textContent = msg;
            let inputParent = input.parentNode;
            template.classList.remove('template');
            inputParent.appendChild(template);
        }
    }


    cleanValidations(validations) {
        validations.forEach(el => el.remove());
    }
}


function ajustaCelular(v) {
    v.value = v.value.replace(/\D/g, "");
    if (v.value.startsWith("55")) {
        v.value = "+55" + v.value.slice(2);
    }
    if (v.value.startsWith("+55") && v.value.length >= 4) {
        v.value = v.value.replace(/^(\+\d{2})(\d{2})/, "$1 ($2)");
    }
    v.value = v.value.replace(/(\d{2})(\d{5})(\d{4})/, "$1$2-$3");
}


function ajustaTelefone(v) {
    v.value = v.value.replace(/\D/g, "");
    if (v.value.startsWith("55")) {
        v.value = "+55" + v.value.slice(2);
    }
    if (v.value.startsWith("+55") && v.value.length >= 4) {
        v.value = v.value.replace(/^(\+\d{2})(\d{2})/, "$1 ($2)");
    }
    v.value = v.value.replace(/(\d{2})(\d{4})(\d{4})/, "$1 $2-$3");
}

// Função para formatar CPF
function validarCPF(input) {
    let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos

    // Formata o CPF com pontos e traço
    if (value.length > 3) {
        value = value.substring(0, 3) + '.' + value.substring(3);
    }
    if (value.length > 7) {
        value = value.substring(0, 7) + '.' + value.substring(7);
    }
    if (value.length > 11) {
        value = value.substring(0, 11) + '-' + value.substring(11);
    }

    input.value = value;

    // Validação do CPF
    if (value.length === 14) { // CPF completo
        const apenasNumeros = value.replace(/\D/g, '');
        if (!validarRegrasCPF(apenasNumeros)) {
            alert("CPF inválido! Verifique e tente novamente.");
            input.value = ''; // Limpa o campo se o CPF for inválido
        }
    }
}

// Função para validar as regras do CPF
function validarRegrasCPF(cpf) {
    // Rejeita CPFs com todos os dígitos iguais
    const repetidos = /^(.)\1{10}$/;
    if (repetidos.test(cpf)) return false;

    // Validação dos dígitos verificadores
    let soma = 0;
    let resto;

    // Valida o primeiro dígito verificador
    for (let i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) return false;

    // Valida o segundo dígito verificador
    soma = 0;
    for (let i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) return false;

    return true;
}

// Validação de CEP e preenchimento automático de endereço
function preencherEndereco(v) {
    let cep = v.value.replace(/\D/g, '');
    if (cep.length === 8) {
        let url = 'https://viacep.com.br/ws/' + cep + '/json/';
        fetch(url)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro;
                    document.getElementById('bairro').value = data.bairro;
                    document.getElementById('uf').value = data.localidade + '-' + data.uf;
                }
            })
            .catch(error => console.log('Ocorreu um erro:', error));
    }
}

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


// Iniciando a validação ao enviar o formulário
let form = document.getElementById('register-form');
let submit = document.getElementById('btn-submit');
let validator = new Validator();

submit.addEventListener('click', function (e) {
    e.preventDefault();

    // Realiza a validação
    if (validator.validate(form)) {
        form.submit(); // Envia o formulário caso seja válido
    }
});


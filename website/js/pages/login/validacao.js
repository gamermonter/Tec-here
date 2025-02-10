// Função para aplicar a máscara de CPF
function mascaraCPF(cpf) {
    cpf.value = cpf.value.replace(/\D/g, ''); // Remove qualquer caracter não numérico
    cpf.value = cpf.value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o ponto
    cpf.value = cpf.value.replace(/(\d{3})(\d)/, '$1.$2'); // Adiciona o ponto
    cpf.value = cpf.value.replace(/(\d{3})(\d{1,2})$/, '$1-$2'); // Adiciona o hífen
}

// Função para validar o CPF
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, ''); // Remove caracteres não numéricos

    // Verifica se o CPF tem 11 dígitos
    if (cpf.length !== 11) {
        return false;
    }

    // Verifica se todos os números são iguais (ex: 111.111.111.11)
    if (/^(\d)\1{10}$/.test(cpf)) {
        return false;
    }

    // Validação do primeiro dígito
    let soma = 0;
    for (let i = 0; i < 9; i++) {
        soma += parseInt(cpf.charAt(i)) * (10 - i);
    }
    let resto = 11 - (soma % 11);
    if (resto === 10 || resto === 11) {
        resto = 0;
    }
    if (resto !== parseInt(cpf.charAt(9))) {
        return false;
    }

    // Validação do segundo dígito
    soma = 0;
    for (let i = 0; i < 10; i++) {
        soma += parseInt(cpf.charAt(i)) * (11 - i);
    }
    resto = 11 - (soma % 11);
    if (resto === 10 || resto === 11) {
        resto = 0;
    }
    if (resto !== parseInt(cpf.charAt(10))) {
        return false;
    }

    return true;
}

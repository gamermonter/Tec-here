function validarFormulario() {
    var cpf = document.getElementById('cpf').value;
    var senha = document.getElementById('senha').value;
    var confirmaSenha = document.getElementById('confirma').value;

    // Validação do CPF
    if (!validarCPF(cpf)) {
        document.getElementById('cpf-message').textContent = 'CPF inválido!';
        return false;
    } else {
        document.getElementById('cpf-message').textContent = '';
    }

    // Validação da Senha
    if (senha !== confirmaSenha) {
        alert('As senhas não coincidem!');
        return false;
    }

    if (senha.length < 6 || senha.length > 10) {
        alert('A senha deve ter entre 6 e 10 caracteres!');
        return false;
    }

    return true;
}

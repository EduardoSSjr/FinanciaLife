
closeFormButton.addEventListener('click', () => {
    overlay.style.display = 'none';
});

const form = document.getElementById('myForm');
form.addEventListener('submit', (event) => {
    event.preventDefault();
    const nome = document.getElementById('signup_user_input').value;


    const email = document.getElementById('signup_email_input').value;
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

    const confirmEmail = document.getElementById('confirm-email').value;


    const senha = document.getElementById('signup_password_input').value;
    const senhaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    const confirmSenha = document.getElementById('confirm-senha').value;

    // Aqui você pode adicionar a lógica para processar os dados do formulário

    if (!emailRegex.test(email)) {
        // Email inválido
        alert('Email inválido. Por favor, insira um email válido.');
    }

    if (!senhaRegex.test(senha)) {
        // Senha inválida
        alert('A senha deve conter pelo menos 8 caracteres, uma letra minúscula, uma letra maiúscula, um número e um caractere especial.');
    }

    if (email !== confirmEmail) {
        // Email de confirmação não corresponde ao email
        alert('O email de confirmação não corresponde ao email inserido.');
    }

    if (senha !== confirmSenha) {
        // Senha de confirmação não corresponde à senha
        alert('A senha de confirmação não corresponde à senha inserida.');
    }
});
const openFormButton = document.getElementById('btncadastro');
const closeFormButton = document.getElementById('closeFormButton');
const overlay = document.getElementById('overlay');

openFormButton.addEventListener('click', () => {
    overlay.style.display = 'flex';
});

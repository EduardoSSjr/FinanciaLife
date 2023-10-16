var formlogin = document.querySelector('#login')
var formcadastro = document.querySelector('#cadastro')
var btnColor = document.querySelector('.btnColor')

document.querySelector('#btnlogin')
  .addEventListener('click', () =>{
    formlogin.style.left = "25px"
    formcadastro.style.left = "450px"
    btnColor.style.left = "0px"
});


document.querySelector('#btncadastro')
  .addEventListener('click', () =>{
    formlogin.style.left = "-450px"
    formcadastro.style.left = "25px"
    btnColor.style.left = "110px"
});


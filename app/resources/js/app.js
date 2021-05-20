

var modal = document.querySelector("#myModal");
var btn = document.querySelector("#myBtn");
var close = document.querySelector(".close");
var inpuId = document.querySelector('#inputId');

// função responsavel por chamar o modal para edição
function onEdit(value){
  window.location = "?onEdit="+value;
};// espera o click no botão para mostrar o modal

// Responsavel por deletar um registro
function onDelete(value){
  window.location = "?onDelete="+value;
};// espera o click no botão para mostrar o modal

// espera o click no botão para mostrar o modal
btn.addEventListener('click',function(){
  modal.style.display = "block";
});

// espera o click no botão de fechar para sumir com o modal
close.addEventListener('click',function() {
  modal.style.display = "none";
});

// no load da janela ele fecha o modal se não tiver aberto
window.addEventListener('load',function(event) {
  if(event.target == modal)
    modal.style.display = "none";
});
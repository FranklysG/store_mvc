// console.log('oi');
var $ = document;
var modalBanner = $.querySelector('#myModalBanner');
var upload = $.querySelector('#file');
var btnBanner = $.querySelector("#myBtnBanner");
var closeBanner = $.querySelector(".closeBanner");

upload.addEventListener('change', function(event){
    const reader = new FileReader();
    reader.addEventListener('load', () => {
        localStorage.setItem('recent-image', reader.result);
        $.querySelector('#image-recent').setAttribute('src', reader.result)
    });
    reader.readAsDataURL(this.files[0]);

});

// espera o click no botão para mostrar o modal
btnBanner.addEventListener('click',function(){
    modalBanner.style.display = "block";
});

// espera o click no botão de fechar para sumir com o modal
closeBanner.addEventListener('click',function() {
    modalBanner.style.display = "none";
});

// no load da janela ele fecha o modal se não tiver aberto
window.addEventListener('load',function(event) {
if(event.target == modalBanner)
    modalBanner.style.display = "none";
});
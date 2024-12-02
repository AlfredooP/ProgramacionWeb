jQuery(document).ready(function ($) {
    $(".slider-img").on("click", function () {
      $(".slider-img").removeClass("active");
      $(this).addClass("active");
    });
  });

const productos = document.querySelectorAll('.producto');
const btnEnviar = document.querySelector('.boton--primario');
btnEnviar.addEventListener('click', function (evento) {
     console.log(evento);
     //evento.preventDefault();

     //Validar un formulario
     console.log('Enviando Formulario');
 });
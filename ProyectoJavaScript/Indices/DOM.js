let numProductos = 1
const btnCarrito = document.querySelectorAll('.botonCarritoP')
const btnComprar = document.querySelectorAll('.botonP')
const productos = document.querySelectorAll('.producto')

for (let i = 0; i < btnCarrito.length; i++) {
    let cont = 0
    btnCarrito[i].addEventListener('click', function (evento) {
        if (cont > 0) {

        }
        else {
            cont++
            const botonMas = document.createElement('a')
            botonMas.addEventListener('click', function () {
                numProductos++;
                botonAgregar.textContent = "Agregar " + numProductos
            })
            botonMas.textContent = "+"
            botonMas.classList.add('botonP')

            const botonMenos = document.createElement('a')            
            botonMenos.addEventListener('click', function () {
                if (numProductos != 1) {
                    numProductos--
                    botonAgregar.textContent = "Agregar " + numProductos
                }
            })
            botonMenos.textContent = "-"
            botonMenos.classList.add('botonP')

            const botonAgregar = document.createElement('a')
            botonAgregar.addEventListener('click', function () {
                botonAgregar.href = "carrito.php?producto=" + evento.target.id + "&eliminar=false&cantidad=" + numProductos
            })
            botonAgregar.textContent = "Agregar " + numProductos
            botonAgregar.classList.add('botonP')

            const espacio = document.createElement('p')
            espacio.textContent = " "

            productos[i].insertBefore(botonMenos, btnComprar[i])
            productos[i].insertBefore(botonAgregar, btnComprar[i])
            productos[i].insertBefore(botonMas, btnComprar[i])
            productos[i].insertBefore(espacio, btnComprar[i])
        }

    });
}

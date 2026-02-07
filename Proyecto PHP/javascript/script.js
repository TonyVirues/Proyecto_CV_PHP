//Gate
let barraProgreso = document.getElementById("progressBar");
let numeroPorcentaje = document.getElementById("numPorcentaje");
let form = document.querySelector("form");
let botonEliminar = document.getElementById("killbutton");

//Raid que contiene todos los inputs.
let raidInputs = form.querySelectorAll(
    "input[type='text'], input[type='email'], input[type='tel'], textarea, input[type='file']");

//Raid pasadas descumpuesta en números.
let totalInputs = raidInputs.length;

/**
 *  FUNCIONES.
 */
function actualizarProgeso(){
    //Variable que va guardando el proceso.
    let completado = 0;

    //For para recorrer el array y comprobar cuantos quedan.
    raidInputs.forEach(field =>{
        if (field.type==="file"){
            if(field.files.length>0)
                completado++;
        }else {
            if(field.value.trim()!=="")
                completado++;
        }
    });

    /**
     * Variable que guarda el porcentaje
     * calculado entre lo completado y los fields restantes.
     */
    let porcentaje = Math.round((completado / totalInputs)*100);
    //Se imprime en el html la barra y el numero de porcentaje;
    barraProgreso.style.width = porcentaje + "%";
    numeroPorcentaje.innerHTML = porcentaje + "%";


    //Cambiar el color según el progreso.
    barraProgreso.classList.remove("bg-danger", "bg-warning", "bg-success");

    if (porcentaje < 40) {
        barraProgreso.classList.add("bg-danger");
    } else if (porcentaje < 80) {
        barraProgreso.classList.add("bg-warning");
    } else {
        barraProgreso.classList.add("bg-success");
    }
}


/**
 * Listener o eventos. Me gusta llamarlos caster.
 */
document.addEventListener("DOMContentLoaded",()=>{

    raidInputs.forEach(field => {
        field.addEventListener("input", actualizarProgeso);
        field.addEventListener("change", actualizarProgeso);
    });

});


document.addEventListener("DOMContentLoaded", () => {

    const botonesEliminar = document.querySelectorAll(".btn-eliminar");
    if (botonesEliminar.length === 0) return;

    botonesEliminar.forEach(btn => {
        btn.addEventListener("click", e => {
            e.preventDefault();

            Swal.fire({
                title: "¿Eliminar CV?",
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = btn.href;
                }
            });
        });
    });

});



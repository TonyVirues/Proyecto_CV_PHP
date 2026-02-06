//Gate
let barraProgreso = document.getElementById("barraProgreso");
let form = document.querySelector("form");

//Raid que contiene todos los inputs.
let raidInputs = form.querySelectorAll(
    "input[type='text'], input[type='email'], textarea, input[type='file']");

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

    barraProgreso.style.width = percentage + "%";
    barraProgreso.textContent = percentage + "%";

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

    fields.forEach(field => {
        field.addEventListener("input", actualizarProgeso);
        field.addEventListener("change", actualizarProgeso);
    });

});
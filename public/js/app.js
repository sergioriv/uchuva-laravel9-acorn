// require('./bootstrap');

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

// $( document ).ready(function() {

function callNotify(type = "success", title, message = "") {
    let icon = "cs-check";
    let color = "primary";

    switch (type) {
        case "fail":
            icon = "cs-error-hexagon";
            color = "danger";
            break;
        case "info":
            icon = "cs-info-hexagon";
            color = "info";
            break;

        default:
            break;
    }

    jQuery.notify(
        {
            title: title,
            message: message,
            icon: icon,
        },
        {
            type: color,
            delay: 5000,
        }
    );
}

if (jQuery().select2) {
    jQuery.fn.select2.defaults.set("theme", "bootstrap4");
    jQuery(".kii_select2").select2({ minimumResultsForSearch: Infinity });
}

document.getElementById("avatar").onchange = function(e) {
    // Creamos el objeto de la clase FileReader
    let reader = new FileReader();

    // Leemos el archivo subido y se lo pasamos a nuestro fileReader
    reader.readAsDataURL(e.target.files[0]);

    // Le decimos que cuando este listo ejecute el código interno
    reader.onload = function(){
      let preview = document.getElementById('preview'),
              image = document.createElement('img');

      image.src = reader.result;
      image.classList = 'rounded-xl sh-13 sw-13';

      preview.innerHTML = '';
      preview.append(image);
    };
  }

const lang = $('html').attr('lang');

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
    // jQuery(".kii_select2").select2({ minimumResultsForSearch: Infinity });
}

function DataTableInterval(datatable) {
    setInterval(() => {
        jQuery(datatable).DataTable().ajax.reload();
    }, 2000);
}


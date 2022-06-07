var dishes_selected = [];

jQuery(".add-table").click(function () {
    jQuery("#table")
        .val($(this).data("id"))
        .data("reference", $(this).data("reference"));
    $(".add-table .card").removeClass("border border-primary card-badge");
    $(this).children(".card").addClass("border border-primary card-badge");
});

jQuery(".dish-quality").keyup(function () {
    var id = $(this).data("id");

    if ($(this).val() > 0) {
        $("#note-" + id).removeClass("d-none");

        if (!dishes_selected.includes(id)) dishes_selected.push(id);
    } else {
        $("#note-" + id)
            .addClass("d-none")
            .children("textarea")
            .val("");

        dishes_selected.splice($.inArray(id, dishes_selected), 1);
    }
});

jQuery(".btn-quality").click(function () {
    var id = $(this).data("id");

    var dishQuality = $("#dish-quality-" + id).val();

    dishQuality =
        $(this).data("spin") == "up" ? (dishQuality += 1) : (dishQuality -= 1);

    if (dishQuality > 0) {
        $("#note-" + id).removeClass("d-none");

        if (!dishes_selected.includes(id)) dishes_selected.push(id);
    } else {
        $("#note-" + id)
            .addClass("d-none")
            .children("textarea")
            .val("");

        dishes_selected.splice($.inArray(id, dishes_selected), 1);
    }
});

jQuery("#order-confirm").click(function () {
    var inner_dishes = "";

    if (!$("#table").val() ) {
        $("#dish-confirm").html(`Debe seleccionar una mesa`);
        return;
    }

    if (dishes_selected.length == 0) {
        $("#dish-confirm").html(`Debe seleccionar platos`);
        return;
    }

    $("#footer-confirm").html(
        `<button type="submit" class="btn btn-primary">Crear</button>`
    );

    inner_dishes +=
        `<div class="text-center h4 mb-5">Mesa: ` +
        $("#table").data("reference") +
        `</div>`;
    inner_dishes += `<div class="data-table-rows slim">`;
    inner_dishes += `<table class="data-table nowrap w-100 dataTable no-footer text-center">`;
    inner_dishes += `<tbody>`;

    dishes_selected.forEach((dish_id) => {
        inner_dishes += `<tr><td>`;
        inner_dishes += `<hr>`;
        inner_dishes +=
            `<text class="h4">` +
            $("#dish-name-" + dish_id).html() +
            `</text><br>`;
        inner_dishes +=
            `<text class="text-small">` +
            $("#dish-price-" + dish_id).html() +
            `</text><br>`;
        inner_dishes +=
            `<text class="font-weight-bold h5 text-primary">` +
            $("#dish-quality-" + dish_id).val() +
            `</text><br>`;
        if (
            $("#dish-note-" + dish_id)
                .val()
                .trim().length != 0
        )
            inner_dishes +=
                `<text class="text-small">` +
                $("#dish-note-" + dish_id).val() +
                `</text><br>`;
        inner_dishes += `</td></tr>`;
    });

    inner_dishes += `</tbody>`;
    inner_dishes += `</table>`;
    inner_dishes += `</div>`;

    $("#dish-confirm").html(inner_dishes);
});

/**
 *
 * RowsAjax
 *
 * Interface.Plugins.Datatables.RowsAjax page content scripts. Initialized from scripts.js file.
 *
 *
 */

class RowsAjaxDishes {
    constructor() {
        if (!jQuery().DataTable) {
            console.log("DataTable is null!");
            return;
        }

        // Datatable instance
        this._datatable;

        // Controls and select helper
        this._datatableExtend;

        // Datatable single item height
        this._staticHeight = 62;

        this._createInstance();
        this._extend();
    }

    // Creating datatable instance. Table data is provided by json/products.json file and loaded via ajax
    _createInstance() {
        const _this = this;
        this._datatable = jQuery("#datatable_dishes").DataTable({
            scrollX: true,
            ajax: "/dishes.json",
            sDom: '<"row"<"col-sm-12"<"table-container"t>r>><"row"<"col-12"p>>', // Hiding all other dom elements except table and pagination
            pageLength: 10,
            order: [],
            columns: [
                { data: "available"},
                { data: "name" },
                { data: "category.name" },
                { data: "price", render: $.fn.dataTable.render.number( ',', '.', 2 ) },
                { data: "quality" }
            ],
            language: {
                url: "/json/datatable.spanish.json",
            },
            initComplete: function (settings, json) {
                _this._setInlineHeight();
            },
            drawCallback: function (settings) {
                _this._setInlineHeight();
            },
            preDrawCallback: function (settings) {
                _this._preDrawCallback($(this), settings);
            },
            columnDefs: [
                { // Adding Icon for available true or false
                    targets: 0,
                    orderable: false,
                    className: 'sw-3 no-padding-right',
                    render: function (data) {
                        if (data == 1)
                        {
                            return ('<i class="bi-check-circle-fill icon icon-14 text-success"></i>')
                        } else
                        {
                            return ('<i class="bi-x-circle-fill icon icon-14 text-danger"></i>')
                        }
                    }
                },
                { // Adding Name content as an anchor with a target #
                    targets: 1,
                    render: function (data, type, row, meta) {
                        return (
                            '<a class="list-item-heading body" href="/dishes/' + row.id +'/edit">' + data + "</a>"
                        );
                    },
                },
                {
                    targets: 4,
                    className: 'text-center'
                }
            ],
        });
    }

    // Extending with DatatableExtend to get search, select and export working
    _extend() {
        this._datatableExtend = new DatatableExtend({
            datatable: this._datatable,
        });
    }

    // Setting static height to datatable to prevent pagination movement when list is not full
    _setInlineHeight() {
        if (!this._datatable) {
            return;
        }
        const pageLength = this._datatable.page.len();
        document.querySelector(".dataTables_scrollBody").style.height =
            this._staticHeight * pageLength + "px";
    }

    _preDrawCallback(datatable, settings) {
        var api = new $.fn.dataTable.Api(settings);
        var pagination = datatable
            .closest(".dataTables_wrapper")
            .find(".dataTables_paginate");
        pagination.toggle(api.page.info().pages > 1);
    }
}

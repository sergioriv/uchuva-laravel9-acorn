/**
 *
 * RowsAjax
 *
 * Interface.Plugins.Datatables.RowsAjax page content scripts. Initialized from scripts.js file.
 *
 *
 */

class RowsAjaxRestaurants {
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
        this._datatable = jQuery("#datatable_restaurants").DataTable({
            scrollX: true,
            ajax: "/restaurants.json",
            sDom: '<"row"<"col-sm-12"<"table-container"t>r>><"row"<"col-12"p>>', // Hiding all other dom elements except table and pagination
            pageLength: 10,
            order: [[1, 'asc']],
            columns: [
                { data: "image" },
                { data: "user.name" },
                { data: "user.email" },
                { data: "telephone" },
                { data: "unsubscribe" },
            ],
            language: {
                url: '/json/datatable.spanish.json',
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
                {
                    targets: 0,
                    orderable: false,
                    render: function (data) {
                        if (data)
                        {
                            return (
                                '<div class="sw-6 mb-1 d-inline-block"><img src="' + data + '" class="img-fluid rounded-xl border border-2 border-foreground" alt="thumb" /></div>'
                            )
                        } else
                        {
                            return (
                                '<div class="sw-4 sh-4 me-1 mb-1 d-inline-block bg-separator d-flex justify-content-center align-items-center rounded-xl"><i class="bi-building icon icon-18" class="icon"></i></div>'
                            )
                        }

                    }
                },
                // Adding Name content as an anchor with a target #
                {
                    targets: 1,
                    render: function (data, type, row, meta) {
                        return (
                            '<a class="list-item-heading body" href="/restaurants/' + row.id +'">' + data + "</a>"
                        );
                    },
                },
                // Adding DateTime content class text-small
                {
                    targets: 4,
                    render: function(data) {
                        return (
                            '<h4 class="text-small">' + data + '</h4>'
                        )
                    }
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

    _preDrawCallback(datatable, settings){
        var api = new $.fn.dataTable.Api(settings);
        var pagination = datatable
            .closest('.dataTables_wrapper')
            .find('.dataTables_paginate');
        pagination.toggle(api.page.info().pages > 1);
    }
}

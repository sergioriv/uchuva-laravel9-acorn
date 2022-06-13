/**
 *
 * Scripts
 *
 * Initialization of the template base and page scripts.
 *
 *
 */

class Scripts {
    constructor() {
        this._initSettings();
        this._initVariables();
        this._addListeners();
        this._init();
    }

    // Showing the template after waiting for a bit so that the css variables are all set
    // Initialization of the common scripts and page specific ones
    _init() {
        setTimeout(() => {
            document.documentElement.setAttribute("data-show", "true");
            document.body.classList.remove("spinner");
            this._initBase();
            this._initCommon();
            this._initPages();
            this._initPlugins();
        }, 100);
    }

    // Base scripts initialization
    _initBase() {
        // Navigation
        if (typeof Nav !== "undefined") {
            const nav = new Nav(document.getElementById("nav"));
        }

        // Search implementation
        if (typeof Search !== "undefined") {
            const search = new Search();
        }

        // AcornIcons initialization
        if (typeof AcornIcons !== "undefined") {
            new AcornIcons().replace();
        }
    }

    // Common plugins and overrides initialization
    _initCommon() {
        // common.js initialization
        if (typeof Common !== "undefined") {
            let common = new Common();
        }
    }

    // Pages initialization
    _initPages() {
        if (typeof ResponsiveTab !== "undefined") {
            document.querySelector(".responsive-tabs") !== null &&
                new ResponsiveTab(document.querySelector(".responsive-tabs"));
        }
    }

    // Plugin pages initialization
    _initPlugins() {
        // datatable.editablerows.js initialization
        if (typeof RowsAjaxUsers !== "undefined") {
            const rowsAjaxUsers = new RowsAjaxUsers();
        }
        if (typeof RowsAjaxRoles !== "undefined") {
            const rowsAjaxRoles = new RowsAjaxRoles();
        }
        if (typeof RowsAjaxRestaurants !== "undefined") {
            const rowsAjaxRestaurants = new RowsAjaxRestaurants();
        }
        if (typeof RowsAjaxSubscriptions !== "undefined") {
            const rowsAjaxSubscriptions = new RowsAjaxSubscriptions();
        }
        if (typeof RowsAjaxBranches !== "undefined") {
            const rowsAjaxBranches = new RowsAjaxBranches();
        }
        if (typeof RowsAjaxWaiters !== "undefined") {
            const rowsAjaxWaiters = new RowsAjaxWaiters();
        }
        if (typeof RowsAjaxCategories !== "undefined") {
            const rowsAjaxCategories = new RowsAjaxCategories();
        }
        if (typeof RowsAjaxDishes !== "undefined") {
            const rowsAjaxDishes = new RowsAjaxDishes();
        }
        if (typeof RowsAjaxTables !== "undefined") {
            const rowsAjaxTables = new RowsAjaxTables();
        }
        if (typeof RowsAjaxOrders !== "undefined") {
            const rowsAjaxOrders = new RowsAjaxOrders();
        }
        if (typeof RowsAjaxOrdersBranch !== "undefined") {
            const rowsAjaxOrdersBranch = new RowsAjaxOrdersBranch();
        }
        if (typeof RowsAjaxBranchWaiters !== "undefined") {
            const rowsAjaxBranchWaiters = new RowsAjaxBranchWaiters();
        }
        if (typeof RowsAjaxBranchTables !== "undefined") {
            const rowsAjaxBranchTables = new RowsAjaxBranchTables();
        }
        if (typeof RowsAjaxBranchMenu !== "undefined") {
            const rowsAjaxBranchMenu = new RowsAjaxBranchMenu();
        }
    }

    // Settings initialization
    _initSettings() {
        if (typeof Settings !== "undefined") {
            const settings = new Settings({
                attributes: { placement: "vertical" },
                showSettings: false,
                storagePrefix: "acorn-classic-dashboard-",
            });
            //   const settings = new Settings({attributes: {placement: 'vertical', color: 'light-lime', layout: 'fluid', radius: 'rounded', behaviour: 'unpinned' }, showSettings: false, storagePrefix: 'acorn-starter-project-'});
        }
    }

    // Variables initialization of Globals.js file which contains valus from css
    _initVariables() {
        if (typeof Variables !== "undefined") {
            const variables = new Variables();
        }
    }

    // Listeners of menu and layout changes which fires a resize event
    _addListeners() {
        document.documentElement.addEventListener(
            Globals.menuPlacementChange,
            (event) => {
                setTimeout(() => {
                    window.dispatchEvent(new Event("resize"));
                }, 25);
            }
        );

        document.documentElement.addEventListener(
            Globals.layoutChange,
            (event) => {
                setTimeout(() => {
                    window.dispatchEvent(new Event("resize"));
                }, 25);
            }
        );

        document.documentElement.addEventListener(
            Globals.menuBehaviourChange,
            (event) => {
                setTimeout(() => {
                    window.dispatchEvent(new Event("resize"));
                }, 25);
            }
        );
    }
}

// Shows the template after initialization of the settings, nav, variables and common plugins.
(function () {
    window.addEventListener("DOMContentLoaded", () => {
        // Initializing of the Scripts
        if (typeof Scripts !== "undefined") {
            const scripts = new Scripts();
        }
    });
})();

// Disabling dropzone auto discover before DOMContentLoaded
(function () {
    if (typeof Dropzone !== "undefined") {
        Dropzone.autoDiscover = false;
    }
})();

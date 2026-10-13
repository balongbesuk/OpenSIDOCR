// Notifikasi
window.setTimeout(function () {
  $("#notifikasi")
    .fadeTo(500, 0)
    .slideUp(500, function () {
      $(this).remove();
    });
}, 1000);

// Sidebar
if (
  typeof Storage !== "undefined" &&
  localStorage.getItem("sidebar") === "false"
) {
  $("#sidebar_collapse").addClass("sidebar-collapse");
}

$(".sidebar-toggle").on("click", function () {
  localStorage.setItem(
    "sidebar",
    $("#sidebar_collapse").hasClass("sidebar-collapse")
  );
});

// Koordinasi Sidebar Navigasi dan Sidebar Informasi (Control Sidebar) di tampilan mobile
document.addEventListener(
  "click",
  function (e) {
    var togglePushMenu = e.target.closest(
      ".sidebar-toggle, [data-toggle='push-menu']"
    );
    var toggleControlSidebar = e.target.closest(
      "[data-toggle='control-sidebar']"
    );

    if (togglePushMenu) {
      var isControlOpen =
        document.querySelector(".control-sidebar.control-sidebar-open") ||
        document.body.classList.contains("control-sidebar-open");

      if (isControlOpen) {
        // Hentikan propagasi toggle default agar tidak terjadi desinkronisasi
        e.stopPropagation();
        e.preventDefault();

        // 1. Tutup sidebar informasi
        document.querySelectorAll(".control-sidebar").forEach(function (el) {
          el.classList.remove("control-sidebar-open");
        });
        document.body.classList.remove("control-sidebar-open");
        if (window.jQuery && window.jQuery.fn.controlSidebar) {
          window.jQuery('[data-toggle="control-sidebar"]').controlSidebar("collapse");
        }

        // 2. Pastikan sidebar navigasi utama tampil
        if (window.innerWidth <= 767) {
          document.body.classList.add("sidebar-open");
          document.body.classList.remove("sidebar-collapse");
        } else {
          document.body.classList.remove("sidebar-collapse");
        }

        if (typeof Storage !== "undefined") {
          localStorage.setItem("sidebar", "false");
        }
        return;
      }
    }

    if (toggleControlSidebar && window.innerWidth <= 767) {
      // Jika di mobile dan sidebar navigasi utama sedang terbuka, tutup sidebar navigasi
      if (document.body.classList.contains("sidebar-open")) {
        document.body.classList.remove("sidebar-open");
        if (window.jQuery && window.jQuery.fn.pushMenu) {
          window.jQuery('[data-toggle="push-menu"]').pushMenu("close");
        }
      }
      // Tutup dropdown profil jika menu informasi dibuka dari dalam dropdown
      var userDropdown = document.querySelector(
        ".navbar-custom-menu .dropdown.user.user-menu"
      );
      if (userDropdown) {
        userDropdown.classList.remove("open");
      }
    }
  },
  true
);

// Select2 default
$(".select2").select2();

// Select2 dengan fitur pencarian dan boleh isi sendiri
$(".select2-tags").select2({
  tags: true,
});

//CheckBox All Selected
checkAllHeader("id_cb[]");
checkAllBody("#checkall", "#tabeldata", "id_cb[]");

function checkAllHeader(name = "id_cb[]") {
  $("table").on("click", "input[name='" + name + "']", function () {
    enableHapusTerpilih(name);
  });
  enableHapusTerpilih(name);
}

function checkAllBody(
  id = "#checkall",
  tabel = "#tabeldata",
  name = "id_cb[]"
) {
  $("table").on("click", id, function () {
    if ($(this).is(":checked")) {
      $(tabel + " input[type=checkbox]").each(function () {
        $(this).prop("checked", true);
      });
    } else {
      $(tabel + " input[type=checkbox]").each(function () {
        $(this).prop("checked", false);
      });
    }
    $(tabel + " input[type=checkbox]").change();
    enableHapusTerpilih(name);
  });
  $("[data-toggle=tooltip]").tooltip();
}

function enableHapusTerpilih(name = "id_cb[]") {
  if ($("input[name='" + name + "']:checked:not(:disabled)").length <= 0) {
    $(".aksi-terpilih").addClass("disabled");
    $(".hapus-terpilih").addClass("disabled");
    $(".hapus-terpilih").attr("href", "#");
  } else {
    $(".aksi-terpilih").removeClass("disabled");
    $(".hapus-terpilih").removeClass("disabled");
    $(".hapus-terpilih").attr("href", "#confirm-delete");
  }
}

/*
 * Fixes the search menu on mobile
 * Todo: hapus fungsi dibawah ini jika melakukan upgrade adminlte ke >= 4.2.1
 */
+(function ($) {
  "use strict";

  var DataKey = "lte.layout";

  var Default = {
    slimscroll: true,
    resetHeight: true,
  };

  var Selector = {
    wrapper: ".wrapper",
    contentWrapper: ".content-wrapper",
    layoutBoxed: ".layout-boxed",
    mainFooter: ".main-footer",
    mainHeader: ".main-header",
    sidebar: ".sidebar",
    controlSidebar: ".control-sidebar",
    fixed: ".fixed",
    sidebarMenu: ".sidebar-menu",
    logo: ".main-header .logo",
  };

  var ClassName = {
    fixed: "fixed",
    holdTransition: "hold-transition",
  };

  var Layout = function (options) {
    this.options = options;
    this.bindedResize = false;
    this.activate();
  };

  Layout.prototype.activate = function () {
    this.fix();
    this.fixSidebar();

    $("body").removeClass(ClassName.holdTransition);

    if (this.options.resetHeight) {
      $("body, html, " + Selector.wrapper).css({
        height: "auto",
        "min-height": "100%",
      });
    }

    if (!this.bindedResize) {
      $(window).resize(
        function () {
          this.fix();
          this.fixSidebar();

          $(Selector.logo + ", " + Selector.sidebar).one(
            "webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",
            function () {
              this.fix();
              this.fixSidebar();
            }.bind(this)
          );
        }.bind(this)
      );

      this.bindedResize = true;
    }

    $(Selector.sidebarMenu).on(
      "expanded.tree",
      function () {
        this.fix();
        this.fixSidebar();
      }.bind(this)
    );

    $(Selector.sidebarMenu).on(
      "collapsed.tree",
      function () {
        this.fix();
        this.fixSidebar();
      }.bind(this)
    );
  };

  Layout.prototype.fix = function () {
    // Remove overflow from .wrapper if layout-boxed exists
    $(Selector.layoutBoxed + " > " + Selector.wrapper).css(
      "overflow",
      "hidden"
    );

    // Get window height and the wrapper height
    var footerHeight = $(Selector.mainFooter).outerHeight() || 0;
    var neg = $(Selector.mainHeader).outerHeight() + footerHeight;
    var windowHeight = $(window).height();
    var sidebarHeight = $(Selector.sidebar).height() || 0;

    // Set the min-height of the content and sidebar based on
    // the height of the document.
    if ($("body").hasClass(ClassName.fixed)) {
      $(Selector.contentWrapper).css("min-height", windowHeight - footerHeight);
    } else {
      var postSetHeight;

      if (windowHeight >= sidebarHeight) {
        $(Selector.contentWrapper).css("min-height", windowHeight - neg);
        postSetHeight = windowHeight - neg;
      } else {
        $(Selector.contentWrapper).css("min-height", sidebarHeight);
        postSetHeight = sidebarHeight;
      }

      // Fix for the control sidebar height
      var $controlSidebar = $(Selector.controlSidebar);
      if (typeof $controlSidebar !== "undefined") {
        if ($controlSidebar.height() > postSetHeight)
          $(Selector.contentWrapper).css(
            "min-height",
            $controlSidebar.height()
          );
      }
    }
  };

  Layout.prototype.fixSidebar = function () {
    // Make sure the body tag has the .fixed class
    if (!$("body").hasClass(ClassName.fixed)) {
      if (typeof $.fn.slimScroll !== "undefined") {
        $(Selector.sidebar).slimScroll({ destroy: true }).height("auto");
      }
      return;
    }

    // Enable slimscroll for fixed layout
    if (this.options.slimscroll) {
      if (typeof $.fn.slimScroll !== "undefined") {
        // Destroy if it exists
        // $(Selector.sidebar).slimScroll({ destroy: true }).height('auto')

        // Add slimscroll
        $(Selector.sidebar).slimScroll({
          height: $(window).height() - $(Selector.mainHeader).height() + "px",
          color: "rgba(0,0,0,0.2)",
          size: "3px",
        });
      }
    }
  };

  // Plugin Definition
  // =================
  function Plugin(option) {
    return this.each(function () {
      var $this = $(this);
      var data = $this.data(DataKey);

      if (!data) {
        var options = $.extend(
          {},
          Default,
          $this.data(),
          typeof option === "object" && option
        );
        $this.data(DataKey, (data = new Layout(options)));
      }

      if (typeof option === "string") {
        if (typeof data[option] === "undefined") {
          throw new Error("No method named " + option);
        }
        data[option]();
      }
    });
  }

  var old = $.fn.layout;

  $.fn.layout = Plugin;
  $.fn.layout.Constuctor = Layout;

  // No conflict mode
  // ================
  $.fn.layout.noConflict = function () {
    $.fn.layout = old;
    return this;
  };

  // Layout DATA-API
  // ===============
  Plugin.call($("body"));
})(jQuery);

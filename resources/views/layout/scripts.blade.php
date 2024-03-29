<!-- Vendor Scripts Start -->
<script src="/js/vendor/jquery-3.5.1.min.js"></script>
<script src="/js/vendor/bootstrap.bundle.min.js"></script>
<script src="/js/vendor/OverlayScrollbars.min.js"></script>
<script src="/js/vendor/autoComplete.min.js"></script>
<script src="/js/vendor/clamp.min.js"></script>
<script src="/js/vendor/bootstrap-notify.min.js"></script>
<script src="/icon/acorn-icons.js"></script>
<script src="/icon/acorn-icons-interface.js"></script>
@yield('js_vendor')
<!-- Vendor Scripts End -->
<!-- Template Base Scripts Start -->
<script src="/js/base/helpers.js?r=1664915426"></script>
<script src="/js/base/globals.js?r=1664915426"></script>
<script src="/js/base/nav.js?r=1664915426"></script>
<script src="/js/base/settings.js?r=1664915426"></script>
<!-- Template Base Scripts End -->
<!-- Page Specific Scripts Start -->
<script src="/js/app.js?r=1664915426"></script>
@if (Session::has('notify'))
<script>
    callNotify( "{{ Session::get('notify') }}", "{{ Session::get('title') }}")
</script>
@endif
@yield('js_page')
<script src="/js/common.js?r=1664915426"></script>
<script src="/js/scripts.js?r=1664915426"></script>
<!-- Page Specific Scripts End -->

<!-- BEGIN: Vendor JS-->
@yield('vendor-script')
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('default_theme/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('default_theme/js/vibrant.min.js') }}"></script>
<script src="{{ asset('default_theme/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('default_theme/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('default_theme/js/app.min.js') }}"></script>
<script src="{{ asset('default_theme/js/preventdoublesubmission.js') }}"></script>
<script src="{{ asset('default_theme/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('default_theme/libs/select2/select2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>

<script>
    $(function() {
        $('.select2').select2({
            placeholder: $(this).data('placeholder'),
            closeOnSelect: false,
        });
    });
</script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->
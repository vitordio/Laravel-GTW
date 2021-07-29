@if (Auth::check())
    <!-- Footer START -->
    <footer class="footer">
        <div class="footer-content">
            <p class="m-b-0">@lang('labels.rodape')</p>
            <span class="text-gray m-r-15">@lang('labels.direitos')</span>
        </div>
    </footer>
    <!-- Footer END -->

    <!-- Core Vendors JS -->
    <script src="{{ asset('assets/js/vendors.min.js') }}"></script>
    
    <!-- page js -->
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
    
    <!-- Core JS -->
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    
    <!-- Data table -->
    <script src="{{ asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>
    
    {{-- BootBox --}}
    <script src="{{ asset('assets/vendors/bootbox/bootbox.all.min.js') }}"></script>
    
    {{-- Arquivo default para uso geral das páginas --}}
    <script src="{{ asset('assets/js/default.js') }}"></script>
    
    {{-- JQuery Mask Plugin --}}
    <script src="{{ asset('assets/vendors/jquery-mask-plugin/src/jquery.mask.js') }}"></script>

    {{-- Custom Masks --}}
    <script src="{{ asset('assets/js/customMasks.js') }}"></script>

    {{-- Select2 --}}
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>

    @yield('scripts')
@else
    {{-- Google captcha no login --}}
    <script src="{{ asset('assets/js/captcha.js') }}"></script>
@endif

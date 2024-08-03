<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , Tecnologias Megabit, Sysprossv
            </div>
            <div class="d-none d-lg-inline-block">
                <a href="#" class="footer-link me-4">Master Restaurant</a>
                {{--
                    @php
                        $empresa =DB::table('empresas')->first();
                    @endphp
                    @if ($empresa)
                        {{ $empresa->razon }}
                    @endif
                --}}
                <a href="#"  class="footer-link d-none d-sm-inline-block">V 1.0</a>
            </div>
        </div>
    </div>
</footer>

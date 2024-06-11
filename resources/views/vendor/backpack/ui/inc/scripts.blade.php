@basset('https://unpkg.com/jquery@3.6.1/dist/jquery.min.js')
@basset('https://unpkg.com/@popperjs/core@2.11.6/dist/umd/popper.min.js')
@basset('https://unpkg.com/noty@3.2.0-beta-deprecated/lib/noty.min.js')
@basset('https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js')
@basset('https://unpkg.com/imask@7.6.1/dist/imask.js')

@if (backpack_theme_config('scripts') && count(backpack_theme_config('scripts')))
    @foreach (backpack_theme_config('scripts') as $path)
        @if(is_array($path))
            @basset(...$path)
        @else
            @basset($path)
        @endif
    @endforeach
@endif

@if (backpack_theme_config('mix_scripts') && count(backpack_theme_config('mix_scripts')))
    @foreach (backpack_theme_config('mix_scripts') as $path => $manifest)
        <script type="text/javascript" src="{{ mix($path, $manifest) }}"></script>
    @endforeach
@endif

@if (backpack_theme_config('vite_scripts') && count(backpack_theme_config('vite_scripts')))
    @vite(backpack_theme_config('vite_scripts'))
@endif

@include(backpack_view('inc.alerts'))

@if(config('app.debug'))
    @include('crud::inc.ajax_error_frame')
@endif

@push('after_scripts')
    @basset(base_path('vendor/backpack/crud/src/resources/assets/js/common.js'))
@endpush
<script type="text/javascript">
    function maiuscula(z){
        v = z.value.toUpperCase();
        z.value = v;
    }

    function formatCnpjCpf(z) {
        cnpjCpf = z.value;

        if (cnpjCpf.length === 11) {
            v = cnpjCpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3-\$4");
            z.value = v;
        }
        if(cnpjCpf.length === 14){
            v = cnpjCpf.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/g, "\$1.\$2.\$3/\$4-\$5");
            z.value = v;
        }
    }

    function formatZipCode(z) {
        cnpjCpf = z.value;

        if (cnpjCpf.length === 8) {
            v = cnpjCpf.replace(/(\d{5})(\d{3})/g, "\$1-\$2");
            z.value = v;
        }
    }

    function minusculo(z){
        v = z.value.toLowerCase();
        z.value = v;
    }

</script>

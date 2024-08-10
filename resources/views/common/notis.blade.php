<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('select2ActiEmpresa').select2()
        $('#select2ActiEmpresa').on('change', function(e) {
            var mId = $('#select2ActiEmpresa').select2('val')
            var mName = $('#select2ActiEmpresa option:selected').text()
            @this.set('actividadSelectId', mId)
            @this.set('actividadSelectName', mName)
        });
    });
</script>

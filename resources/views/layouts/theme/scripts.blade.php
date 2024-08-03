<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="../../assets/vendor/libs/jquery/jquery.js"></script>
<script src="../../assets/vendor/libs/popper/popper.js"></script>
<script src="../../assets/vendor/js/bootstrap.js"></script>
<script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
<script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="../../assets/vendor/libs/hammer/hammer.js"></script>
<script src="../../assets/vendor/libs/i18n/i18n.js"></script>
<script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
<script src="../../assets/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="../../assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

<!-- Main JS -->
<script src="../../assets/js/main.js"></script>

<!-- Page JS -->
<script src="../../assets/js/dashboards-analytics.js"></script>
<script src="../../assets/vendor/libs/toastr/toastr.js"></script>
<script src="../../assets/js/ui-toasts.js"></script>
<script src="../../assets/js/extended-ui-sweetalert2.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    window.addEventListener('noty', event => {
        Toastify({
            text: event.detail.msg,
            duration: 4000,
            gravity: 'bottom',
            style: {
                background: "linear-gradient(to right, #28a745, #218838)", // Verde de Bootstrap success
                color: "#ffffff", // Texto en blanco
                borderRadius: "8px", // Esquinas redondeadas
                padding: "10px 20px", // Padding adicional para mejor apariencia
                boxShadow: "0 4px 6px rgba(0, 0, 0, 0.1)", // Sombra para dar profundidad
            },
        }).showToast();
    });

    window.addEventListener('close-modal', () => {
        $('#MyModal').modal('hide'); // Asegúrate de reemplazar `yourModalId` con el ID de tu modal
    });

    window.addEventListener('open-modal', () => {
        $('#MyModal').modal('show'); // Asegúrate de reemplazar `yourModalId` con el ID de tu modal
    });

    function confirmDestroy(id) {
        Swal.fire({
            title: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('destroy', {
                    id: id
                });
            }
        });
    }
</script>

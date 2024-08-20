<div class="row" style="display: flex; flex-direction: column;">
    <!-- Form Separator -->
    <div class="col-xxl">
        <div class="card mb-6">
            <div style="display: flex; justify-content: space-between;align-items: center; margin-bottom: -3rem;">
                <h5 class="card-header">Crear Traslado <i class="ri-arrow-up-down-line"></i></h5>
                <button type="submit" class="btn btn-primary me-4 waves-effect waves-light mr-2">
                    <i style="margin-right: 0.3rem;" class="ri-save-line"></i>
                    Procesar Traslado 
                </button>
                
            </div>
            
            <form class="card-body">
            <hr class="my-6 mx-n4">
                <h6>1. Detalles Del Traslado</h6>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="multicol-email">Sucursal Origen </label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-merge">
                            <select wire:model.lazy="categoria" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                <option selected=""></option>
                                @forelse ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">
                                    {{ $sucursal->nombre }}
                                    </option>
                                @empty
                                    <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="multicol-email">Sucursal Destino </label>
                    <div class="col-sm-9">
                        <div class="input-group input-group-merge">
                            <select wire:model.lazy="categoria" class="form-select" data-allow-clear="true" tabindex="-1" aria-hidden="true">
                                <option selected=""></option>
                                @forelse ($sucursales as $sucursal)
                                    <option value="{{ $sucursal->id }}">
                                    {{ $sucursal->nombre }}
                                    </option>
                                @empty
                                    <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label">Fecha Traslado</label>
                    <div class="col-sm-9">
                        <input type="date"  class="form-control dob-picker flatpickr-input" placeholder="YYYY-MM-DD">
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-3 col-form-label" for="basic-default-message">Detalles</label>
                    <div class="col-sm-9">
                        <textarea id="basic-default-message" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?" aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2"></textarea>
                    </div>
                </div>

                <div class="input-group input-group-merge  mb-5 w-50" style="display: none;">
                    <span id="basic-icon-default-fullname2" class="input-group-text">
                        <i class="ri-text" style="color: #8e8e8e;"></i>
                    </span>
                    <div class="form-floating form-floating-outline" >
                        <input type="text" wire:model.lazy="marca" id="productos_json" class="form-control" placeholder="Nombre del Marca">
                        <label for="marca">JSON</label>

                        @error('marca')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </form>
        </div>
    </div>


    <div class="col-xxl">
        <div class="card mb-6">
            <form class="card-body">
                <h6>2. Carrito De Productos</h6>

                <div class="col-sm-12 col-md-12 mb-3">
                    {{-- <style>
                        #searchTraslado .position-relative .select2-container{
                            max-width: 40.5rem !important;
                            min-width: 40.5rem !important;
                        }
                    </style> --}}



                    <div class="row mb-4" wire:ignore id='searchTraslado'>
                        <label class="col-sm-3 col-form-label" for="inputGroupSelect01">Productos a Trasladar</label>
                        <div class="col-sm-9" >
                            <select id="select2ActiEmpresa" class="select2 form-select form-select-lg select2-hidden-accessible" data-allow-clear="true"            data-select2-id="select2ActiEmpresa" tabindex="-1" aria-hidden="true"  style="width: 100%;">
                                <option selected=""></option>
                                @forelse ($productos as $producto)
                                    <option value="{{ $producto->id }}">
                                        CODIGO: {{ $producto->codigo_barra }} - 
                                        NOMBRE: {{ $producto->producto  }} -
                                        UM: {{ $producto->unidadMedida->nombre }} -
                                        PRECIO: {{ $producto->csiva }}
                                    </option>
                                @empty
                                    <option>No hay actividades disponibles</option> <!-- Añadir opción vacía -->
                                @endforelse
                            </select>
                            <div style="display: flex;justify-content: right;margin-top: 1rem;">
                                <button type="button" style="margin-right: 1rem;" class="btn btn-warning waves-effect waves-light" id="reloadButton">
                                <i class="ri-loop-left-line" style="margin-right: 0.3rem;"></i> Reiniciar </button>
                                <button type="button" class="btn btn-success waves-effect waves-light" id="selectButton"><i class="ri-add-line" style="margin-right: 0.15rem;"></i> Agregar </button>
                            </div>
                        </div>

                    </div>
                    @error('actividad')
                        <span class="text-danger er">{{ $message }}</span>
                    @enderror

                </div>

                <div class="table-responsive">
                    <table class="table table-responsive-md table-hover">
                        <thead class="thead-primary">
                            <tr>
                                <th class="text-center">Codigo</th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Medida</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Accion</th>
                            </tr>
                        </thead>

                        <tbody id="selectedProductsBody">

                        </tbody> 


                        

                    </table>
                    <div style="display: flex;justify-content: right;margin-top: 1rem;">
                        <button type="button" style="display: none !important;" class="btn btn-info waves-effect waves-light" id="selectButton2">
                            <i class="ri-shopping-cart-2-line" style="margin-right: 0.3rem;"></i> Terminar Carrito 
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script>
    let selectedProducts = [];
        function eliminarFila(id) {
            const tr = document.getElementById(id);
            if (tr) {
                tr.remove();
            }

        }

        function filaExiste(id) {
            return document.getElementById(id) !== null;
        }
        document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('select2ActiEmpresa');
        const button = document.getElementById('selectButton');
        const button2 = document.getElementById('selectButton2');
        const selectedProductsDiv = document.getElementById('selectedProductsBody');
        let selectedProducts = [];

        button.addEventListener('click', function() {
            const selectedOption = select.options[select.selectedIndex];
            const selectedValue = selectedOption.value;
            const selectedText = selectedOption.text;
            const selectedPrice = parseFloat(selectedOption.getAttribute('data-precio'));

            if (selectedValue) {
                const parts = selectedText.split(' - ');
                const codigo = parts[0].split(': ')[1];
                const nombre = parts[1].split(': ')[1];
                const um = parts[2].split(': ')[1];
                const precio = parts[3].split(': ')[1];

                // Verificar si el producto ya está en la lista
                const existingProductIndex = selectedProducts.findIndex(product => product.value === selectedValue);
                button2.style.display = 'block';
                if (existingProductIndex >= -1) {
                    selectedProducts.push({
                        value: selectedValue,
                        codigo: codigo,
                        nombre: nombre,
                        um: um,
                        price: parseFloat(precio)
                    });

                    const rowId = `row-${selectedValue}`;

                    if (filaExiste(rowId)) {
                        console.log(`Fila con id ${rowId} ya existe.`);
                        return; // Salir de la función si la fila ya existe
                    }

                    // Crear y añadir una nueva fila a la tabla
                    const row = document.createElement('tr');
                    row.id = `row-${selectedValue}`;
                    row.innerHTML = `
                        <td class="text-center">${codigo}</td>
                        <td class="text-center">${nombre}</td>
                        <td class="text-center">${um}</td>
                        <td class="text-center">
                            <input style="background-color:transparent; border: none; width: 4rem" type="number" value="1" min="1" data-price="${precio}" class="quantity-input">
                        </td>
                        <td class="total-cell text-center">
                            ${precio}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-outline-danger waves-effect waves-light" onclick="eliminarFila('row-${selectedValue}')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </td>
                    `;
                    selectedProductsDiv.appendChild(row);

                    // Añadir el evento para actualizar el total
                    row.querySelector('.quantity-input').addEventListener('input', function() {
                        const quantity = parseFloat(this.value) || 1;
                        const price = parseFloat(this.getAttribute('data-price'));
                        const totalCell = this.closest('tr').querySelector('.total-cell');
                        totalCell.textContent = (quantity * price).toFixed(2);
                    });


                }
            }
        });
        
        button2.addEventListener('click', function() {
            function capturarDatos() {
                let productos = [];
                let filas = document.querySelectorAll('#selectedProductsBody tr');
                filas.forEach(function(fila) {
                    let celdas = fila.querySelectorAll('td');
                    let producto = {
                        id: celdas[0].textContent.trim(),
                        nombre: celdas[1].textContent.trim(),
                        unidad: celdas[2].textContent.trim(),
                        cantidad: parseInt(celdas[3].querySelector('input').value),
                        precio: parseFloat(celdas[3].querySelector('input').getAttribute('data-price')),
                        total: parseFloat(celdas[4].textContent.trim())
                    };
                    productos.push(producto);
                });

                return productos;
            }

            function guardarDatos() {
                let productos = capturarDatos();
                document.getElementById('productos_json').value = JSON.stringify(productos);


                Toastify({
                    text: 'Productos Guardados ✓',
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
            }
            guardarDatos(); 

        });

        // Función para limpiar el tbody y el input
        function limpiarTablaYInput() {
            const tbody = document.getElementById('selectedProductsBody');
            const productosJsonInput = document.getElementById('productos_json');

            // Eliminar todos los <tr> dentro del tbody
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }

            // Limpiar el valor del input productos_json
            productosJsonInput.value = '';

            // También vaciar la lista de productos seleccionados si es necesario
            selectedProducts = [];
            Toastify({
                text: 'Carrito Reiniciado ✓',
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
        }

        // Asociar la función al evento click del botón reloadButton
        document.getElementById('reloadButton').addEventListener('click', limpiarTablaYInput);



    });

    </script>
</div>


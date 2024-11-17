<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\ProductosMarca;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
class ProductosMarcas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $records, $selected_id,$pageTitle, $modalAction, $componentName, $codigo,
    $valor, $status, $pagination = 10, $nombre, $estado, $image, $allImages = [],$imageChange, $activateNewSection;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Marcas';
    }

    public function render()
    {
        return view('livewire.productos_marcas.productos_marcas',[
            'marcas' => $this->Allmarcas()
        ]);
    }

    public function Allmarcas()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ProductosMarca::where('nombre', 'like', "%{$this->search}%")
                ->orderBy('created_at', 'desc');

        } else {
            $query = ProductosMarca::orderBy('created_at', 'desc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    protected function rules()
    {
        $rules = [
            'nombre' => "required|min:1",
            'estado' => "required|min:1",
        ];


        return $rules;
    }

    protected function messages()
    {
        return [
            'nombre.required' => 'La nombre es requerido',
            'nombre.unique' => 'Ya existe la nombre',
            'nombre.min'=> 'La nombre debe tener mas de 1 caracteres',
            'estado.required' => 'El estado del producto es requerido',
            'estado.min'=> 'El estado debe tener mas de 1 caracteres'
        ];
    }


    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $createMarca = ProductosMarca::create([
            'nombre' => $this->nombre,
            'estado' => $this->estado
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/marcas', $customFileName);
            $createMarca->image = $customFileName;
            $createMarca->save();
        }

        $createMarca->save();

        $this->dispatch('noty', msg: 'Marca registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id, $activateNewSection = true)
    {
        $selectMarca = ProductosMarca::find($id);
        $this->nombre = $selectMarca->nombre;
        $this->estado = $selectMarca->estado;
        $this->selected_id = $selectMarca->id;
        $this->image = $selectMarca->image;
        $this->activateNewSection = $activateNewSection;

        $this->allImages = Storage::disk('public')->files('marcas');
        usort($this->allImages, function ($a, $b) {
            return Storage::disk('public')->lastModified($b) - Storage::disk('public')->lastModified($a);
        });


        $this->dispatch('open-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $updateMarca = ProductosMarca::find($this->selected_id);
        $updateMarca->nombre = $this->nombre;
        $updateMarca->estado = $this->estado;
        if (!empty($this->imageChange)) {
            $updateMarca->image = $this->imageChange;
        } else {
            if ($this->image && is_file($this->image)) {
                $customFileName = uniqid() . '_.' . pathinfo($this->image->getClientOriginalName(), PATHINFO_EXTENSION);
                $this->image->storeAs('public/marcas', $customFileName);
                $imagetemp = $updateMarca->image;
                $updateMarca->image = $customFileName;

            }
        }
        $updateMarca->save();

        $this->dispatch('noty', msg: 'PRODUCTO Actualizado con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');

        return redirect()->route(route: 'productosMarcas');
    }


    #[On('destroy')]
    public function destroy($id)
    {
        $deleteMarca = ProductosMarca::findOrFail($id);
        if ($deleteMarca->HProducto()->exists()) {
            $this->dispatch('noty-error', msg: 'NO POSIBLE ELIMINAR LA MARCA - este registro se esta usando en otro modulo');
            return;
        }
        $deleteMarca->delete();

        $this->resetPage();
        $this->ResetInt();
        $this->dispatch('noty', msg: 'MARCA ELIMINADA CON ÉXITO');
    }

    public function renderImage($filename)
    {

        $path = 'public/marcas/' . $filename;
        if (!Storage::exists($path)) {
            abort(404);
        }
        return response()->file(storage_path("app/{$path}"));
    }

    public function eliminarImagen($imgDelete)
    {
        $imagePath = 'marcas/' . $imgDelete;

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);

            // Actualizar la lista de imágenes después de la eliminación
            $this->allImages = Storage::disk('public')->files('marcas');

            // Reiniciar la página si es necesario
            $this->resetPage();

            // Enviar notificación de éxito
            $this->dispatch('noty', msg: 'Imagen eliminada exitosamente.');
        } else {
            // Manejar el caso donde la imagen no existe
            $this->dispatch('noty', msg: 'La imagen no fue encontrada.');
        }
    }


    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->nombre = '';
        $this->estado = '';
        $this->imageChange = '';
        $this->resetValidation();
    }

}

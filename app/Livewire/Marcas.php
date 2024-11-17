<?php

namespace App\Livewire;

use App\Models\Marcas as ModelsMarcas;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
class Marcas extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search, $selected_id, $pageTitle, $modalAction, $componentName, $marca, $pagination = 10, $image, $allImages = [],$imageChange, $activateNewSection;

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Marcas';
    }

    public function render()
    {
        return view('livewire.marcas.marcas', [
            'marcas' => $this->loadData()
        ]);
    }

    public function loadData()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = ModelsMarcas::where('marca', 'like', "%{$this->search}%")
                ->orderBy('marca', 'asc');

        } else {
            $query = ModelsMarcas::orderBy('id', 'asc');
        }

        return $query->paginate($this->pagination);
    }

    protected function rules()
    {
        $rules = [
            'marca' => "required|unique:marcas,marca,{$this->selected_id}|min:3",
        ];

        return $rules;
    }

    protected function messages()
    {
        return [
            'marca.required' => 'El nombre de la marca es requerido',
            'marca.unique' => 'Ya existe esta marca',
            'marca.min'=> 'El nombre de la marca debe tener mas de 3 caracteres',
        ];
    }

    public function Store()
    {
        $this->validate($this->rules(), $this->messages());

        $data = ModelsMarcas::create([
            'marca' => $this->marca,
        ]);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/marcas', $customFileName);
            $data->image = $customFileName;
            $data->save();
        }

        $this->dispatch('noty', msg: 'Marca registrada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Edit($id,  $activateNewSection = true)
    {
        $marca = ModelsMarcas::find($id);
        $this->marca = $marca->marca;
        $this->selected_id = $marca->id;
        $this->image = $marca->image;
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

        $data = ModelsMarcas::find($this->selected_id);
        $data->marca = $this->marca;
        if (!empty($this->imageChange)) {
            $data->image = $this->imageChange;
        } else {
            if ($this->image && is_file($this->image)) {
                $customFileName = uniqid() . '_.' . pathinfo($this->image->getClientOriginalName(), PATHINFO_EXTENSION);
                $this->image->storeAs('public/marcas', $customFileName);
                $imagetemp = $data->image;
                $data->image = $customFileName;

            }
        }
        $data->save();

        $this->dispatch('noty', msg: 'Marca Actualizada con exito');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    #[On('destroy')]

    public function destroy($id)
    {
        $data = ModelsMarcas::find($id);
        $data->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'MARCA ELIMINADA CON ÉXITO');
    }

    #[On('ResetInt')]
    public function ResetInt()
    {
        $this->marca = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
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

}

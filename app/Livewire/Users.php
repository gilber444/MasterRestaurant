<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $selected_id, $editing, $search, $records, $pagination = 8;
    public $name;
    public $email, $password, $profile, $status,  $temppwd, $componentName, $pageTitle, $roles=[], $empresas= [];
    public $image, $showPassword;
    public $usuario;
    public $phone;
    public $empresa;

    protected function rules()
    {
        $rules = [
            'name' => 'required|max:85',
            'usuario' => 'required|max:50|unique:users,user,'. ($this->selected_id ?? 'NULL') . ',id',
            'email' => 'required|email|max:75|unique:users,email,' . ($this->selected_id ?? 'NULL') . ',id',
            'phone' => 'required|max:8',
            'password' => [
                'required',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/'
            ],
            'status' => 'required|not_in:elegir|in:ACTIVE,LOCKED',
            'profile' => 'required|not_in:elegir|',
            'empresa' => 'required|not_in:elegir|',
            'image' => 'nullable|image|max:1024', // Limit image size to 1MB
        ];

        if ($this->isUpdate()) {
            $rules['password'] = [
                'nullable',
                'min:6',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).+$/'
            ];
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'name.required' => 'Nombre requerido',
            'name.max' => 'Nombre debe tener máximo 85 caracteres',
            'usuario.required' => 'Usuario requerido',
            'usuario.max' => 'Usuario debe tener máximo 50 caracteres',
            'usuario.unique' => 'El usuario ya existe',
            'email.required' => 'Correo electrónico requerido',
            'email.email' => 'Correo electrónico inválido',
            'email.max' => 'Correo electrónico debe tener máximo 75 caracteres',
            'email.unique' => 'El correo electrónico ya existe',
            'phone.required' => 'Teléfono requerido',
            'phone.max' => 'Teléfono debe tener máximo 20 caracteres',
            'password.required' => 'Contraseña requerida',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula, un número y un carácter especial',
            'status.required' => 'Estatus requerido',
            'status.in' => 'Elige un estatus válido',
            'status.not_in' => 'Elige un estatus válido que no sea "Elegir"',
            'profile.required' => 'Selecciona el perfil',
            'profile.in' => 'Elige un perfil válido',
            'profile.not_in' => 'Elige un perfil válido que no sea "Elegir"',
            'empresa.required' => 'Selecciona una empresa',
            'empresa.exists' => 'Empresa no válida',
            'empresa.not_in' => 'Elige una empresa válida que no sea "Elegir"',
            'image.image' => 'La imagen debe ser un archivo de imagen válido',
            'image.max' => 'La imagen no debe exceder 1MB',
        ];
    }
    protected function isUpdate()
    {
        return isset($this->selected_id);
    }

    public function mount()
    {

        $this->componentName = 'Usuarios';
        $this->pageTitle = 'Listado';
        $this->roles =Role::all();

        session(['map' => 'Usuarios', 'child' => ' Componente ']);
    }


    public function render()
    {
        return view('livewire.users.users', [
            'users' => $this->loadUsers()
        ]);
    }


    public function loadUsers()
    {
        if (!empty($this->search)) {

            $this->resetPage();

            $query = User::where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orderBy('name', 'asc');
            //$query = User::with('sales')->where('name', 'like', "%{$this->search}%")
                //->orWhere('email', 'like', "%{$this->search}%")
                //->orderBy('name', 'asc');
        } else {
            //$query =  User::with('sales')->orderBy('name', 'asc');
            $query =  User::orderBy('name', 'asc');
        }

        $this->records = $query->count();

        return $query->paginate($this->pagination);
    }

    public function Edit(User $user)
    {
        $this->name = $user->name;
        $this->usuario = $user->user;
        $this->phone = $user->phone;
        $this->email = $user->email;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->empresa = $user->empresa;
        $this->selected_id = $user->id;

        $this->dispatch('open-modal');
    }

    public function Store()
    {

        $this->validate($this->rules(), $this->messages());

        $user = User::create([
            'name' => $this->name,
            'user'  => $this->usuario,
            'phone'  => $this->phone,
            'email'  => $this->email,
            'profile'  => $this->profile,
            'status'  => $this->status,
            'password' => bcrypt($this->password),
            'empresa'  => $this->empresa
        ]);

        $user->syncRoles($this->profile);

        if($this->image)
        {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/users', $customFileName);
            $user->image = $customFileName;
            $user->save();
        }
        $this->dispatch('noty', msg: 'USUARIO REGISTRADO CON ÉXITO');
        $this->ResetInt();
        $this->dispatch('close-modal');
    }

    public function Update()
    {
        $this->validate($this->rules(), $this->messages());

        $user = User::find($this->selected_id);
        $user->name = $this->name;
        $user->user  = $this->usuario;
        $user->phone  = $this->phone;
        $user->email  = $this->email;
        $user->profile  = $this->profile;
        $user->status  = $this->status;
        $user->empresa  = $this->empresa;

        if (!empty($this->password)) {
            $user->password = bcrypt($this->password);
        }

        $user->save();

        $this->dispatch('noty', msg: 'USUARIO ACTUALIZADO CON ÉXITO');
        $this->ResetInt();
        $this->dispatch('close-modal');

    }

    #[On('destroy')]
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        $this->resetPage();
        $this->dispatch('noty', msg: 'USUARIO ELIMINADO CON ÉXITO');
    }

    public function ResetInt()
    {
        $this->name = '';
        $this->usuario = '';
        $this->phone = '';
        $this->email = '';
        $this->profile = 'Elegir';
        $this->status = 'Elegir';
        $this->password = '';
        $this->empresa = 'Elegir';
        $this->resetValidation();
        $this->resetPage();
    }

    public function renderImage($filename)
    {
        $path = 'public/users/' . $filename;
        if(!Storage::exists($path))
        {
            abort(404);
        }
        return response()->file(storage_path("app/{$path}"));
    }

}

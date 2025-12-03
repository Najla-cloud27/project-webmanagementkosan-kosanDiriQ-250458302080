<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserManagement extends Component
{
    use WithPagination;

    public $showModal = false;
    public $name, $email, $password, $password_confirmation, $role = 'penyewa';
    public $phone_number, $nik;
    public $search = '';
    public $editMode = false;
    public $userId;

    protected $paginationTheme = 'bootstrap';

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'phone_number' => 'nullable|string|max:20|unique:users,phone_number,' . $this->userId,
            'nik' => 'nullable|string|max:20|unique:users,nik,' . $this->userId,
            'role' => 'required|in:pemilik,penyewa',
        ];

        if (!$this->editMode) {
            $rules['password'] = 'required|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        } elseif (!empty($this->password)) {
            $rules['password'] = 'min:8|confirmed';
            $rules['password_confirmation'] = 'required_with:password';
        }

        return $rules;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->phone_number = '';
        $this->nik = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'penyewa';
        $this->editMode = false;
        $this->userId = null;
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'nik' => $this->nik,
            'role' => $this->role,
        ];

        if ($this->editMode) {
            $user = User::find($this->userId);
            
            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }
            
            $user->update($data);
            session()->flash('message', 'Pengguna berhasil diupdate.');
        } else {
            $data['password'] = Hash::make($this->password);
            User::create($data);
            session()->flash('message', 'Pengguna berhasil ditambahkan.');
        }

        $this->closeModal();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->userId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone_number = $user->phone_number;
        $this->nik = $user->nik;
        $this->role = $user->role;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function delete($id)
    {
        // Prevent deleting current user
        if (Auth::id() == $id) {
            session()->flash('error', 'Anda tidak dapat menghapus akun sendiri.');
            return;
        }

        User::find($id)->delete();
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users
        ]);
    }
}

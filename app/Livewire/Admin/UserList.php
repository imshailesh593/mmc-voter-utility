<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public ?int $confirmDeleteId = null;
    public string $confirmDeleteName = '';

    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    public function openCreate(): void
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showForm = true;
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    public function openEdit(int $id): void
    {
        $user = User::findOrFail($id);
        $this->editingId = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showForm = true;
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    public function save(): void
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editingId)],
        ];

        if (! $this->editingId || $this->password !== '') {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $this->validate($rules);

        if ($this->editingId) {
            $user = User::findOrFail($this->editingId);
            $user->name  = $this->name;
            $user->email = $this->email;
            if ($this->password !== '') {
                $user->password = Hash::make($this->password);
            }
            $user->save();
            $this->successMessage = 'User "' . $user->name . '" updated.';
        } else {
            $user = User::create([
                'name'     => $this->name,
                'email'    => $this->email,
                'password' => Hash::make($this->password),
            ]);
            $this->successMessage = 'User "' . $user->name . '" created.';
        }

        $this->showForm = false;
        $this->resetForm();
    }

    public function cancelForm(): void
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function confirmDelete(int $id): void
    {
        $user = User::findOrFail($id);
        if ($user->id === Auth::id()) {
            $this->errorMessage = 'You cannot delete your own account.';
            return;
        }
        $this->confirmDeleteId = $id;
        $this->confirmDeleteName = $user->name;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteId = null;
        $this->confirmDeleteName = '';
    }

    public function deleteUser(): void
    {
        if (! $this->confirmDeleteId) return;

        $user = User::find($this->confirmDeleteId);
        if ($user) {
            if ($user->id === Auth::id()) {
                $this->errorMessage = 'You cannot delete your own account.';
                $this->cancelDelete();
                return;
            }
            $name = $user->name;
            $user->delete();
            $this->successMessage = 'User "' . $name . '" deleted.';
        }

        $this->cancelDelete();
    }

    private function resetForm(): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->editingId = null;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.user-list', [
            'users' => User::orderBy('name')->get(),
        ]);
    }
}

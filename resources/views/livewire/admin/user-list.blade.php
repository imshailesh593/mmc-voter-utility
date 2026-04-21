<div>

    {{-- Alerts --}}
    @if($successMessage)
        <div class="alert alert-success" style="margin-bottom:1rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $successMessage }}
        </div>
    @endif
    @if($errorMessage)
        <div class="alert alert-error" style="margin-bottom:1rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $errorMessage }}
        </div>
    @endif

    {{-- Create / Edit Form --}}
    @if($showForm)
        <div class="card" style="margin-bottom:1.25rem">
            <div class="card-header">
                <span class="card-title">{{ $editingId ? 'Edit User' : 'New Admin User' }}</span>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="save" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">

                    <div style="display:flex;flex-direction:column;gap:0.35rem">
                        <label style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--gray-500)">Full Name</label>
                        <input wire:model="name" type="text" class="toolbar-input" placeholder="Dr. John Doe" style="width:100%">
                        @error('name') <span style="font-size:0.73rem;color:#dc2626">{{ $message }}</span> @enderror
                    </div>

                    <div style="display:flex;flex-direction:column;gap:0.35rem">
                        <label style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--gray-500)">Email Address</label>
                        <input wire:model="email" type="email" class="toolbar-input" placeholder="user@example.com" style="width:100%">
                        @error('email') <span style="font-size:0.73rem;color:#dc2626">{{ $message }}</span> @enderror
                    </div>

                    <div style="display:flex;flex-direction:column;gap:0.35rem">
                        <label style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--gray-500)">
                            Password{{ $editingId ? ' (leave blank to keep current)' : '' }}
                        </label>
                        <input wire:model="password" type="password" class="toolbar-input" placeholder="Min. 8 characters" style="width:100%">
                        @error('password') <span style="font-size:0.73rem;color:#dc2626">{{ $message }}</span> @enderror
                    </div>

                    <div style="display:flex;flex-direction:column;gap:0.35rem">
                        <label style="font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--gray-500)">Confirm Password</label>
                        <input wire:model="password_confirmation" type="password" class="toolbar-input" placeholder="Repeat password" style="width:100%">
                    </div>

                    <div style="grid-column:1/-1;display:flex;gap:0.65rem;justify-content:flex-end;padding-top:0.5rem;border-top:1px solid var(--gray-100)">
                        <button type="button" wire:click="cancelForm" class="btn btn-ghost">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ $editingId ? 'Save Changes' : 'Create User' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Users Table --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">Admin Users <span class="td-badge" style="margin-left:0.4rem">{{ count($users) }}</span></span>
            @if(!$showForm)
                <button wire:click="openCreate" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add User
                </button>
            @endif
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created</th>
                        <th style="width:1%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td class="td-name">
                                {{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span class="td-badge" style="background:#dcfce7;color:#166534;margin-left:0.3rem">You</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td style="color:var(--gray-400);font-size:0.78rem">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="td-actions">
                                    <button wire:click="openEdit({{ $user->id }})" class="btn btn-ghost btn-sm">Edit</button>
                                    @if($user->id !== auth()->id())
                                        <button wire:click="confirmDelete({{ $user->id }})" class="btn btn-danger btn-sm">Delete</button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align:center;color:var(--gray-400);padding:2rem">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Delete confirmation overlay --}}
    @if($confirmDeleteId)
        <div class="confirm-overlay">
            <div class="confirm-box">
                <h3>Delete User</h3>
                <p>Delete <strong>{{ $confirmDeleteName }}</strong>? This action cannot be undone.</p>
                <div class="confirm-actions">
                    <button wire:click="cancelDelete" class="btn btn-ghost">Cancel</button>
                    <button wire:click="deleteUser" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>

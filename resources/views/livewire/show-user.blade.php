<div>
    <h1 class="h3 mb-2 text-gray-800">Daftar User</h1>
    
    <div class="py-3">
        <div class="flex justify-between">
            <div class=" mb-3 w-1/4">
                <x-input.text wire:model="search" placeholder="Search User..." 
                    class="py-1 px-2 rounded-lg w-1/4"/>
            </div>
        </div>
        <div class="flex-col space-y-4 " >
            <x-table style="overflow: scroll; ">
                <x-slot name="head">
                    <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Name</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('email')" :direction="$sortField === 'email' ? $sortDirection : null">Email</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('nameBranch')" :direction="$sortField === 'nameBranch' ? $sortDirection : null">Bagian</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('role')" :direction="$sortField === 'role' ? $sortDirection : null">Akses</x-table.heading>
                    <x-table.heading sortable wire:click="sortBy('active')" :direction="$sortField === 'active' ? $sortDirection : null">Status</x-table.heading>
                    <x-table.heading ></x-table.heading>
                </x-slot>
                <x-slot name="body">
                    @forelse ( $users as $user )
                        <x-table.row>
                            <x-table.cell>{{ $user->name }}</x-table.cell>
                            <x-table.cell>{{ $user->email }}</x-table.cell>
                            <x-table.cell>{{ $user->nameBranch}}</x-table.cell>
                            <x-table.cell>{{ $user->role }}</x-table.cell>
                            <x-table.cell>{{ $user->active }}</x-table.cell>
                            <x-table.cell>
                                <x-button.link wire:click="edit({{ $user->id }})">Edit</x-button.link>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                                <x-table.cell colspan="6">
                                    <div class="flex justify-center items-center space-x-2">
                                        <x-icon.inbox class="h-8 w-8 text-cool-gray-400" />
                                        <span class="font-medium py-8 text-cool-gray-400 text-xl">Data yang ada cari tidak ada...</span>
                                    </div>
                                </x-table.cell>
                            </x-table.row>
                    @endforelse    
                </x-slot>
            </x-table>
            <div class="mt-3"> {{ $users->links() }}</div>
        </div>
        
    </div>

    <x-modal.dialog wire:model.defer="showEditModal">
        <x-slot name="title">Edit User</x-slot>
        <x-slot name="content">
            <x-input.group for="name" label="Name">
                <x-input.text id="name" wire:model="editing.name" id="name"
                class="w-10"
                />              
            </x-input.group>
        </x-slot>
        <x-slot name="footer">
            <x-button.secondary>Cancel</x-button.secondary>
            <x-button.primary>Save</x-button.primary>
        </x-slot>
    </x-modal.dialog>

    
</div>

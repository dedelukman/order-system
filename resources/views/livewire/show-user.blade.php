<div>
<div class="py-4">
    <div class="flex justify-between">
                <div class=" mb-3 w-1/4">
                    <x-input.text wire:model="search" placeholder="Search User..." 
                    class="py-1 px-2 rounded-lg w-1/4"/>
                </div>
            </div>
<div class="flex-col space-y-4 " >
    <x-table style="overflow: scroll; ">
        <x-slot name="head">
            <x-table.heading sortable wire:click="sortBy('name')">Name</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('email')">Email</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('nameBranch')">Bagian</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('role')">Akses</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('active')">Status</x-table.heading>
        </x-slot>
        <x-slot name="body">
            @forelse ( $users as $user )
                <x-table.row>
                    <x-table.cell>{{ $user->name }}</x-table.cell>
                    <x-table.cell>{{ $user->email }}</x-table.cell>
                    <x-table.cell>{{ $user->nameBranch}}</x-table.cell>
                    <x-table.cell>{{ $user->role }}</x-table.cell>
                    <x-table.cell>{{ $user->active }}</x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                        <x-table.cell colspan="5">
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
</div>

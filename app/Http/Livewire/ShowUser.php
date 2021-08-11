<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ShowUser extends Component
{
    use WithPagination;


    public $search;

    public $sortField;

    


    public function render()
    {
        return view('livewire.show-user', [
            // 'users'=>User::where('name','like', "%{$this->search}%")->paginate(10)
        'users' => DB::table('users')
        ->join('branches', 'users.branch_id','branches.id')
        ->select('users.*', 'branches.name as nameBranch')
        ->where('users.name','like',"%{$this->search}%")
        ->orWhere('users.email','like',"%{$this->search}%")
        ->orWhere('branches.name','like',"%{$this->search}%")
        ->latest()->paginate(10)
        ]);
    }
}

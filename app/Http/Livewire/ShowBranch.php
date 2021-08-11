<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBranch extends Component
{

    use WithPagination;

    public $search;

    public function changeActive(Branch $branch, $akses){
        $branch->active = $akses;
        $branch->save();
        
    }

    public function changePrice(Branch $branch, $akses){
        $branch->price = $akses;
        $branch->save();
      
    }

    public function changeCategory(Branch $branch, $akses){
        $branch->category = $akses;
        $branch->save();
        
    }

 

    public function render()
    {
        return view('livewire.show-branch', 
        ['branches' => Branch::
        where('code','like',"%{$this->search}%")
        ->orWhere('name','like',"%{$this->search}%")
        ->orWhere('category','like',"%{$this->search}%")
        ->paginate(10)]);
    
    }
}

<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;

class ShowBranch extends Component
{

    public $branches;

    public function mount(){
        $this->branches = Branch::all();
    }
    
    public function changeActive(Branch $branch, $akses){
        $branch->active = $akses;
        $branch->save();
        return redirect()->to('/branch');
    }

    public function render()
    {
        return view('livewire.show-branch');
    }
}

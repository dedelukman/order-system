<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBranch extends Component
{

    use WithPagination;

    public $search;
    public $sortField='name';
    public $sortDirection ='desc';
    public $titleEditModal = 'Edit';
    public Branch $editing;
    public Branch $deleting;
    

    public function rules() { 
        return [
            'editing.code' => 'required|min:3',
            'editing.name' => 'required',
            'editing.address' => 'required',
            'editing.discount' => 'required',
        ]; 
    }

    public function makeBlankTransaction(){
        return Branch::make();
    }

    public function create(){
        $this->editing =  $this->makeBlankTransaction();
        $this->titleEditModal='Tambah';
    }

    public function edit(Branch $branch){
        $this->editing = $branch;
         $this->titleEditModal='Edit';
    }

    public function deleteId(Branch $branch)
    {
        $this->deleting = $branch;
    }

    public function delete(){
        $this->deleting->delete();
        $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Berhasil di Delete!!"
            ]);
    }

    public function sortBy($field){

        if($this->sortField == $field){
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        }else{
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

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

    public function save()
    {
        $this->validate();

        try {
            $this->editing->save();    
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Berhasil Disimpan!!"
            ]);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Tidak Berhasil Disimpan!!"
            ]);
        }
    }

 

    public function render()
    {
        return view('livewire.show-branch', 
        ['branches' => Branch::
        where('code','like',"%{$this->search}%")
        ->orWhere('name','like',"%{$this->search}%")
        ->orWhere('category','like',"%{$this->search}%")
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)]);
    
    }
}

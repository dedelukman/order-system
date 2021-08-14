<?php

namespace App\Http\Livewire;

use App\Models\Branch as Entities;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBranch extends Component
{

    use WithPagination;
    

    public $search;
    public $sortField='name';
    public $sortDirection ='desc';
    public $titleEditModal = 'Edit';
    public $closeModal = false;
    public Entities $editing;
    public Entities $deleting;    
    

    protected $rules = [
            'editing.code' => 'required|min:3|unique:branches as editing',
            'editing.name' => 'required|unique:branches as editing',
            'editing.address' => 'required',
            'editing.discount' => 'required',
        ]; 
       

    public function makeBlankTransaction(){
        return Entities::make();
    }

    public function create(){
        $this->editing =  $this->makeBlankTransaction();
        $this->titleEditModal='Tambah';
    }

    public function edit(Entities $entity){
        $this->editing = $entity;
         $this->titleEditModal='Edit';
    }

    public function deleteId(Entities $entity)
    {
        $this->deleting = $entity;
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

    public function changeActive(Entities $entity, $akses){
        $entity->active = $akses;
        $entity->save();
        
    }

    public function changePrice(Entities $entity, $akses){
        $entity->price = $akses;
        $entity->save();
      
    }

    public function changeCategory(Entities $entity, $akses){
        $entity->category = $akses;
        $entity->save();
        
    }

    public function save()
    {
        $this->closeModal =false;
        $this->validate();
        

        try {
            $this->editing->save();    
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Berhasil Disimpan!!"
            ]);
            $this->dispatchBrowserEvent('closeModal'); 
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
        ['entities' => Entities::
        where('code','like',"%{$this->search}%")
        ->orWhere('name','like',"%{$this->search}%")
        ->orWhere('category','like',"%{$this->search}%")
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)]);
    
    }
}

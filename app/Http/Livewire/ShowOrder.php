<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use App\Models\Order as Entities;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Str;



class ShowOrder extends Component
{
    use WithPagination;


    public $search;
    public $sortField='code';
    public $sortDirection ='desc';    
    public $titleEditModal = 'Edit';
    public Entities $editing;
    public Entities $deleting;
    public $dropdownBranch;
    public $dropdownUser;
    

    public function mount(){
        $this->dropdownBranch = Branch::where('active','1')->get();
        $this->dropdownUser = User::where('active','1')->get();
    }

    public function rules() { 
        return [
            'editing.code' => 'required',
            'editing.branch_id' => 'required',
            'editing.user_id' => 'required',            
            'editing.status' => 'required',                                 
        ]; 
    }

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

     public function changeRole(Entities $entity, $akses){
        $entity->role = $akses;
        $entity->save();
      
    }

    public function changeActive(Entities $entity, $akses){
        $entity->active = $akses;
        $entity->save();
        
    }

    public function save()
    {
        $this->validate();
        $this->editing->slug = Str::slug($this->editing->name,'-');

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
        return view('livewire.show-order', [
         'entities' => Entities::leftJoin('branches', 'orders.branch_id','=','branches.id')    
        ->leftJoin('users', 'orders.user_id','=','users.id')  
        ->select('orders.*', 'branches.name as nameBranch', 'users.name as nameUser')
        ->where('orders.code','like',"%{$this->search}%")
        ->orWhere('orders.status','like',"%{$this->search}%")
        ->orWhere('branches.name','like',"%{$this->search}%")
        ->orWhere('users.name','like',"%{$this->search}%")
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)
        ]);
    }
}

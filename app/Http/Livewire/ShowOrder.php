<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use Livewire\Component;
use App\Models\Order as Entities;
use App\Models\User;
use Illuminate\Routing\Route;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;



class ShowOrder extends Component
{
    use WithPagination;


    public $search;
    public $sortField='code';
    public $sortDirection ='desc';      
    public Entities $editing;
    public Entities $deleting;
    public $dropdownBranch;

    

    public function mount(){
        $this->dropdownBranch = Branch::where('active','1')->get();        
    }

    public function rules() { 
        return [                     
            'editing.branch_id' => 'required',            
            'editing.description' => 'required',                                                        
        ]; 
    }

    public function makeBlankTransaction(){
        return Entities::make();
    }

    public function create(){
        $this->editing =  $this->makeBlankTransaction(); 
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

    
    public function save()
    {
        $this->validate();
        $this->editing->code = (Branch::find($this->editing->branch_id)->category =="DISTRIBUTOR" ? "OD" : 
        (Branch::find($this->editing->branch_id)->category =="AGEN" ? "OA" : "OC") ) 
        ."/".Branch::find($this->editing->branch_id)->code."/".date("ymdhi") ;
        $this->editing->user_id = Auth::id();

    

        try {
            $this->editing->save();    
            $this->dispatchBrowserEvent('closeModal');             
            return Redirect()->route('create.order',$this->editing);            
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

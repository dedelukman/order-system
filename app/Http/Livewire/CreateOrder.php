<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Order;
use Livewire\Component;
use App\Models\Product;
use App\Models\OrderDetail as Entities;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CreateOrder extends Component
{
    use WithPagination;

    public $code;
    public $branch;
    public $description;


    public $search;
    public $sortField='code';
    public $sortDirection ='desc';    
    public $titleEditModal = 'Edit';
    public Entities $editing;
    public Entities $deleting;
    public $dropdownMaster;    
    public $dropdown;    
    

    public function mount(){
        $this->dropdown = Product::where('active','1')->get();        
        $this->dropdownMaster = Branch::where('active','1')->get();        
    }

    public function saveForm(){
        $data = $this->validate([
            'code' => 'required',
            'branch' => 'required',
            
        ]);
        

        Order::Create([
            
            'code' => (Branch::find($this->branch)->category =="DISTRIBUTOR" ? "OD" : 
            (Branch::find($this->branch)->category =="AGEN" ? "OA" : "OC") ) 
            ."/".Branch::find($this->branch)->code."/".date("ymdhi") ,
            'branch_id' => $data['branch'],
            'description' => $this->description,
            'user_id' => Auth::id(),
        ]);
    }

    public function rules() { 
        return [
            'editing.product_id' => 'required',            
            'editing.quantity' => 'required',            
            'editing.price' => 'required',                                 
            'editing.discount' => 'required',                                 
            'editing.total' => 'required',                                 
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
        return view('livewire.create-order', [
         'entities' => Entities::leftJoin('products', 'order_details.product_id','=','products.id')            
        ->select('order_details.*', 'products.name as nameProduct')
        ->where('products.name','like',"%{$this->search}%")
        ->orWhere('order_details.quantity','like',"%{$this->search}%")
        ->orWhere('order_details.price','like',"%{$this->search}%")
        ->orWhere('order_details.diskon','like',"%{$this->search}%")        
        ->orWhere('order_details.total','like',"%{$this->search}%")        
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)
        ]);
    }
}

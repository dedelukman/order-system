<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Order as EntityMaster;
use Livewire\Component;
use App\Models\Product;
use App\Models\OrderDetail as Entities;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class CreateOrder extends Component
{
    use WithPagination;

    public EntityMaster $editingMaster;

    public $order;
    public $search;
    public $sortField='code';
    public $sortDirection ='desc';    
    public $titleEditModal = 'Edit';
    public Entities $editing;
    public Entities $deleting;
    public $branch;    
    public $description;    
    public $dropdown;    
      
     
    

    public function mount(EntityMaster $order){
        $this->editingMaster = $order;
        $this->dropdown = Product::where('active','1')->get();        
        $this->branch = Branch::find($order->branch_id);
        $this->description = $order->description;          
    }
  
    public function updated(){
        $this->editingMaster->description = $this->description;       
        $this->editingMaster->save(); 
          
     
    }

    public function productUpdate(){       
        $this->editing->price= $this->branch->price === "HET2" ?
        (Product::find($this->editing->product_id))->het2 :
        (Product::find($this->editing->product_id))->hj;
       $this->totalUpdate();
    }

    public function priceUpdate(){             
       $this->totalUpdate();
    }

    public function totalUpdate(){               
        $this->editing->total= ($this->editing->price * $this->editing->quantity) 
        * ((100- $this->editing->diskon)/100);
    }

    public function rules() { 
        return [
            'editing.product_id' => 'required',            
            'editing.quantity' => 'required',            
            'editing.price' => 'required',                                 
            'editing.diskon' => 'required|max:100',                                 
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

    
    public function save()
    {
        $this->validate();
        $this->editing->order_id = $this->order->id;       

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
        ->where('order_id',$this->order->id,)
        ->where(function($query){
            $query->orwhere('products.name','like',"%{$this->search}%")
                ->orWhere('order_details.quantity','like',"%{$this->search}%")
                ->orWhere('order_details.price','like',"%{$this->search}%")
                ->orWhere('order_details.diskon','like',"%{$this->search}%")        
                ->orWhere('order_details.total','like',"%{$this->search}%");                      
        })->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)
        ]);
    }
}

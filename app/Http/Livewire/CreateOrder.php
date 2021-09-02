<?php

namespace App\Http\Livewire;

use App\Models\Branch;
use App\Models\Order as EntityMaster;
use Livewire\Component;
use App\Models\Product;
use App\Models\OrderDetail as Entities;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
    public $subtotal;    
    public $total;    
    public $ppn;    
    public $diskon;    
    public $ppnValue;    
    public $diskonValue;    
    public $dropdown;
    

    public function mount(EntityMaster $order){
        $this->editingMaster = $order;
        $this->dropdown = Product::where('active','1')->get();        
        $this->branch = Branch::find($order->branch_id);
        $this->description = $order->description;          
        $this->subtotal = $order->netto;          
        $this->total = $order->bruto;          
        $this->ppnValue = $order->tax;          
        $this->ppn = $order->hdkp === "0.00" ?  "10.00" : ($order->tax/$order->hdkp)*100;
        $this->diskon=$order->diskon;          
        $this->diskonValue=($order->diskon/100)*$order->bruto;     
    
    }
  
  
    public function keteranganUpdate(){
        $this->editingMaster->description = $this->description;       
        $this->editingMaster->save();          
    }

    public function diskonUpdate(){
        $this->diskonValue = ($this->diskon/100) * $this->editingMaster->netto;
        $this->totalMasterUpdate();
    }

    public function diskonValueUpdate(){
        $this->diskon = ($this->diskonValue/$this->editingMaster->netto)*100;
        $this->totalMasterUpdate();   
    }

    public function ppnUpdate(){
        $this->ppnValue = $this->ppn === "0" || $this->ppn ==="0.00" ? "0" : $this->editingMaster->hdkp * ($this->ppn/100);
        $this->saveMasterUpdate();
    }

    public function totalMasterUpdate(){
        $this->editingMaster->diskon = $this->diskon;
        $this->editingMaster->hdkp = $this->editingMaster->netto - $this->diskonValue;
        $this->ppnValue = $this->ppn === "0" || $this->ppn ==="0.00" ? "0" : $this->editingMaster->hdkp * ($this->ppn/100);
        $this->saveMasterUpdate();
    }
    public function saveMasterUpdate(){       
        $this->editingMaster->tax = $this->ppnValue;
        $this->total = $this->editingMaster->hdkp + $this->ppnValue;
        $this->editingMaster->bruto = $this->total;
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
        $this->sumTotal();
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

    public function sumTotal(){  
        $this->subtotal =(DB::table('order_details') 
                                ->select('order_id', DB::raw('SUM(total) as jumlah'))
                                ->groupBy('order_id')
                                ->where('order_id', $this->order->id)
                                ->first())->jumlah;
        $this->editingMaster->netto = $this->subtotal;
        $this->diskonUpdate();
    }

    
    public function save()
    {
        $this->validate();
        $this->editing->order_id = $this->order->id;       

        try {
            $this->editing->save();
            $this->sumTotal();
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

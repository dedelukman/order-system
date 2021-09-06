<?php

namespace App\Http\Livewire;

use App\Mail\HoldOrder;
use App\Mail\ProcessOrder;
use App\Models\Branch;
use App\Models\Order as EntityMaster;
use Livewire\Component;
use App\Models\Product;
use App\Models\OrderDetail as Entities;
use Livewire\WithPagination;
use App\Mail\RequestOrder;
use Illuminate\Support\Facades\Mail;
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
    public $harga;    
    public $jumlahDetail;    
    public $status;    
    public $dropdown;
    

    public function mount(EntityMaster $order){
        $this->editingMaster = $order;
        $this->dropdown = Product::where('active','1')->get();        
        $this->branch = Branch::find($order->branch_id);
        $this->description = $order->description;          
        $this->subtotal = number_format($order->subtotal, 0, ',', '.');          
        $this->total = number_format($order->total, 0, ',', '.');          
        $this->ppnValue = number_format($order->tax, 0, ',', '.');          
        $this->ppn = number_format($order->hdkp === "0.00" ?  "10.00" : ($order->tax/$order->hdkp)*100,0);
        $this->diskon= $order->diskon;          
        $this->diskonValue=number_format($order->diskon_value, 0, ',', '.'); 
            
    }
  
  
    public function keteranganUpdate(){
        $this->editingMaster->description = $this->description;       
        $this->editingMaster->save();          
    }

    public function diskonUpdate(){
        $this->diskonValue = number_format(($this->diskon/100) * $this->editingMaster->subtotal, 0, ',', '.');
        $this->totalMasterUpdate();
    }

    public function diskonValueUpdate(){
        $this->diskonValue = strpos($this->diskonValue, '.') !== false ? $this->diskonValue : number_format($this->diskonValue, 0, ',', '.');
        $this->diskon = (str_replace('.','',$this->diskonValue)/$this->editingMaster->subtotal)*100;
        $this->totalMasterUpdate();   
    }

    public function ppnUpdate(){
        $this->ppnValue = number_format($this->ppn === "0" || $this->ppn ==="0.00" ? "0" : $this->editingMaster->hdkp * ($this->ppn/100) , 0, ',', '.');                                                                                          
        $this->saveMasterUpdate();
    }

    public function totalMasterUpdate(){
        $this->editingMaster->diskon = $this->diskon;
        $this->editingMaster->diskon_value = str_replace('.','',$this->diskonValue);
        $this->editingMaster->hdkp = $this->branch->price === "HJ" ?
        $this->editingMaster->subtotal - $this->editingMaster->diskon_value : ($this->editingMaster->subtotal - $this->editingMaster->diskon_value)/1.1;
        $this->ppnValue =  number_format($this->ppn === "0" || $this->ppn ==="0.00" ? "0" : $this->editingMaster->hdkp * ($this->ppn/100), 0, ',', '.');
        $this->saveMasterUpdate();
    }

    public function saveMasterUpdate(){       
        $this->editingMaster->tax = str_replace('.','',$this->ppnValue);
        $this->total = number_format($this->editingMaster->hdkp + $this->editingMaster->tax, 0,',','.');       
        $this->editingMaster->total = str_replace('.','',$this->total);
        $this->editingMaster->save();
    }

    public function productUpdate(){       
        $this->harga = number_format($this->branch->price === "HET2" ?
        (Product::find($this->editing->product_id))->het2 :
        (Product::find($this->editing->product_id))->hj,0,',','.');
        $this->editing->price = str_replace('.','',$this->harga);
       $this->totalUpdate();
    }

    public function priceUpdate(){             
       $this->totalUpdate();
    }

    public function totalUpdate(){               
        $this->jumlahDetail= number_format(($this->editing->price * $this->editing->quantity) 
        * ((100- $this->editing->diskon)/100),0,',','.');
        $this->editing->total = str_replace('.','',$this->jumlahDetail);
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
        $this->harga=0;    
        $this->jumlahDetail=0; 
        $this->editing->quantity = 0;   
        $this->editing->diskon = 0;   
    }

    public function edit(Entities $entity){
        $this->editing = $entity;
        $this->harga = number_format($this->editing->price, 0,',','.');
        $this->jumlahDetail = number_format($this->editing->total, 0,',','.');
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
        $this->subtotal = number_format((DB::table('order_details') 
                                ->select('order_id', DB::raw('SUM(total) as jumlah'))
                                ->groupBy('order_id')
                                ->where('order_id', $this->order->id)
                                ->first())->jumlah, 0,',','.') === null ?
                                0 : 
                                number_format((DB::table('order_details') 
                                ->select('order_id', DB::raw('SUM(total) as jumlah'))
                                ->groupBy('order_id')
                                ->where('order_id', $this->order->id)
                                ->first())->jumlah, 0,',','.')
                                ;
        $this->editingMaster->subtotal = str_replace('.','',$this->subtotal);
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

    public function requestOrder()
    {
        $details = [
            'title' => 'Title: Mail from Real Programmer',
            'body' => 'Body: This is for testing email using smtp'
        ];

        Mail::to('abo@araya.co.id')->send(new RequestOrder($details));
        $this->editingMaster->status="PENDING";
        $this->editingMaster->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Request Order Berhasil disimpan!!"
        ]);
        
    }

    public function holdOrder()
    {
        $details = [
            'title' => 'Title: Mail from Real Programmer',
            'body' => 'Body: This is for testing email using smtp'
        ];

        Mail::to('abo@araya.co.id')->send(new HoldOrder($details));
        $this->editingMaster->status="HOLD";
        $this->editingMaster->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"Order Sementara di tahan!!"
        ]);
        
    }

    public function processOrder()
    {
        $details = [
            'title' => 'Title: Mail from Real Programmer',
            'body' => 'Body: This is for testing email using smtp'
        ];

        Mail::to('abo@araya.co.id')->send(new ProcessOrder($details));
        $this->editingMaster->status="PROCESS";
        $this->editingMaster->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"Proses Order telah berhasil dikirim!!"
        ]);
        
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

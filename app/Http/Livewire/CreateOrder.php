<?php

namespace App\Http\Livewire;


use App\Models\Branch;
use App\Models\Order as EntityMaster;
use Livewire\Component;
use App\Models\Product;
use App\Models\OrderDetail as Entities;
use Livewire\WithPagination;
use App\Mail\RequestOrder;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Connection;
use PDO;

class CreateOrder extends Component
{
    use WithPagination;

    public EntityMaster $editingMaster;

    public $order;
    public $orderCode;
    public $search;
    public $sortField='code';
    public $sortDirection ='desc';    
    public $titleEditModal = 'Edit';
    public Entities $editing;
    public Entities $deleting;
    public $branch;    
    public $branchCode;    
    public $description;    
    public $subtotal;    
    public $subtotalV;    
    public $total;    
    public $totalV;    
    public $ppn;    
    public $diskon;    
    public $ppnValue;    
    public $ppnValueV;    
    public $diskonValue;    
    public $diskonValueV;    
    public $harga;    
    public $jumlahDetail;    
    public $status;    
    public $dropdown;
    public $users;
    public $salesorder;
    public $karyawan = 'dde';
    public $satuan = 'unit';
    public $tanggal;
    public $isppn;
    public $hdkp;
    public $codeDetail;
    public $quantityDetail;
    public $priceDetail;
    public $totalDetail;

    

    public function mount(EntityMaster $order){
        $this->editingMaster = $order;
        $this->orderCode = $order->code.'/'.$order->description;
        $this->dropdown = Product::where('active','1')->get();        
        $this->branch = Branch::find($order->branch_id);
        $this->branchCode = $this->branch->code;
        $this->users = User::find($order->user_id);
        $this->description = $order->description;          
        $this->subtotal = number_format($order->subtotal, 0, ',', '.');          
        $this->subtotalV = $order->subtotal;        
        $this->total = number_format($order->total, 0, ',', '.');          
        $this->totalV = $order->total;        
        $this->ppnValue = number_format($order->tax, 0, ',', '.');          
        $this->ppnValueV = $order->tax;         
        $this->ppn = number_format($order->hdkp === "0.00" ?  "10.00" : ($order->tax/$order->hdkp)*100,0);
        $this->isppn = $this->ppn !== 0 ? '1' : '0';
        $this->diskon= $order->diskon;          
        $this->diskonValue=number_format($order->diskon_value, 0, ',', '.'); 
        $this->diskonValueV=$order->diskon_value; 
        $this->hdkp = $order->hdkp;
            
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
        if($this->branch->category == 'CABANG' || $this->branch->category == 'PUSAT' ){
          
                $this->salesOrder();
      
            
        }else{
            $details = [
                'url' => url("/order/create/{$this->editingMaster->id}"),
                'from' =>  Auth::user()->email,
                'subject' => 'Request Order '. $this->branch->name,
                'orderNo' => 'Order Number : '. $this->editingMaster->code,
                'title' => 'Verifikasi Hutang Pelanggan',
                'button' => 'Konfirmasi',
                'note' => $this->editingMaster->description,
                'body' => 'Mohon Konfirmasi Request Order atas '. $this->branch->name .' senilai Rp. '. number_format($this->editingMaster->total , 0, ',', '.')
            ];

            Mail::to('abo@araya.co.id')->send(new RequestOrder($details));
            $this->editingMaster->status="PENDING";
            $this->editingMaster->save();
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Request Order Berhasil disimpan!!"
            ]);
        }
        
        
    }

    public function holdOrder()
    {
        $details = [
            'url' => url("/order/create/{$this->editingMaster->id}"),
            'from' =>  Auth::user()->email,
            'subject' => 'Order Ditolak ',
            'orderNo' => 'Order Number : '. $this->editingMaster->code,
            'title' => 'Penolakan Order',
            'button' => 'Lihat Order',
            'note' => $this->editingMaster->description,
            'body' => 'Order Anda untuk sementara tidak dapat kami proses, silahkan selesaikan administrasi dengan bagian keuagan, 
            apabila sudah, anda dapat mengajukan kembali order yang telah Anda buat, dengan mengklik tombol dibawah ini.'
        ];

        Mail::to($this->users->email)->send(new RequestOrder($details));
        $this->editingMaster->status="HOLD";
        $this->editingMaster->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'warning',
            'message'=>"Penolakan Order Berhasil kami kirim ke Pelanggan!!"
        ]);
        
    }

    public function processOrder()
    {
        $details = [
            'url' => url("/order/create/{$this->editingMaster->id}"),
            'from' =>  Auth::user()->email,
            'subject' => 'Request Order ',
            'orderNo' => 'Order Number : '. $this->editingMaster->code,
            'title' => 'Process Order',
            'button' => 'Detail Order',
            'note' => $this->editingMaster->description,
            'body' => 'Mohon untuk segera kirim order dari.'. $this->branch->name . ' dengan No SO : '.$this->salesorder,
        ];

        Mail::to('gudang@sekarayu.co.id')->send(new RequestOrder($details));
        $this->editingMaster->status="PROCESS";
        $this->editingMaster->save();
        $this->dispatchBrowserEvent('alert',[
            'type'=>'success',
            'message'=>"Proses Kirim akan segera disiapkan oleh Bagian Gudang!!"
        ]);
        
    }

    public function salesOrder(){
        try{
                  
        $stmt = Connection::connect()->prepare("SELECT LPAD(IFNULL(RIGHT(MAX(NoSO),6),0)+1,8,'SO000000') AS newNoSO FROM SO");			
		$stmt -> execute();
		$this->salesorder = $stmt -> fetch(PDO::FETCH_COLUMN);
        $this->tanggal=date('Y-m-d');
        

        $stmt = Connection::connect()->prepare("INSERT INTO SO 
        (NoSo, Tanggal, KodePelanggan, Catatan, KodeKaryawan, Subtotal, Diskon, Potongan, HDKP, isPPN, PPn, Total) 
        VALUES (:NoSo, :Tanggal, :KodePelanggan, :Catatan, :KodeKaryawan, :Subtotal, :Diskon, :Potongan, :HDKP, :isPPN, :PPn, :Total)");

        $stmt->bindParam(":NoSo", $this->salesorder, PDO::PARAM_STR);
        $stmt->bindParam(":Tanggal", $this->tanggal, PDO::PARAM_STR);
        $stmt->bindParam(":KodePelanggan", $this->branchCode, PDO::PARAM_STR);
        $stmt->bindParam(":Catatan", $this->orderCode, PDO::PARAM_STR);
        $stmt->bindParam(":KodeKaryawan", $this->karyawan, PDO::PARAM_STR);
        $stmt->bindParam(":Subtotal", $this->subtotalV, PDO::PARAM_STR);
        $stmt->bindParam(":Diskon", $this->diskon, PDO::PARAM_STR);
        $stmt->bindParam(":Potongan", $this->diskonValueV, PDO::PARAM_STR);
        $stmt->bindParam(":HDKP", $this->hdkp, PDO::PARAM_STR);
        $stmt->bindParam(":isPPN",$this->isppn, PDO::PARAM_INT);
        $stmt->bindParam(":PPn", $this->ppnValueV, PDO::PARAM_STR);
        $stmt->bindParam(":Total", $this->totalV, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = Connection::connect()->prepare("INSERT INTO DSO 
        (NoSo, KodeBarang, Kuantitas, Satuan, Harga, Jumlah) 
        VALUES (:NoSo, :KodeBarang, :Kuantitas, :Satuan, :Harga, :Jumlah)");

        $orderlist = Entities::leftJoin('products', 'order_details.product_id','=','products.id')            
                ->select('order_details.*', 'products.code as codeProduct')
                ->where('order_id',$this->order->id)->get();
        
       foreach ($orderlist as $item) {

        $this->codeDetail = $item->codeProduct;
        $this->quantityDetail = $item->quantity;
        $this->priceDetail =$item->price;
        $this->totalDetail = $item->total;

            $stmt->bindParam(":NoSo", $this->salesorder, PDO::PARAM_STR);
            $stmt->bindParam(":KodeBarang",$this->codeDetail , PDO::PARAM_STR);
            $stmt->bindParam(":Kuantitas", $this->quantityDetail, PDO::PARAM_STR);
            $stmt->bindParam(":Satuan", $this->satuan, PDO::PARAM_STR);
            $stmt->bindParam(":Harga", $this->priceDetail, PDO::PARAM_STR);
            $stmt->bindParam(":Jumlah", $this->totalDetail, PDO::PARAM_STR);          
            $stmt->execute();
            
        }
         
        $this->processOrder();

        }catch(\Exception $e){
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

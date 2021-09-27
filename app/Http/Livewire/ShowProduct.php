<?php

namespace App\Http\Livewire;

use App\Models\Category;
use App\Models\Connection;
use App\Models\ConnectionLampung;
use Livewire\Component;
use App\Models\Product as Entities;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Illuminate\Support\Str;


class ShowProduct extends Component
{
    use WithPagination;


    public $search;
    public $sortField='name';
    public $sortDirection ='desc';    
    public $titleEditModal = 'Edit';
    public Entities $editing;
    public Entities $deleting;
    public $dropdown;
    

    public function mount(){
        $this->dropdown = Category::where('name','!=','')->get();
    }

    public function rules() { 
        return [
            'editing.code' => 'required|min:3',
            'editing.name' => 'required',
            'editing.category_id' => 'required',            
            'editing.hj' => 'required',            
            'editing.het2' => 'required',            
            'editing.description' => 'required',            
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

    public function updateStok(){
        $this->stokJombang();
        $this->stokLampung();
    }

    public function stokJombang(){
        try{
            $stmt = Connection::connect()->prepare("SELECT * FROM vstokpj");
            $stmt->execute();   
            $this->stokjombang =$stmt->fetchAll();
       
            foreach($this->stokjombang as $stok){                
                DB::table('products')
                ->where('code',  $stok['KodeBarang'])
                ->update(['stok1' => $stok['Stok'] ]);               
            }
          

        }  catch(\Exception $e){
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Stok Jombang Tidak Berhasil di Update!!"
            ]);
        }
      
    }

    public function stokLampung(){
        try{
            $stmt = ConnectionLampung::connect()->prepare("SELECT * FROM stok");
            $stmt->execute();   
            $this->stoklampung =$stmt->fetchAll();
            foreach($this->stoklampung as $stok){                
                DB::table('products')
                ->where('code',  $stok['KodeBarang'])
                ->update(['stok2' => $stok['Stok'] ]);               
            }
            $this->dispatchBrowserEvent('alert',[
                'type'=>'success',
                'message'=>"Data Stok Berhasil di Update!!"
            ]);
        }  catch(\Exception $e){
            $this->dispatchBrowserEvent('alert',[
                'type'=>'error',
                'message'=>"Data Stok Lampung Tidak Berhasil di Update!!"
            ]);
        }
      
    }

    public function render()
    {
        return view('livewire.show-product', [
         'entities' => Entities::leftJoin('categories', 'products.category_id','=','categories.id')    
        ->select('products.*', 'categories.name as nameCategory')
        ->where('products.code','like',"%{$this->search}%")
        ->orWhere('products.name','like',"%{$this->search}%")
        ->orWhere('categories.name','like',"%{$this->search}%")
        ->orderBy($this->sortField, $this->sortDirection)
        ->paginate(10)
        ]);
    }
}

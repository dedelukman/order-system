<div>
    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tambah Order</h1>
                    <p class="mb-4">Tambah order Cabang, Distributor dan Agen.</p>
                   
                      <div class="card shadow mb-2">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Master</h6>
                        </div>
                        <div class="card-body"> 
                            <form class="">
                                <div class="form-group row ">
                                    <div class="col-lg-6">
                                        <label for="code">No Order</label>
                                        <input type="text" class="form-control" id="code" readonly value="{{$editingMaster->code }}">
                                
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="branch">Pelanggan</label>
                                        <input type="text" class="form-control" id="branch" readonly value="{{$branch->name }}">
                            
                                    </div>
                                
                                </div>                               
                                        
                            </form>

                        </div>
                      </div>
               

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Data Detail</h6>
                        </div>
                        <div class="card-body">
                            <!-- Topbar Search -->
                            <div class="flex flex-auto">
                                <form
                                class="d-sm-inline-block form-inline mr-auto ml-md-3 mw-100 mb-3 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                            aria-label="Search" aria-describedby="basic-addon2" wire:model="search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form> 
                                <div >
                                    <button class="btn btn-primary " data-toggle="modal" data-target="#formModal" wire:click="create">
                                        <i class="fas fa-plus fa-sm"> New</i>
                                    </button>  
                                </div>
                            </div>
                            
                                                 
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th wire:click="sortBy('nameProduct')" ><i class="fa fa-fw fa-sort"></i>Produk</th>
                                            <th wire:click="sortBy('quantity')" ><i class="fa fa-fw fa-sort"></i>Qty</th>                                              
                                            <th wire:click="sortBy('price')" ><i class="fa fa-fw fa-sort"></i>Harga</th>
                                            <th wire:click="sortBy('diskon')" ><i class="fa fa-fw fa-sort"></i>Diskon</th>                                            
                                            <th wire:click="sortBy('total')" ><i class="fa fa-fw fa-sort"></i>Total</th>                                            
                                            <th wire:click="sortBy('created_at')" ><i class="fa fa-fw fa-sort"></i>Dibuat</th>                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @forelse($entities as $entity )
                                            <tr wire:loading.class.delay="opacity-50">                                                
                                                <td>{{ $entity->nameProduct }}</td>
                                                <td>{{ $entity->quantity}}</td>
                                                <td>Rp {{ number_format($entity->price , 0, ',', '.') }}</td>
                                                <td>{{ $entity->diskon}}%</td>
                                                <td>Rp {{ number_format($entity->total , 0, ',', '.') }}</td>                                                                                               
                                                <td>{{ $entity->created_at->diffForHumans()}}</td>                                                                                             
                                                <td>                                                                                                                                                       
                                                    <div class="dropdown mb-4">
                                                        <button class="dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu animated--fade-in"
                                                            aria-labelledby="dropdownMenuButton">
                                                            <a class="dropdown-item" 
                                                            wire:click="edit({{ $entity->id }})"
                                                            data-toggle="modal" data-target="#formModal"
                                                            >Edit</a>
                                                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteModal"
                                                            wire:click="deleteId({{ $entity->id }})"
                                                            >Delete</a>                                                        
                                                        </div>
                                                    </div>
                                                    
                                                </td>                                                
                                            </tr>
                                        
                                            @empty

                                            <tr>
                                                <td colspan="7" style="text-align: center;"> 
                                                    <p class="py-3">
                                                        <i class="fas fa-archive fa-sm"></i> Data yang Anda cari tidak ditemukan
                                                    </p>
                                                   
                                                </td>
                                            </tr>
                                            
                                        @endforelse 
                                       
                                       
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">{{ $entities->links() }}</div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Keterangan</label>
                                        <textarea class="form-control" id="description" rows="6" wire:model="description" wire:change="keteranganUpdate()"></textarea>
                                      </div>               
                                </div>
                                <div class="col-md-6">
                                <form >
                                <div class="form-group row ">
                                  <label for="inputEmail3" class="col-sm-3 col-form-label">Subtotal</label>
                                  <div class="col-sm-9">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <span class="input-group-text">Rp</span>                            
                                        </div>
                                        <input type="number" class="form-control" id="inputEmail3" placeholder="SubTotal" readonly wire:model="subtotal">
                                    </div>                                    
                                  </div>
                                </div>     
                                
                                <div class="form-group row ">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Diskon</label>
                                    <div class="col-sm-4">
                                        <div class="input-group"> 
                                            <input type="number" class="form-control" id="inputEmail3" placeholder="Diskon" wire:model="diskon" wire:click="diskonUpdate()">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>                            
                                            </div>                                           
                                        </div>                                    
                                      </div>
                                    <div class="col-sm-5">
                                      <div class="input-group">
                                          <div class="input-group-append">
                                              <span class="input-group-text">Rp</span>                      
                                          </div>
                                          <input type="number" class="form-control" id="inputEmail3" placeholder="Diskon" wire:model="diskonValue" wire:click="diskonValueUpdate()">
                                      </div>                                    
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">PPn</label>
                                    <div class="col-sm-4">
                                        <div class="input-group"> 
                                            <input type="number" class="form-control" id="inputEmail3" placeholder="PPn" wire:model="ppn" wire:change="ppnUpdate()">
                                            <div class="input-group-append">
                                                <span class="input-group-text">%</span>                            
                                            </div>                                           
                                        </div>                                    
                                      </div>
                                    <div class="col-sm-5">
                                      <div class="input-group">
                                          <div class="input-group-append">
                                              <span class="input-group-text">Rp</span>                            
                                          </div>
                                          <input type="number" class="form-control" id="inputEmail3" placeholder="PPn" wire:model="ppnValue" readonly>
                                      </div>                                    
                                    </div>
                                </div>
                                <div class="form-group row ">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-sm-9">
                                      <div class="input-group">
                                          <div class="input-group-append">
                                              <span class="input-group-text">Rp</span>                            
                                          </div>
                                          <input type="email" class="form-control" id="inputEmail3" placeholder="Total" readonly wire:model="total">
                                      </div>                                    
                                    </div>
                                </div>                        
                        

                            </form>
                                </div>
                            </div>
                           

                                             
                        </div>
                    </div>

        
        <!-- Modal Form-->
        <form action="">            
            <div wire:ignore.self class="modal fade" id="formModal"
             tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                <div class="modal-dialog" wire:loading.class.delay="opacity-50">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="formModalLabel">
                            {{ $titleEditModal }}
                             Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">                       
                         <div class="form-group">
                            <label for="name">Produk</label>                           
                              <select class="form-control" name="city_id" wire:model.defer="editing.product_id"  wire:click="productUpdate()" >
                                <option value="" selected>Pilih Produk</option>
                        
                                @foreach ($dropdown as $item)
                                    <option value="{{ $item->id }}" >{{ $item->name }}</option>
                                @endforeach
                                                                
                            </select>
                            @error('editing.product_id') <p class="error text-sm text-red-500 w-full">{{ $message }}</p> @enderror                         
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Harga</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>                            
                                </div>
                                <input type="number" class="form-control" aria-label="price" min="0" wire:change="totalUpdate()"
                                wire:model.defer="editing.price">
                                
                                @error('editing.price') <p class="error text-sm text-red-500 w-full">{{ $message }}</p> @enderror
                            </div>      
                           
                        </div>   
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kuantitas</label>
                            <div class="input-group">                            
                                <input type="number" class="form-control" aria-label="quantity" min="0"  required wire:change="totalUpdate()"
                                wire:model.defer="editing.quantity">
                                    <div class="input-group-append">
                                    <span class="input-group-text">Unit</span>                            
                                </div>
                                @error('editing.quantity') <p class="error text-sm text-red-500 w-full">{{ $message }}</p> @enderror
                            </div>      
                           
                        </div>     
                        
                        <div class="form-group">
                            <label for="exampleInputEmail1">Diskon</label>
                            <div class="input-group">
                                
                                <input type="number" class="form-control" aria-label="discount" min="0"  max="100"  wire:change="totalUpdate()"
                                wire:model.defer="editing.diskon">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>                            
                                </div>
                                @error('editing.diskon') <p class="error text-sm text-red-500 w-full">{{ $message }}</p> @enderror
                            </div>      
                           
                        </div>  
                        <div class="form-group">
                            <label for="exampleInputEmail1">Total</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text">Rp</span>                            
                                </div>
                                <input type="number" class="form-control" aria-label="total" min="0" required
                                wire:model.defer="editing.total">
                                
                                @error('editing.total') <p class="error text-sm text-red-500 w-full">{{ $message }}</p> @enderror
                            </div>                                 
                        </div>                      
                        
                        
                                                                  
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"
                        wire:click.prevent="save()"  
                        >Save changes</button>
                    </div>
                    </div>
                </div>
            </div>        
        </form>

        <!-- Modal Delete-->
        <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-red-400">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda Yakin Akan menghapus Data Ini!!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" wire:click.prevent="delete()" data-dismiss="modal">Ya Saya Yakin</button>
            </div>
            </div>
        </div>
        </div>
  
</div>


                    
                



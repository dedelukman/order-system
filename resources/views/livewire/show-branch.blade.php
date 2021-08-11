<div>
    
    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar Cabang</h1>
                    <p class="mb-4">Daftar data cabang, distributor dan agen yang terhubung dengan order system web app.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Data</h6>
                        </div>
                        <div class="card-body">
                            <!-- Topbar Search -->
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
                            <div class="table-responsive">
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>Harga</th>
                                            <th>Status</th>                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach ($branches as $branch )
                                            <tr>
                                                <td>{{ $branch->code }}</td>
                                                <td>{{ $branch->name }}</td>
                                                <td>
                                                     <div class="dropdown mb-4">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            {{ $branch->category }}
                                                        </button>
                                                        <div class="dropdown-menu animated--fade-in"
                                                            aria-labelledby="dropdownMenuButton" >
                                                            @if ($branch->price =='HJ')
                                                                 <button class="btn " type="button" wire:click="changeCategory({{ $branch->id}}, $event.target.innerText)"
                                                                   >
                                                                    HET2
                                                                </button>
                                                            @else
                                                                 <button class="btn " type="button" wire:click="changeCategory({{ $branch->id}}, $event.target.innerText)"
                                                                   >
                                                                    HJ
                                                                </button>
                                                            @endif
                                                                                                                   
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                     <div class="dropdown mb-4">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            {{ $branch->price }}
                                                        </button>
                                                        <div class="dropdown-menu animated--fade-in"
                                                            aria-labelledby="dropdownMenuButton" >
                                                            @if ($branch->price =='HJ')
                                                                 <button class="btn " type="button" wire:click="changePrice({{ $branch->id}}, $event.target.innerText)"
                                                                   >
                                                                    HET2
                                                                </button>
                                                            @else
                                                                 <button class="btn " type="button" wire:click="changePrice({{ $branch->id}}, $event.target.innerText)"
                                                                   >
                                                                    HJ
                                                                </button>
                                                            @endif
                                                                                                                   
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <td style="align-content: center">
                                                    @if ($branch->active)                                                                                                     
                                                        <a  class="btn btn-success btn-icon-split" wire:click="changeActive({{ $branch->id}}, '0')">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Active</span>
                                                        </a>
                                                    @else                                                                      
                                                         <a  class="btn btn-danger btn-icon-split" wire:click="changeActive({{ $branch->id}}, '1')">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                            <span class="text">Inactive</span>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="dropdown mb-4">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            Aksi
                                                        </button>
                                                        <div class="dropdown-menu animated--fade-in"
                                                            aria-labelledby="dropdownMenuButton" >
                                                            <a class="dropdown-item"  data-toggle="modal" data-target="#exampleModal"
                                                          
                                                            >
                                                                Edit
                                                            </a>
                                                            <a class="dropdown-item" href="#">Delete</a>                                                            
                                                        </div>
                                                    </div>
                                                </td>                                                
                                            </tr>
                                        @endforeach
                                       
                                       
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4">{{ $branches->links() }}</div>
                        </div>
                    </div>

        <!-- Modal -->
        <form action="">
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                          
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            wire:model.defer="editing.name"
                            >
                           
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alamat</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Diskon</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                           
                        </div>                                                
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>        
        </form>

        
            


  
</div>


                    
                



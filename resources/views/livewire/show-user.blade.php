<div>
    
    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar User</h1>
                    <p class="mb-4">Daftar data user yang memiliki akses order system web app.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Data</h6>
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
                                            <th wire:click="sortBy('name')" ><i class="fa fa-fw fa-sort"></i>Nama</th>
                                            <th wire:click="sortBy('email')" ><i class="fa fa-fw fa-sort"></i>Email</th>
                                            <th wire:click="sortBy('nameBranch')" ><i class="fa fa-fw fa-sort"></i>Perusahaan</th>
                                            <th wire:click="sortBy('role')" ><i class="fa fa-fw fa-sort"></i>Akses</th>
                                            <th wire:click="sortBy('active')" ><i class="fa fa-fw fa-sort"></i>Status</th>                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @forelse($entities as $entity )
                                            <tr wire:loading.class.delay="opacity-50">
                                                <td>{{ $entity->name }}</td>
                                                <td>{{ $entity->email }}</td>
                                                <td>{{ $entity->nameBranch }}</td>
                                               
                                                <td>
                                                     <div class="dropdown mb-4">
                                                        <button class="btn dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            {{ $entity->role }}
                                                        </button>
                                                        <div class="dropdown-menu animated--fade-in"
                                                            aria-labelledby="dropdownMenuButton" >
                                                            @if ($entity->role =='ADMIN')
                                                                 <button class="btn " type="button" wire:click="changeRole({{ $entity->id}}, $event.target.innerText)"
                                                                   >
                                                                    USER
                                                                </button>
                                                            @else
                                                                 <button class="btn " type="button" wire:click="changeRole({{ $entity->id}}, $event.target.innerText)"
                                                                   >
                                                                    ADMIN
                                                                </button>
                                                            @endif
                                                                                                                   
                                                        </div>
                                                    </div>
                                                    
                                                </td>
                                                <td style="align-content: center">
                                                    @if ($entity->active)                                                                                                     
                                                        <a  class="btn btn-success btn-icon-split" wire:click="changeActive({{ $entity->id}}, '0')">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-check"></i>
                                                            </span>
                                                            <span class="text">Active</span>
                                                        </a>
                                                    @else                                                                      
                                                         <a  class="btn btn-danger btn-icon-split" wire:click="changeActive({{ $entity->id}}, '1')">
                                                            <span class="icon text-white-50">
                                                                <i class="fas fa-times"></i>
                                                            </span>
                                                            <span class="text">Inactive</span>
                                                        </a>
                                                    @endif
                                                </td>
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
                                                <td colspan="6" style="text-align: center;"> 
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
                            <label for="code">Nama</label>
                            <input type="text" class="form-control" id="code" aria-describedby="code"
                            wire:model.defer="editing.code" :error="$errors->first('editing.code')"
                            >
                          
                        </div>
                        <div class="form-group">
                            <label for="name">Email</label>
                            <input type="text" class="form-control" id="name" aria-describedby="name"
                            wire:model.defer="editing.name"
                            >
                           
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" rows="3"
                            wire:model.defer="editing.address"
                            ></textarea>
                        </div>
                        
                                                                  
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary"
                        wire:click.prevent="save()" data-dismiss="modal"
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


                    
                



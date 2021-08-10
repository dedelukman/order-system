<div>
    @push('addon-style')
        <!-- Custom styles for this page -->
    <link href="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    @endpush
    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Daftar Cabang</h1>
                    <p class="mb-4">Daftar data cabang, distributor dan agen yang terhubung dengan order system web app.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Daftar Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode</th>
                                            <th>Name</th>
                                            <th>Kategori</th>
                                            <th>Active</th>                                            
                                            <th></th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                        @foreach ($branches as $branch )
                                            <tr>
                                                <td>{{ $branch->code }}</td>
                                                <td>{{ $branch->name }}</td>
                                                <td>{{ $branch->category }}</td>
                                                <td style="align-content: center">
                                                    @if ($branch->active)                                                       
                                                        <a class="btn btn-success btn-circle btn-sm" wire:click="changeActive({{ $branch->id}}, '0')">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                        @else                                                        
                                                        <a class="btn btn-danger btn-circle btn-sm" wire:click="changeActive({{ $branch->id}}, '1')">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td></td>                                                
                                            </tr>
                                        @endforeach
                                       
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


    @push('addon-script')
        <!-- Page level plugins -->
        <script src="{{ asset('theme/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('theme/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('theme/js/demo/datatables-demo.js') }}"></script>
    @endpush                    
</div>


                    
                



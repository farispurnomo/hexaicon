<?php $this->load->view('partials/admin/admin_alert')?>

<div class="card card-custom">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">
                <?= $pagetitle?>
            </h3>
        </div>
        <div class="card-toolbar">
            {{-- @can($permission.'create') --}}
            <a href="{{ route( $route . '.create' ) }}" class="btn btn-success btn-sm mr-3 ajaxify">
                <i class="flaticon-file-1"></i> Tambah Data
            </a>
            {{-- @endcan --}}
        </div>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <div class="datatable datatable-bordered datatable-head-custom" id="{{$table}}"></div>
        <!--end: Datatable-->
    </div>
</div>

<script>
    $(function(){
        const id   = '#{{$table}}';
        const urll   = '{{ route($route . ".ktable" ) }}';
        const column = [
            { field : 'RecordID', title : '#', sortable : false, selector : { class : '' }, textAlign : 'center', width : 30 },
            { field : 'no', title : 'No. ', textAlign : 'center', sortable : false, width : 30 },
            { field : 'name', title : 'Nama' },
            { field : 'description', title : 'Deskripsi' },
            { field : 'serie_name', title: 'Seri' },
            { field : 'image', title: 'Image', sortable: false, textAlign: 'center' },
            { field : 'image_bg', title: 'BG Image', sortable: false, textAlign: 'center' },
            { field : 'action', title : 'Aksi', textAlign : 'center', sortable : false },
        ];

        const cari = {
            name_module         : '.name_module',
            description_module  : '.description_module',
            serie_id_module     : '.serie_id_module'
        };

        global.init_ktable(id,urll,column,cari);

        const serieOptions = {
            route_to    : "{{ route('admin.master.car_serie.paginate') }}",
            placeholder : 'Semua Seri',
            allowClear  : true
        };
        global.init_select2('.serie_id_module', serieOptions);
    })
</script>
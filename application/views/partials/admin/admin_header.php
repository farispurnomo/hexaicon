<style>
    #kt_quick_user_toggle:hover {
        cursor: pointer !important;
    }
</style>
<div id="kt_header" class="header header-fixed">
    <!--begin::Container-->
    <div class=" container-fluid  d-flex align-items-stretch justify-content-between">
        <!--begin::Header Menu Wrapper-->
        <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
            <!--begin::Header Menu-->
            <div id="kt_header_menu" class="header-menu header-menu-mobile  header-menu-layout-default ">

            </div>
            <!--end::Header Menu-->
        </div>
        <!--end::Header Menu Wrapper-->

        <!--begin::Topbar-->
        <div class="topbar">
            <!--begin::User-->
            <div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
                <!-- {{-- @if ($records->count() > 1)
                <select class="form-control selectpicker" data-width="250px" id="changeRole">
                    @foreach ($records as $item)
                    <option value="{{$item->role_id}}" {{$currentRoles == $item->role_id ? 'selected' : ''}}>{{$item->roles->name}}</option>
                    @endforeach
                </select>                
                @endif --}} -->
            </div>
            <div class="topbar-item">
                <div class="btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
                    <span class="font-weight-bold font-size-base d-none d-md-inline mr-1" style="color: white">Hi,</span>
                    <span class="font-weight-bolder font-size-base d-none d-md-inline mr-3" style="color: white"><?= $this->session->userdata('name') ?? '-'; ?></span>
                    <span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
                        <span class="symbol-label font-size-h5 font-weight-bold"><?= substr($this->session->userdata('name') ?? '-', 0, 1) ?></span>
                    </span>
                </div>
            </div>
            <!--end::User-->
        </div>
        <!--end::Topbar-->
    </div>
    <!--end::Container-->
</div>
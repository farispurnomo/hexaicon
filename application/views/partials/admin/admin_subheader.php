<div class="subheader py-2 py-lg-6  subheader-solid " id="kt_subheader">
    <div class=" container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <!--begin::Info-->
        <div class="d-flex align-items-center flex-wrap mr-1">
            <!--begin::Page Heading-->
            <div class="d-flex align-items-baseline flex-wrap mr-5">
                <!--begin::Page Title-->
                <a href="<?= base_url() ?>" class="ajaxify">
                    <h5 class="text-dark font-weight-bold my-1 mr-5">
                        Home
                    </h5>
                </a>
                <!--end::Page Title-->
                <div class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-4 bg-gray-200"></div>
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-transparent  font-weight-bold p-0 my-2 font-size-sm">
                    <?php $subheaders = $subheaders ?? []; ?>

                    <?php foreach ($subheaders as $subheader => $link) : ?>
                        <li class="breadcrumb-item">
                            <a href="<?= $link ?>" class="text-muted ajaxify">
                                <?= $subheader ?>
                            </a>
                        </li>
                    <?php endforeach ?>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page Heading-->
        </div>
        <!--end::Info-->

        <!--begin::Toolbar-->
        <div class="d-flex align-items-center">

        </div>
        <!--end::Toolbar-->
    </div>
</div>

<div class="toolbar" id="kt_toolbar">
                        <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                            <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                                <h1 class="d-flex align-items-center text-dark fw-bolder my-1 fs-3"><?=$title?>
                                    <span class="h-20px border-gray-200 border-start ms-3 mx-2"></span>
                                </h1>
                            </div>
                        </div>
                    </div>
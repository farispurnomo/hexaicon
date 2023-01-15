<div id="kt_content_container" class="container-fluid">
	<div class="card">
		<div class="card-header border-0 pt-6">
			<div class="card-title">
				<div class="d-flex align-items-center position-relative my-1">
					<span class="svg-icon svg-icon-1 position-absolute ms-6">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
							<rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
							<path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
						</svg>
					</span>
					<input type="text" data-kt-customer-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Clients" />
				</div>
			</div>
			<div class="card-toolbar">
				<?php if (isHaveAbility($permission . 'create')) : ?>
					<div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
						<a href="<?= base_url($route . '/create') ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</a>
					</div>
				<?php endif ?>
			</div>
		</div>
		<div class="card-body pt-0">
			<div class="py-3">
				<?php $this->load->view('partials/admin/admin_alert'); ?>
			</div>

			<table class="table align-middle table-row-dashed fs-6 gy-5" id="<?= $table_id ?>">

			</table>
		</div>
	</div>
</div>

<script defer>
	"use strict";

	// Class definition
	const KTHandleList = function() {
		// Define shared variables
		let table;
		let datatable;

		const initDataList = function() {
			table = document.getElementById('<?= $table_id ?>');

			datatable = $(table).DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: '<?= base_url($route . '/paginate') ?>',
					type: 'POST'
				},
				columns: [{
						data: 'name',
						title: 'Client',
						render: function(data, type, row) {
							return `
								<div class="row">
									<div class="col-md-3 text-center">
										<img width="64" class="img-fluid rounded-circle img-thumbnail" draggable="false" src="${row.url_image}"/>
									</div>
									<div class="col-md-9 d-flex align-items-center">
										<div>
											<div><strong>${row.name || '-'}</strong></div>
											<div class="small text-muted">${row.position || '-'}</div>
										</div>
									</div>
								</div>
							`;
						}
					},
					{
						data: 'email',
						title: 'Email',
						render: function(data, type, row) {
							return `
								<div>
									<div><strong>${row.email || '-'}</strong></div>
									<div class="small text-muted">Account type: ${row.account_type}</div>
								</div>
						`;
						}
					},
					{
						data: 'subscription_name',
						title: 'Subscription',
						render: function(data, type, row) {
							return `
								<div>
									<div><strong>${row.subscription_name}</strong></div>
									<div class="small text-muted">start: ${row.subscribed_at || '-'}</div>
									<div class="small text-muted">end: ${row.subscription_ends_at || '-'}</div>
								</div>
							`;
						}
					},
					{
						data: 'actions',
						title: 'Actions',
						orderable: false,
						render: function(data, type, row) {
							return `
								<a href="<?= base_url($route . '/profile/') ?>${row.id}" class="btn btn-light btn-active-light-primary btn-sm">
									Detail
								</a>
						`;
						}
					}
				]
			});

			const filterSearch = document.querySelector('[data-kt-customer-table-filter="search"]');
			filterSearch.addEventListener('keyup', function(e) {
				datatable.search(e.target.value).draw();
			});
		};

		return {
			init: function() {
				initDataList();
			}
		}
	}();

	// On document ready
	KTUtil.onDOMContentLoaded(function() {
		KTHandleList.init();
	})
</script>
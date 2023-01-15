<div id="kt_content_container" class="container-fluid animate__animated animate__fadeIn">
	<div class="row mb-5">
		<div class="col-xl-8">
			<div class="card card-flush overflow-hidden h-md-100">
				<div class="card-header py-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bolder text-dark">Total Download</span>
						<span class="text-gray-400 mt-1 fw-bold fs-6">Users from all subscriptions</span>
					</h3>
				</div>
				<div class="card-body d-flex justify-content-between flex-column pb-1 px-0">
					<div id="kt_charts_widget_3" class="min-h-auto ps-4 pe-6" style="height: 300px"></div>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="row">
				<div class="col-sm-4 col-xl-12 p-4">
					<div class="card">
						<div class="card-body">
							<djv class="row">
								<div class="col-2 d-flex align-items-center justify-content-center">
									<img draggable="false" src="<?= base_url('public/images') ?>/down.png" class="img-fluid" alt="">
								</div>
								<div class="col-10">
									<span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2 counter" data-counter="<?= $total_downloads ?>">0</span>
									<div class="m-0">
										<span class="fw-bold fs-6 text-gray-400">Downloaded Today</span>
									</div>
								</div>
							</djv>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-xl-12 p-4">
					<div class="card">
						<div class="card-body">
							<djv class="row">
								<div class="col-2 d-flex align-items-center justify-content-center">
									<img draggable="false" src="<?= base_url('public/images') ?>/icontexto-emoticons-02-icon.png" class="img-fluid" alt="">
								</div>
								<div class="col-10">
									<span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2 counter" data-counter="<?= $total_icons ?>">0</span>
									<div class="m-0">
										<span class="fw-bold fs-6 text-gray-400">Icon Total</span>
									</div>
								</div>
							</djv>
						</div>
					</div>
				</div>
				<div class="col-sm-4 col-xl-12 p-4">
					<div class="card">
						<div class="card-body">
							<djv class="row">
								<div class="col-2 d-flex align-items-center justify-content-center">
									<img draggable="false" src="<?= base_url('public/images') ?>/clients.png" class="img-fluid" alt="">
								</div>
								<div class="col-10">
									<span class="fw-bold fs-3x text-gray-800 lh-1 ls-n2 counter" data-counter="<?= $total_clients ?>">0</span>
									<div class="m-0">
										<span class="fw-bold fs-6 text-gray-400">Client Total</span>
									</div>
								</div>
							</djv>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-5">
		<div class="col-xl-4">
			<div class="card card-flush h-xl-100">
				<div class="card-header border-0 pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bolder text-dark">Most Downloaded Categories</span>
						<!-- <span class="text-muted mt-1 fw-bold fs-7">Avg. <span class="counter" data-counter="<?= $most_downloaded['average'] ?>"></span>% downloads per month</span> -->
					</h3>
				</div>
				<div class="card-body pt-5">
					<?php foreach ($most_downloaded['categories'] as $category) : ?>
						<div class="d-flex flex-stack">
							<div class="d-flex align-items-center me-3">
								<img draggable="false" src="<?= $category->url_image ?>" class="me-4 w-30px" alt="">
								<div class="flex-grow-1">
									<span class="text-gray-800 fs-5 fw-bolder lh-0"><?= $category->name ?></span>
									<span class="text-gray-400 fw-bold d-block fs-6">
										<i class="fa fa-download text-dark"></i> <span class="counter" data-counter="<?= $category->number_of_downloads ?>">0</span>
									</span>
								</div>
							</div>
							<div class="d-flex align-items-center w-100 mw-125px">
								<div class="progress h-6px w-100 me-2 bg-light-success">
									<div class="progress-bar bg-success" role="progressbar" style="width: <?= $category->average ?>%" aria-valuenow="<?= $category->average ?>" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
								<span class="text-gray-400 fw-bold"><?= $category->average ?>%</span>
							</div>
						</div>
						<div class="separator separator-dashed my-3"></div>
					<?php endforeach ?>
				</div>
			</div>
		</div>

		<div class="col-xl-8">
			<div class="card card-flush h-xl-100">
				<div class="card-header pt-7">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bolder text-gray-800">Latest Transactions</span>
						<span class="text-gray-400 mt-1 fw-bold fs-6">Avg. <?= $latest_transactions['average'] ?> transactions per month</span>
					</h3>
				</div>
				<div class="card-body pt-2">
					<div class="table-responsive">
						<table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_4_table">
							<thead>
								<tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
									<th class="min-w-100px">Order ID</th>
									<th class="text-end min-w-100px">Created</th>
									<th class="text-end min-w-125px">Customer</th>
									<th class="text-end min-w-100px">Total</th>
									<th class="text-end min-w-50px">Status</th>
								</tr>
							</thead>
							<tbody class="fw-bolder text-gray-600">
								<?php foreach ($latest_transactions['transactions'] as $transaction) : ?>
									<tr>
										<td>
											<div role="button" data-bs-toggle="modal" data-bs-target="#detail-<?= $transaction->id ?>">
												<span class="text-gray-800"><?= $transaction->order_id ?></span>
											</div>
										</td>
										<td class="text-end"><?= $transaction->created ?></td>
										<td class="text-end">
											<a href="#" class="text-gray-600"><?= $transaction->client_email ?></a>
										</td>
										<td class="text-end"><?= number_format($transaction->subscription_total) ?></td>
										<td class="text-end">
											<?= $transaction->status_html ?>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						<div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"></div>
						<div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php foreach ($latest_transactions['transactions'] as $transaction) : ?>
	<div class="modal fade" id="detail-<?= $transaction->id ?>" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header pb-0 border-0 justify-content-end">
					<div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<span class="svg-icon svg-icon-1">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
								<rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
								<rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
							</svg>
						</span>
					</div>
				</div>
				<div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
					<?php if ($transaction->response) : ?>
						<?php $response = json_decode($transaction->response); ?>
						<div class="mb-7 h5 fw-bolder">Response Detail</div>

						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">status code</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->status_code ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">status message</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->status_message ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">transaction id</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->transaction_id ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">order id</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->order_id ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">gross amount</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->gross_amount ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">payment type</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->payment_type ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">transaction time</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->transaction_time ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">transaction status</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->transaction_status ?></span>
							</div>
						</div>
						<div class="row mb-7">
							<label class="col-lg-4 fw-bold text-muted">fraud status</label>
							<div class="col-lg-8">
								<span class="fw-bolder fs-6 text-gray-800"><?= $response->fraud_status ?></span>
							</div>
						</div>
					<?php else : ?>
						<div class="text-center">No Data Available</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
<?php endforeach ?>

<script defer>
	const dashboard = function() {
		const initCounter = function() {
			$('.counter').each(function() {
				$(this).prop('Counter', 0).animate({
					// Counter: $(this).text()
					Counter: $(this).data('counter')
				}, {
					duration: 2000,
					easing: 'swing',
					step: function(now) {
						now = Number(Math.ceil(now)).toLocaleString('en');
						$(this).text(now);
					}
				});
			});
		}

		const initChart = function() {
			const chart_el = document.getElementById("kt_charts_widget_3");
			if (!chart_el) return;

			const height = parseInt(KTUtil.css(chart_el, "height")),
				color_gray = KTUtil.getCssVariableValue("--bs-gray-500"),
				// color_grey = KTUtil.getCssVariableValue("--bs-border-dashed-color"),
				color_grey = '#E4E6EF',
				color_success = KTUtil.getCssVariableValue("--bs-success");

			const datas = JSON.parse(`<?= $chart_downloaded ?>`),
				categories = datas.categories,
				series = datas.series;

			const chart = new ApexCharts(chart_el, {
				series: series,
				chart: {
					fontFamily: "inherit",
					type: "area",
					height: height,
					toolbar: {
						show: false
					}
				},
				plotOptions: {},
				legend: {
					show: false
				},
				dataLabels: {
					enabled: false
				},
				fill: {
					type: "gradient",
					gradient: {
						shadeIntensity: 1,
						opacityFrom: .4,
						opacityTo: 0,
						stops: [0, 80, 100]
					}
				},
				stroke: {
					curve: "smooth",
					show: !0,
					width: 3,
					colors: [color_success]
				},
				xaxis: {
					categories: categories,
					axisBorder: {
						show: false
					},
					axisTicks: {
						show: false
					},
					tickAmount: 6,
					labels: {
						rotate: 0,
						rotateAlways: !0,
						style: {
							colors: color_gray,
							fontSize: "12px"
						}
					},
					crosshairs: {
						position: "front",
						stroke: {
							color: color_success,
							width: 1,
							dashArray: 3
						}
					},
					tooltip: {
						enabled: !0,
						formatter: void 0,
						offsetY: 0,
						style: {
							fontSize: "12px"
						}
					}
				},
				yaxis: {
					tickAmount: 4,
					// max: 24,
					// min: 10,
					labels: {
						style: {
							colors: color_gray,
							fontSize: "12px"
						},
						formatter: function(e) {
							return e
						}
					}
				},
				states: {
					normal: {
						filter: {
							type: "none",
							value: 0
						}
					},
					hover: {
						filter: {
							type: "none",
							value: 0
						}
					},
					active: {
						allowMultipleDataPointsSelection: false,
						filter: {
							type: "none",
							value: 0
						}
					}
				},
				tooltip: {
					style: {
						fontSize: "12px"
					},
					y: {
						formatter: function(e) {
							return e
						}
					}
				},
				colors: [color_success],
				grid: {
					borderColor: color_grey,
					strokeDashArray: 4,
					yaxis: {
						lines: {
							show: !0
						}
					}
				},
				markers: {
					strokeColor: color_success,
					strokeWidth: 3
				}
			});

			chart.render()
		}

		const initDataTable = function() {
			const table = document.querySelector("#kt_table_widget_4_table");
			$(table).DataTable({
				info: false,
				order: [],
				lengthChange: false,
				responsive: true,
				pageLength: 6,
				ordering: false,
				paging: false,
				columnDefs: [{
					orderable: false,
					targets: 0
				}]
			});
		}

		return {
			init: function() {
				initCounter();
				initChart();
				initDataTable();
			}
		}
	}();

	KTUtil.onDOMContentLoaded((function() {
		dashboard.init();
	}))
</script>
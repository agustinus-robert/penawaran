<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<div class="card">

						<div class="card-body">
							<table class="table">
								<tr>
									<td>{{__('permintaan.status')}}</td>
									<td><?php 
										if($core->status == 1){
											echo "<label class='badge badge-success'>".__('penawaran.aksi_setuju')."</label> <br /> <b>(".$core->tanggal_approve.")</b>";
										} else if($core->status == 2){
											echo "<label class='badge badge-dange'>".__('penawaran.aksi_ditolak')."</label> <br /> <b>(".$core->tanggal_approve.")</b>";
										}
									?>
									</td>
								</tr>

								<tr>
									<td>{{__('permintaan.table_perusahaan')}}</td>
									<td><?=$perusahaan->name?></td>
								</tr>

								<tr>
									<td>{{__('permintaan.table_client')}}</td>
									<td><?=$client->nama?></td>
								</tr>

								<tr>
									<td>{{__('permintaan.table_request_date')}}</td>
									<td><?=$core->tanggal_awal?></td>
								</tr>


								<tr>
									<td>{{__('permintaan.table_end_request_date')}}</td>
									<td><?=$core->tanggal_akhir?></td>
								</tr>

							</table>
						</div>
					</div>
				</div>

				<div class="col-md-4">
			        <div class="card border-left-primary shadow h-100 py-2">
			            <div class="card-body">
			                <div class="row no-gutters align-items-center">
			                    <div class="col mr-2">
			                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
			                            <?=$client->name?></div>
			                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?=number_format($core->nominal, 0, ",", ".")?>,00</div>
			                        <p>{{__('penawaran.dibuat')}} <?=$core->created_at?></p>
			                    </div>
			                    <div class="col-auto">
			                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
			                    </div>
			                </div>
			            </div>
			        </div>
				</div>
			</div>
		</div>

	</div>
</div>
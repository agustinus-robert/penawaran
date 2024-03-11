<div class="container-fluid">
	<div class="card">
		<div class="card-body">
			<div class="row">
				<div class="col-md-8">
					<div class="card">

						<div class="card-body">
							<table class="table">
								<tr>
									<td>{{__('penawaran.status')}}</td>
									<td><?php 
										if($core->approve == 1){
											echo "<label class='badge badge-success'>".__('penawaran.aksi_setuju')."</label> <br /> <b>(".$core->approved_at.")</b>";
										} else if($core->approve == 2){
											echo "<label class='badge badge-dange'>".__('penawaran.aksi_ditolak')."</label> <br /> <b>(".$core->approved_at.")</b>";
										}
									?>
									</td>
								</tr>

								<tr>
									<td>{{__('penawaran.table_proyek')}}</td>
									<td><?=$proyek->nama?></td>
								</tr>

								<tr>
									<td>{{__('penawaran.form_pekerjaan')}}</td>
									<td><?=$pekerjaan->nama?></td>
								</tr>

								<tr>
									<td>{{__('penawaran.table_nama_perusahaan')}}</td>
									<td><?=$perusahaan->name?></td>
								</tr>

								<tr>
									<td>{{__('penawaran.table_tipe_pekerjaan')}}</td>
									<td><?=$pekerjaan_tipe->nama?></td>
								</tr>


								<tr>
									<td>{{__('penawaran.table_nominal')}}</td>
									<td><?=$core->nominal?></td>
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
<div class="card">
	<div class="card-body">
		<div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            {{__('global.currency')}}</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?=number_format($nominal_bayar, 0, ",", ".")?>,00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas  	fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>

		<div class="form-group">
			<input type="hidden" id="nominal_harus_bayar" value="<?=$nominal_bayar?>" />
		</div>

		<div class="form-group">
			<input type="hidden" id="id" name="id" value="<?=$id_pesanan_pembelian?>" />
			<input class="form-control" type="text" name="paid" id="paid" required />
		</div>
	</div>

	<div class="card-footer">
		<input class="btn btn-primary" type="button" id="submit_paid" value="Save" />
	</div>
</div>
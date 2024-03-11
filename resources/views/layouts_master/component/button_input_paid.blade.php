<a id="input_paid" data-toggle="modal" data-target="#paidModal" href="javascript:void(0)" data-id="<?=$id?>" data-nominal="<?=$nominal?>" href="#"><i class='far fas fa-money-bill-wave text-info'></i> {{__('global.paid')}}</a> 

<div class="modal fade" id="paidModal" tabindex="-1" role="dialog" aria-labelledby="paidModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel"><i class="far fa-eye"></i> {{__('global.paid')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal_show_input_paid"></div>
      
    </div>
  </div>
</div>
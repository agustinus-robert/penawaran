<a id="input_ref" data-toggle="modal" data-target="#refModal" href="javascript:void(0)" data-tipe="<?=$tipe?>" data-id="<?=$id?>" href="#"><i class='fas fa-calculator text-info'></i> {{__('global.referensi')}}</a> 

<div class="modal fade" id="refModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel"><i class="far fa-eye"></i> {{__('global.referensi')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal_show_input_ref"></div>
      
    </div>
  </div>
</div>
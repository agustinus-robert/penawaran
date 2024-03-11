<button id="detail" data-toggle="modal" data-target="#detailModal" href="javascript:void(0)" class="btn text-info border-info btn_detail_modal" type="button" data-id="{{ $id }}" title="Edit">
    <i class="fas fa-eye"></i>
</button>

<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title text-white" id="exampleModalLabel"><i class="far fa-eye"></i> {{__('global.detail')}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="modal_show"></div>
      
    </div>
  </div>
</div>
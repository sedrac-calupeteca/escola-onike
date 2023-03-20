<div class="modal fade" id="modalFoto" tabindex="-1" role="dialog" aria-labelledby="modalFotoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form class="modal-content" action="{{route('user.foto')}}" method="POST" id="formFoto" enctype="multipart/form-data">
        @csrf
        <div class="modal-header bg-warning text-white">
          <h5 class="modal-title" id="modalFotoLabel">
            <span>Foto de perfil</span>
          </h5>
          <button type="button" class="" data-bs-dismiss="modal" aria-label="Close" style="background: none; border: none;">
            <span aria-hidden="true" class="text-white h3">x</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="file" name="image" id="image" class="form-control" placeholder="Escolha a imagem, para ser a foto de perfil"/>
          </div>
          <input type="hidden" name="user_id" @isset($user_id) value="{{$user_id}}" @endisset/>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <span>Alterar</span>
          </button>
        </div>
      </form>
    </div>
  </div>
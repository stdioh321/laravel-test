<div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">title</i>
            <input type="text" class="validate" id="titulo" name="titulo" minlength="1"  maxlength="255" required value="{{isset($data['titulo'])?$data['titulo']:''}}">
                <label for="titulo">Titulo</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                {{-- <input type="text" class="validate" id="descricao" name="descricao" minlength="1" required> --}}
                <i class="material-icons prefix">info</i>    
                <textarea class="materialize-textarea"  class="validate"  id="descricao" name="descricao" minlength="1"  maxlength="255" required
                
                >{{isset($data['descricao'])?$data['descricao']:''}}</textarea>

                <label for="descricao">Descrição</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <i class="material-icons prefix">attach_money</i>
                <input type="text" class="validate" id="valor" name="valor" minlength="1" required
                value="{{isset($data['valor'])?$data['valor']:''}}"
                >
                <label for="valor">Valor</label>
            </div>
        </div>

 

        <div class="row">
            <div class="col s12">
                 <div class="file-field input-field">
      <div class="btn orange">
        <span>Imagem</span>
        <input type="file" name="imagem" {{ isset($data) ? '':'required' }} id="iImg">
      </div>
      <div class="file-path-wrapper">
        <input class="file-path validate" type="text">
      </div>
    </div>
    <?php
    $imgPreview =isset($data) && isset($data->imagem)? $data->imagem : null;
    ?>
    <div>
        <img src="{{!$imgPreview?'':url('assets/cursos/'.$imgPreview)}}" alt="" style="max-width: 100%; max-height: 200px" id="img-preview">
    </div>    
    </div>
        </div>
       <div class="row">
            <div class="col s12">
                <label class="right">
                    <input type="checkbox" class="filled-in" name="publicado" 
                    {{ isset($data->publicado) && $data->publicado == 'nao'? '':'checked' }}
                    />
                    <span>Publicado</span>
                </label>
                
            </div>
        </div>
        @if ($errors->any())
            <div class="row">
            <div class="col s12">
                @foreach ($errors->all() as $error)
                    <div class="red-text">
                        {{$error}}
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
$(document).ready(function(){
    $('#valor').mask('09999.00', {reverse: true});
    
})
</script>
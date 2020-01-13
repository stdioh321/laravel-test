@extends('layouts.site')
@section('title', 'Contato')

@section('content')

<div class="row">
       <div class="col-12">
           <form action="contato" method="post" id="fContato">
               {{ csrf_field() }}
               <div class="form-row">
                   <div class="form-group col-md-6 col-12">
                       <label for="">Name</label>
                       <input type="text" class="form-control" name="name" placeholder="Name"/>
                   </div>
                   <div class="form-group col-md-6 col-12">
                       <label for="">Phone</label>
                       <input type="text" class="form-control" name="tel" placeholder="Phone" maxlength="9"/>
                       @if ($errors->has('tel'))
                            @foreach ( $errors->get('tel') as $error)
                            <div class="small text-danger font-weight-bold font-italic">
                                {{$error}}
                            </div>        
                            @endforeach
                            
                            
                            
                        @endif
                   </div>
                   
                    @if($errors->any())
                   <div class="form-group col-12 errors-wrap">     
                          
                    </div>
                    @endif
                   
                   <div class="form-group col-12 text-right">
                       <button class="btn btn-primary btn-lg" onclick="sendApi(event)" type="button">
                           Send API
                       </button>
                       <button class="btn btn-primary btn-lg ml-2" type="submit">
                           Send
                       </button>

                   </div>

               </div>
           </form>
       </div>
       
   </div>
   <div class="row">
       <div class="col-12">
            <h1>Contato</h1>
    <div class="row">
        @foreach ( $contatos as $contato )
    @if (!empty($contato['name']))
        <div class="col-md-6 col-12 mb-1">
            <div class="card">
                <div class="card-body">
                    <h5 class="d-flex justify-content-between align-items-center">
                        <div class="font-weight-bold">{{$contato['name']}}</div>
                        <div class="text-danger font-weight-bold" style="font-size:30px; cursor:pointer">
                        {{-- <a href="contato/{{$contato['id']}}">&olcross;</a> --}}
                        <form action="contato/{{$contato['id']}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="DELETE">
                        <div class="font-danger" style="font-size:30px" onclick="javascript:this.parentNode.submit();">&olcross;</div>
                        </form>
                        </div>
                    </h5>
            <h5 class="font-italic small">{{$contato['tel']}}</h5>
                </div>
            </div>
        </div>
    @endif
    @endforeach
    </div>
       </div>
   </div>
   
   <script>
   var iName = document.getElementsByName('name')[0];
       var iTel = document.getElementsByName('tel')[0];
   window.onload = function(){
       
       
       f = document.querySelector("#fContato");
       f.onsubmit = function(e){
           
           if(!iName.value || !iTel.value) {
               alert('Fields required');
            //    e.preventDefault();
               return false;
           }
           
       }

       
   }
   function sendApi(e){
       axios.post('/contato-api',{name:iName.value,tel:iTel.value})
       .then(res=>{
            console.log(res.data);
       })
       .catch(err=>{
           console.log(err.response.data);
           
       });
   }
   </script>    
@endsection


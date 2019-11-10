@extends('layouts.app')

@section('content')
<div class="container">
<form class="form-horizontal" id="edit_property_type">
  @csrf
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">Name:</label>
      <div class="col-sm-10">
        <input type="text" class="form-control" value="{{ $contracttype->name }}" id="name" placeholder="Enter Name" name="name">
      </div>
      <input type="hidden" name="id" value="{{ $contracttype->id }}" >
       <div class="col-sm-10">
        <span class="error-name" style="color: red"></span>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
        <a href="{{ route('contracttypes.index') }}" class="btn btn-primary">Cancel</a>
      </div>
    </div>
  </form>
  </div>



  <script type="text/javascript">
  $(document).ready(function(){
    $("#edit_property_type").submit(function(e){
      e.preventDefault();
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      var name = $("#name").val();
       $.ajax({
                    url: '{{ route("contracttypes.update", $contracttype->id)}}',
                    type: 'PUT',
                    data: {_token: CSRF_TOKEN, name: name},
                    dataType: 'JSON',
                    success: function (data) { 
                      if(data.msg == "true")
                       {
                          window.location.replace("{{ route('contracttypes.index') }}");
                       }


                    },

                    error: function (response) {
        if (response.status == 422) { // when status code is 422, it's a validation issue
            $(".error-name").html(response.responseJSON.errors.name);
        }
    }



                }); 
    });
  });
</script>
  


@endsection



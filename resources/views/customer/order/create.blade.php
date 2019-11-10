@extends('layouts.app')

<style type="text/css">
  
.col-sm-2 {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 25.666667% !important;
</style>

@section('content')

<div class="container">
<form class="form-horizontal" id="add_contract_type">
	@csrf
    <div class="form-group">
      <label class="control-label col-sm-2" for="name">What kind of property</label>
      <div class="col-sm-10">
        <select class="form-control" id="property_type" name="property_type">
          <option>Select Property Type</option>
          @foreach($array['property_types'] as $property_type)
          <option value="{{ $property_type->name }}">{{ $property_type->name }}</option>
          @endforeach
        </select>
      </div>
       <div class="col-sm-10">
        <span class="error-name" style="color: red"></span>
      </div>
    </div>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" class="btn btn-default">Submit</button>
      </div>
    </div>
  </form>
  </div>
  <script type="text/javascript">
	$(document).ready(function(){
		$("#add_contract_type").submit(function(e){
			e.preventDefault();
         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
			var name = $("#name").val();
			 $.ajax({
                    url: '{{ route("contracttypes.store")}}',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, name: name},
                    dataType: 'JSON',
                    success: function (data) { 
                       if(data.msg == "true")
                       {
                       		swal("", "New Contract Type is inserted succesfully", "success");
                       		$("#name").val('');
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



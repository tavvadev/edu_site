@extends('layouts.master')

@section('content')
<br>
<br>
<?php
        
        ?>
<form class="row gx-3 gy-2 align-items-center">
  <div class="col-sm-3">
  <div class="input-group">
    <div class="input-group-text">Districts</div>
      <select class="form-select" id="district_id" name="district_id" onchange="mandalsList();">
        <option >Choose...</option>
        <?php
          foreach($districts as $district){
        ?>
        <option value="{{$district->id}}">{{$district->dist_name}}</option>
        <?php } ?>
        
      </select>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">Mandals</div>
      <select class="form-select" id="mandalOptionsList" name="mandalOptionsList">
     
    </select>
    </div>
  </div>

  
  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">Villages</div>
      <select class="form-select" id="specificSizeSelect">
      <option selected>Choose...</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
    </select>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">School Category</div>
      <select class="form-select" id="specificSizeSelect">
      <option selected>Choose...</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
    </select>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">Schools</div>
      <select class="form-select" id="specificSizeSelect">
      <option selected>Choose...</option>
      <option value="1">One</option>
      <option value="2">Two</option>
      <option value="3">Three</option>
    </select>
    </div>
  </div>

  
  
  
  <div class="col-auto">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>
</form>

<br>
<br>
<br>
<script>
          function mandalsList(){   
            var mandalsoptions =""; 

            $.ajax({
                type: "POST",
                url: 'http://127.0.0.1:8000/api/mandals',
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                  district: $("#district_id").val()
                }),
                success: function(response) {
                  mandalsoptions+='<option selected>Choose...</option>';
                    var m=0;
                    $.each(response.mandals, function(key, value) {
                      mandalsoptions+='<option value="'+response.mandals[m].id+'">'+response.mandals[m].mandal_name+'</option>';
                      m++;
                    });
                    $("#mandalOptionsList").html(mandalsoptions);
                },
                error: function(response) {
                    console.log(response);
                }
            });
            
            
          } 
</script>  
@endsection
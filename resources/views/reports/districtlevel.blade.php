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
      <select class="form-select" id="mandalOptionsList" name="mandalOptionsList" onchange="villagesList();">
     
    </select>
    </div>
  </div>

  
  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">Villages</div>
      <select class="form-select" id="village_id" name="village_id" onchange="schoolsList();" >
      
      </select>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">School Category</div>
      <select class="form-select" id="school_category" name="school_category">
          <option selected>Choose...</option>
          <option value="PRIMARY">PRIMARY</option>
          <option value="UPPER PRIMARY">UPPER PRIMARY</option>
          <option value="SECOUNDARY">SECOUNDARY</option>
    </select>
    </div>
  </div>

  <div class="col-sm-3">
    <div class="input-group">
      <div class="input-group-text">Schools</div>
      <select class="form-select" id="school_id" name="school_id" >
      
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

          function villagesList(){   
            var villageoptions =""; 

            $.ajax({
                type: "POST",
                url: 'http://127.0.0.1:8000/api/villages',
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                  district_id: $("#district_id").val(),
                  mandal_id: $("#mandalOptionsList").val()
                }),
                success: function(response) {
                  villageoptions+='<option selected>Choose...</option>';
                    var n=0;
                    $.each(response.villages, function(key, value) {
                      villageoptions+='<option value="'+response.villages[n].id+'">'+response.villages[n].village_name+'</option>';
                      n++;
                    });
                    $("#village_id").html(villageoptions);
                },
                error: function(response) {
                    console.log(response);
                }
            });
            
            
          }


          function schoolsList(){   
            var schoolsoptions =""; 

            $.ajax({
                type: "POST",
                url: 'http://127.0.0.1:8000/api/schools',
                contentType: "application/json",
                dataType: "json",
                data: JSON.stringify({
                  district_id: $("#district_id").val(),
                  village_id: $("#village_id").val()
                }),
                success: function(response) {
                  schoolsoptions+='<option selected>Choose...</option>';
                    var p=0;
                    $.each(response.schools, function(key, value) {
                      schoolsoptions+='<option value="'+response.schools[p].id+'">'+response.schools[p].school_name+'</option>';
                      p++;
                    });
                    $("#school_id").html(schoolsoptions);
                },
                error: function(response) {
                    console.log(response);
                }
            });
            
            
          }

</script>  
@endsection
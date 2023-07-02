@extends('layouts.master')

@section('content')
<br>
<br>
<?php
        
        ?>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"><form class="row gx-3 gy-2 align-items-center">
  <div class="col-sm-3">
  <div class="input-group">
    <div class="input-group-text">Districts</div>
      <select class="form-select" id="district_id" name="district_id" onchange="mandalsList();">
        <option value="">Choose...</option>
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
    <button type="button" class="btn btn-primary" onClick="Reports();" >Submit</button>
  </div>
</form>

<br>
<br>

<table class="table table-bordered" >
    <thead>
      <tr>
        <th>S.No</th>
        <th>District</th>
        <th>No Of Mandals</th>
        <th>No Of Villages</th>
        <th>No Of Schools</th>
        <th>No Of Teachers</th>
        <th>No Of Boys</th>
        <th>No Of Girls</th>
        <th>Total Students</th>
        <th>No Of ClassRooms</th>
      </tr>
    </thead>
    <tbody id="districtreporttable">

    </tbody> 

</table>


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
        mandalsoptions+='<option value="">Choose...</option>';
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
        villageoptions+='<option value="">Choose...</option>';
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
        schoolsoptions+='<option value="">Choose...</option>';
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


function Reports(){
  $("#districtreporttable").empty();
  var reportsHtml =""; 
  var district_id = $("#district_id").val();
  if(district_id==""){
    district_id = "";
  }
  var mandal_id = $("#mandalOptionsList").val();
  if(mandal_id=="" || village_id==null){
    mandal_id = "";
  }
  var village_id = $("#village_id").val();
  if(village_id=="" || village_id==null){
    village_id = "";
  }
  var school_id = $("#school_id").val();
  if(school_id=="" || school_id==null){
    school_id = "";
  }

  $.ajax({
      type: "POST",
      url: 'http://127.0.0.1:8000/api/districtlevelreport',
      contentType: "application/json",
      dataType: "json",
      data: JSON.stringify({
        district_id: district_id,
        mandal_id: mandal_id,
        village_id: village_id,
        school_id: school_id
      }),
      success: function(response) {
          var p=0;
          var ml=1;
          $.each(response.reports, function(key, value) {
            //console.log("key : "+key+" ; value : "+value);

           reportsHtml+='<tr><td>'+ml+'</td><td>'+response.reports[p].dist_name+'</td><td>'+response.reports[p].mandals_count+'</td><td>'+response.reports[p].villages_count+'</td><td>'+response.reports[p].schools_count+'</td><td>'+response.reports[p].teachers+'</td><td>'+response.reports[p].boys+'</td><td>'+response.reports[p].girls+'</td><td>'+response.reports[p].total_students+'</td><td>'+response.reports[p].total_classrooms+'</td></tr>';
           ml++;
           p++;
          });
          $("#districtreporttable").append(reportsHtml);
      },
      error: function(response) {
          console.log(response);
      }
  });
  
  
}
</script>  
@endsection
@extends('layouts.app')

@section('content')

<section class="section">
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Send New Messages</h4>
          </div>
          <div class="card-body">
          <form id="add-form" action="" method="POST">
          <?= csrf_field() ?>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-2">Select Type</label>
              <div class="col-sm-12 col-md-8" data-select2-id="12">
              <select name="source" class="form-control selectric" id="source">
              <option value="_">select Here..</option>
                <option value="members">All Users</option>
                  <option value="groups">Based on Groups</option>
                  <option value="numbers">Input Numbers</option>
                </select>
              </div>
            </div>
            <div class="form-group row mb-4" style="display: none;" id="groups">
              <label class="col-form-label text-md-right col-12 col-md-2">Select Group</label>
              <div class="col-sm-12 col-md-8" data-select2-id="12">
              <select name="group_id[]" class="form-control  select2" style="width: 100%"style="width: 100%" multiple="">
              <option value="">Select Group here...</option>
                  <option value="all">All</option>
                  <?php 
                    foreach($groups as $group){
                      echo '<option value="'.$group->id.'">'.$group->name.' ('.$group->members->count().')</option>';
                    }
                    ?>
                </select>
              </div> 
            </div>
          
            <div class="form-group row mb-4"  style="display: none;" id="numbers">
              <label class="col-form-label text-md-right col-12 col-md-2">Enter Numbers</label>
              <div class="col-sm-12 col-md-8">
                  <input name="numbers" type="text" class="form-control" style="width: 100%"style="width: 100%" placeholder="Enter numbers separetaed by commas">
              </div>
            </div>

            <div class="form-group row mb-4"  style="display: none;" id="members">
              <label class="col-form-label text-md-right col-12 col-md-2">Select Members</label>
              <div class="col-sm-12 col-md-8" data-select2-id="12">
              <select name="member_id[]" class="form-control  select2" style="width: 100%"style="width: 100%" multiple="">
              <option value="">Select Members here...</option>
              <option value="all">All</option>
                  <?php 
                    foreach($users as $user){
                      echo '<option value="'.$user->id.'">'.$user->name.'</option>';
                    }
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-2">Message Content</label>
              <div class="col-sm-12 col-md-8" data-select2-id="12">
                <textarea class="form-control" name="body" style="height: 200px;" rows="10" required id="content_area"></textarea><br>
                <span>SMS count <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
              </div>
              <div class="col-sm-12 pl-4">
            
            <div class="text-center">Write <b style="color: green;">#name</b>, System will replace with a member name. </div>
            <!-- <code style="color: green;">#username</code>,  Replace With Member Username</div> -->
            
        </div>
            </div>
            <div class="form-group row mb-4">
              <label class="col-form-label text-md-right col-12 col-md-2"></label>
              <div class="col-sm-12 col-md-8" data-select2-id="12">
                <button class="btn btn-success pl-4 pr-4">Send</button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>
<script src="/assets/js/jquery-3.6.3.min.js"></script>
<script>
  jQuery.noConflict();
  // Use jQuery via $() instead of via $()
  $(document).ready(function(){
    $('#source').change(function (event) {
    var source = $(this).val();
    if (source === 'all' || source === '') {
      $('#families,#groups,#members,#numbers,#visitors').hide();
    }else if (source === 'groups') {
      $('#groups').show();
      $('#families,#members,#numbers,#visitors').hide();
    }else if (source === 'families') {
      $('#families').show();
      $('#groups,#members,#visitors').hide();
    }else if (source === 'visitors') {
      $('#visitors').show();
      $('#families,#groups,#numbers,#members').hide();
    }else if (source === 'members') {
      $('#members').show();
      $('#families,#groups,#numbers,#visitors').hide();
    }else if (source === 'numbers') {
      $('#numbers').show();
      $('#families,#groups,#members,#visitors').hide();
    } else {
      $('#families,#groups,#members,#numbers,#visitors').hide();
    }
});
$('#families,#groups,#members,#numbers,#visitors').hide();
});  

</script>

@endsection
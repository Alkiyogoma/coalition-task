@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4>
                Send New Messages
              </h4>
              <hr class="horizontal dark mt-3 mb-2" />

            <form id="add-form" action="" method="POST">
            <?= csrf_field() ?>
              <div class="row input-group input-group-outline my-3">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Type</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="source" class="form-control selectric" id="source">
                <option value="_">select Here..</option>
                  <option value="members">Church Members</option>
                    <option value="leaders">Church Leaders</option>
                    <option value="groups">Church Groups</option>
                    <option value="families">Church Families</option>
                    <option value="visitors">Church Visitors</option>
                  </select>
                </div>
              </div>
              <div class="row input-group input-group-outline my-3" style="display: none;" id="groups">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Group</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="group_id[]" class="form-control  select2" style="width: 100%"style="width: 100%" multiple="">
                <option value="">Select Group here...</option>
                    <option value="all">All</option>
                    <?php 
                      foreach($groups as $group){
                        echo '<option value="'.$group->id.'">'.$group->name.' ('.$group->clients->count().')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>
              
              <div class="row input-group input-group-outline my-3" style="display: none;" id="leaders">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Leaders</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="leader_id[]" class="form-control  select2" style="width: 100%"style="width: 100%" multiple="">
                <option value="">Select Leaders here...</option>
                    <option value="all">All</option>
                    <?php 
                      foreach($leaders as $leader){
                        echo '<option value="'.$leader->user_id.'">'.$leader->name.' ('.$leader->clients->count().')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>

              <div class="row input-group input-group-outline my-3" style="display: none;" id="families">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Families</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="family_id[]" class="form-control  select2" style="width: 100%"style="width: 100%" multiple="">
                <option value="">Select Families here...</option>
                    <option value="all">All</option>
                    <?php 
                      // $families = \App\Models\Family::get();
                      foreach($families as $family){
                        echo '<option value="'.$family->user_id.'">'.$family->name.' ('.$family->account.')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>
              

              <div class="row input-group input-group-outline my-3" style="display: none;" id="visitors">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Visitors</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="visitor_id[]" class="form-control  select2" style="width: 100%"style="width: 100%" multiple="">
                <option value="">Select Visitor here...</option>
                    <option value="all">All</option>
                    <?php 
                      foreach($visitors as $visitor){
                        echo '<option value="'.$visitor->id.'">'.$visitor->name.' ('.$visitor->sex.')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>
              

              <div class="row input-group input-group-outline my-3"  style="display: none;" id="members">
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
              <div class="row input-group input-group-outline my-3">
                <label class="col-form-label text-md-right col-12 col-md-2">Content</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                  <textarea class="form-control" name="body" style="height: 200px;" rows="10" required id="content_area"></textarea><br>
                  <span>SMS count <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
                </div>
                <div class="col-sm-12 pl-4">
              
              <div class="text-center">Write <b style="color: green;">#name</b>, System will replace with a member name. </div>
              <!-- <code style="color: green;">#username</code>,  Replace With Member Username</div> -->
              
          </div>
              </div>
              <div class="row input-group input-group-outline my-3">
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
    // Use jQuery via jQuery() instead of via jQuery()
    jQuery(document).ready(function(){
      jQuery('#source').change(function (event) {
      var source = jQuery(this).val();
      if (source === 'all' || source === '') {
        jQuery('#families,#groups,#members,#leaders,#visitors').hide();
      }else if (source === 'groups') {
        jQuery('#groups').show();
        jQuery('#families,#members,#leaders,#visitors').hide();
      }else if (source === 'families') {
        jQuery('#families').show();
        jQuery('#groups,#members,#visitors').hide();
      }else if (source === 'visitors') {
        jQuery('#visitors').show();
        jQuery('#families,#groups,#leaders,#members').hide();
      }else if (source === 'members') {
        jQuery('#members').show();
        jQuery('#families,#groups,#leaders,#visitors').hide();
      }else if (source === 'leaders') {
        jQuery('#leaders').show();
        jQuery('#families,#groups,#members,#visitors').hide();
      } else {
        jQuery('#families,#groups,#members,#leaders,#visitors').hide();
      }
  });
  jQuery('#families,#groups,#members,#leaders,#visitors').hide();
});  

</script>

@endsection
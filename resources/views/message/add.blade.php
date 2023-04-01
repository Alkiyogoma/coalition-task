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
                <label class="col-form-label text-md-right col-12 col-md-2">Set Message </label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="source" class="form-control" required id="source">
                <option value="" selected>select Here..</option>
                    <option value="groups">Specific Partners</option>
                    <option value="leaders">Specific Branches</option>
                    <option value="families">Specific Clients</option>
                    <option value="visitors">Assigned Employers</option>
                    <option value="members">Company Employee</option>
                  </select>
                </div>
              </div>
              <div class="row input-group input-group-outline my-3" style="display: none;" id="groups">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Partners</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="group_id[]" class="form-control select-multiple" style="width: 100%" multiple="">
                <option value="">Select Partners here...</option>
                    <option value="all">Send to All Partners</option>
                    <?php 
                      foreach($groups as $group){
                        echo '<option value="'.$group->id.'">'.$group->name.' ('.$group->clients->count().')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>
              
              <div class="row input-group input-group-outline my-3" style="display: none;" id="leaders">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Branches</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="leader_id[]" class="form-control select-multiple" style="width: 100%" multiple="">
                <option value="">Select Branches here...</option>
                    <option value="all">All Branches</option>
                    <?php 
                      foreach($leaders as $leader){
                        echo '<option value="'.$leader->user_id.'">'.$leader->name.' ('.$leader->clients->count().')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>

              <div class="row input-group input-group-outline my-3" style="display: none;" id="families">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Customers</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="family_id[]" class="form-control select-multiple" style="width: 100%" multiple="">
                <option value="">Select Customers here...</option>
                    <option value="all">All Clients</option>
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
                <label class="col-form-label text-md-right col-12 col-md-2">Select Employers</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="visitor_id[]" class="form-control select-multiple" style="width: 100%" multiple="">
                <option value="">Select Employers here...</option>
                    <option value="all">All Employers</option>
                    <?php 
                      foreach($visitors as $visitor){
                        echo '<option value="'.$visitor->id.'">'.$visitor->name.' ('.$visitor->clients->count().')</option>';
                      }
                      ?>
                  </select>
                </div>
              </div>
              

              <div class="row input-group input-group-outline my-3"  style="display: none;" id="members">
                <label class="col-form-label text-md-right col-12 col-md-2">Select Staff</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                <select name="member_id[]" class="form-control select-multiple" style="width: 100%" multiple="">
                <option value="">Select Staffs here...</option>
                <option value="all">All Staffs</option>
                    <?php 
                      foreach($users as $user){
                        echo '<option value="'.$user->id.'">'.$user->name.'</option>';
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="row input-group input-group-outline">
                <label class="col-form-label text-md-right col-12 col-md-2">Message Content</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                  <textarea class="form-control" id="comment" name="body" style="height: 200px;" rows="10" required></textarea><br>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-2 col-md-2"></div>
                  <div class="col-sm-6 col-md-5">
                      <button type="submit" style="float: left;" class="btn btn-success pl-4 pr-4">Send</button>
                </div>
                <div class="col-sm-2 col-md-2">
                  <span  style="float: right;">SMS count - <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
                </div>
              </div>

                <hr class="horizontal dark mt-3 mb-2" />
                <div class="text-center">Keywords <b style="color: green;">#name</b> for client name,  <b style="color: green;">#balance</b> for client outstanding balance,  <b style="color: green;">#bank</b> for client bank name. </div>

              {{-- <p>Habari <b>#name</b>  unakumbushwa kulipa deni lako la <b>#balance</b> kutoka bank ya <b>#bank</b> lipia deni lako mapema kuepuka usumbufu.</p>
              <hr class="horizontal dark mt-3 mb-2" />
              <p>Ndugu <b>#name</b>,  lipa LEO mkopo wako wa <b>#bank</b> Tshs. <b>#balance</b> ndani ya siku 30 ili kuepuka usumbufu.</p> --}}
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
  <script>
   $(document).ready(function() {
        $('.select-single').select2();
        $('.select-multiple').select2();

      $('#comment').keyup(function () {
          var words = $('#comment').text().length;
          $('#word_counts').html(words);
          $('#sms_count').html(Math.ceil(words / 160));

          if (words > 475) {
              swal("Warning!", "You have reached maximum message words limit of 480 Words ", "warning");
          }
          if (words > 160) {
              $('#word_counts').style.color = 'black';
          }
          
      });
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

    word_count = function () {
        $('#comment').keyup(function () {
            var words = $('#comment').val().length;
            $('#word_counts').html(words);
            $('#sms_count').html(Math.ceil(words / 160));
            if (words > 475) {
              toastr.options =
                {
                  "closeButton" : true,
                  "progressBar" : true
                }
                  toastr.error("You have reached maximum message words limit of 480 Words");
            }
            if (words > 160) {
                $('#word_counts').style.color = 'black';
            }
            
        });
      }
$(document).ready(word_count);

</script>

@endsection
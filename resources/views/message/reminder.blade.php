@extends('layouts.app')

@section('title')
Add New Message
@endsection

@section('content')

<section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Message Form</h4>
                  </div>
                  <div class="card-body">
                  <form id="add-form" action="" method="POST">
                  <?= csrf_field() ?>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Select Type</label>
                      <div class="col-sm-12 col-md-8">
                      <select name="source" class="form-control selectric" id="source">
                      <option value="">select Here..</option>
                      <option value="all">All</option>
                          <option value="leaders">Church Leaders</option>
                          <option value="groups">Church Groups</option>
                          <option value="members">Church Members</option>
                          <option value="families">Church Families</option>
                          <option value="visitors">Church Visitors</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row mb-4" id="groups">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Select Group</label>
                      <div class="col-sm-12 col-md-8">
                      <select name="group_id[]" class="form-control select2" style="width: 100%"multiple="">
                      <option value="">Select Group here...</option>
                          <option value="all">All</option>
                          <?php 
                            $groups = \App\Models\Group::get();
                            foreach($groups as $group){
                              echo '<option value="'.$group->id.'">'.$group->name.' ('.$group->members->count().')</option>';
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group row mb-4" id="leaders">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Select Leaders</label>
                      <div class="col-sm-12 col-md-8">
                      <select name="leader_id[]" class="form-control select2" style="width: 100%"multiple="">
                      <option value="">Select Leaders here...</option>
                          <option value="all">All</option>
                          <?php 
                            $leaders = \App\Models\Leader::get();
                            foreach($leaders as $leader){
                              echo '<option value="'.$leader->user_id.'">'.$leader->user->name.' ('.$leader->role->name.')</option>';
                            }
                            ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row mb-4" id="families">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Select Families</label>
                      <div class="col-sm-12 col-md-8">
                      <select name="family_id[]" class="form-control select2" style="width: 100%"multiple="">
                      <option value="">Select Families here...</option>
                          <option value="all">All</option>
                          <?php 
                           // $families = \App\Models\Family::get();
                            foreach($families as $family){
                              echo '<option value="'.$family->user_id.'">'.$family->name.' ('.$family->members->count().')</option>';
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                    

                    <div class="form-group row mb-4" id="visitors">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Select Visitors</label>
                      <div class="col-sm-12 col-md-8">
                      <select name="visitor_id[]" class="form-control select2" style="width: 100%"multiple="">
                      <option value="">Select Visitor here...</option>
                          <option value="all">All</option>
                          <?php 
                          $visitors = \App\Models\Client::get();
                            foreach($visitors as $visitor){
                              echo '<option value="'.$visitor->id.'">'.$visitor->name.' ('.$visitor->sex.')</option>';
                            }
                            ?>
                        </select>
                      </div>
                    </div>
                    

                    <div class="form-group row mb-4"  id="members">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Select Members</label>
                      <div class="col-sm-12 col-md-8">
                      <select name="member_id[]" class="form-control select2" style="width: 100%"required multiple="">
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
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2">Content</label>
                      <div class="col-sm-12 col-md-8">
                        <textarea class="form-control" name="body" style="height: 200px;" rows="10" required id="content_area"></textarea><br>
                        <span>SMS count <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
                      </div>
                      <div class="col-sm-12 pl-4">
                   
                    <!-- <div>Write <code style="color: green;">#name</code>, it_will <code style="color: green;">#username</code>, it_will_username</div>
                    <div id="account_tags" style="display: none">
                        <code style="color: green;">#name</code> =Parent Name, <code style="color: green;">#student_name </code>= Student Name, <code style="color: green;">#username </code>=parent username, <code style="color: green;">#balance </code>= requested amount a student needs to pay, <code style="color: green;">#invoice </code>=invoice number
                    </div> -->
                </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-2 col-lg-2"></label>
                      <div class="col-sm-12 col-md-8">
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
        <script src="<?=url('public/assets/js/jquery-3.3.1.min.js')?>"></script>
        <script src="<?=url('public/assets/js/jquery-ui.min.js')?>" ></script>
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
          jQuery('#groups,#members#visitors').hide();
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

    jQuery('#student_type').change(function (event) {
        var types = jQuery(this).val();
        if (types === '0') {
            jQuery('#load_types').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('mailandsms/loadtypes') ?>",
                data: "type=" + types,
                dataType: "html",
                success: function (data) {
                  jQuery('#category3').show();
                jQuery('#category4').hide();
                jQuery('#load_payment_status,#account_tags,#load_payment_amount').hide();
                    jQuery('#load_types').html(data);
                }
            });
        }
    });

      jQuery('#content_area').keyup(function () {
          var words = jQuery('#content_area').val().length;
          jQuery('#word_counts').html(words);
          jQuery('#sms_count').html(Math.ceil(words / 160));
      });
  });  

  </script>
  
@endsection
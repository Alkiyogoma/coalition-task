@extends('layouts.app')
@section('content')
      <div class="row">
        <div class="col-lg-12"> 
            <div class="card mt-4" id="notifications">
                    <div class="card-header">
                        <h5>Define {{ $role_->name }} Permissions</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                        <form action="<?=url('savePermits')?>" method="POST">
                        <?= csrf_field() ?> 
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-1" colspan="4">
                                            <p class="mb-0">Task Group</p>
                                        </th>
                                      
                                        <th colspan="6" class="text-center">
                                            <p class="mb-0">Permisition</p>
                                        </th>
                                       
                                    </tr>
                                </thead>
                                <tbody>   
                                    @foreach($groups as $role)
                                    <tr>
                                        <td><label for="email" class="text-uppercase">{{ $role->name }}</label></td>
                                    <?php 
                                        $perms = $role->permissions()->get();
                                        if(count($perms)){ 
                                    ?>
                                        @foreach($perms as $permission)
                                        <?php
                                            $check_permission = \App\Models\RoleHasPermission::where('role_id', $role_->id)->where('permission_id', $permission->id)->first();
                                            !empty($check_permission) ? $check = 'checked' : $check = '';
                                            ?>
                                        <td class="text-right">
                                              <div
                                                class="form-check form-switch mb-0 d-flex align-items-center justify-content-center">
                                                <input class="form-check-input" name="permission_id[]" {{ $check }} value="<?=$permission->id?>" id="switch<?=$permission->id?>" type="checkbox"
                                                    id="flexSwitchCheckDefault<?=$permission->id?>">
                                                    <label class="custom-control-label px-2" for="switch<?=$permission->id?>">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</label>

                                            </div>
                                        </td>
                                    <!-- <div class="custom-control custom-switch">
                                        <input type="checkbox" name="permission_id[]" {{ $check }} value="<?=$permission->id?>" class="custom-control-input" id="switch<?=$permission->id?>">
                                        <label class="custom-control-label" for="switch<?=$permission->id?>">{{ str_replace('-', ' ', $permission->name) }}</label>
                                    </div> -->
                                    @endforeach
                                    <?php } ?>
                                    </td>
                                    </tr>
                                    @endforeach
                                  
                                </tbody>
                            </table>
                        <input type="hidden" class="form-control" value='<?=$role_->id?>' name="role_id">
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save Changes</button>
                            <a href="/roles" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                        </div>
                        
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="status-Modal">
<div class="modal-dialog modal-lg" role="document">

      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Add New Permission</h5>
        </div>
        <form action="" method="POST">
            <?= csrf_field() ?>
      <div class="modal-body">
          <div class="form-group">
              <label>Permission Name</label>
              <input type="text" class="form-control" placeholder="Enter group name..."autocomplete="off"  name="name" autofocus required>

            </div>
          <div class="form-group">
            <label>Select Permission Group</label>
            <select class="form-control selectric" name="group_id" required>
                <?php 
                echo '<option value="">Select Here...</option>';
                foreach($groups as $position){
                    echo '<option value="'.$position->id.'">'.$position->name.'</option>';
                }
                ?>
            </select>
          </div>
        </div>
          <div class="modal-footer">
            <input type="hidden" class="form-control" value="<?=Auth::user()->church_id?>" name="church_id">
                           <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
  </div>
</div>

@endsection
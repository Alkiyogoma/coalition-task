@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <form id="add-form" action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="row input-group input-group-outline">
                        <div class="col-md-3">
                            <label class="col-form-label text-md-right">Set Bank </label>
                            <select name="partner_id" id="partner_id" class="form-control" style="width: 100%" required>
                            <option value="">select bank</option>
                            <?php 
                                foreach($partners as $leader){
                                    echo '<option value="'.$leader->id.'">'.$leader->name.' ('.$leader->clients->count().')</option>';
                                }
                            ?>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="col-form-label text-md-right">Staff</label>
                            <select name="user_id" id="user_id" class="form-control" style="width: 100%" required>
                            </select>
                        </div>
                        
                        <div class="col-md-3">
                            
                            @if($types == 'week')
                                <label class="col-form-label text-md-right">Select Week</label>
                                <input type="week" name="start" min="{{ date('Y') }}-W01" class="form-control" value="<?php echo date('Y').'-W'.date('W');?>" max="<?php echo date('Y').'-W'.date('W');?>">
                            @elseif($types == 'month')
                                <label class="col-form-label text-md-right">Select Month</label>
                                <input type="month" id="start" name="start" min="{{ date('Y') }}-01" value="{{ date('Y-m') }}" max="{{ date('Y-m') }}" class="form-control">
                            @else
                                <label class="col-form-label text-md-right">Set Date</label>
                                <input name="start" type="date" class="form-control" style="width: 100%" required>
                            @endif
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label text-md-right">Action</label> <br>
                            <input type="submit"  class="btn btn-success" value="Submit Here" />
                        </div>
                        </div>
                    </form>
              <hr>
                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Customer
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Account Number
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Action Codes
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        PTP Date
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        PTP Amount
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Remarks
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($clients))
                                @foreach ($clients as $client)
                                <tr>
                                    <td class="text-sm font-weight-normal">{{ $client->name }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->account }}</td>
                                    <td class="text-sm font-weight-normal ">
                                        <div class="input-group input-group-outline">
                                        <select name="codes" id="code{{ $client->id }}" onchange="send_comment(<?= $client->id ?>, 'code')" class="form-control">
                                            <option value="<?= $client->code ?>"><?= $client->code ?></option>
                                           @foreach($codes as $code)
                                            <option value="{{ $code->code }}"> {{ $code->code}}</option>
                                           @endforeach
                                        </select>
                                        </div>
                                    </td>
                                    <td class="text-sm font-weight-normal">
                                        <div class="input-group input-group-outline">
                                            <input type="date" name="date{{ $client->id }}" id="ptpdate{{ $client->id }}" onchange="send_comment(<?= $client->id ?>, 'ptpdate')" value="<?php echo $client->ptpdate != '' ?  date('Y-m-d', strtotime($client->ptpdate)) : ''; ?>" class="form-control">
                                        </div>
                                    </td>
                                    <td class="text-sm font-weight-normal">
                                        <div class="input-group input-group-outline">
                                            <input type="text" class="form-control" name="ptpamount{{ $client->id }}"  id="ptpamount{{ $client->id }}"  onchange="send_comment(<?= $client->id ?>, 'ptpamount')" value="{{ $client->ptpamount}}">
                                        </div>
                                    </td>
                                    <td class="text-sm font-weight-normal">
                                        <div class="input-group input-group-outline">
                                            <textarea type="text" style="height: 40px;" name="placement{{ $client->id }}" id="placement{{ $client->id }}"  onchange="send_comment(<?= $client->id ?>, 'placement') class="form-control">{{ $client->placement }}</textarea>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
          

                <div class="card justify-content-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="flex items-center justify-end border-gray-100">
                                    <button class="btn btn-success btn-rounded" type="submit">Save Changes</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="flex items-center justify-end border-gray-100">
                                @if($url != '') <a href="/{{ $url }}?start={{ $start }}" class="btn bg-gradient-info btn-rounded" type="submit">Export Report</a> @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('.js-example-basic-multiple').select2();
      
      $('#partner_id').change(function (event) {
        var class_id = $(this).val();
        if (class_id === '0') {
            $('#group_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('callGroup') ?>",
                data: "partner_id=" + class_id,
                dataType: "html",
                success: function (data) {
                    $('#group_id').html(data);
                }
            });
        }
    });

    $('#partner_id').change(function (event) {
        var class_id = $(this).val();
        if (class_id === '0') {
            $('#user_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('staffClient') ?>",
                data: "partner_id=" + class_id,
                dataType: "html",
                success: function (data) {
                    $('#user_id').html(data);
                }
            });
        }
    });

    $('#user_id').change(function (event) {
        var class_id = $(this).val();
        if (class_id === '0') {
            $('#task_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('callTasks') ?>",
                data: "user_id=" + class_id,
                dataType: "html",
                success: function (data) {
                    $('#task_id').html(data);
                }
            });
        }
    });

    $('#group_id').change(function (event) {
        var class_id = $(this).val();
        if (class_id === '0') {
            $('#client_id').val(0);
        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('groupClient') ?>",
                data: "group_id=" + class_id,
                dataType: "html",
                success: function (data) {
                    $('#client_id').html(data);
                }
            });
        }
    });
    send_comment = function(id,type) {
        var amount = $('#code'+id).val();
        var value = $("#"+type+id).val();
        if (amount == 0) {

        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('getCode') ?>",
                data: {
                    code: amount,
                    type: type,
                    type_value: value,
                    client_id: id
                },
                dataType: "html",
                success: function(data) {
                    $('#placement' + id).html(data);
                }
            });
        }
    }

    

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

});
    </script>
@endsection

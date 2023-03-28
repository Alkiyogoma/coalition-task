@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                <form id="add-form" action="" method="POST">
                    <?= csrf_field() ?>
                    <div class="row input-group input-group-outline">
                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">Set Bank </label>
                            <select name="partner_id" id="partner_id" class="form-control form-control-sm" style="width: 100%" required>
                            <option value="">select bank</option>
                            <?php 
                                foreach($partners as $leader){
                                    echo '<option value="'.$leader->id.'">'.$leader->name.' ('.$leader->clients->count().')</option>';
                                }
                            ?>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">Staff</label>
                            <select name="user_id" id="user_id" class="form-control form-control-sm" style="width: 100%" required>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <label class="col-form-label text-md-right">Select Code </label>
                            <select name="code" id="codes" class="form-control form-control-sm" style="width: 100%" required>
                            <option value="">---code---</option>
                            <?php 
                                foreach($codes as $leader){
                                    echo '<option value="'.$leader->code.'">'.$leader->code.'</option>';
                                }
                            ?>
                            </select>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">Start Date</label>
                            <input name="start_date" type="date" class="form-control form-control-sm" style="width: 100%" required>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">End Date</label>
                            <input name="end_date" type="date" class="form-control form-control-sm" style="width: 100%" required>
                        </div>
                        <div class="col-md-1 col-sm-6">
                            <label class="col-form-label text-md-right">Action</label> <br>
                            <input type="submit"  class="btn btn-success btn-sm"
                            style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"
                             value="Submit" />
                        </div>
                        </div>
                    </form>
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
                                        Principle Balance
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        PTP Amount 
                                    </th>
                                    
                                    <th colspan="3" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        PTP Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                 $total = 0;
                                ?>
                            @if (count($clients))
                                @foreach ($clients as $client)
                                <?php $total += $client->ptpamount; ?>
                                <tr>
                                    <td class="text-sm font-weight-normal">{{ $client->name }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->account }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->amount }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->ptpamount }}</td>
                                    <td class="text-sm font-weight-normal">{{ date('Y-m-d', strtotime($client->ptpdate)) }}</td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
          
    @if(count($clients) > 0)
        <div class="card justify-content-center">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="flex items-center justify-end border-gray-100">
                                <h6 class="text-dark mb-0">Total Customers - {{ count($clients) }}</h6>
                                <h6 class="text-dark mb-0">Total PTP Amount - {{ money($total) }} </h6>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="flex items-center justify-end border-gray-100">
                        @if($url != '') <a href="/{{ $url }}?start={{ $start_date }}&end={{ $end_date }}&code={{ $code }}" class="btn bg-gradient-info btn-rounded" type="submit">
                            <i class="material-icons text-lg me-2">
                                arrow_circle_down
                            </i>
                            Export <u>{{ $code }}</u> Report</a> @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>


<script>
$(document).ready(function() {
    $('.js-example-basic-single').select2();
    $('.js-example-basic-multiple').select2();
    
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



    send_comment = function(id, a, type) {
        var amount = $('#code'+id).val();
        var value = $("#"+type+id).val();
        if (amount == 0) {

        } else {
            $.ajax({
                type: 'POST',
                url: "<?= url('getTrace') ?>",
                data: {
                    code: amount,
                    trace_id: a,
                    type: type,
                    type_value: value,
                    client_id: id
                },
                dataType: "html",
                success: function(data) {
                    $('#about' + id).html(data);
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

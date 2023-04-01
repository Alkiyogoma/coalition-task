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
                            <?php $i =1;
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
                        
                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">Start Date</label>
                            <input name="start_date" type="date" class="form-control form-control-sm" style="width: 100%" required>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">End Date</label>
                            <input name="end_date" type="date" class="form-control form-control-sm" style="width: 100%" required>
                        </div>
                        <div class="col-md-2 col-sm-6">
                            <label class="col-form-label text-md-right">Action</label> <br>
                            <input type="submit"  class="btn btn-success btn-sm"           style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"            value="Submit" />
                        </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-flush" id="datatable-basic">
                            <thead class="thead-light">
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Customer
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Account Number
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Trace Status
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Phone 
                                    </th>
                                    
                                    <th colspan="3" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Comments
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @if (count($clients))
                                @foreach ($clients as $client)
                                <tr>
                                    <td class="text-sm {{ $client->status == 1 ? 'text-white bg-info' : '' }} font-weight-normal">{{ $i++ }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->name }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->account }}</td>
                                    <td class="text-sm font-weight-normal ">
                                        <div class="input-group input-group-outline">
                                        <select name="codes" id="code{{ $client->id }}" onchange="send_comment(<?= $client->id ?>,<?= $client->traces()->first()->id?>, 'code')" class="form-control form-control-sm">
                                            <option value="<?= $client->traces()->first()->task_type_id ?>"><?= $client->traces()->first()->tasktype->name ?></option>
                                           @foreach($codes as $code)
                                            <option value="{{ $code->id }}"> {{ $code->name}}</option>
                                           @endforeach
                                        </select>
                                        </div>
                                    </td>
                                    <td class="text-sm font-weight-normal">
                                        <div class="input-group input-group-outline">
                                            <input type="text" class="form-control form-control-sm" name="phone_number{{ $client->id }}"  id="phone{{ $client->id }}"  onchange="send_comment(<?= $client->id ?>, <?= $client->traces()->first()->id ?>, 'phone')" value="{{$client->traces()->first()->phone}}">
                                        </div>
                                    </td>
                                    <td colspan="3" class="text-sm font-weight-normal">
                                        <div class="input-group input-group-outline">
                                            <input type="text" name="about{{ $client->id }}" id="about{{ $client->id }}"  onchange="send_comment(<?= $client->id ?>, <?= $client->traces()->first()->id ?>, 'about')" class="form-control form-control-sm" value="{{ $client->traces()->first()->about }}" />
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
          
@if (count($clients))
    <div class="card justify-content-center">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card justify-content-center">
                        <div class="card-body">
                            <h6 class="text-dark mb-0">COLLECTTION REPORT: {{ $start_date }}  - {{ $end_date }}</h6>
                            <h6 class="text-dark mb-0">COLLECTOR NAME : {{ $report['user'] }}</h6>
                            <h6 class="text-dark mb-0">ACCOUNT COLLECTED CLIENT : {{ $report['bank'] }}</h6>
                            <h6 class="text-dark mb-0">TOTAL ACCOUT PORTFOLIO: {{ $report['total'] }}</h6>
                            <h6 class="text-dark mb-0">TOTAL ACCOUNT SCANNED: {{ $report['scanned'] }}</h6>
                            <h6 class="text-dark mb-0">TOTAL ACCOUNT PENDING: {{ $report['pending'] }}</h6>
                            <h6 class="text-dark mb-0">TOTAL ACCOUNT RECOVERD: {{ $report['recoved'] }}</h6>
                            <h6 class="text-dark mb-0">TOTAL ACCOUNT FOR SKP TRACING: {{ $report['remained'] }}</h6>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="flex items-center justify-end border-gray-100">
                        @if($url != '') <a href="/{{ $url }}?start={{ $start }}" class="btn bg-gradient-info btn-rounded" type="submit">
                            <i class="material-icons text-lg me-2">arrow_circle_down</i>
                            Export Tracing Report</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

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

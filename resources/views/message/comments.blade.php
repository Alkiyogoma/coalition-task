@extends('layouts.app')


@section('content')
    <div class="row gx-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Timeline light</h6>
                </div>

                <div class="card-body p-3">
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
                                @foreach ($clients as $client)
                                    
                                <tr>
                                    <td class="text-sm font-weight-normal">{{ split_name($client->name)['first'] }}</td>
                                    <td class="text-sm font-weight-normal">{{ $client->account }}</td>
                                    <td class="text-sm font-weight-normal">
                                        <select name="codes" id="codes" class="form-control">
                                            <option value="003">client number is not correct so as I will find this client in credt info to get more information</option>
                                            <option value="006">client is not answered my phone so as I continue to call later and text a message</option>
                                            <option value="012">He promise to pay when he gets money</option>

                                        </select>
                                    </td>
                                    <td class="text-sm font-weight-normal">
                                        <input type="date" name="dates" id="dates" class="form-control">
                                    </td>
                                    <td class="text-sm font-weight-normal"><input type="text" id="amounts" value="{{ $client->payments()->sum('amount') }}"></td>
                                    <td class="text-sm font-weight-normal"><textarea name="comments" id="comments" rows="1"></textarea></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="d-flex justify-content-center">


    </div>
@endsection

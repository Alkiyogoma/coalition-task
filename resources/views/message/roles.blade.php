@extends('layouts.app')
<?php $root = url('/') . '/public/' ?>

@section('content')
<!-- CSS Libraries -->
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-md-12 bg-white pt-2">
                <div class="section-header">
                    <h3>List of Permission Groups</h3>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active">
                            <!-- <a class="btn btn-primary" href="<?=url('attendances/create/group')?>"> Add New <i class="fas fa-plus-circle"></i></a> -->
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                            <table width="100%" class="table table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Role Name</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td>Active</td>
                                        <td class="text-right">
                                            <a href="<?=url('permissions/'.$role->id)?>" class="btn btn-outline-secondary btn-sm btn-rounded"><i class="fas fa-toggle-on"></i>Assign</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
            </div>

        </div>
    </div>
@endsection
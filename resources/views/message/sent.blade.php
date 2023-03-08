@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  <h3 class="section-title"> Lastest Sent Messages</h3>
                  <a href="{{ url('sent/resent') }}" class="btn btn-primary" style="float: right;"> Resend Failed SMS</a>

                <?php 
                   if(count($messages) > 0){
                          foreach($messages as $message){
                        ?>
                        <div class="ticket-content" style="width: 100%;">
                            <div class="ticket-header" style="border-bottom: 1px solid #ccc; padding-top: 5px;">

                                <div class="ticket-detail">

                                    <div class="ticket-info">
                                        <div class="font-weight-600"> {{ $message->user->name }} - {{ timeAgo($message->created_at) }}</div>
                                    </div>
                                    <p>{{ $message->body }}</p>
                                </div>
                            </div>
                            <?php } ?>
                            <div class="d-flex justify-content-center">
                                {!! $messages->links('pagination::bootstrap-4') !!}
                                
                            </div>
                            <?php }else{ ?>
                            <div class="text-center p-3 text-muted">
                                <h5>No Message Found!!</h5>
                                <p>Looks like you don't have any message yet.</p>
                            </div>
                            <?php  } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
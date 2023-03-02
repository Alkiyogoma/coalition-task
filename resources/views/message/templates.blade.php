@extends('layouts.app')


@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-12 col-12">
                <div class="dropdown">
                    <span class="mb-0 px-2">Company text messages  Templates</span>
                    <a href="/addtemplate" style="float: right; margin-right: 4em;" class="mr-4 text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">
                        <span class="btn btn-primary btn-sm bg-gradient-secondary"><i class="material-icons text-lg me-2">add</i> Add Template</span>
                    </a>
                </div>
                </div>
            </div>
            </div>
        </div>
            @foreach ($messages as $message)
            <div class="card bg-gradient-defaul mb-1">
                <div class="card-body">
                  <h5 class="font-weight-normal text-info text-gradient">{{ $message->name }}</h5>
                  <blockquote class="blockquote text-white mb-0">
                    <p class="text-dark ms-3"> <?= $message->body ?></p>
                    <footer class="blockquote-footer text-gradient text-info text-sm ms-3">{{ $message->user_id}} <cite title="Source Title">Delete</cite></footer>
                  </blockquote>
                </div>
              </div>
              @endforeach
          </div>
        </div>
      </div>
    </div>
    
  </div>

</div>
@endsection
@extends('layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4>
                Define  New  message Templates
              </h4>
              <hr class="horizontal dark mt-3 mb-2" />

            <form id="add-form" action="" method="POST">
            <?= csrf_field() ?>
              <div class="row input-group input-group-outline my-3">
                <label class="col-form-label text-md-right col-12 col-md-2">Set Title </label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                    <input name="name" type="text" class="form-control" required id="source" />
                    <input name="user_id" type="hidden" value="{{ Auth::User()->id }}" class="form-control" required id="source" />
                </div>
              </div>

              <div class="row input-group input-group-outline my-3">
                <label class="col-form-label text-md-right col-12 col-md-2">Message</label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
                  <textarea class="form-control" id="comment" name="body" style="height: 200px;" rows="10" required></textarea><br>
                  <span>SMS count - <b id="word_counts">0</b>/<b id="sms_count">1</b></span>
                </div>
              </div>
              <div class="row input-group input-group-outline my-3">
                <label class="col-form-label text-md-right col-12 col-md-2"></label>
                <div class="col-sm-12 col-md-8" data-select2-id="12">
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
@endsection
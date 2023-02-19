<template>
    <div class="container px-6 mx-auto grid">
<div class="row">
  <div class="col-md-4">
    <button type="button" class="btn btn-block bg-gradient-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-default">Default</button>
    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title font-weight-normal" id="modal-title-default">Type your modal title</h6>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
            <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
            <button type="button" class="btn btn-link  ml-auto" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <button type="button" class="btn btn-block bg-gradient-warning mb-3" data-bs-toggle="modal" data-bs-target="#modal-notification">Notification</button>
    <div class="modal fade" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
      <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title font-weight-normal" id="modal-title-notification">Your attention is required</h6>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="py-3 text-center">
              <i class="material-icons h1 text-secondary">
                notifications_active
              </i>
              <h4 class="text-gradient text-danger mt-4">You should read this!</h4>
              <p>A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-white">Ok, Got it</button>
            <button type="button" class="btn btn-link text-white ml-auto" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <button type="button" class="btn btn-block btn-light mb-3" data-bs-toggle="modal" data-bs-target="#modal-form">Form</button>
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-body p-0">
            <div class="card card-plain">
              <div class="card-header pb-0 text-left">
                <h5 class="">Welcome back</h5>
                <p class="mb-0">Enter your email and password to sign in</p>
              </div>
              <div class="card-body">
                <form role="form text-left">
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
                  </div>
                  <div class="form-check form-switch d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                    <label class="form-check-label mb-0 ms-3" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Sign in</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-lg-2 px-1">
                <p class="mb-4 text-sm mx-auto">
                  Don't have an account?
                  <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign up</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-4">
    <!-- Button trigger modal -->
    <button type="button" class="btn bg-gradient-danger btn-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalLong">
      Long Modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title font-weight-normal" id="exampleModalLongTitle">Modal title</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body font-weight-light">
            I always felt like I could do anything. That’s the main thing people are controlled by! Thoughts- their perception of themselves! They're slowed down by their perception of themselves. If you're taught you can’t do anything, you won’t do anything. I was taught I could do everything.
            <br/><br/>
            As we live, our hearts turn colder. Cause pain is what we go through as we become older. We get insulted by others, lose trust for those others. We get back stabbed by friends. It becomes harder for us to give others a hand. We get our heart broken by people we love, even that we give them all we have. Then we lose family over time. What else could rust the heart more over time? Blackgold.
            <br/><br/>


            We’re not always in the position that we want to be at. We’re constantly growing. We’re constantly making mistakes. We’re constantly trying to express ourselves and actualize our dreams. If you have the opportunity to play this game of life you need to appreciate every moment. A lot of people don’t appreciate the moment until it’s passed.
            <br/><br/>


            There’s nothing I really wanted to do in life that I wasn’t able to get good at. That’s my skill. I’m not really specifically talented at anything except for the ability to learn. That’s what I do. That’s what I’m here for. Don’t be afraid to be wrong because you can’t learn anything from a compliment.
            <br/><br/>

            It really matters and then like it really doesn’t matter. What matters is the people who are sparked by it. And the people who are like offended by it, it doesn’t matter. Because it's about motivating the doers. Because I’m here to follow my dreams and inspire other people to follow their dreams, too.
            <br/><br/>

            The time is now for it to be okay to be great. People in this world shun people for being great. For being a bright color. For standing out. But the time is now to be okay to be the greatest you. Would you believe in what you believe in, if you were the only one who believed it?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn bg-gradient-primary">Save changes</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <!-- Button trigger modal -->
    <button type="button" class="btn bg-gradient-success btn-block mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
      Message Modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h6 class="modal-title font-weight-normal" id="exampleModalLabel">New message to Creative Tim</h6>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="input-group input-group-outline my-3">
                  <label class="form-label">Recipient</label>
                  <input type="email" class="form-control">
              </div>
              <div class="input-group input-group-dynamic">
                  <textarea class="multisteps-form__textarea form-control" rows="5" placeholder="Say a few words." spellcheck="false"></textarea>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn bg-gradient-primary">Send message</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <!-- Button trigger modal -->
    <button type="button" class="btn bg-gradient-info btn-block" data-bs-toggle="modal" data-bs-target="#exampleModalSignUp">
      SignUp Modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalSignUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-body p-0">
            <div class="card card-plain">
              <div class="card-header pb-0 text-left">
                  <h5 class="">Join Us</h5>
                  <p class="mb-0">Enter your email and password to register</p>
              </div>
              <div class="card-body pb-3">
                <form role="form text-left">
                  <div class="input-group input-group-outline my-3">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control">
                  </div>
                  <div class="input-group input-group-outline my-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control">
                  </div>
                  <div class="input-group input-group-outline my-3">
                      <label class="form-label">Password</label>
                      <input type="password" class="form-control">
                  </div>
                  <div class="form-check form-check-info text-left">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                    <label class="form-check-label" for="flexCheckDefault">
                      I agree the <a href="javascrpt:;" class="text-dark font-weight-bolder">Terms and Conditions</a>
                    </label>
                  </div>
                  <div class="text-center">
                    <button type="button" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Sign up</button>
                  </div>
                </form>
              </div>
              <div class="card-footer text-center pt-0 px-sm-4 px-1">
                <p class="mb-4 mx-auto">
                  Already have an account?
                  <a href="javascrpt:;" class="text-primary text-gradient font-weight-bold">Sign in</a>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</template>
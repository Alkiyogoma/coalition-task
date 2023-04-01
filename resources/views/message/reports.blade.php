@extends('layouts.app')

@section('content')
<?php $root = url('/') . '/public/' ?>

        <div class="row">
            <div class="col-12 col-sm-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $setting->church_name }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-info active" data-tab-group="summary-tab" id="summary-text">
                                <h2>{{ $setting->sms_enabled }}</h2>
                                <div class="text-muted">Remained messages</div>
                       
                                <div class="d-block mt-2">

                                    <a href="#" class="btn btn-success"  data-toggle="modal"  role="button" data-target="#status-Modals"> Buy New SMS  <i class="fas fa-comments"> </i></a>

                                </div>
                            </div>
                            <div class="summary-item">
                                <h6 class="mt-3">Message</h6>
                                <ul class="list-unstyled list-unstyled-border">
                                    <li class="media">
                                        <a href="#">
                                            <img alt="image" class="mr-3 rounded" width="50"                               src="<?=$root?>assets/img/products/product-4-50.png">
                                        </a>
                                        <div class="media-body">
                                        <div class="media-right"><?=$this_day?></div>
                                            <div class="media-title"><a href="#">Message Sent Today </a></div>
                                            <div class="text-small text-muted"> <a href="#">Number of SMS </a>
                                                <div class="bullet"></div> <?=$this_day?>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a href="#">
                                            <img alt="image" class="mr-3 rounded" width="50"                           src="<?=$root?>assets/img/products/product-2-50.png">
                                        </a>
                                        <div class="media-body">
                                        <div class="media-right"><?=$this_week?></div>
                                            <div class="media-title"><a href="#">Message Sent This Week</a></div>
                                            <div class="text-small text-muted"> <a href="#">Number of SMS </a>
                                                <div class="bullet"></div> <?=$this_week?>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <a href="#">
                                            <img alt="image" class="mr-3 rounded" width="50"                               src="<?=$root?>assets/img/products/product-2-50.png">
                                        </a>
                                        <div class="media-body">
                                            <div class="media-right"><?=$this_month?></div>
                                            <div class="media-title"><a href="#">Message Sent This Month</a></div>
                                            <div class="text-small text-muted"> <a href="#">Number of SMS </a>
                                                <div class="bullet"></div> <?=$this_month?>
                                            </div>
                                        </div>
                                    </li>
                              
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-6 mt-lg-0 mt-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <h4> Message Statistics</h4>
                        </div>
                        <div class="card-body pb-0">
                        <div class="clearfix"></div>
                            <div id="container" style="max-width: 1000px; height: 515px; margin: 0 auto"></div>
                        <div class="clearfix"></div>
                  </div>
                </div>
                                  
            </div>
        </div>
    </div>
    </div>


<div class="modal fade" id="status-Modals">
<div class="modal-dialog modal-lg" role="document">
<form id="add-form" action="<?=url('buySMS') ?>" method="POST">
<?= csrf_field() ?>
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">You need to have SMS credit to Send SMS.</h5>
        </div>
      <div class="modal-body">
          <div class="form-group row">
                    <div class="col-sm-12 col-md-12">
                        <label class="col-form-label text-md-right"><i class="fas fa-calendar"></i> Number of SMS You Want to Buy</label>
                        <input type="number" id="number_sms" autocomplete="off" placeholder="0"  name="message" class="form-control" required>
                    </div>
                    
                    <div class="col-sm-12 col-md-12">
                      <label class="col-form-label text-md-right"><i class="fas fa-tags"></i> Total Amount to Pay</label>
                      <h3 id="sms_amount"><h3>
                    </div>
                </div>
                <div class="form-group">
                <label class="col-form-label text-md-right">Payment Method</label>
                    <select name="method" class="form-control selectric" id="source">
                      <option value="M-Pesa">M-Pesa</option>
                        <option value="TigoPesa">TigoPesa</option>
                        <option value="Airtel">Airtel Money</option>
                        <option value="HaloPesa">HaloPesa</option>
                    </select>
                </div>
          <div class="form-group">
            <label>Comment on this order</label>
                <textarea name="comment" class="form-control" style="height: 100px;" required></textarea>
                <input type="hidden" class="form-control" value="<?=Auth::user()->phone?>" name="phone">
          </div>
          <div class="col-sm-12 pl-4">
          <div class="text-left">Unit Price: <b style="color: green;">20Tsh/SMS</b>.
              <span style="float: right; color: green; font-weight: bold;">One SMS = 160 characters</b>. </span>
        </div>
        </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
  </div>
</div>
</div>
</div>

    <script type="text/javascript">
        jQuery.noConflict();
        jQuery(document).ready(function () {

            var chart = new Highcharts.Chart({
                chart: {
                    type: 'column',
                    renderTo: 'container'
                },
                title: {
                    text: "Message Sent Statistics"
                },
                subtitle: {
                    text: 'Number of SMS Sent per Date Evaluation.'
                },
                xAxis: {
                    type: 'category'
                },
                yAxis: {
                    title: {
                        text: 'Number of SMS'
                    }

                },
                legend: {
                    enabled: false
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y:.1f}'
                        }
                    }
                },

                tooltip: {
                    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b><br/>'
                },

                series: [{
                    name: 'Sent Per Date',
                    colorByPoint: true,
                    data: [ <?php
                        $i = 0;
                        foreach($datas as $data) {
                          
                           ?> {
                                name: '<?php echo ' <b> '.ucfirst($data->date).' </b>'; ?>',
                                y: <?= $data->ynumber == NULL ? '0' : $data->ynumber ?> ,
                                drilldown: '<?= $data->date ?>'
                            }, <?php
                            $i++;
                        } ?>
                    ]
                }]
            });

              
        jQuery('#number_sms').keyup(function () {
          var source = jQuery(this).val();
          var nn = source * 20;
          jQuery('#sms_amount').html(nn);
      });


        });

    </script>
</section>
@endsection
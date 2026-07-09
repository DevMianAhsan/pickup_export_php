<!doctype html>
<html lang="en">
  <?php include_once 'includes/head.php';  ?>
  <body class="vertical  dark  ">
    <div class="wrapper">
      <?php include_once 'includes/header.php'; ?>
      <?php include_once 'includes/sidebar.php'; ?>
      <style>
        .vertical .main-content, .vertical.hover .main-content, .narrow.open .main-content{
          margin-left: 7rem !important;
        }
      </style>
      <main role="main" class="main-content">
        <div class="col-12">
          <div class="row align-items-center mb-2">
            <div class="col">
              <h2 class="h5 page-title">Welcome!</h2>
            </div>
            <div class="col-auto">
              <form class="form-inline">
                <div class="form-group d-none d-lg-inline">
                  <label for="reportrange" class="sr-only">Date Ranges</label>
                  <div id="reportrange" class="px-2 py-2 text-muted">
                    <span class="small">March 29, 2023 - April 27, 2023</span>
                  </div>
                </div>
                <div class="form-group">
                  <button type="button" class="btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></button>
                  <button type="button" class="btn btn-sm mr-2"><span class="fe fe-filter fe-16 text-muted"></span></button>
                </div>
              </form>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow bg-primary text-white border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-white">
                        <i class="fe fe-16 fe-shopping-bag text-default mb-0"></i>
                      </span>
                    </div>
                    <div class="col pr-0">
                      <p class="small text-white mb-0">Today Sales</p>
                      <span class="h3 mb-0 text-white">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col pr-0">
                      <p class="small text-muted mb-0">Total Orders</p>
                      <span class="h3 mb-0">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-dollar-sign text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col">
                      <p class="small text-muted mb-0">Total Sales</p>
                      <div class="row align-items-center no-gutters">
                        <div class="col-12">
                          <span class="h3 mr-2 mb-0">
                            0
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-activity text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col">
                      <p class="small text-muted mb-0">Total Orders</p>
                      <span class="h3 mb-0">
                        0
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow bg-primary text-white border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-white">
                        <i class="fe fe-16 fe-shopping-bag text-default mb-0"></i>
                      </span>
                    </div>
                    <div class="col pr-0">
                      <p class="small text-white mb-0">Today Purchase</p>
                      <span class="h3 mb-0 text-white">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col pr-0">
                      <p class="small text-muted mb-0">Total Purchases</p>
                      <span class="h3 mb-0">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-dollar-sign text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col">
                      <p class="small text-muted mb-0">Total Purchase</p>
                      <div class="row align-items-center ">
                        <div class="col-12">
                          <span class="h3 mr-2 mb-0">
                            0
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-activity text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col">
                      <p class="small text-muted mb-0">Total Purchase</p>
                      <span class="h3 mb-0">
                        0
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow bg-primary text-white border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-white">
                        <i class="fe fe-16 fe-shopping-bag text-default mb-0"></i>
                      </span>
                    </div>
                    <div class="col pr-0">
                      <p class="small text-white mb-0">Today Cash Received</p>
                      <span class="h3 mb-0 text-white">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-shopping-cart text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col pr-0">
                      <p class="small text-muted mb-0">Today Cash Received Order</p>
                      <span class="h3 mb-0">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-dollar-sign text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col">
                      <p class="small text-muted mb-0">Total Pending Amount</p>
                      <div class="row align-items-center no-gutters">
                        <div class="col-12">
                          <span class="h3 mr-2 mb-0">
                          0 </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
              <div class="card shadow border-0">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-3 text-center">
                      <span class="circle circle-sm bg-primary">
                        <i class="fe fe-16 fe-activity text-white mb-0"></i>
                      </span>
                    </div>
                    <div class="col">
                      <p class="small text-muted mb-0">Pending Order's Amount</p>
                      <span class="h3 mb-0">
                      0 </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <strong>Accounts</strong>
                </div>
                <div class="card-body px-4">
                  <div class="row border-bottom">
                    <div class="col-4 text-center mb-3">
                      <p class="mb-1 small text-muted">Revenue</p>
                      <span class="h3">
                        0
                      </span><br>
                      <span class="small text-muted">+20%</span>
                      <span class="fe fe-arrow-up text-success fe-12"></span>
                    </div>
                    <div class="col-4 text-center mb-3">
                      <p class="mb-1 small text-muted">Income</p>
                      <span class="h3">
                      0 </span><br>
                      <span class="small text-muted">+20%</span>
                      <span class="fe fe-arrow-up text-success fe-12"></span>
                    </div>
                    <div class="col-4 text-center mb-3">
                      <p class="mb-1 small text-muted">Expense</p>
                      <span class="h3">0</span><br>
                      <span class="small text-muted">-2%</span>
                      <span class="fe fe-arrow-down text-danger fe-12"></span>
                    </div>
                  </div>
                  <table class="table table-bordered mt-3 mb-1 mx-n1 table-sm">
                    <thead>
                      <tr>
                        <th class="">Type</th>
                        <th class="text-right">Cash in Hand (no.)</th>
                        <th class="text-right">Cash in Hand (pkr)</th>
                        <th class="text-right">Credit (no.)</th>
                        <th class="text-right">Credit (pkr)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Orders</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                      </tr>
                      <tr>
                        <td>Purchases</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                        <td class="text-center">0</td>
                      </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Cash in hand Account</th>
                      <td style="font-size: 22px;text-align: right;" align="right" colspan="4">
                      36,699 </td>
                    </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card shadow mb-4">
                <div class="card-header">
                  <strong class="card-title">Balance</strong>
                  <a class="float-right small text-muted" href="customerpendingreport.php">View all</a>
                </div>
                <div class="card-body">
                  <div class="list-group list-group-flush my-n3">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-6">
              <div class="card shadow">
                <div class="card-header">
                  <strong class="card-title">Cash Sale's Pending Orders</strong>
                  <a class="float-right small text-muted" href="pending_bills.php?search_it=all">View all</a>
                </div>
                <div class="card-body my-n2">
                  <table class="table table-striped table-hover table-borderless">
                    <thead>
                      <tr>
                        <th>Order No.</th>
                        <th>Customer Details</th>
                        <th>Order Date</th>
                        <th>Piad Amount</th>
                        <th>Remaining Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>21</td>
                        <td>sami ()</td>
                        <td>2023-02-27</td>
                        <td><span class="badge badge-success">130</span> </td>
                        <td><span class="badge badge-danger">22</span> </td>
                      </tr>
                      <tr>
                        <td>7</td>
                        <td>sami (03457573667)</td>
                        <td>2022-03-07</td>
                        <td><span class="badge badge-success">50000</span> </td>
                        <td><span class="badge badge-danger">451000</span> </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card shadow">
                <div class="card-header">
                  <strong class="card-title">Today Payments</strong>
                  <a class="float-right small text-muted" href="reports3.php?type=customer">View all</a>
                </div>
                <div class="card-body my-n2">
                  <table class="table table-striped table-hover table-borderless">
                    <thead>
                      <tr><th>Customer Name</th>
                      <th>Order Date</th>
                      <th>Payment Date</th>
                      <th>Amount</th>
                      <th>Remaining Days</th>
                    </tr></thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="card shadow eq-card mb-4">
                <div class="card-body">
                  <div class="card-title">
                    <strong>Sale</strong>
                    <a class="float-right small text-muted" href="analytics.php">View all</a>
                  </div>
                  <div class="row mt-b">
                    <div class="col-6 text-center mb-3 border-right">
                      <p class="text-muted mb-1">Today</p>
                      <h6 class="mb-1">
                      0 </h6>
                      <p class="text-muted mb-2"></p>
                    </div>
                    <div class="col-6 text-center mb-3">
                      <p class="text-muted mb-1">Yesterday</p>
                      <h6 class="mb-1">0</h6>
                      <p class="text-muted"></p>
                    </div>
                    <div class="col-6 text-center border-right">
                      <p class="text-muted mb-1">This Week</p>
                      <h6 class="mb-1">0</h6>
                      <p class="text-muted mb-2"></p>
                    </div>
                    <div class="col-6 text-center">
                      <p class="text-muted mb-1">Last Week</p>
                      <h6 class="mb-1">0</h6>
                      <p class="text-muted"></p>
                    </div>
                  </div>
                  <div class="chart-widget" style="position: relative;">
                    <div id="columnChartWidget" width="300" height="200" style="min-height: 165px;"><div id="apexcharts245kaho9" class="apexcharts-canvas apexcharts245kaho9 apexcharts-theme-light" style="width: 435px; height: 150px;"><svg id="SvgjsSvg1084" width="435" height="150" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" class="apexcharts-svg" xmlns:data="ApexChartsNS" transform="translate(0, 0)" style="background: transparent;"><g id="SvgjsG1086" class="apexcharts-inner apexcharts-graphical" transform="translate(11.333333333333336, 30)"><defs id="SvgjsDefs1085"><linearGradient id="SvgjsLinearGradient1090" x1="0" y1="0" x2="0" y2="1"><stop id="SvgjsStop1091" stop-opacity="0.4" stop-color="rgba(216,227,240,0.4)" offset="0"></stop><stop id="SvgjsStop1092" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop><stop id="SvgjsStop1093" stop-opacity="0.5" stop-color="rgba(190,209,230,0.5)" offset="1"></stop></linearGradient><clipPath id="gridRectMask245kaho9"><rect id="SvgjsRect1109" width="443.99999999999994" height="105" x="-14.333333333333336" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath><clipPath id="gridRectMarkerMask245kaho9"><rect id="SvgjsRect1110" width="419.3333333333333" height="109" x="-2" y="-2" rx="0" ry="0" opacity="1" stroke-width="0" stroke="none" stroke-dasharray="0" fill="#fff"></rect></clipPath></defs><rect id="SvgjsRect1094" width="6.9222222222222225" height="105" x="131.07777591281467" y="0" rx="0" ry="0" opacity="1" stroke-width="0" stroke-dasharray="3" fill="url(#SvgjsLinearGradient1090)" class="apexcharts-xcrosshairs" y2="105" filter="none" fill-opacity="0.9" x1="131.07777591281467" x2="131.07777591281467"></rect><g id="SvgjsG1143" class="apexcharts-xaxis" transform="translate(0, 0)"><g id="SvgjsG1144" class="apexcharts-xaxis-texts-g" transform="translate(0, -4)"></g></g><g id="SvgjsG1147" class="apexcharts-grid"><g id="SvgjsG1148" class="apexcharts-gridlines-horizontal" style="display: none;"><line id="SvgjsLine1150" x1="-12.333333333333336" y1="0" x2="427.66666666666663" y2="0" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1151" x1="-12.333333333333336" y1="26.25" x2="427.66666666666663" y2="26.25" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1152" x1="-12.333333333333336" y1="52.5" x2="427.66666666666663" y2="52.5" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1153" x1="-12.333333333333336" y1="78.75" x2="427.66666666666663" y2="78.75" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line><line id="SvgjsLine1154" x1="-12.333333333333336" y1="105" x2="427.66666666666663" y2="105" stroke="#e0e0e0" stroke-dasharray="0" class="apexcharts-gridline"></line></g><g id="SvgjsG1149" class="apexcharts-gridlines-vertical" style="display: none;"></g><line id="SvgjsLine1156" x1="0" y1="105" x2="415.3333333333333" y2="105" stroke="transparent" stroke-dasharray="0"></line><line id="SvgjsLine1155" x1="0" y1="1" x2="0" y2="105" stroke="transparent" stroke-dasharray="0"></line></g><g id="SvgjsG1112" class="apexcharts-bar-series apexcharts-plot-series"><g id="SvgjsG1113" class="apexcharts-series" rel="1" seriesName="Orders" data:realIndex="0"><path id="SvgjsPath1115" d="M -6.9222222222222225 105L -6.9222222222222225 64.73055555555555Q -3.4611111111111112 61.269444444444446 0 64.73055555555555L 0 64.73055555555555L 0 105L 0 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M -6.9222222222222225 105L -6.9222222222222225 64.73055555555555Q -3.4611111111111112 61.269444444444446 0 64.73055555555555L 0 64.73055555555555L 0 105L 0 105z" pathFrom="M -6.9222222222222225 105L -6.9222222222222225 105L 0 105L 0 105L 0 105L -6.9222222222222225 105" cy="63" cx="0" j="0" val="32" barHeight="42" barWidth="6.9222222222222225"></path><path id="SvgjsPath1116" d="M 27.68888888888889 105L 27.68888888888889 20.105555555555554Q 31.150000000000002 16.644444444444442 34.611111111111114 20.105555555555554L 34.611111111111114 20.105555555555554L 34.611111111111114 105L 34.611111111111114 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 27.68888888888889 105L 27.68888888888889 20.105555555555554Q 31.150000000000002 16.644444444444442 34.611111111111114 20.105555555555554L 34.611111111111114 20.105555555555554L 34.611111111111114 105L 34.611111111111114 105z" pathFrom="M 27.68888888888889 105L 27.68888888888889 105L 34.611111111111114 105L 34.611111111111114 105L 34.611111111111114 105L 27.68888888888889 105" cy="18.375" cx="34.611111111111114" j="1" val="66" barHeight="86.625" barWidth="6.9222222222222225"></path><path id="SvgjsPath1117" d="M 62.300000000000004 105L 62.300000000000004 48.980555555555554Q 65.76111111111112 45.519444444444446 69.22222222222223 48.980555555555554L 69.22222222222223 48.980555555555554L 69.22222222222223 105L 69.22222222222223 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 62.300000000000004 105L 62.300000000000004 48.980555555555554Q 65.76111111111112 45.519444444444446 69.22222222222223 48.980555555555554L 69.22222222222223 48.980555555555554L 69.22222222222223 105L 69.22222222222223 105z" pathFrom="M 62.300000000000004 105L 62.300000000000004 105L 69.22222222222223 105L 69.22222222222223 105L 69.22222222222223 105L 62.300000000000004 105" cy="47.25" cx="69.22222222222223" j="2" val="44" barHeight="57.75" barWidth="6.9222222222222225"></path><path id="SvgjsPath1118" d="M 96.91111111111111 105L 96.91111111111111 34.543055555555554Q 100.37222222222222 31.081944444444442 103.83333333333333 34.543055555555554L 103.83333333333333 34.543055555555554L 103.83333333333333 105L 103.83333333333333 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 96.91111111111111 105L 96.91111111111111 34.543055555555554Q 100.37222222222222 31.081944444444442 103.83333333333333 34.543055555555554L 103.83333333333333 34.543055555555554L 103.83333333333333 105L 103.83333333333333 105z" pathFrom="M 96.91111111111111 105L 96.91111111111111 105L 103.83333333333333 105L 103.83333333333333 105L 103.83333333333333 105L 96.91111111111111 105" cy="32.8125" cx="103.83333333333333" j="3" val="55" barHeight="72.1875" barWidth="6.9222222222222225"></path><path id="SvgjsPath1119" d="M 131.52222222222224 105L 131.52222222222224 52.918055555555554Q 134.98333333333335 49.456944444444446 138.44444444444446 52.918055555555554L 138.44444444444446 52.918055555555554L 138.44444444444446 105L 138.44444444444446 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 131.52222222222224 105L 131.52222222222224 52.918055555555554Q 134.98333333333335 49.456944444444446 138.44444444444446 52.918055555555554L 138.44444444444446 52.918055555555554L 138.44444444444446 105L 138.44444444444446 105z" pathFrom="M 131.52222222222224 105L 131.52222222222224 105L 138.44444444444446 105L 138.44444444444446 105L 138.44444444444446 105L 131.52222222222224 105" cy="51.1875" cx="138.44444444444446" j="4" val="41" barHeight="53.8125" barWidth="6.9222222222222225"></path><path id="SvgjsPath1120" d="M 166.13333333333333 105L 166.13333333333333 75.23055555555555Q 169.59444444444443 71.76944444444445 173.05555555555554 75.23055555555555L 173.05555555555554 75.23055555555555L 173.05555555555554 105L 173.05555555555554 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 166.13333333333333 105L 166.13333333333333 75.23055555555555Q 169.59444444444443 71.76944444444445 173.05555555555554 75.23055555555555L 173.05555555555554 75.23055555555555L 173.05555555555554 105L 173.05555555555554 105z" pathFrom="M 166.13333333333333 105L 166.13333333333333 105L 173.05555555555554 105L 173.05555555555554 105L 173.05555555555554 105L 166.13333333333333 105" cy="73.5" cx="173.05555555555554" j="5" val="24" barHeight="31.5" barWidth="6.9222222222222225"></path><path id="SvgjsPath1121" d="M 200.74444444444444 105L 200.74444444444444 18.793055555555554Q 204.20555555555555 15.331944444444442 207.66666666666666 18.793055555555554L 207.66666666666666 18.793055555555554L 207.66666666666666 105L 207.66666666666666 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 200.74444444444444 105L 200.74444444444444 18.793055555555554Q 204.20555555555555 15.331944444444442 207.66666666666666 18.793055555555554L 207.66666666666666 18.793055555555554L 207.66666666666666 105L 207.66666666666666 105z" pathFrom="M 200.74444444444444 105L 200.74444444444444 105L 207.66666666666666 105L 207.66666666666666 105L 207.66666666666666 105L 200.74444444444444 105" cy="17.0625" cx="207.66666666666666" j="6" val="67" barHeight="87.9375" barWidth="6.9222222222222225"></path><path id="SvgjsPath1122" d="M 235.35555555555555 105L 235.35555555555555 77.85555555555555Q 238.81666666666666 74.39444444444445 242.27777777777777 77.85555555555555L 242.27777777777777 77.85555555555555L 242.27777777777777 105L 242.27777777777777 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 235.35555555555555 105L 235.35555555555555 77.85555555555555Q 238.81666666666666 74.39444444444445 242.27777777777777 77.85555555555555L 242.27777777777777 77.85555555555555L 242.27777777777777 105L 242.27777777777777 105z" pathFrom="M 235.35555555555555 105L 235.35555555555555 105L 242.27777777777777 105L 242.27777777777777 105L 242.27777777777777 105L 235.35555555555555 105" cy="76.125" cx="242.27777777777777" j="7" val="22" barHeight="28.875" barWidth="6.9222222222222225"></path><path id="SvgjsPath1123" d="M 269.9666666666667 105L 269.9666666666667 50.293055555555554Q 273.4277777777778 46.831944444444446 276.8888888888889 50.293055555555554L 276.8888888888889 50.293055555555554L 276.8888888888889 105L 276.8888888888889 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 269.9666666666667 105L 269.9666666666667 50.293055555555554Q 273.4277777777778 46.831944444444446 276.8888888888889 50.293055555555554L 276.8888888888889 50.293055555555554L 276.8888888888889 105L 276.8888888888889 105z" pathFrom="M 269.9666666666667 105L 269.9666666666667 105L 276.8888888888889 105L 276.8888888888889 105L 276.8888888888889 105L 269.9666666666667 105" cy="48.5625" cx="276.8888888888889" j="8" val="43" barHeight="56.4375" barWidth="6.9222222222222225"></path><path id="SvgjsPath1124" d="M 304.5777777777778 105L 304.5777777777778 64.73055555555555Q 308.0388888888889 61.269444444444446 311.5 64.73055555555555L 311.5 64.73055555555555L 311.5 105L 311.5 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 304.5777777777778 105L 304.5777777777778 64.73055555555555Q 308.0388888888889 61.269444444444446 311.5 64.73055555555555L 311.5 64.73055555555555L 311.5 105L 311.5 105z" pathFrom="M 304.5777777777778 105L 304.5777777777778 105L 311.5 105L 311.5 105L 311.5 105L 304.5777777777778 105" cy="63" cx="311.5" j="9" val="32" barHeight="42" barWidth="6.9222222222222225"></path><path id="SvgjsPath1125" d="M 339.18888888888887 105L 339.18888888888887 20.105555555555554Q 342.65 16.644444444444442 346.1111111111111 20.105555555555554L 346.1111111111111 20.105555555555554L 346.1111111111111 105L 346.1111111111111 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 339.18888888888887 105L 339.18888888888887 20.105555555555554Q 342.65 16.644444444444442 346.1111111111111 20.105555555555554L 346.1111111111111 20.105555555555554L 346.1111111111111 105L 346.1111111111111 105z" pathFrom="M 339.18888888888887 105L 339.18888888888887 105L 346.1111111111111 105L 346.1111111111111 105L 346.1111111111111 105L 339.18888888888887 105" cy="18.375" cx="346.1111111111111" j="10" val="66" barHeight="86.625" barWidth="6.9222222222222225"></path><path id="SvgjsPath1126" d="M 373.8 105L 373.8 48.980555555555554Q 377.2611111111111 45.519444444444446 380.72222222222223 48.980555555555554L 380.72222222222223 48.980555555555554L 380.72222222222223 105L 380.72222222222223 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 373.8 105L 373.8 48.980555555555554Q 377.2611111111111 45.519444444444446 380.72222222222223 48.980555555555554L 380.72222222222223 48.980555555555554L 380.72222222222223 105L 380.72222222222223 105z" pathFrom="M 373.8 105L 373.8 105L 380.72222222222223 105L 380.72222222222223 105L 380.72222222222223 105L 373.8 105" cy="47.25" cx="380.72222222222223" j="11" val="44" barHeight="57.75" barWidth="6.9222222222222225"></path><path id="SvgjsPath1127" d="M 408.4111111111111 105L 408.4111111111111 34.543055555555554Q 411.8722222222222 31.081944444444442 415.3333333333333 34.543055555555554L 415.3333333333333 34.543055555555554L 415.3333333333333 105L 415.3333333333333 105z" fill="rgba(27,104,255,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="0" clip-path="url(#gridRectMask245kaho9)" pathTo="M 408.4111111111111 105L 408.4111111111111 34.543055555555554Q 411.8722222222222 31.081944444444442 415.3333333333333 34.543055555555554L 415.3333333333333 34.543055555555554L 415.3333333333333 105L 415.3333333333333 105z" pathFrom="M 408.4111111111111 105L 408.4111111111111 105L 415.3333333333333 105L 415.3333333333333 105L 415.3333333333333 105L 408.4111111111111 105" cy="32.8125" cx="415.3333333333333" j="12" val="55" barHeight="72.1875" barWidth="6.9222222222222225"></path></g><g id="SvgjsG1128" class="apexcharts-series" rel="2" seriesName="Visitors" data:realIndex="1"><path id="SvgjsPath1130" d="M 0 105L 0 97.54305555555555Q 3.4611111111111112 94.08194444444445 6.9222222222222225 97.54305555555555L 6.9222222222222225 97.54305555555555L 6.9222222222222225 105L 6.9222222222222225 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 0 105L 0 97.54305555555555Q 3.4611111111111112 94.08194444444445 6.9222222222222225 97.54305555555555L 6.9222222222222225 97.54305555555555L 6.9222222222222225 105L 6.9222222222222225 105z" pathFrom="M 0 105L 0 105L 6.9222222222222225 105L 6.9222222222222225 105L 6.9222222222222225 105L 0 105" cy="95.8125" cx="6.9222222222222225" j="0" val="7" barHeight="9.1875" barWidth="6.9222222222222225"></path><path id="SvgjsPath1131" d="M 34.611111111111114 105L 34.611111111111114 67.35555555555555Q 38.07222222222222 63.894444444444446 41.53333333333334 67.35555555555555L 41.53333333333334 67.35555555555555L 41.53333333333334 105L 41.53333333333334 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 34.611111111111114 105L 34.611111111111114 67.35555555555555Q 38.07222222222222 63.894444444444446 41.53333333333334 67.35555555555555L 41.53333333333334 67.35555555555555L 41.53333333333334 105L 41.53333333333334 105z" pathFrom="M 34.611111111111114 105L 34.611111111111114 105L 41.53333333333334 105L 41.53333333333334 105L 41.53333333333334 105L 34.611111111111114 105" cy="65.625" cx="41.53333333333333" j="1" val="30" barHeight="39.375" barWidth="6.9222222222222225"></path><path id="SvgjsPath1132" d="M 69.22222222222223 105L 69.22222222222223 89.66805555555555Q 72.68333333333334 86.20694444444445 76.14444444444445 89.66805555555555L 76.14444444444445 89.66805555555555L 76.14444444444445 105L 76.14444444444445 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 69.22222222222223 105L 69.22222222222223 89.66805555555555Q 72.68333333333334 86.20694444444445 76.14444444444445 89.66805555555555L 76.14444444444445 89.66805555555555L 76.14444444444445 105L 76.14444444444445 105z" pathFrom="M 69.22222222222223 105L 69.22222222222223 105L 76.14444444444445 105L 76.14444444444445 105L 76.14444444444445 105L 69.22222222222223 105" cy="87.9375" cx="76.14444444444445" j="2" val="13" barHeight="17.0625" barWidth="6.9222222222222225"></path><path id="SvgjsPath1133" d="M 103.83333333333333 105L 103.83333333333333 76.54305555555555Q 107.29444444444444 73.08194444444445 110.75555555555555 76.54305555555555L 110.75555555555555 76.54305555555555L 110.75555555555555 105L 110.75555555555555 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 103.83333333333333 105L 103.83333333333333 76.54305555555555Q 107.29444444444444 73.08194444444445 110.75555555555555 76.54305555555555L 110.75555555555555 76.54305555555555L 110.75555555555555 105L 110.75555555555555 105z" pathFrom="M 103.83333333333333 105L 103.83333333333333 105L 110.75555555555555 105L 110.75555555555555 105L 110.75555555555555 105L 103.83333333333333 105" cy="74.8125" cx="110.75555555555556" j="3" val="23" barHeight="30.1875" barWidth="6.9222222222222225"></path><path id="SvgjsPath1134" d="M 138.44444444444446 105L 138.44444444444446 80.48055555555555Q 141.90555555555557 77.01944444444445 145.36666666666667 80.48055555555555L 145.36666666666667 80.48055555555555L 145.36666666666667 105L 145.36666666666667 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 138.44444444444446 105L 138.44444444444446 80.48055555555555Q 141.90555555555557 77.01944444444445 145.36666666666667 80.48055555555555L 145.36666666666667 80.48055555555555L 145.36666666666667 105L 145.36666666666667 105z" pathFrom="M 138.44444444444446 105L 138.44444444444446 105L 145.36666666666667 105L 145.36666666666667 105L 145.36666666666667 105L 138.44444444444446 105" cy="78.75" cx="145.36666666666667" j="4" val="20" barHeight="26.25" barWidth="6.9222222222222225"></path><path id="SvgjsPath1135" d="M 173.05555555555554 105L 173.05555555555554 90.98055555555555Q 176.51666666666665 87.51944444444445 179.97777777777776 90.98055555555555L 179.97777777777776 90.98055555555555L 179.97777777777776 105L 179.97777777777776 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 173.05555555555554 105L 173.05555555555554 90.98055555555555Q 176.51666666666665 87.51944444444445 179.97777777777776 90.98055555555555L 179.97777777777776 90.98055555555555L 179.97777777777776 105L 179.97777777777776 105z" pathFrom="M 173.05555555555554 105L 173.05555555555554 105L 179.97777777777776 105L 179.97777777777776 105L 179.97777777777776 105L 173.05555555555554 105" cy="89.25" cx="179.97777777777776" j="5" val="12" barHeight="15.75" barWidth="6.9222222222222225"></path><path id="SvgjsPath1136" d="M 207.66666666666666 105L 207.66666666666666 96.23055555555555Q 211.12777777777777 92.76944444444445 214.58888888888887 96.23055555555555L 214.58888888888887 96.23055555555555L 214.58888888888887 105L 214.58888888888887 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 207.66666666666666 105L 207.66666666666666 96.23055555555555Q 211.12777777777777 92.76944444444445 214.58888888888887 96.23055555555555L 214.58888888888887 96.23055555555555L 214.58888888888887 105L 214.58888888888887 105z" pathFrom="M 207.66666666666666 105L 207.66666666666666 105L 214.58888888888887 105L 214.58888888888887 105L 214.58888888888887 105L 207.66666666666666 105" cy="94.5" cx="214.58888888888887" j="6" val="8" barHeight="10.5" barWidth="6.9222222222222225"></path><path id="SvgjsPath1137" d="M 242.27777777777777 105L 242.27777777777777 89.66805555555555Q 245.73888888888888 86.20694444444445 249.2 89.66805555555555L 249.2 89.66805555555555L 249.2 105L 249.2 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 242.27777777777777 105L 242.27777777777777 89.66805555555555Q 245.73888888888888 86.20694444444445 249.2 89.66805555555555L 249.2 89.66805555555555L 249.2 105L 249.2 105z" pathFrom="M 242.27777777777777 105L 242.27777777777777 105L 249.2 105L 249.2 105L 249.2 105L 242.27777777777777 105" cy="87.9375" cx="249.2" j="7" val="13" barHeight="17.0625" barWidth="6.9222222222222225"></path><path id="SvgjsPath1138" d="M 276.8888888888889 105L 276.8888888888889 71.29305555555555Q 280.35 67.83194444444445 283.81111111111113 71.29305555555555L 283.81111111111113 71.29305555555555L 283.81111111111113 105L 283.81111111111113 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 276.8888888888889 105L 276.8888888888889 71.29305555555555Q 280.35 67.83194444444445 283.81111111111113 71.29305555555555L 283.81111111111113 71.29305555555555L 283.81111111111113 105L 283.81111111111113 105z" pathFrom="M 276.8888888888889 105L 276.8888888888889 105L 283.81111111111113 105L 283.81111111111113 105L 283.81111111111113 105L 276.8888888888889 105" cy="69.5625" cx="283.81111111111113" j="8" val="27" barHeight="35.4375" barWidth="6.9222222222222225"></path><path id="SvgjsPath1139" d="M 311.5 105L 311.5 97.54305555555555Q 314.9611111111111 94.08194444444445 318.4222222222222 97.54305555555555L 318.4222222222222 97.54305555555555L 318.4222222222222 105L 318.4222222222222 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 311.5 105L 311.5 97.54305555555555Q 314.9611111111111 94.08194444444445 318.4222222222222 97.54305555555555L 318.4222222222222 97.54305555555555L 318.4222222222222 105L 318.4222222222222 105z" pathFrom="M 311.5 105L 311.5 105L 318.4222222222222 105L 318.4222222222222 105L 318.4222222222222 105L 311.5 105" cy="95.8125" cx="318.4222222222222" j="9" val="7" barHeight="9.1875" barWidth="6.9222222222222225"></path><path id="SvgjsPath1140" d="M 346.1111111111111 105L 346.1111111111111 67.35555555555555Q 349.5722222222222 63.894444444444446 353.0333333333333 67.35555555555555L 353.0333333333333 67.35555555555555L 353.0333333333333 105L 353.0333333333333 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 346.1111111111111 105L 346.1111111111111 67.35555555555555Q 349.5722222222222 63.894444444444446 353.0333333333333 67.35555555555555L 353.0333333333333 67.35555555555555L 353.0333333333333 105L 353.0333333333333 105z" pathFrom="M 346.1111111111111 105L 346.1111111111111 105L 353.0333333333333 105L 353.0333333333333 105L 353.0333333333333 105L 346.1111111111111 105" cy="65.625" cx="353.0333333333333" j="10" val="30" barHeight="39.375" barWidth="6.9222222222222225"></path><path id="SvgjsPath1141" d="M 380.72222222222223 105L 380.72222222222223 89.66805555555555Q 384.18333333333334 86.20694444444445 387.64444444444445 89.66805555555555L 387.64444444444445 89.66805555555555L 387.64444444444445 105L 387.64444444444445 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 380.72222222222223 105L 380.72222222222223 89.66805555555555Q 384.18333333333334 86.20694444444445 387.64444444444445 89.66805555555555L 387.64444444444445 89.66805555555555L 387.64444444444445 105L 387.64444444444445 105z" pathFrom="M 380.72222222222223 105L 380.72222222222223 105L 387.64444444444445 105L 387.64444444444445 105L 387.64444444444445 105L 380.72222222222223 105" cy="87.9375" cx="387.64444444444445" j="11" val="13" barHeight="17.0625" barWidth="6.9222222222222225"></path><path id="SvgjsPath1142" d="M 415.3333333333333 105L 415.3333333333333 76.54305555555555Q 418.7944444444444 73.08194444444445 422.25555555555553 76.54305555555555L 422.25555555555553 76.54305555555555L 422.25555555555553 105L 422.25555555555553 105z" fill="rgba(58,210,159,1)" fill-opacity="1" stroke-opacity="1" stroke-linecap="square" stroke-width="0" stroke-dasharray="0" class="apexcharts-bar-area" index="1" clip-path="url(#gridRectMask245kaho9)" pathTo="M 415.3333333333333 105L 415.3333333333333 76.54305555555555Q 418.7944444444444 73.08194444444445 422.25555555555553 76.54305555555555L 422.25555555555553 76.54305555555555L 422.25555555555553 105L 422.25555555555553 105z" pathFrom="M 415.3333333333333 105L 415.3333333333333 105L 422.25555555555553 105L 422.25555555555553 105L 422.25555555555553 105L 415.3333333333333 105" cy="74.8125" cx="422.25555555555553" j="12" val="23" barHeight="30.1875" barWidth="6.9222222222222225"></path><g id="SvgjsG1129" class="apexcharts-datalabels" data:realIndex="1"></g></g><g id="SvgjsG1114" class="apexcharts-datalabels" data:realIndex="0"></g></g><line id="SvgjsLine1157" x1="-12.333333333333336" y1="0" x2="427.66666666666663" y2="0" stroke="#b6b6b6" stroke-dasharray="0" stroke-width="1" class="apexcharts-ycrosshairs"></line><line id="SvgjsLine1158" x1="-12.333333333333336" y1="0" x2="427.66666666666663" y2="0" stroke-dasharray="0" stroke-width="0" class="apexcharts-ycrosshairs-hidden"></line><g id="SvgjsG1159" class="apexcharts-yaxis-annotations"></g><g id="SvgjsG1160" class="apexcharts-xaxis-annotations"></g><g id="SvgjsG1161" class="apexcharts-point-annotations"></g></g><g id="SvgjsG1145" class="apexcharts-yaxis" rel="0" transform="translate(-8, 0)"><g id="SvgjsG1146" class="apexcharts-yaxis-texts-g"></g></g><g id="SvgjsG1087" class="apexcharts-annotations"></g></svg><div class="apexcharts-legend"></div><div class="apexcharts-tooltip apexcharts-theme-light" style="left: 145.872px; top: 65px;"><div class="apexcharts-tooltip-title" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;">05 Jan</div><div class="apexcharts-tooltip-series-group apexcharts-active" style="display: flex;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(0, 143, 251);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Orders: </span><span class="apexcharts-tooltip-text-value">41</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div><div class="apexcharts-tooltip-series-group" style="display: none;"><span class="apexcharts-tooltip-marker" style="background-color: rgb(0, 143, 251);"></span><div class="apexcharts-tooltip-text" style="font-family: Helvetica, Arial, sans-serif; font-size: 12px;"><div class="apexcharts-tooltip-y-group"><span class="apexcharts-tooltip-text-label">Orders: </span><span class="apexcharts-tooltip-text-value">41</span></div><div class="apexcharts-tooltip-z-group"><span class="apexcharts-tooltip-text-z-label"></span><span class="apexcharts-tooltip-text-z-value"></span></div></div></div></div><div class="apexcharts-yaxistooltip apexcharts-yaxistooltip-0 apexcharts-yaxistooltip-left apexcharts-theme-light"><div class="apexcharts-yaxistooltip-text"></div></div></div></div>
                    <div class="resize-triggers"><div class="expand-trigger"><div style="width: 436px; height: 166px;"></div></div><div class="contract-trigger"></div></div></div>
                  </div>
                </div>
              </div>
              <div class="col-md-8">
                <div class="card shadow eq-card mb-4">
                  <div class="card-body">
                    <div class="card-title">
                      <strong>Credit Sales</strong>
                      <a class="float-right small text-muted" href="credit_orders.php">View all</a>
                    </div>
                    <div class="row mt-b">
                      <table class="table">
                        <thead>
                          <tr><th>Customer Name</th>
                          <th>Order Date</th>
                          <th>Payment Date</th>
                          <th>Amount</th>
                          <th>Remaining Days</th>
                        </tr></thead>
                        <tbody>
                          <tr>
                            <td>Test Customer (123)</td>
                            <td>2022-08-06</td>
                            <td>2022-08-21</td>
                            <td>47000</td>
                            <td>
                              <span class="badge badge-danger">-249</span>
                            </td>
                          </tr>
                          <tr>
                            <td>Test (1234567)</td>
                            <td>2022-08-06</td>
                            <td>2022-08-21</td>
                            <td>940</td>
                            <td>
                              <span class="badge badge-danger">-249</span>
                            </td>
                          </tr>
                          <tr>
                            <td>Test Customer (123)</td>
                            <td>2022-07-30</td>
                            <td>2022-08-14</td>
                            <td>2</td>
                            <td>
                              <span class="badge badge-danger">-256</span>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="chart-widget">
                      <div id="columnChartWidget" width="300" height="200"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </main> <!-- main -->
          </div> <!-- .wrapper -->
          <?php include_once 'includes/footer.php'; ?>
        </body>
      </html>
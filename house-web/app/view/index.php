<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<title>最近一个月青岛全市住宅成交量走势-青岛市一手房成交量走势-青岛市二手房成交量走势-最近一年青岛市各区每月成交量走势-最近一年青岛市全市每月成交量走势-青岛市各区住宅成交量走势-青岛房产-青岛住宅成交量统计</title>   
<meta name="Keywords" content="青岛全市住宅成交量走势,青岛市各区住宅成交量走势,青岛房产,青岛住宅成交量统计,岛市一手房成交量走势，青岛市二手房成交量走势,最近一年青岛市全市每月成交量走势,最近一年青岛市各区每月成交量走势" />
<meta name="Description" content="青岛全市住宅成交量走势,青岛市各区住宅成交量走势,青岛房产,青岛住宅成交量统计,最近一个月青岛全市住宅成交量走势,岛市一手房成交量走势,青岛市二手房成交量走势,最近一年青岛市全市每月成交量走势,最近一年青岛市各区每月成交量走势" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
<!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/2.3.2/css/bootstrap.min.css" crossorigin="anonymous">
<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://apps.bdimg.com/libs/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="images/Chart.min.js"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="span12">
			<div class="carousel slide" id="carousel-793226">
				<ol class="carousel-indicators">
					<li class="active" data-slide-to="0" data-target="#carousel-793226"></li>
					<li data-slide-to="1" data-target="#carousel-793226"></li>
					<li data-slide-to="2" data-target="#carousel-793226"></li>
				</ol>
				<div class="carousel-inner">
					<div class="item active">
						<img alt="" src="images/qingdao/qingdao1.jpg" />
						<!--<div class="carousel-caption">
							<p>棒球运动是一种以棒打球为主要特点，集体性、对抗性很强的球类运动项目，在美国、日本尤为盛行。</p>
						</div>-->
					</div>
					<div class="item">
						<img alt="" src="images/qingdao/qingdao2.jpg" />
						<!--<div class="carousel-caption">
							<p>冲浪是以海浪为动力</p>
						</div>-->
					</div>
					<div class="item">
						<img alt="" src="images/qingdao/qingdao3.jpg" />
						<!--<div class="carousel-caption">
							<p>以自行车为工具比赛骑行速度的体育运动。1896年第一届奥林匹克运动会上被列为正式比赛项目。环法赛为最著名的世界自行车锦标赛。</p>
						</div>-->
					</div>
				</div> 
                <a data-slide="prev" href="#carousel-793226" class="left carousel-control">‹</a>
                <a data-slide="next" href="#carousel-793226" class="right carousel-control">›</a>
			</div>
            <ul class="breadcrumb">
                <li>
                    <a href="http://house.04007.cn">最近一个月青岛全市住宅成交量走势</a> <span class="active">/</span>
                </li>
                <li>
                    <a href="http://www.04007.cn" target="_self">04007.cn主站</a>
                </li>
            </ul>
            <h3>最近一个月青岛全市住宅成交量走势 <small>最近一个月青岛全市住宅成交量走势</small></h3>
			<div class="row">
                <div style="width:100%;height:385px;">
                    <canvas id="myChart" style="width:100%;height:385px;"></canvas>
                </div>
			</div>
            <h3>最近一个月青岛市各区住宅成交量走势 <small>最近一个月青岛市各区住宅成交量走势</small></h3>
			<div class="row">
                <div style="width:100%;height:385px;border:">
                    <canvas id="myChart2" style="width:100%;height:385px;"></canvas>
                </div>
			</div>
            
            <h3>最近一年青岛市全市每月成交量走势 <small>最近一年青岛市全市每月成交量走势</small></h3>
            <div class="row">
                <div style="width:100%;height:385px;border:">
                    <canvas id="myChart3" style="width:100%;height:385px;"></canvas>
                </div>
            </div>

            <h3>最近一年青岛市各区每月成交量走势 <small>最近一年青岛市各区每月成交量走势</small></h3>
            <div class="row">
                <div style="width:100%;height:385px;border:">
                    <canvas id="myChart4" style="width:100%;height:385px;"></canvas>
                </div>
            </div>

            <div class="row">
			    <p class="text-center" style="font-size:12px;margin-top:15px;">
			    	数据来自青岛市房地产交易中心，<strong>By:Kermit:2017</strong> <a href="http://www.04007.cn">www.04007.cn</a><br>
                    中国.山东.青岛
			    </p>
            </div>
            <script type="text/javascript">
            $(function($) {
                    $.ajax({
                        type:"get",    //请求方式
                        async:true,    //是否异步
                        url:"http://house.04007.cn/index/month",
                        dataType:"jsonp",    //跨域json请求一定是jsonp
                        jsonp: "callbackparam",    //跨域请求的参数名，默认是callback
                            //jsonpCallback:"successCallback",    //自定义跨域参数值，回调函数名也是一样，默认为jQuery自动生成的字符串
                        data:{"query":"civilnews"},    //请求参数
                        beforeSend: function() {
                            //请求前的处理
                        },

                        success: function(json) {
                            var ctx = document.getElementById("myChart").getContext("2d");
                            var ctx2 = document.getElementById("myChart2").getContext("2d");
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                     labels :json.date,
                                     datasets : [
                                         {
                                             label: '二手房成交量',
                                             backgroundColor: "rgba(75,192,192,0.4)",
                                             borderColor: "rgba(75,192,192,1)",
                                             pointBorderColor: "rgba(75,192,192,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             pointHoverBorderColor: "rgba(220,220,220,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             //pointHoverBorderColor: "rgba(220,220,220,1)",
                                             //pointHoverBorderWidth: 2,
                                             //pointRadius: 1,
                                             //pointHitRadius: 10,
                                             data : json.two[15],
                                         },
                                         {
                                             label: '一手房成交量',
                                             backgroundColor: "rgba(102,242,190,0.4)",
                                             borderColor: "#094",
                                             pointBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             pointHoverBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             data : json.one[15],
                                         }      
                                     ]
                                },
                            }); 

                            var myCharts = new Chart(ctx2, {
                                type: 'line',
                                data: {
                                     labels :json.date,
                                     datasets : [
                                         {
                                             label: json.area[1],
                                             backgroundColor: "rgba(102,242,190,0.4)",
                                             borderColor: "#094",
                                             pointBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             pointHoverBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             data : json.one[1],
                                         },
                                         {
                                             label: json.area[2],
                                             backgroundColor: "rgba(75,192,192,0.4)",
                                             borderColor: "rgba(75,192,192,1)",
                                             pointBorderColor: "rgba(75,192,192,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             pointHoverBorderColor: "rgba(220,220,220,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             data : json.one[2],
                                         },
                                         {
                                             label: json.area[3],
                                             backgroundColor: "rgba(33,219,151,0.4)",
                                             borderColor: "#9fc5e8",
                                             pointBorderColor:  "#9fc5e8",
                                             pointHoverBackgroundColor:"#9fc5e8",
                                             pointHoverBorderColor: "#9fc5e8",
                                             pointHoverBackgroundColor: "#9fc5e8",
                                             data : json.one[3],
                                         },
                                         {
                                             label: json.area[4],
                                             backgroundColor: "rgba(238,91,91,0.4)",
                                             borderColor: "#ee5b5b",
                                             pointBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             pointHoverBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             data : json.one[4],
                                         },
                                         {
                                             label: json.area[5],
                                             backgroundColor: "rgba(18,91,91,0.4)",
                                             borderColor: "#ee5b5b",
                                             pointBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             pointHoverBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             data : json.one[5],
                                         },
                                         //{
                                         //    label: json.area[6],
                                         //    backgroundColor: "rgba(8,251,91,0.4)",
                                         //    borderColor: randomColorGenerator(),
                                         //    pointBorderColor:randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    pointHoverBorderColor: randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    data : json.one[6],
                                         //},
                                         {
                                             label: json.area[8],
                                             backgroundColor: "rgba(148,91,115,0.3)",
                                             borderColor: "#5aab5b",
                                             pointBorderColor: "#5aab5b",
                                             pointHoverBackgroundColor: "#5aab5b",
                                             pointHoverBorderColor: "#5aab5b",
                                             pointHoverBackgroundColor: "#5aab5b",
                                             data : json.one[8],
                                         },
                                         //{
                                         //    label: json.area[9],
                                         //    backgroundColor: "rgba(118,91,181,0.4)",
                                         //    borderColor: randomColorGenerator(),
                                         //    pointBorderColor:randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    pointHoverBorderColor: randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    data : json.one[9],
                                         //}
                                     ]
                                }
                            }); 
                        },
                        complete: function() {
                            //请求完成的处理
                        },
                        error: function() {
                            //请求出错处理
                        }
                    });


                    //按月统计 
                    $.ajax({
                        type:"get",    //请求方式
                        async:true,    //是否异步
                        url:"http://house.04007.cn/index/statmonth",
                        dataType:"jsonp",    //跨域json请求一定是jsonp
                        jsonp: "callbackparam",    //跨域请求的参数名，默认是callback
                            //jsonpCallback:"successCallback",    //自定义跨域参数值，回调函数名也是一样，默认为jQuery自动生成的字符串
                        data:{"query":"civilnews"},    //请求参数
                        beforeSend: function() {
                            //请求前的处理
                        },

                        success: function(json) {
                            var ctx = document.getElementById("myChart3").getContext("2d");
                            var ctx2 = document.getElementById("myChart4").getContext("2d");
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                     labels :json.date,
                                     datasets : [
                                         {
                                             label: '二手房成交量',
                                             backgroundColor: "rgba(75,192,192,0.4)",
                                             borderColor: "rgba(75,192,192,1)",
                                             pointBorderColor: "rgba(75,192,192,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             pointHoverBorderColor: "rgba(220,220,220,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             //pointHoverBorderColor: "rgba(220,220,220,1)",
                                             //pointHoverBorderWidth: 2,
                                             //pointRadius: 1,
                                             //pointHitRadius: 10,
                                             data : json.two[15],
                                         },
                                         {
                                             label: '一手房成交量',
                                             backgroundColor: "rgba(102,242,190,0.4)",
                                             borderColor: "#094",
                                             pointBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             pointHoverBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             data : json.one[15],
                                         }      
                                     ]
                                },
                            }); 

                            var myCharts = new Chart(ctx2, {
                                type: 'line',
                                data: {
                                     labels :json.date,
                                     datasets : [
                                         {
                                             label: json.area[1],
                                             backgroundColor: "rgba(102,242,190,0.4)",
                                             borderColor: "#094",
                                             pointBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             pointHoverBorderColor: "#094",
                                             pointHoverBackgroundColor: "#094",
                                             data : json.one[1],
                                         },
                                         {
                                             label: json.area[2],
                                             backgroundColor: "rgba(75,192,192,0.4)",
                                             borderColor: "rgba(75,192,192,1)",
                                             pointBorderColor: "rgba(75,192,192,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             pointHoverBorderColor: "rgba(220,220,220,1)",
                                             pointHoverBackgroundColor: "rgba(75,192,192,1)",
                                             data : json.one[2],
                                         },
                                         {
                                             label: json.area[3],
                                             backgroundColor: "rgba(33,219,151,0.4)",
                                             borderColor: "#9fc5e8",
                                             pointBorderColor:  "#9fc5e8",
                                             pointHoverBackgroundColor:"#9fc5e8",
                                             pointHoverBorderColor: "#9fc5e8",
                                             pointHoverBackgroundColor: "#9fc5e8",
                                             data : json.one[3],
                                         },
                                         {
                                             label: json.area[4],
                                             backgroundColor: "rgba(238,91,91,0.4)",
                                             borderColor: "#ee5b5b",
                                             pointBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             pointHoverBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             data : json.one[4],
                                         },
                                         {
                                             label: json.area[5],
                                             backgroundColor: "rgba(18,91,91,0.4)",
                                             borderColor: "#ee5b5b",
                                             pointBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             pointHoverBorderColor: "#ee5b5b",
                                             pointHoverBackgroundColor: "#ee5b5b",
                                             data : json.one[5],
                                         },
                                         //{
                                         //    label: json.area[6],
                                         //    backgroundColor: "rgba(8,251,91,0.4)",
                                         //    borderColor: randomColorGenerator(),
                                         //    pointBorderColor:randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    pointHoverBorderColor: randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    data : json.one[6],
                                         //},
                                         {
                                             label: json.area[8],
                                             backgroundColor: "rgba(148,91,115,0.3)",
                                             borderColor: "#5aab5b",
                                             pointBorderColor: "#5aab5b",
                                             pointHoverBackgroundColor: "#5aab5b",
                                             pointHoverBorderColor: "#5aab5b",
                                             pointHoverBackgroundColor: "#5aab5b",
                                             data : json.one[8],
                                         },
                                         //{
                                         //    label: json.area[9],
                                         //    backgroundColor: "rgba(118,91,181,0.4)",
                                         //    borderColor: randomColorGenerator(),
                                         //    pointBorderColor:randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    pointHoverBorderColor: randomColorGenerator(),
                                         //    pointHoverBackgroundColor: randomColorGenerator(),
                                         //    data : json.one[9],
                                         //}
                                     ]
                                }
                            }); 
                        },
                        complete: function() {
                            //请求完成的处理
                        },
                        error: function() {
                            //请求出错处理
                        }
                    });

                });
                </script>
		</div>
	</div>
</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?b2c9b53f71353fc5c964c14faff097d5";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
</body>
</html>

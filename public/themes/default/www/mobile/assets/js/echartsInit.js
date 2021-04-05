// 折线图
function drawLineCharts(id,xData,name,value){
    var lineCharts = echarts.init(document.getElementById(id));
    var options = {
        grid: {
            top: '5%',
            left: '0%',
            right: '0%',
            bottom: '0%',
            containLabel: true
        },
        tooltip: {},
        xAxis: {
            data: xData,
            axisLine: {
                show: false
            },
            axisLabel: {
                show: true
            },
            axisTick: {
                show: false
            },
        },
        yAxis: {
            splitNumber: 3,
            axisLine: {
                show: false
            },
            axisLabel: {
                show: true
            },
            axisTick: {
                show: false
            },
        },
        series: [{
            name: name,
            type: 'line',
            itemStyle:{
                normal:{
                    color:'#39bc54',
                    lineStyle:{
                        color:'#39bc54'
                    }
                }
            },
            data: value
        }]
    };
    lineCharts.setOption(options);

    setTimeout(function (){
        window.onresize = function () {
            lineCharts.resize();
        }
    },200);
}


var dom = document.getElementById("echarts_line");
var myChart = echarts.init(dom);
var app = {};
option = null;



option = {

    // Make gradient line here
    visualMap: [{
        show: false,
        type: 'continuous',
        seriesIndex: 0,
        min: 0,
        max: 400
    }],


    title: [{
        left: 'center',
        text: ''
    }],
    tooltip: {
        trigger: 'axis'
    },
    xAxis: [{
        data: dateList
    }],
    yAxis: [{
        splitLine: {show: false}
    }],
    
    series: [{
        name:"Percent",
        type: 'line',
        showSymbol: false,
        data: valueList
    }]
};;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}


var dom = document.getElementById("echarts_line1");
var myChart = echarts.init(dom);
var app = {};
option = null;



option = {

    // Make gradient line here
    visualMap: [{
        show: false,
        type: 'continuous',
        seriesIndex: 0,
        min: 0,
        max: 400
    }],


    title: [{
        left: 'center',
        text: ''
    }],
    tooltip: {
        trigger: 'axis'
    },
    xAxis: [{
        data: dateList1
    }],
    yAxis: [{
        splitLine: {show: false}
    }],
    
    series: [{
        name:"Percent",
        type: 'line',
        showSymbol: false,
        data: valueList1
    }]
};;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}

// JavaScript Document
jQuery(function ($) {
	
	"use strict";
		
	  $(document).ready(function () {
            showGraph();
			showTopUsers() ;
        });


        function showGraph()
        {
            {
                $.post("topfiveitems.php",
                function (data)
                {
                     var item_name = [];
                    var salesAmt = [];

                    for (var i in data) {
                        item_name.push(data[i].item_name);
                        salesAmt.push(data[i].salesAmt);
                    }

                    var chartdata = {
                        labels: item_name,
                        datasets: [
                            {
                                label: 'Amount($)',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: salesAmt
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
		
		
		
		function showTopUsers()
        {
            {
                $.post("topfiveusers.php",
                function (data)
                {
                     var uName = [];
                    var purchaseAmt = [];

                    for (var i in data) {
                        uName.push(data[i].uName);
                        purchaseAmt.push(data[i].purchaseAmt);
                    }

                    var chartdata = {
                        labels: uName,
                        datasets: [
                            {
                                label: 'Purchased Amt($) ',
                                backgroundColor: '#1603fa',
                                borderColor: '#1603fa',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: purchaseAmt
                            }
                        ]
                    };

                    var graphTarget = $("#userCanvas");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
});
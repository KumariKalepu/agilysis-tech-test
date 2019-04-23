var ctx = document.getElementById("myChart");
    
	var Data    = new Array();
	    urlData = document.getElementById("myChart").getAttribute("data");		
	    urlData = urlData.slice(1);	 
	    urlData = urlData.slice(0,urlData.length - 1);
	       Data = urlData.split(',');
	  
	  var labelArray = new Array();
	  for (index = 0; index < Data.length; index++) 
	  { 
              labelArray[index]= index;
      }	  	
	 
	  var myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: labelArray,
          datasets: [{
            data: Data,
            lineTension: 0,
            backgroundColor: 'transparent',
            borderColor: '#007bff',
            borderWidth: 4,
            pointBackgroundColor: '#007bff'
          }]
        },
        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: false
              }
            }]
          },
          legend: {
            display: false,
          }
        }
      });
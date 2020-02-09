
<div class="chalign">
       <canvas id="myChart" width="100" height="400"></canvas>
       <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
       <script>
       var ctx = document.getElementById('myChart').getContext('2d');
       var myChart = new Chart(ctx, {
           type: 'bar',
           data: {
               labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto','Septiembre','Octubre', 'Noviembre', 'Diciembre'],
               datasets: [{
                   label: '',
                   data: [


                    <?php
                    	
                    	if (empty($year)) {
                    		$year=2019;
                    	}else{

                    		$year = $_REQUEST["year"];
                    	}

       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-01-01' AND fecha_hora < '".$year."-02-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,
      


                  



                    <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-02-01' AND fecha_hora < '".$year."-03-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					 

					?>,



					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-03-01' AND fecha_hora < '".$year."-04-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-04-01' AND fecha_hora < '".$year."-05-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-05-01' AND fecha_hora < '".$year."-06-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-06-01' AND fecha_hora < '".$year."-07-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,


					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-07-01' AND fecha_hora < '".$year."-08-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,


					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-08-01' AND fecha_hora < '".$year."-09-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-09-01' AND fecha_hora < '".$year."-10-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					  <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-10-01' AND fecha_hora < '".$year."-11-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					 <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-11-01' AND fecha_hora < '".$year."-12-01'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>,

					 <?php


       					$query = "select sum(total_factura)from factura where fecha_hora >= '".$year."-12-01' AND fecha_hora <= '".$year."-12-31'";

        				$ejecutar = mysqli_query($con, $query);

                   
						while ($a = mysqli_fetch_array($ejecutar)) {
					

						echo $a['sum(total_factura)'];
					




						}
 					

					?>

					,],
                   backgroundColor: [
                       'rgba(255, 99, 132, 0.2)',
                       'rgba(54, 162, 235, 0.2)',
                       'rgba(255, 206, 86, 0.2)',
                       'rgba(75, 192, 192, 0.2)',
                       'rgba(153, 102, 255, 0.2)',
                       'rgba(255, 159, 64, 0.2)'
                   ],
                   borderColor: [
                       'rgba(255, 99, 132, 1)',
                       'rgba(54, 162, 235, 1)',
                       'rgba(255, 206, 86, 1)',
                       'rgba(75, 192, 192, 1)',
                       'rgba(153, 102, 255, 1)',
                       'rgba(255, 159, 64, 1)'
                   ],
                   borderWidth: 1
               }]
           },
          options: {
          	responsive: true,
            maintainAspectRatio: false,
            showScale: false,
          	scales: {
        	yAxes: [{
          ticks: {
            beginAtZero: false
          }
        }]
      },
   legend: {
        display: false
      },

       animation: {
            duration: 3000
        },

        hover: {
            animationDuration: 1000 // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 3000 // animation duration after a resize
    
    
    }
    });
</script>
</div>
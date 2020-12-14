<script type="text/javascript">
    console.log('hi');

    google.charts.load('current', {
        'packages': ['bar']
    });

    google.charts.setOnLoadCallback(loadChart);

    function loadChart() {

        let project = JSON.stringify(<?php echo json_encode($projects) ?>);



        project = JSON.parse(project);
        //    console.log(assignTask);
        drawChart(project);
    }
    // console.log(assignTask);
    function drawChart(project) {
        let jsonData = project;
        console.log(jsonData);
        var data = new google.visualization.DataTable();
  
        data.addColumn('string', 'Projects');
        data.addColumn('number', 'Assign Hrs');
        data.addColumn('number', 'Booked Hrs');
        data.addColumn('string', 'id');
        $.each(jsonData, function(i, jsonData) {

            let id=jsonData.project_Id;
            let name = jsonData.name;
            let assignHrs = parseInt(jsonData.totalHrs);
            let booked = parseInt((jsonData.allocatedHours));
            data.addRow(
                [
                name,
                assignHrs,
                booked,
                id
                ]);
        });

        var options = {
            chart: {
                title: 'Project complete status',
                subtitle: 'Assign, and Booked',
            },
            bars: 'vertical',
            vAxis: {
                format: 'decimal'
            },
            height: 300,
            colors: ['#1b9e77', '#d95f02', '#7570b3']
        };


        function selectHandler() {
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            alert('The user selected ' + topping);
          }
        }

        var chart = new google.charts.Bar(document.getElementById('project_report'));
        google.visualization.events.addListener(chart, 'select', selectHandler);   
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }


    const calculateTime = (time) => {
        time = time.split(':')
        let h = 0;
        if (time[0] !== 0) {
            let minute = parseInt(time[1]) % 60;

            h = `${ parseInt(time[0])}.${minute}`;
        } else {
            let minute = parseInt(time[1]) % 60;
            h = `${0}.${minute}`;

        }
        return h;
        // console.log(h);

    }

</script>
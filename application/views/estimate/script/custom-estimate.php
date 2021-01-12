<script>
    $(document).ready(function() {

        $('#report-data-Table').dataTable({

            columnDefs: [{
                    width: "5%",
                    targets: 0
                },
                {
                    width: "20%",
                    targets: [1]
                },
                {
                    width: "10%",
                    targets: [2, 3, 4, 5]
                }
            ],
            fixedColumns: true,
            fixedHeader: {
                header: false,
                footer: false
            },

        });
    });
    $(document).ready(function() {

        let pricePerUnitTime = 2; //2AED

        function getRowTotalTransPrice(annualNofTransaction, pricePerTransaction) {
            return annualNofTransaction * pricePerTransaction
        };

        function getRowTotalTransPriceTime(annualNofTransaction, pricePerUnitTime, timePerTransaction) {
            return annualNofTransaction * pricePerUnitTime * timePerTransaction;
        };

        function getSumofCol(className) {
            let array = document.querySelectorAll(className);
            let sum = 0;
            array.forEach(e => {
                sum += (e.innerHTML !== '') ? parseInt(e.innerHTML) : 0;
            });
            return sum;
        }


        // Calculating by role
        $('.selected-role').change(function() {
            let rate = $(this).children(":selected").attr('data-rate');
            let roleId = $(this).children(":selected").val();
            let currentRow = $(this).closest('tr');
            let byRate = currentRow.children('td:eq(2)').text(rate);

            currentRow.children('td:eq(4)').text(0);
            $('.rates').trigger('keyup');
            $('.estimate-time').trigger('keyup');
            $('#cost').text(getSumofCol('.totalAmt'));
            $('#time').text(getSumofCol('.estimate-time'));
        });

        $('.rates').on('keyup', function() {
            var ele = document.getElementsByClassName('estimatedTime');
            console.log(ele);

            // if ($('.estimatedTime').checked) {
            //     console.log($('.estimatedTime').prop('checked').val());
            // }
            // console.log(sset);
            let rate = $(this).text()
            let currentRow = $(this).closest('tr');
            let estimateDOT = currentRow.children('td:eq(3)').text()
            let totalAmt = parseInt(rate) * parseInt(estimateDOT);
            currentRow.children('td:eq(4)').text(totalAmt);
            $('#cost').text(getSumofCol('.totalAmt'));
            $('#time').text(getSumofCol('.estimate-time'));

        });

        $('.estimate-time').on('keyup', function() {
            const DayOrHrs = $(this).text()
            let currentRow = $(this).closest('tr');
            let rates = currentRow.children('td:eq(2)').text()
            let totalAmt = parseInt(rates) * parseInt(DayOrHrs);
            currentRow.children('td:eq(4)').text(totalAmt);
            $('#cost').text(getSumofCol('.totalAmt'));
            $('#time').text(getSumofCol('.estimate-time'));

        });




        // $('.estimatedTime').on('click')



    });
</script>
<script>
    $(document).ready(function() {

        // $('#report-data-Table').dataTable({

        //     columnDefs: [{
        //             width: "5%",
        //             targets: 0
        //         },
        //         {
        //             width: "20%",
        //             targets: [1]
        //         },
        //         {
        //             width: "10%",
        //             targets: [2, 3, 4, 5]
        //         }
        //     ],
        //     fixedColumns: true,
        //     fixedHeader: {
        //         header: false,
        //         footer: false
        //     },

        // });
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

        const pickCheckedVal = (tagName = null) => {
            var ele = document.getElementsByName(tagName);
            let checkedVal = '';
            for (i = 0; i < ele.length; i++) {
                if (ele[i].checked)
                    checkedVal = ele[i].value;
            }
            return checkedVal;
        }

        const calculateDiscount = (p, r) => {
            return (p - (p * r / 100));
        }
        const calculateMargin = (p, r) => {
            return ((p * r / 100));
        }
        const calculateGST = (p, r) => {
            return (p + (p * r / 100));
        }


        const getGrand = () => {
            let total = getSumofCol('.totalAmt');
            let margin = $('#margin').text();
            let discount = $('#discount').text();
            let gstTax = $('#gst-tax').text();
            let taxableAmt = (parseFloat(total) + parseFloat(margin) + parseFloat(gstTax)) - parseFloat(discount);
            return taxableAmt;
        }


        $('#mrg').on('keyup', function() {
            let total = getSumofCol('.totalAmt');
            let rate = parseFloat($(this).text());
            $('#margin').text(calculateMargin(total, rate));
        })
        $('#dis').on('keyup', function() {
            let total = getSumofCol('.totalAmt');
            let rate = parseFloat($(this).text());
            $('#discount').text(calculateMargin(total, rate));
        })
        $('#gst').on('keyup', function() {
            let total = getSumofCol('.totalAmt');
            let rate = parseFloat($(this).text());
            $('#gst-tax').text(calculateMargin(total, rate));
        })
        // Calculating by role
        $('.selected-role').change(function() {
            let rate = $(this).children(":selected").attr('data-rate');
            let roleId = $(this).children(":selected").val();
            let currentRow = $(this).closest('tr');
            let byRate = currentRow.children('td:eq(2)').text(rate);
            currentRow.children('td:eq(4)').text(0);
            $('.rates').trigger('keyup');
            $('#mrg').trigger('keyup');
            $('#dis').trigger('keyup');
            $('#gst').trigger('keyup');
            $('.estimate-time').trigger('keyup');
            // $('#cost').text(getSumofCol('.totalAmt'));
            $('#totalAmt').text(getGrand());
            $('#time').text(getSumofCol('.estimate-time'));
        });
        // Calculating by Rate
        $('.rates').on('keyup', function() {
            let est = pickCheckedVal('estimatedTime');
            let rate = $(this).text()
            let currentRow = $(this).closest('tr');
            let estimateDOT = currentRow.children('td:eq(3)').text()
            estimateDOT = est * estimateDOT;
            let totalAmt = parseInt(rate) * parseInt(estimateDOT);
            currentRow.children('td:eq(4)').text(totalAmt);

            $('#cost').text(getGrand());
            $('#time').text(getSumofCol('.estimate-time'));

            $('#mrg').trigger('keyup');
            $('#dis').trigger('keyup');
            $('#gst').trigger('keyup');
            $('#totalAmt').text(getSumofCol('.totalAmt'));
            $('#grandTotal').text(getGrand());

        });
        // Calculating by Time
        $('.estimate-time').on('keyup', function() {
            let DayOrHrs = $(this).text()
            let est = pickCheckedVal('estimatedTime');
            let currentRow = $(this).closest('tr');
            let rates = currentRow.children('td:eq(2)').text()
            DayOrHrs = parseInt(est) * parseInt(DayOrHrs);
            let totalAmt = parseInt(rates) * parseInt(DayOrHrs);
            currentRow.children('td:eq(4)').text(totalAmt);
            $('.rates').trigger('keyup');

            $('#cost').text(getGrand());
            $('#time').text(getSumofCol('.estimate-time'));

            $('#totalAmt').text(getSumofCol('.totalAmt'));
            $('#mrg').trigger('keyup');
            $('#dis').trigger('keyup');
            $('#gst').trigger('keyup');
            $('#grandTotal').text(getGrand());

        });
        // Calculating by Selected method
        $('.estimatedTime').on('click', function() {
            // $('#cost').text(getGrand());
            $('#mrg').trigger('keyup');
            $('#dis').trigger('keyup');
            $('#gst').trigger('keyup');
            $('#totalAmt').text(getSumofCol('.totalAmt'));
            $('#grandTotal').text(getGrand());
            $('.estimate-time').trigger('keyup');
            $('.rates').trigger('keyup');
        });

        // Generate final estimate reports
        $('#generate-reports').on('click', function() {
            let tableData = [];

            $('#report-data-Table').find('tr').each(function(i, el) {
                var $tds = $(this).find('td'),
                    question = $tds.eq(0).text(),
                    resourcesRole = $tds.eq(1).find('select option:selected').text(),
                    rate = $tds.eq(2).text(),
                    time = $tds.eq(3).text(),
                    totalAmount = $tds.eq(4).text();
                let obj = {
                    question,
                    resourcesRole,
                    rate,
                    time,
                    totalAmount
                }
                tableData.push(obj);
                // do something with productId, product, Quantity
            });


            $('#estimate-cal').css('display', 'none');
            $('#estimate-view').css('display', 'block');

            let grdTotal = [];
            $('#grd-tfoot').find('tr').each(function(i, el) {
                let $tds = $(this).find('td'),
                    $ths = $(this).find('th'),
                    rate = $tds.eq(0).text(),
                    total = $tds.eq(1).text(),
                    title = $ths.eq(0).text(),
                    obj1 = {
                        title,
                        rate,
                        total

                    }
                grdTotal.push(obj1);

                // do something with productId, product, Quantity
            });

            let cid = '<?php echo $id ?>';
            let qttype = '<?php echo json_encode($qtype[0]) ?>';
            qttype = JSON.parse(qttype);
            let clientDetails = '<?php echo json_encode($clinetDetails) ?>';
            let estIn = pickCheckedVal('estimatedTime') == 1 ? 'hrs' : 'Days';
            let estDate = new Date();
            let totalTime = $('#time').text();

            let form_data = {
                client: cid,
                clientDetails,
                qttype: qttype.id,
                quationType: qttype,
                tableData,
                grdTotal,
                estIn,
                totalTime,
                estimateDate: estDate.toLocaleDateString(),
                totalAmount: getGrand()
            }
            let url = BASEURL + 'Estimate/insertNewQuatation';
            $.post(url, form_data, function(data) {
                // console.log(data);
            });

            showReport(form_data);
        });



        // print

        $('#print').click(function() {
            window.print();
        });

        $('#cancel').click((e)=>{
            e.preventDefault();
            $('#estimate-cal').css('display', 'block');
            $('#estimate-view').css('display', 'none');
        });
    });
</script>
<script>
    // console.log('i am in');

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
            return `${(p - (p * r / 100))}`;
        }
        const calculateMargin = (p, r) => {
            return `${((p * r / 100))}`;
        }
        const calculateGST = (p, r) => {
            return `${(p + (p * r / 100))}`;
        }

        const getGrand = () => {
            let total = getSumofCol('.totalAmt');
            let margin = $('#margin').text();
            let discount = $('#discount').text();
            let gstTax = $('#gst-tax').text();
            let taxableAmt = `${(parseFloat(total) + parseFloat(margin) + parseFloat(gstTax)) - parseFloat(discount)}`;
            return taxableAmt;
        }
        
        $('#mrg').on('keyup', function() {
            let total = getSumofCol('.totalAmt');
            let rate = parseFloat($(this).text());
            $('#margin').text(calculateMargin(total, rate));
            $('#grandTotal').text(getGrand());
        });
        $('#dis').on('keyup', function() {
            let total = getSumofCol('.totalAmt');
            let rate = parseFloat($(this).text());
            $('#discount').text(calculateMargin(total, rate));
            $('#grandTotal').text(getGrand());
        });
        $('#gst').on('keyup', function() {
            let total = getSumofCol('.totalAmt');
            let rate = parseFloat($(this).text());
            $('#gst-tax').text(calculateMargin(total, rate));
            $('#grandTotal').text(getGrand());
        });
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

            let tableRow = [];;

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
                if (totalAmount != 0) {
                    tableRow.push(obj);
                }

                // do something with productId, product, Quantity
            });

            let grdTotalRow = [];
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
                grdTotalRow.push(obj1);

                // do something with productId, product, Quantity
            });


            let tableData = {
                tableRow,
                grdTotalRow
            }

            saveLsData('quotation', tableData);

            $('#estimate-cal').css('display', 'none');
            $('#client-view').removeClass('hide');

            // console.log(tableRow);

            // let cid = '<?php //echo $id 
                            ?>';
            // let qttype = '<?php //echo json_encode($qtype[0]) 
                                ?>';
            // qttype = JSON.parse(qttype);
            // let clientDetails = '<?php //echo json_encode($clinetDetails) 
                                    ?>';
            // let estIn = pickCheckedVal('estimatedTime') == 1 ? 'hrs' : 'Days';
            // let estDate = new Date();
            // let totalTime = $('#time').text();

            // let form_data = {
            //     client: cid,
            //     clientDetails,
            //     qttype: qttype.id,
            //     quationType: qttype,
            //     tableData,
            //     grdTotal,
            //     estIn,
            //     totalTime,
            //     estimateDate: estDate.toLocaleDateString(),
            //     totalAmount: getGrand()
            // }

            // let url = BASEURL + 'Estimate/insertNewQuatation';
            // $.post(url, form_data, function(data) {
            //     // console.log(data);
            // });

            // showReport(form_data);
        });


        function showReport1(obj) {

            // Definding variables
            if (obj) {
                // console.log(obj.client_data);
                let client = JSON.parse(obj.client_data),
                    data = JSON.parse(obj.data),
                    tableData = data.tableRow,
                    grandTotal = data.grdTotalRow;

                console.log(tableData);


                // let 
                //     client = JSON.parse(obj.client_Details),
                //     tableData = data.tableRow,
                //     grandTotal = data.grdTotalRow,
                //     clientDetails = client,
                //     quotation_Type = obj.quationType,
                let selectedServices = [];

                // // Setting tops header details
                // $('#current-date').text(obj.estimateDate);
                // let est = obj.estIn == 'hrs' ? '(Hrs)' : '(Days)';
                // $('#est-cost').text(obj.totalAmount);

                // Filtering data which is selected by user
                for (let index = 0; index < tableData.length; index++) {
                    if (tableData[index].totalAmount != 0) {
                        selectedServices.push(tableData[index]);
                    }
                }
                // Apending Grandtotal data list table view
                let selectedServicesDom = ``;
                selectedServices.forEach((e, i) => {
                    selectedServicesDom += ` <tr>
                    <td>${(i+1)}</td>
                    <td>${e.question}</td>
                    <td>${e.resourcesRole}</td>
                    <td class="text-center">${e.rate}</td>
                    <td class="text-center">${e.time}</td>
                    <td class="text-right">${e.totalAmount}</td>
                    </tr>`;
                });

                console.log(selectedServicesDom);

                $('#estimate-report-tbody').html(selectedServicesDom);

                // $('#rates').text(est); //Total estimated Rates
                // $('#times').text(est); //Total estimated time
                // $('#est-time').text(obj.totalTime); //Total time estimate times
                // // console.log(obj.quationType);
                // $('#est-for').text(quotation_Type['title']); // For printing selected services

                let grdTotalRow = ``;
                grandTotal.forEach((e) => {
                    grdTotalRow += `<tr class="border-top">
                          <th colspan="4" class="text-right">${e.title}</th>
                          <td class="text-center">${e.rate}</td>
                          <td class=" text-right" id="totalAmt">${e.total}.00</td>
                      </tr>`;
                });
                $('#est-tfoot').html(grdTotalRow);

                // clientDetails = JSON.parse(clientDetails);
                // console.log(clientDetails);

                let address = `${client['address']}, ${client['country']}, 
                ${client['pin']}`;
                // Adding client details dynamic
                let clinetViewTemplate = `<div class="card">
                  <div class="card-header">
                      <h6>CUSTOMER</h6>
                  </div>
                  <div class="card-body card-p-0">
                      <p class="card-text" id="cname">${client['orgName']}</p>
                      <p class="card-text"><span> Address:</span> <span id="address">${address}</span></p>
                      <p class="card-text"><span> Phone:</span> <span id="phone">
                      ${client['phone']}</span></p>
                      <p class="card-text"><span> Mobile:</span> <span id="mobile">${client['mobile']}</span></p>
                      <p class="card-text"><span> Email:</span> <span id="email">${client['email']}</span></p>
                  </div>
                    </div>`;
                $('#client-box').html(clinetViewTemplate);
            }
        };



        $('#clinet-form').submit(function(e) {
            e.preventDefault();
            let client_data = {
                orgName: $('#org-name').val(),
                gstVat: $('#gst-vat').val(),
                ogtype: $('#og-type').val(),
                phone: $('#c-phone').val(),
                mobile: $('#c-mobile').val(),
                email: $('#c-email').val(),
                address: $('#c-address').val(),
                country: $('#c-country').val(),
                pin: $('#c-pin-zip').val(),
                qtype: $('#qtype').val(),
            };

            let quotation = JSON.parse(retriveLsData('quotation'));
            let url = BASEURL + 'Estimate/insertNewQuatation';
            if (quotation != '') {
                $.post(url, {
                    client_data,
                    quotation,
                }, function(data) {
                    data = JSON.parse(data);
                    showReport1(data)
                    // console.log(data);

                });
                $('#client-view').css('display', 'none');
                $('#estimate-view').css('display', 'block');
            }
        });

        //Function for print 
        $('#print').click(print);
        //Function Go back
        $('#cancel').click((e) => {
            e.preventDefault();
            $('#estimate-cal').css('display', 'block');
            $('#estimate-view').css('display', 'none');
        });
    });
</script>
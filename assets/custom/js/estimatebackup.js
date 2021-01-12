$(document).ready(function() {

    function getTotal() {
        let totalTime = 0;
        let totalCost = 0;
        let annualValue = document.querySelectorAll('.annual-value');
        let annualTimeInminute = document.querySelectorAll('.annual-time-in-minute');
        // Calculating time
        annualTimeInminute.forEach(e => {
            if (e.innerHTML !== '') {
                // console.log(e)
                totalTime += parseInt(e.innerHTML);
            } else {
                totalTime += 0;
                // return;
            }
        });
        // Calculating cost
        annualValue.forEach(e => {
            if (e.innerHTML !== '') {
                // console.log(e.innerHTML)
                totalCost += parseInt(e.innerHTML);
            }
            // } else {
            //     return;
            // }
        });

        // console.log()
        return {
            time: totalTime / 60,
            cost: totalCost
        };
    }

    // Calculation by monthly transaction
    $('#account').on('blur', '.monthly-transaction', function() {
        let sum = 0;
        let numbers = /^[0-9]+$/;
        let MonthlyNofTransaction = $(this).text();
        if (MonthlyNofTransaction.match(numbers)) {
            // Calcualting Annual value by given monthly transaction
            let anualTransaction = $(this).next().text(parseInt(MonthlyNofTransaction) * 12);
            // Extrcting Annual value form column
            let anualValue = $(this).next().text();
            //  // Extrcting price per transaction value form table
            let pricePerTransaction = $(this).nextAll("td").eq(1).text();
            // Calcualting Annual value
            let AnualValueAED = parseInt(pricePerTransaction) * parseInt(anualValue);
            // Assign annual value multiply by pricePerTransaction
            $(this).nextAll("td").eq(2).text(AnualValueAED);
            //  // Extrcting price per transaction value form table
            let TimePerTransactioninMinute = $(this).nextAll("td").eq(3).text();

            // alert(parseInt(TimePerTransactioninMinute) * AnualValueAED);
            let totalAnualTimeInMinute = $(this).nextAll("td").eq(4).text(parseInt(AnualValueAED));

            let totalCoastAED = $(this).nextAll("td").eq(5).text(parseInt(AnualValueAED * 1));

            let MonthlyTimeinMinutes = parseInt(TimePerTransactioninMinute) * parseInt(MonthlyNofTransaction);

            let monthlytimeInminute = $(this).nextAll("td").eq(6).text(parseInt(MonthlyTimeinMinutes));
            // Assigning Total value in result field
            sum = getTotal();
            $('#ac').text(sum.cost);
            $('#atim').text(sum.time);

        } else if (MonthlyNofTransaction === '') {
            $(this).next().text('');
            $(this).nextAll("td").eq(2).text('');
            $(this).nextAll("td").eq(4).text('');
            $(this).nextAll("td").eq(5).text('');
            $(this).nextAll("td").eq(6).text('');
            $(this).nextAll("td").eq(7).text('');
            sum = getTotal();
            $('#ac').text(sum.cost);
            $('#atim').text(sum.time);
            return;
        } else {
            alert('Warning! Only Number allowed');
            return;
        }
    });

    // Calculation by Annual transaction

    $('#account').on('blur', '.annual-transaction', function() {
        let sum = 0;
        let numbers = /^[0-9]+$/;
        let annualNofTransaction = $(this).text();
        if (annualNofTransaction.match(numbers)) {
            // Calcualting Annual value by given monthly transaction

            // let monthly = $(this).prev().text('-')

            let pricePerTransaction = parseInt($(this).next().text());

            let TotalValue = parseInt(annualNofTransaction) * pricePerTransaction;

            // console.log(TotalValue);


            $(this).nextAll("td").eq(1).text(TotalValue);
            sum = getTotal();
            $('#ac').text(sum.cost);
            $('#atim').text(sum.time);

        } else if (annualNofTransaction === '') {
            $(this).prev().text('')
            $(this).nextAll("td").eq(1).text('');
            // $(this).nextAll("td").eq(3).text('');
            // $(this).nextAll("td").eq(4).text('');
            // $(this).nextAll("td").eq(5).text('');
            sum = getTotal();
            $('#ac').text(sum.cost);
            $('#atim').text(sum.time);
            return;
        } else {
            alert('Warning! Only Number allowed');
            return;
        }
    });

    // Calculated by price per trasaction



    $('#account').on('blur', '.price-per-transaction', function() {
        let sum = 0;
        let numbers = /^[0-9]+$/;
        let pricePerTransaction = $(this).text();

        if (pricePerTransaction.match(numbers)) {
            // Calcualting Annual value by given monthly transaction
            let annualTransaction = parseInt($(this).prev().text().trim()) !== '' ? $(this).prev().text() : 0;

            console.log('Trans' + annualTransaction);
            console.log('price' + pricePerTransaction);
            if (annualTransaction) {
                let TotalValue = parseInt(annualTransaction) * parseInt(pricePerTransaction);
                $(this).nextAll("td").eq(0).text(TotalValue);
            } else {
                $(this).prev().text().trim()
                $(this).nextAll("td").eq(0).text(0);
            }
            // console.log('Trans' + TotalValue);
            sum = getTotal();
            $('#ac').text(sum.cost);
            $('#atim').text(sum.time);

        } else if (pricePerTransaction === '') {
            $(this).nextAll("td").eq(0).text(0);
            sum = getTotal();
            $('#ac').text(sum.cost);
            $('#atim').text(sum.time);
            return;
        } else {
            alert('Warning! Only Number allowed');
            return;
        }
    });
});
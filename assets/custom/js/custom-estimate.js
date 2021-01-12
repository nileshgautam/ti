$(document).ready(function() {

    let pricePerUnitTime = 2;  //2AED
    function getRowTotalTransPrice(annualNofTransaction,pricePerTransaction) {
        return annualNofTransaction * pricePerTransaction
        };
    function getRowTotalTransPriceTime(annualNofTransaction,pricePerUnitTime,timePerTransaction) {
            return annualNofTransaction * pricePerUnitTime * timePerTransaction;
        };
    function getSumofCol(className){
        let array = document.querySelectorAll(className);
        let sum=0;
        array.forEach(e => {
            sum+=(e.innerHTML !== '') ? parseInt(e.innerHTML):0;
        });
        return sum;
    }

    // function getTotal() {
    //     let totalTime = 0;
    //     let totalCost = 0;
    //     let annuaValuePPT = document.querySelectorAll('.annual-value-ppt');
    //     let annualValueTPT = document.querySelectorAll('.annual-value-tpt');
    //     // Calculating time
    //     annuaValuePPT.forEach(e => {
    //         totalTime+=(e.innerHTML !== '') ? parseInt(e.innerHTML):0;
    //     });
    //     // Calculating cost
    //     annualValueTPT.forEach(e => {
    //         totalCost+=(e.innerHTML !== '') ? parseInt(e.innerHTML):0;
            
    //     });

    //     // console.log()
    //     return {
    //         annuaValuePPT: annuaValuePPT,
    //         annualValueTPT: annualValueTPT
    //     };
    // }


     // Calculation by monthly transaction
     $('#account .monthly-transaction').on('keyup', function() {

        let numbersRegex = /^[0-9]+$/;
        let currentRow=$(this).closest('tr');  
        let monthlyNofTrans=currentRow.children('td:eq(1)');
        let monthlyNofTransText=monthlyNofTrans.text().trim();
        let monthlyNofTransNum=0;
    
        let annualNofTrans=currentRow.children('td:eq(2)');  
        
        if (monthlyNofTransText.match(numbersRegex)){
                monthlyNofTransNum=parseInt(monthlyNofTransText);
        }
        else if (monthlyNofTransText=='' ) {
            monthlyNofTransNum=0;
        }
        else if (monthlyNofTransText=='-' ) {
            monthlyNofTransNum=1;
    }
        else {
            // alert('Please enter only numbers in number of transactions');
            return;
        }
        
        let annualTransNum = monthlyNofTransNum*12;
        annualNofTrans.text(annualTransNum);  
        $('#account .price-per-transaction').trigger('keyup');
        $('#account .time-per-transaction').trigger('keyup');
        
       
    });
    

     // Calculation by annual transaction
     $('#account .annual-transaction').on('keyup', function() {

        let numbersRegex = /^[0-9]+$/;
        let currentRow=$(this).closest('tr');  
        let annualNofTrans=currentRow.children('td:eq(2)');
        let annualNofTransText=annualNofTrans.text().trim();
        let annualNofTransNum=0;
    
        let monthlyNofTrans=currentRow.children('td:eq(1)');
        let monthlyNofTransNum=0;  
        
        if (annualNofTransText.match(numbersRegex)){
            annualNofTransNum=parseInt(annualNofTransText);
            monthlyNofTransNum = annualNofTransNum/12;
            if (annualNofTransNum%monthlyNofTransNum===0) {
                monthlyNofTrans.text(monthlyNofTransNum);
            }
            else {
                monthlyNofTrans.text("-");
            }

        }
        else if (annualNofTransText=='' ) {
            annualNofTransNum=0;
            monthlyNofTrans.text("");
        }
        else {
            // alert('Please enter only numbers in number of transactions');
            return;
        }
        
        let annualTransNum = monthlyNofTransNum*12;
        annualNofTrans.text(annualTransNum);  
        $('#account .price-per-transaction').trigger('keyup');
        $('#account .time-per-transaction').trigger('keyup');
       
    });
        

    // Calculation by price-per-transaction
    $('#account .price-per-transaction').on('keyup', function() {

        let numbersRegex = /^[0-9]+$/;
        let currentRow=$(this).closest('tr');  
        let pricePerTrans=currentRow.children('td:eq(3)');
        let pricePerTransText=pricePerTrans.text().trim();
        let pricePerTransNum=0;

        let monthlyNofTrans=currentRow.children('td:eq(1)');

        let annualNofTrans=currentRow.children('td:eq(2)');
        let annualNofTransText=annualNofTrans.text().trim();
        let annualNofTransNum=0;
        

        if (annualNofTransText.match(numbersRegex)){
            annualNofTransNum=parseInt(annualNofTransText);
            let monthlyNofTransNum = annualNofTransNum/12;
            if ((annualNofTransNum%monthlyNofTransNum)===0) {
                monthlyNofTrans.text(monthlyNofTransNum);
            }
            else {
                monthlyNofTrans.text("-");
            }

        }
        else if (annualNofTransText=='' ) {
            annualNofTransNum=0;
            monthlyNofTrans.text("");
        }
        else {
            // alert('Please enter only numbers in number of transactions');
            return;
        }
        let avAEDPPT=currentRow.children('td:eq(5)');  
        
        if (pricePerTransText.match(numbersRegex)){
            pricePerTransNum=parseInt(pricePerTransText);

        }
        else if (pricePerTransText=='' ) {
            pricePerTransNum=0;
        }
        else {
            // alert('Please enter only numbers in price per transactions');
            return;
        }
        
        let aavAEDPPTVal = getRowTotalTransPrice(annualNofTransNum,pricePerTransNum);
        avAEDPPT.text(aavAEDPPTVal);  
           
            $('#ppt').text(getSumofCol('.annual-value-ppt'));
            $('#tpt').text(getSumofCol('.annual-value-tpt'));
            
       
    });
      
    
    // Calculation by time-per-transaction
    $('#account .time-per-transaction').on('keyup', function() {

        let numbersRegex = /^[0-9]+$/;
        let currentRow=$(this).closest('tr');  
        let timePerTrans=currentRow.children('td:eq(4)');
        let timePerTransText=timePerTrans.text().trim();
        let timePerTransNum=0;

        let annualNofTrans=currentRow.children('td:eq(2)').text().trim();
        let annualNofTransNum =(annualNofTrans=='')? 0:parseInt(annualNofTrans);
        
        let avAEDTPT=currentRow.children('td:eq(6)');  
        
        if (timePerTransText.match(numbersRegex)){
            timePerTransNum=parseInt(timePerTransText);

        }
        else if (timePerTransText=='' ) {
            timePerTransNum=0;
        }
        else {
            // alert('Please enter only numbers in time per transactions');
            return;
        }
        
        let aavAEDTPTVal = getRowTotalTransPriceTime(annualNofTransNum,pricePerUnitTime,timePerTransNum)
        avAEDTPT.text(aavAEDTPTVal);  
        $('#ppt').text(getSumofCol('.annual-value-ppt'));
        $('#tpt').text(getSumofCol('.annual-value-tpt'));
       
    });
      
    //   // Calculation by monthly transaction
    //     $('#account').on('blur', '.monthly-transaction', function() {
        
    //     let sum = 0;
    //     let numbersRegex = /^[0-9]+$/;
    //     let currentRow=$(this).closest('tr');  
    //     let monthlyNofTrans=currentRow.children('td:eq(1)');
    //     let monthlyNofTransText=monthlyNofTrans.text().trim();
    //     let monthlyNofTransNum=0;

    //     let annualNofTrans=currentRow.children('td:eq(2)');
    //     let annualNofTransText=annualNofTrans.text().trim();
    //     // let annualTransNum=0;

    //     let pricePerTrans=currentRow.children('td:eq(3)');
    //     let pricePerTransText=pricePerTrans.text().trim();
    //     let pricePerTransNum=0

    //     let timePerTrans=currentRow.children('td:eq(4)');
    //     let timePerTransText=timePerTrans.text().trim();
    //     let timePerTransNum = 0;

    //     let avPPT=currentRow.children('td:eq(5)');
    //     let avPPTText=timePerTrans.text().trim();
    //     let avpPPTNum = 0;

    //     let avTPT=currentRow.children('td:eq(6)');
    //     let avTPTText=timePerTrans.text().trim();
    //     let avTPTNum =0;

        
    //     if (monthlyNofTransText.match(numbersRegex)){
    //             monthlyNofTransNum=parseInt(monthlyNofTransText);
    //     }
    //     else if (monthlyNofTransText=='' ) {
    //         monthlyNofTransNum=0;
    //     }
    //     else if (monthlyNofTransText=='-' ) {
    //         monthlyNofTransNum=1;
    // }
    //     else {
    //         alert('Please enter only numbers in number of transactions');
    //         $this.focus();
    //         return;
    //     }
        
    //     let annualTransNum = monthlyNofTransNum*12;
    //     annualNofTrans.text(annualTransNum);

    //     if (pricePerTransText.match(numbersRegex)){
    //         pricePerTransNum=parseInt(pricePerTransText);
    //       }
    //     else if (pricePerTransText=='') {
    //         pricePerTransNum=0;
    //         }
    //         else {
    //             alert('Please enter only numbers in number of transactions');
    //             $this.focus();
    //             return;
    //         }

    //     if (timePerTransText.match(numbersRegex)){
    //         timePerTransNum=parseInt(timePerTransText);
    //         }
    //     else if (timePerTransText=='') {
    //         timePerTransNum=0;
    //         }
    //         else {
    //             alert('Please enter only numbers in number of transactions');
    //             $this.focus();
    //             return;
    //         }
    //     let avPPTAED = getRowTotalTransPrice(annualTransNum,pricePerTransNum);
    //     let avTPTAED = getRowTotalTransPriceTime(annualTransNum,timePerTransNum,);
        
    //     //Populate Annual value in AED field
    //     avPPT.text(avPPTAED);
        
    //     // Get sum of annual Vallue in AED field and time
    //         sum = getTotal();
    //         $('#ac').text(sum.cost);
    //         $('#atim').text(sum.time);

    
    // });

    //     // Calculation by Annual transaction

    //     $('#account').on('blur', '.annual-transaction', function() {
            
    //         let sum = 0;
    //         let numbersRegex = /^[0-9]+$/;
    //         let annualTransText = $(this).text();
    //         let pricePerTransText = $(this).next().text().trim();
    //         let annualTransNum =0;
            
    //         if (annualTransText.match(numbersRegex)){
    //             annualTransNum=parseInt(annualTransText);
                
    //              let  monthlyTransText = $(this).prev().text().trim();
    //              if (monthlyTransText==='-'){
    //                 monthlyTransNum = 1;
    //              }
    //              else if (monthlyTransText==''){
    //                 monthlyTransNum=0;
    //              }
    //              else {
    //                 monthlyTransNum = parseInt(monthlyTransText);
    //              }
                
    //              if (annualTransNum===monthlyTransNum*12){

    //              }
    //              else {
    //                 $(this).prev().text('-');
    //              }

    //         }
    //         else if (annualTransText=='') {
    //             annualTransNum=0;
    //         }
    //         else {
    //             alert('Please enter only numbers in number of transactions');
    //             $this.focus();
    //             return;
    //         }
            
        
    //         if (pricePerTransText.match(numbersRegex)){
    //             pricePerTransNum=parseInt(pricePerTransText);
    //           }
    //         else if (pricePerTransText=='') {
    //             pricePerTransNum=0;
    //             }
    //             else {
    //                 alert('Please enter only numbers in number of transactions');
    //                 $this.focus();
    //                 return;
    //             }
    //         let annualValueAED = getRowTotalTransPrice(annualTransNum,pricePerTransNum);
            
    //         //Populate Annual value in AED field
    //         $(this).nextAll("td").eq(1).text(annualValueAED);
            
    //         // Get sum of annual Vallue in AED field and time
    //             sum = getTotal();
    //             $('#ac').text(sum.cost);
    //             $('#atim').text(sum.time);
        
    //     });
        
    //     // Calculated by price per trasaction

    //     $('#account').on('blur', '.price-per-transaction', function() {
    //         let sum = 0;
    //         let numbersRegex = /^[0-9]+$/;
    //         let pricePerTransText = $(this).text().trim();
                    
    //         if (pricePerTransText.match(numbersRegex)){
    //             pricePerTransNum = parseInt(pricePerTransText);
    //         }
    //         else if (pricePerTransText === ''){
    //             pricePerTransNum=0;
    //         }
    //         else {
    //             alert('Please enter only numbers in price field');
    //             $this.focus();
    //             return;

    //         }
    //         let annualTransNum = 0;
    //         let annualTransText = $(this).prev().text().trim();
            
    //         if (annualTransText.match(numbersRegex)){
    //             annualTransNum=parseInt(annualTransText);
                
    //             //  let  monthlyTransNum = parseInt($(this).prev().text());
    //             //  if (annualTransNum===monthlyTransNum*12){

    //             //  }
    //             //  else {
    //             //     $(this).prev().text('-');
    //             //  }

    //         }
    //         else if (annualTransaction=='') {
    //             annualTransNum=0;
    //         }
    //         else {
    //             alert('Please enter only numbers in number of transactions');
    //             // $this.focus();
    //             return;
    //         }
            
    //         let annualValueAED = getRowTotalTransPrice(annualTransNum,pricePerTransNum);
            
    //         //Populate Annual value in AED field
    //         $(this).nextAll("td").eq(0).text(annualValueAED);
            
    //         // Get sum of annual Vallue in AED field and time
    //             sum = getTotal();
    //             $('#ac').text(sum.cost);
    //             $('#atim').text(sum.time);
        
    //     });

// Calculation by monthly transaction
$('#audit').on('blur', '.monthly-transaction', function() {
      
    let sum = 0;
    let numbersRegex = /^[0-9]+$/;
    let monthlyNofTransText = $(this).text();
    let monthlyNofTransNum = 0;
    let timePerTransText = $(this).nextAll("td").eq(1).text();
    
    if (monthlyNofTransText.match(numbersRegex)){
            monthlyNofTransNum=parseInt(monthlyNofTransText);
    }
    else if (monthlyNofTransText=='' ) {
             monthlyNofTransNum=0;
    }
    else if (monthlyNofTransText=='-' ) {
            monthlyNofTransNum=1;
}
    else {
        alert('Please enter only numbers in number of transactions');
        $this.focus();
        return;
    }
    
    let annualTransNum = monthlyNofTransNum*12;
    $(this).next().text(annualTransNum);

    if (timePerTransText.match(numbersRegex)){
        timePerTransNum=parseInt(timePerTransText);
      }
    else if (timePerTransText=='') {
        timePerTransNum=0;
        }
        else {
            alert('Please enter only numbers in number of transactions');
            $this.focus();
            return;
        }
    let annualValueAED = getRowTotalTransPrice(annualTransNum,timePerTransNum);
    
    //Populate Annual value in AED field
    $(this).nextAll("td").eq(2).text(annualValueAED);
       
    // Get sum of annual Vallue in AED field and time
        sum = getTotal();
        $('#ac').text(sum.cost);
        $('#atim').text(sum.time);

   
});




// Calculation by monthly transaction
// $('#audit').on('blur', '.monthly-transaction', function() {
      
//     let sum = 0;
//     let numbersRegex = /^[0-9]+$/;
//     let monthlyNofTransText = $(this).text();
//     let monthlyNofTransNum = 0;
//     let pricePerTransText = $(this).nextAll("td").eq(1).text();
    
//     if (monthlyNofTransText.match(numbersRegex)){
//             monthlyNofTransNum=parseInt(monthlyNofTransText);
//     }
//     else if (monthlyNofTransText=='' ) {
//              monthlyNofTransNum=0;
//     }
//     else if (monthlyNofTransText=='-' ) {
//             monthlyNofTransNum=1;
// }
//     else {
//         alert('Please enter only numbers in number of transactions');
//         $this.focus();
//         return;
//     }
    
//     let annualTransNum = monthlyNofTransNum*12;
//     $(this).next().text(annualTransNum);

//     if (pricePerTransText.match(numbersRegex)){
//         pricePerTransNum=parseInt(pricePerTransText);
//       }
//     else if (pricePerTransText=='') {
//         pricePerTransNum=0;
//         }
//         else {
//             alert('Please enter only numbers in number of transactions');
//             $this.focus();
//             return;
//         }
//     let annualValueAED = getRowTotalTransPrice(annualTransNum,pricePerTransNum);
    
//     //Populate Annual value in AED field
//     $(this).nextAll("td").eq(2).text(annualValueAED);
       
//     // Get sum of annual Vallue in AED field and time
//         sum = getTotal();
//         $('#ac').text(sum.cost);
//         $('#atim').text(sum.time);

   
// });



});
// Global varialble pattern
var alphaPattern = /^[a-zA-Z]+$/;
var stringPattern = /^[a-zA-Z0-9.-_&:\s]+$/;
var alphaNumericPattern = /^[a-zA-Z0-9\s]+$/;
var namePattern = /^[a-zA-Z.-\s]+$/;
var ifscPattern = /[a-zA-Z]{4}\d{7}/;
var numericPattern = /^[0-9]+$/;
var mobilePattern = /^[0-9]{10}$/;
var specialCharPattern = /^[a-zA-Z.-_:\s]+$/;
var pincodePattern = /^[0-9]{6}$/;
var datePattern = /^([0-2][0-9]|[3][0-1])\/|-([0-9][1-2])\/|-((19|20)[0-9]{2})$/;
var timePattern = /^[0-9:.-\s]+$/;
var websitePattern = /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$/;
const EMAILPATTERN = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

// Local storage function
function retriveLsData(FILE_KEY) {
    return localStorage.getItem(FILE_KEY);
};
// Function to save 
function saveLsData(FILE_KEY, data) {
    localStorage.setItem(FILE_KEY, JSON.stringify(data));
};

function hasLsData(FILE_KEY) {
    return localStorage.hasOwnProperty(FILE_KEY) ? true : false;
    // localStorage 
};

function removeLsData(FILE_KEY) {
    localStorage.removeItem(FILE_KEY);
    // localStorage 
};

function errorAlert(errorMessage = null) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        preventDuplicates: true,
        timeOut: 500,
        positionClass: "toast-top-right"
    };
    toastr.error(errorMessage, 'Error');
};

function successAlert(successMessage = null) {
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        preventDuplicates: true,
        timeOut: 500,
        positionClass: "toast-top-right"
    };
    toastr.success(successMessage, 'Success');
}

// date 4/11/2020
const Checked = (id, cl) => {
    let values = [];
    $(`#${id + ' .' + cl}:checked`).each(function() {
        // console.log($(this).attr('data-st'));
        // console.log($(this).attr('data-et'));
        // console.log($(this).val());

        let task = {
            id: $(this).val(),
            st: $(this).attr('data-st'),
            et: $(this).attr('data-et')
        }
        values.push(task);

    });
    return values;

};
// Convert TimeTo 24hrs to 12 hrs 
function tConvert(time) {
    // Check correct time format and split into components
    time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
    if (time.length > 1) { // If time format correct
        time = time.slice(1);
        console.log(time);
        // Remove full string match value
        time[5] = +time[0] < 12 ? 'am' : 'pm'; // Set AM/PM
        // time[0] = +time[0] % 12 || 12; // Adjust hours

        console.log(time[0])
        console.log(time[5])
        console.log(time)
    }
    return time.join(''); // return adjusted time or original string
};

const timeConvert12hrs = (times) => {
    let timeString = times;
    let H = +timeString.substr(0, 2);
    let h = (H % 12) || 12;
    let ampm = H < 12 ? "am" : "pm";
    timeString = h + timeString.substr(2, 3) + ampm;
    return timeString;
};

// Function for retrived selected radio butoon 
function displayRadioValue(name) {
    var ele = document.getElementsByName(name);
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked)
            return ele[i].value;
    }
};

const convert12T24hrs = (time) => {
    let totalTime = time.split(":");
    let hrs = parseInt(totalTime[0]);
    let minute = totalTime[1].slice(0, -2);
    postFix = totalTime[1].slice(-2);
    if (postFix === 'pm') {
        if (hrs == 12) {
            hrs += 1;
            return `${hrs}:${minute}:00`;
        } else {
            hrs += 12;
            return `${hrs}:${minute}:00`;
        }
    } else if (postFix === 'am') {
        return `${hrs}:${minute}:00`;
    }
};

function deleteRow(id, table, url) {
    swal("Are you sure!", " Wants to delete this entry? It will delete permanently.", "warning", {
            buttons: {
                Yes: true,
                No: true,
            },
        })
        .then((value) => {
            switch (value) {
                case "Yes":
                    let form_data = {
                        row_id: id,
                        table_name: table
                    };
                    if (id !== undefined) {
                        $.post(url, form_data, function(data) {
                            response = JSON.parse(data);
                            (response.type === 'success') ? successAlert(response.message): errorAlert(res.message);
                            setTimeout(() => {
                                window.location.reload();
                            }, 4000);
                        });
                    }
                    break;
                case "No":
                    swal('Confirmation', 'Data safe', 'success');
                default:
                    break;
            }
        });
};

// Function to validate mobile number should be 10 digit only.
const validateMobileNumber = (mobilenumber) => {
    // var phoneno = /^\d{10}$/;
    const MOBILENUMBER = /^[0-9]{10}$/;
    if (mobilenumber.match(MOBILENUMBER)) {
        return true;
    } else {
        return false;
    }
};
// Function to validate email.
const validateEmail = (email) => {
    if (email.match(EMAILPATTERN)) {
        return true;
    } else {
        return false;
    }

};
// Function to validate GST number
const gstNumberValidate = (gstNo) => {

    var gstin = gstNo;
    var stateCode = gstin.substring(0, 2);
    var str1 = gstin.substring(2, 7);
    var str2 = gstin.substring(7, 11);
    var str3 = gstin.substring(11, 12);

    if ($.trim(gstin) != "" && gstin.length != 15) {
        error = "Please enter 15 digit GSTIN";
        return error;
    } else if ($.trim(gstin) != "" && !str1.match(alphaPattern)) {
        error = "Please enter valid GSTIN";
        return error;
    } else if ($.trim(gstin) != "" && !str2.match(numericPattern)) {
        error = "Please enter valid GSTIN";
        return error;
    } else if ($.trim(gstin) != "" && !str3.match(alphaPattern)) {
        error = "Please enter valid GSTIN";
        return error;
    }

    // else if ($.trim(gstin) == "" && state.val() == "") {
    //     // alert(state.val());
    //     error = "Invalid state code";
    //     // state.focus();
    //     return error;
    // }
    // else if ($.trim(gstin) != "" && state.val() != parseInt(stateCode)) {
    //     error = "GSTIN does not match state";
    //     // state.focus();
    //     return error;
    // }

};
// Function date validate 
function ValidateDate() {
    var start = $('#start-date').val();
    var end = $('#end-date').val();
    var startDay = new Date(start);
    var endDay = new Date(end);
    var millisecondsPerDay = 1000 * 60 * 60 * 24;
    var millisBetween = endDay.getTime() - startDay.getTime();
    var days = millisBetween / millisecondsPerDay;
    // Round down.
    days = Math.floor(days);
    if (days < 0) {
        return true
    } else {
        return false
    }
};
// Function for calclate time
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

};

const convertMinToHRS = (minutes) => {
    let hrs = parseFloat(minutes / 60);
    return (`${(hrs).toFixed(2)}`);
};
// Function to convert date time to 24 to 12
function formatAMPM(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0' + minutes : minutes;
    var strTime = hours + ':' + minutes + '' + ampm;
    return strTime;
};
// Function for add times
function addTimes(startTime, endTime) {
    var a = (startTime || '').split(':')
    var b = (endTime || '').split(':')
    let st = (parseInt(a[0]) * 60) + parseInt(a[1]);
    let et = (parseInt(b[0]) * 60) + parseInt(b[1]);
    return ((et - st) / 60).toFixed(2);
};
// Function to pick checked radio;
const radioVal = (ele) => {
    let val = '';
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked)
        // console.log(ele[i].value);
            val = ele[i].value;
    }


    return val;
};
// Function to show estimate reports
function showReport(obj) {

    // Definding variables
    if (obj) {
        let tableData = obj.tableData,
            grandTotal = obj.grdTotal,
            clientDetails = obj.clientDetails,
            quotation_Type = obj.quationType,
            selectedServices = [];

        // Setting tops header details
        $('#current-date').text(obj.estimateDate);
        let est = obj.estIn == 'hrs' ? '(Hrs)' : '(Days)';
        $('#est-cost').text(obj.totalAmount);

        // Filtering data which is selected by user
        for (let index = 1; index < tableData.length - 5; index++) {
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
        $('#estimate-report-tbody').html(selectedServicesDom);
        $('#rates').text(est); //Total estimated Rates
        $('#times').text(est); //Total estimated time
        $('#est-time').text(obj.totalTime); //Total time estimate times
        // console.log(obj.quationType);
        $('#est-for').text(quotation_Type['title']); // For printing selected services
        let grdTotalRow = ``;
        grandTotal.forEach((e) => {
            grdTotalRow += `<tr class="border-top">
                              <th colspan="4" class="text-right">${e.title}</th>
                              <td class="text-center">${e.rate}</td>
                              <td class=" text-right" id="totalAmt">${e.total}.00</td>
                          </tr>`;
        });
        $('#est-tfoot').html(grdTotalRow);
        clientDetails = JSON.parse(clientDetails);
        // console.log(clientDetails);
        let address = `${clientDetails['c-address']}, ${clientDetails['c-country']}, 
    ${clientDetails['c-pin-zip']}`;
        // Adding client details dynamic
        let clinetViewTemplate = `<div class="card">
                      <div class="card-header">
                          <h6>CUSTOMER</h6>
                      </div>
                      <div class="card-body card-p-0">
                          <p class="card-text" id="cname">${clientDetails['org-name']}</p>
                          <p class="card-text"><span> Address:</span> <span id="address">${address}</span></p>
                          <p class="card-text"><span> Phone:</span> <span id="phone">
                          ${clientDetails['c-phone']}</span></p>
                          <p class="card-text"><span> Mobile:</span> <span id="mobile">${clientDetails['c-mobile']}</span></p>
                          <p class="card-text"><span> Email:</span> <span id="email">${clientDetails['c-email']}</span></p>
                      </div>
                  </div>`;
        $('#client-box').html(clinetViewTemplate);
    }
};

// function showReport1(obj) {

//     // Definding variables
//     if (obj) {
//         // console.log(obj.client_data);
//         let client = JSON.parse(obj.client_data),
//             data = JSON.parse(obj.data),
//             tableData = data.tableRow,
//             grandTotal = data.grdTotalRow;

//         console.log(tableData);


//         // let 
//         //     client = JSON.parse(obj.client_Details),
//         //     tableData = data.tableRow,
//         //     grandTotal = data.grdTotalRow,
//         //     clientDetails = client,
//         //     quotation_Type = obj.quationType,
//         let selectedServices = [];

//         // // Setting tops header details
//         // $('#current-date').text(obj.estimateDate);
//         // let est = obj.estIn == 'hrs' ? '(Hrs)' : '(Days)';
//         // $('#est-cost').text(obj.totalAmount);

//         // Filtering data which is selected by user
//         for (let index = 0; index < tableData.length; index++) {
//             if (tableData[index].totalAmount != 0) {
//                 selectedServices.push(tableData[index]);
//             }
//         }
//         // Apending Grandtotal data list table view
//         let selectedServicesDom = ``;
//         selectedServices.forEach((e, i) => {
//             selectedServicesDom += ` <tr>
//             <td>${(i+1)}</td>
//             <td>${e.question}</td>
//             <td>${e.resourcesRole}</td>
//             <td class="text-center">${e.rate}</td>
//             <td class="text-center">${e.time}</td>
//             <td class="text-right">${e.totalAmount}</td>
//             </tr>`;
//         });

//         console.log(selectedServicesDom);

//         $('#estimate-report-tbody').html(selectedServicesDom);

//         // $('#rates').text(est); //Total estimated Rates
//         // $('#times').text(est); //Total estimated time
//         // $('#est-time').text(obj.totalTime); //Total time estimate times
//         // // console.log(obj.quationType);
//         // $('#est-for').text(quotation_Type['title']); // For printing selected services

//         let grdTotalRow = ``;
//         grandTotal.forEach((e) => {
//             grdTotalRow += `<tr class="border-top">
//                   <th colspan="4" class="text-right">${e.title}</th>
//                   <td class="text-center">${e.rate}</td>
//                   <td class=" text-right" id="totalAmt">${e.total}.00</td>
//               </tr>`;
//         });
//         $('#est-tfoot').html(grdTotalRow);

//         // clientDetails = JSON.parse(clientDetails);
//         // console.log(clientDetails);

//         let address = `${client['address']}, ${client['country']}, 
//         ${client['pin']}`;
//         // Adding client details dynamic
//         let clinetViewTemplate = `<div class="card">
//           <div class="card-header">
//               <h6>CUSTOMER</h6>
//           </div>
//           <div class="card-body card-p-0">
//               <p class="card-text" id="cname">${client['orgName']}</p>
//               <p class="card-text"><span> Address:</span> <span id="address">${address}</span></p>
//               <p class="card-text"><span> Phone:</span> <span id="phone">
//               ${client['phone']}</span></p>
//               <p class="card-text"><span> Mobile:</span> <span id="mobile">${client['mobile']}</span></p>
//               <p class="card-text"><span> Email:</span> <span id="email">${client['email']}</span></p>
//           </div>
//             </div>`;
//         $('#client-box').html(clinetViewTemplate);
//     }
// };

function showReport1(obj) {

    // Definding variables
    if (obj) {
        // console.log(obj.client_data);
        let client = JSON.parse(obj.client_data),
            data = JSON.parse(obj.data),
            tableData = data.tableRow,
            grandTotal = data.grdTotalRow;

        // console.log(tableData);


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

        // console.log(selectedServicesDom);

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
// Function for Go back from current page
const goBack = () => {
    window.history.back(-1);
};
// Function to print current view 
const print = () => {
    window.print();
};
//Function for selected Url
const selectedURL = () => {
    if (hasLsData('sl')) {
        let sl = JSON.parse(retriveLsData('sl'));
        // $(`.nav-link a[href="${sl}"]`).addClass('active');
        let el = $('.nav-link');
        for (let i = 0; i < el.length; i++) {
            if (sl == el[i].href) {
                el[i].classList.add("active");
            }
        }
    }
};
// Function for Selected links(Navigation)
$(function() {
    $('.nav-link').click(function() {
        let selectedLink = $(this).attr('href');
        saveLsData('sl', selectedLink);
    });
    selectedURL();
});
// Local storage function
function retriveLsData(FILE_KEY) {
    return localStorage.getItem(FILE_KEY);
}

function saveLsData(FILE_KEY, data) {
    localStorage.setItem(FILE_KEY, JSON.stringify(data));
}

function hasLsData(FILE_KEY) {
    return localStorage.hasOwnProperty(FILE_KEY) ? true : false;
    // localStorage 
}

function removeLsData(FILE_KEY) {
    localStorage.removeItem(FILE_KEY);
    // localStorage 
}

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
}

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

    }
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
}

const timeConvert12hrs = (times) => {
    let timeString = times;
    let H = +timeString.substr(0, 2);
    let h = (H % 12) || 12;
    let ampm = H < 12 ? "am" : "pm";
    timeString = h + timeString.substr(2, 3) + ampm;
    return timeString;
}

// Function for retrived selected radio butoon 
function displayRadioValue(name) {
    var ele = document.getElementsByName(name);
    for (i = 0; i < ele.length; i++) {
        if (ele[i].checked)
            return ele[i].value;
    }
}

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
}

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
}

$(function() {
    $('.nav-link').click(function() {
        let selectedLink = $(this).attr('href');
        saveLsData('sl', selectedLink);
    });

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
    }

    selectedURL();

});


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

// const EMAILPATTERN=/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;

// function to validate mobile number should be 10 digit only.
const validateMobileNumber = (mobilenumber) => {
    // var phoneno = /^\d{10}$/;
    const MOBILENUMBER = /^[0-9]{10}$/;
    if (mobilenumber.match(MOBILENUMBER)) {
        return true;
    } else {
        return false;
    }
}

// function to validate email.
const validateEmail = (email) => {
    if (email.match(EMAILPATTERN)) {
        return true;
    } else {
        return false;
    }

}

// function to validate GST number
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

}

// date validate function
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
}

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

}

const convertMinToHRS = (minutes) => {
        let hrs = parseFloat(minutes / 60);
        return (`${(hrs).toFixed(2)}`);
    }
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
}
document.addEventListener('DOMContentLoaded', leave_type);

function leave_type(){
    const leaveType = document.querySelector('#leaveType');
    const casualLeave = document.querySelector('.casual_leave');
    const annualLeave = document.querySelector('.annual_leave');
    const recall_publicHolidayForm = document.querySelector('.recall_publicHolidayForm');

    leaveType.addEventListener('change', ()=>{
        if(leaveType.value === "casual"){
            casualLeave.style.display = "block";
            annualLeave.style.display = "none";
            recall_publicHolidayForm.style.display = "none";
        }
        
        if(leaveType.value === "annual"){
            casualLeave.style.display = "none";
            annualLeave.style.display = "block";
            recall_publicHolidayForm.style.display = "none";
            //console.log(leaveType.value);
        }
        
        // if(leaveType.value === "recall_publicHolidayFormannual"){
        //     casualLeave.style.display = "none";
        //     annualLeave.style.display = "none";
        //     recall_publicHolidayForm.style.display = "block";

            
        // }
    })

}


//   function calculateWorkingDays(start, end) {
//     let startDate = new Date(start);
//     let endDate = new Date(end);
//     let count = 0;

//     for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
//       let day = d.getDay();
//       let dateStr = d.toISOString().split("T")[0];

//       // Skip weekends (0=Sunday, 6=Saturday) and public holidays
//       if (day !== 0 && day !== 6 && !publicHolidays.includes(dateStr)) {
//         count++;
//       }
//     }

//     return count;
//   }

//   // document.getElementById("start_date").addEventListener("change", updateDays);
//   // document.getElementById("end_date").addEventListener("change", updateDays);


//   function updateDays() {
//     let start = document.getElementById("start_date").value;
//     let end = document.getElementById("end_date").value;

//     if (start && end) {
//       let days = calculateWorkingDays(start, end);
//       document.getElementById("working_days").value = days;
//       //document.getElementById("working_days_annual").value = days;
//     }
//   }


let publicHolidays = [
    "2025-04-21", // Easter Monday
    "2025-05-01", // Workers' Day
    "2025-06-12", // Democracy Day
    "2025-10-01", // Independence Day
    "2025-12-25", // Christmas
    "2025-12-26"  // Boxing Day
  ];

  // Function to add a holiday manually
  function addHoliday(date) {
    if (!publicHolidays.includes(date)) {
      publicHolidays.push(date);
    }
  }



function updateDays(type) {
    let start = document.getElementById(type + "_start").value;
    let end = document.getElementById(type + "_end").value;

    if (start && end) {
        let startDate = new Date(start);
        let endDate = new Date(end);

        if (endDate < startDate) {
            alert("End date cannot be before start date!");
            document.getElementById(type + "_days").value = "";
            return;
        }

        let workingDays = 0;
        let currentDate = new Date(startDate);
         let dateStr = currentDate.toISOString().split("T")[0];

        while (currentDate <= endDate) {
            let day = currentDate.getDay();
            // count Monday to Friday only
            if (day !== 0 && day !== 6  && !publicHolidays.includes(dateStr)) {
                workingDays++;
            }
            currentDate.setDate(currentDate.getDate() + 1);
        }

        document.getElementById(type + "_days").value = workingDays;
    }
}

  const radios = document.querySelectorAll('#onLeave');
  const startDate = document.querySelectorAll("#onLeaveStart");
  const endDate = document.querySelectorAll("#onLeaveEnd");
  const approvedNotStart = document.getElementById('approvedNotStart')

  radios.forEach(radio => {
    radio.addEventListener("change", function () {
      if (this.value === "yes") {
        startDate.forEach(field =>{
          field.disabled = false;
          field.required = true;
        })

        endDate.forEach(field =>{
          field.disabled = false;
          field.required = true;
        })

        //approvedNotStart.style.display = 'block';
      } else {

        startDate.forEach(field =>{
          field.disabled = true;
          field.required = false;
          field.value=""
        })

        endDate.forEach(field =>{
          field.disabled = true;
          field.required = false;
          field.value=""
        })

        //approvedNotStart.style.display = 'none';
      }
    });
  });


  const approvedRadios = document.querySelectorAll('#onLeaveApproved');
  const approvedStartDate = document.querySelector("input[name='on_leave_start_approved']");
  const ApprovedEndDate = document.querySelector("input[name='on_leave_end_approved']");

  approvedRadios.forEach(radio => {
    radio.addEventListener("change", function () {
      if (this.value === "yes") {
        approvedStartDate.disabled = false;
        ApprovedEndDate.disabled = false;
        approvedStartDate.required = true;
        ApprovedEndDate.required = true;
      } else {
        approvedStartDate.disabled = true;
        ApprovedEndDate.disabled = true;
        approvedStartDate.required = false;
        ApprovedEndDate.required = false;
        approvedStartDate.value = "";
        ApprovedEndDate.value = "";
      }
    });
  });

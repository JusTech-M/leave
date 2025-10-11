    // Define Nigerian public holidays (YYYY-MM-DD format).
    // You can extend this list or fetch from DB
    const publicHolidays = [
        "2025-01-01", // New Year
        "2025-04-18", // Good Friday
        "2025-04-21", // Easter Monday
        "2025-05-01", // Workers’ Day
        "2025-06-12", // Democracy Day
        "2025-10-01", // Independence Day
        "2025-12-25", // Christmas
        "2025-12-26"  // Boxing Day
    ];

    const startInput = document.getElementById("start");
    const endInput = document.getElementById("end");
    const output = document.getElementById("num_working_days");

    function calculateWorkingDays() {
        let startDate = new Date(startInput.value);
        let endDate = new Date(endInput.value);

        if (!startInput.value || !endInput.value) return;

        if (endDate < startDate) {
            output.value = "";
            alert("End date cannot be before start date");
            return;
        }

        let count = 0;
        let d = new Date(startDate);

        while (d <= endDate) {
            let day = d.getDay(); // 0 = Sunday, 6 = Saturday
            let dateStr = d.toISOString().split("T")[0]; // YYYY-MM-DD

            if (day !== 0 && day !== 6 && !publicHolidays.includes(dateStr)) {
                count++;
            }

            d.setDate(d.getDate() + 1);
        }

        output.value = count;
    }

    startInput.addEventListener("change", calculateWorkingDays);
    endInput.addEventListener("change", calculateWorkingDays);
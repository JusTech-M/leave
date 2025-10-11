document.addEventListener('DOMContentLoaded', toggleUnit());

function toggleUnit(){
    const roleSelect = document.getElementById('role');
    const unitSelect = document.getElementById('unit');

    roleSelect.addEventListener('change', function () {
        if (this.value === 'director' || this.value === 'admin' || this.value === 'program_coordinator' || this.value === 'deputy_director') {
        unitSelect.value = "";      // Clear selection
        unitSelect.disabled = true; // Disable
    } else {
      unitSelect.disabled = false; // Enable if not director
    }
  });
 }

 const error = document.getElementById("error");
 setTimeout(()=>{
  error.style.display = 'none';
 }, 3000);



 const btnClear = document.getElementById('clear');
 const popDiv = document.getElementById('confirm');
 const back = document.getElementById('back');

btnClear.addEventListener('click', ()=>{
  popDiv.style.display = 'block'
})


back.addEventListener('click', ()=>{
  popDiv.style.display = 'none'
})

//console.log('clear oooo')
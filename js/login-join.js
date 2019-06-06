// grab the popup box
const popup = document.querySelector('.popup')

// grab the close button
const closeX = document.getElementById('close-x')
closeX.addEventListener('click', closePopup)

function closePopup() {
  popup.style.display = 'none'
}

function loginJoin() {
  
  popup.style.display = 'flex'
  
  // disable the click when running of link
  return false
  
}
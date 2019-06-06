/* get the burger element and add a click event listener */
const mobileNav = document.getElementById('mobile-nav')
mobileNav.style.display = "none"

const burger = document.getElementById('burger')
burger.addEventListener('click', toggleMenu)

const searchForm = document.getElementById('search-form')

function toggleMenu() { // runs on burger click
    // reuns on burger click. swap mobile menu and serach from
    // do not have mobile nav menu and search form visible at the same time. clicking burger btn shows-hides one or the other
    if(mobileNav.style.display == "none") {
       mobileNav.style.display = "" // do not override css file, so it becomes visible
       searchForm.style.display = "none"
    } else {
       mobileNav.style.display = "none"
       searchForm.style.display = "" // do not override css file, so it becomes visible
    }
}

const x = window.matchMedia('(min-width: 800px)')
x.addListener(onMediaQuery)

function onMediaQuery() {
    if(x.matches) {
        mobileNav.style.display = 'none'
        searchForm.style.display = ""
    }
}
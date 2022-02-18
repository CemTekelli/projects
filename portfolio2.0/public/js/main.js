/* change background header */
function scrollHeader(){
    const header = document.getElementById('header')
    if (this.scrollY >= 50) {
        header.classList.add('scroll-header');
    } else{
        header.classList.remove('scroll-header');
    }
}
window.addEventListener('scroll', scrollHeader)

/* Services modal */

const modalViews = document.querySelectorAll('.services__modal'),
      modalBtns = document.querySelectorAll('.services__button'),
      modalClose = document.querySelectorAll('.services__modal-close')

let modal = function(modalClick){
    modalViews[modalClick].classList.add('active-modal');
}

modalBtns.forEach((mb, i) =>{
    mb.addEventListener('click', () => {
        modal(i)
    })
})

modalClose.forEach((mc) =>{
    mc.addEventListener('click', () =>{
        modalViews.forEach((mv) => {
            mv.classList.remove('active-modal')
        })
    })
})

/* Link active work */ 

const linkWork = document.querySelectorAll('.work__item');

function activeWork(){
    linkWork.forEach(l=> l.classList.remove('active-work'));
    this.classList.add('active-work');
}
linkWork.forEach(l=> l.addEventListener('click', activeWork));

let mixerPortfolio = mixitup('.work__container', {
    selectors: {
        target: '.work__card'
    },
    animation: {
        duration: 300
    }
});

/* scroll active link */ 

const sections = document.querySelectorAll('section[id]')

function scrollActive(){
    const scrollY = window.pageYOffset

    sections.forEach(current =>{
        const sectionHeight = current.offsetHeight,
              sectionTop = current.offsetTop - 58,
              sectionId = current.getAttribute('id')

        if(scrollY > sectionTop && scrollY <= sectionTop + sectionHeight){
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.add('active-link')
        }else{
            document.querySelector('.nav__menu a[href*=' + sectionId + ']').classList.remove('active-link')
        }
    })
}
window.addEventListener('scroll', scrollActive)


const sr = ScrollReveal({
    origin: 'top',
    distance: '60px',
    duration: 2500,
    delay: 400,

})

sr.reveal('.home__data')
sr.reveal('.home__handle', {delay:700 })
sr.reveal('.home__soc, .home__scroll', {delay:700, origin: 'bottom' })
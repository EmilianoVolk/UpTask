const mobileMenuBtn = document.querySelector('#mobile-menu');
const closeMenuBtn = document.querySelector('.close-menu');
const sidebar = document.querySelector('.sidebar');


if (mobileMenuBtn) {
    mobileMenuBtn.addEventListener('click', ()=>{
        sidebar.classList.add('show')
        document.body.classList.add('no-overflow');

        const nav = document.querySelector('.sidebar-nav');
        
        const closeLink = document.createElement('A')
        closeLink.href = '/logout'
        closeLink.textContent = 'Logout'
        closeLink.classList.add('close-link')
        
        nav.append(closeLink)
        console.log(nav)
    })
}

if (closeMenuBtn) {
    closeMenuBtn.addEventListener('click', ()=>{
        sidebar.classList.add('hide')
        document.body.classList.remove('no-overflow')
        
        setTimeout(() => {
            sidebar.classList.remove('show');
            sidebar.classList.remove('hide');


        }, 500);
    })
}

window.addEventListener('resize', ()=>{
    const screenWidth = document.body.clientWidth;
    if (screenWidth > 768) {
        sidebar.classList.remove('show')
    }
})
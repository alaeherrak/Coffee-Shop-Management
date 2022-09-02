var ownerForm = document.querySelector('#owner-form')
var waiterForm = document.querySelector('#waiter-form')
var b1 = document.querySelector('#b1')
var b2 = document.querySelector('#b2')

function CafeOwner(b){
    ownerForm.style.display = 'block';
    waiterForm.style.display = 'none';
    b1.setAttribute('class','current')
    b2.setAttribute('class','')
}
function Waiter(b){
    ownerForm.style.display = 'none';
    waiterForm.style.display = 'block';
    b1.setAttribute('class','')
    b2.setAttribute('class','current')
}
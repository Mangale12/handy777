var images = ['assets/g2.webp','assets/g3.webp','assets/g4.webp','assets/g5.webp','assets/g6.webp','assets/g8.webp','assets/g9.webp']
var catagory1 = ['assets/g9.webp','assets/g3.webp','assets/g4.webp','assets/g5.webp','assets/g6.webp','assets/g8.webp','assets/g2.webp']
var catagory2 = ['assets/g6.webp','assets/g3.webp','assets/g4.webp','assets/g5.webp','assets/g2.webp','assets/g8.webp','assets/g9.webp']
let gallery = document.getElementById('gallery')
var allCatagory =[images,catagory1,catagory2]
var currentArray = images
var date = new Date().getFullYear()
var footerText = document.getElementById('footer-text')
footerText.innerHTML = "Woods © "+date+" All rights reserved."

function gg(){
currentArray.forEach(element => {
    let images = document.createElement('img')
    images.className="gallery-img"
    images.src=element
    gallery.appendChild(images)
    
});
}
window.addEventListener(onload,gg())

function toogleCatagory(catagory){
if(catagory=="catagory1"){
    console.log(catagory)
    currentArray=catagory1
    document.getElementById('gallery').innerHTML=''
    gg()
}
if(catagory=="catagory2"){
    currentArray=catagory2
    document.getElementById('gallery').innerHTML=''
    gg()
}

if (catagory=="all"){
    var allCat =[]
    allCatagory.forEach((element)=>{
        allCat.push(element[0])
    })
    console.log(allCat)
    currentArray= allCat
    document.getElementById('gallery').innerHTML=''
    gg()
}


}

function validate(){
    if( document.form.fullname.value.length > 15 ) {
        alert( "max length 15" );
        document.form.fullname.focus() ;
        return false;
     }
}



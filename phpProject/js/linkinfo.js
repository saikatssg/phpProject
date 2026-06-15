 const currentpage = window.location.pathname.split("/").pop();

 console.log(currentpage);

 const menuitem = document.querySelectorAll(".nav-item a");

 console.log(menuitem);
 
  
 

let currentIndex = -1;

 menuitem.forEach((menuitem,index)=>{
   

    if(menuitem.getAttribute("href") === currentpage){
        menuitem.parentElement.style.display = "none";
        menuitem.classList.remove('active');
        currentIndex = index;
        console.log(index);
        
    
        
    }
    
 })


  
 
document.getElementById("loginForm").addEventListener("submit",async (e)=>{
    e.preventDefault();

    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const message =document.getElementById("error-message");
    message.textContent='';
    if(!email || !password){
        message.textContent="All fields are required";
    }
    const loginUrl = `${config.apiBaseUrl}/login.php`;
    const response = await axios.post(loginUrl,{
        email,
        password
    });

    if(response.data.status ==="success"){
        localStorage.setItem("userID",response.data.id);
        window.location.href="home.html";
    }else{
        message.textContent=response.data.message;
    }
    
})
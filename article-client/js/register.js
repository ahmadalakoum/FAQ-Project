document.getElementById("registerForm").addEventListener("submit",async (e)=>{
    e.preventDefault();
    const username =document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const message =document.getElementById("error-message");
    message.textContent='';
    if(!username || !email || !password){
        message.textContent="All fields are required";
        return;
    }
    const registerUrl = `${config.apiBaseUrl}/signup.php`;
    const response = await axios.post(registerUrl,{
        username,
        email,
        password
    });
    if(response.data.status ==="success"){
        window.location.href="home.html";
    }else{
        message.textContent=response.data.message;
    }
    
})
document.getElementById("form").addEventListener("submit",async (e)=>{
    e.preventDefault();
    const question = document.getElementById("question").value.trim();
    const answer = document.getElementById("answer").value.trim();
    const message = document.getElementById("message");

    const userID = localStorage.getItem("userID");

    if(!userID){
        window.location.href='./index.html';
    }
    const addQuestionURL=`${config.apiBaseUrl}/createQuestion.php`;
    const response = await axios.post(addQuestionURL,{
        question,
        answer
    },{
    headers:{
        "Authorization":`Bearer ${userID}`
    }
    });
    console.log(response);
    if(response.data.status ==="success"){
        window.location.href ='./home.html';
    }else{
        message.style.color="red";
        message.textContent= "Error adding the question";
    }
})
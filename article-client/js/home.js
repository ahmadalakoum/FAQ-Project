document.addEventListener("DOMContentLoaded", async () => {
    const searchInputElement = document.getElementById("search");
    const questionsContainer = document.getElementById("questionsContainer");
    const userID = localStorage.getItem("userID");
    const username = localStorage.getItem("username");
    const usernameValue =document.getElementById("username");
    const logoutBtn=document.getElementById("logoutBtn");
    usernameValue.innerHTML=`Welcome, ${username}`;

    const addQuestionBtn = document.getElementById("addQuestionBtn");

    if(!userID){
        window.location.href='./index.html';
    }
    logoutBtn.addEventListener("click",()=>{
        localStorage.removeItem("userID");
        localStorage.removeItem("username");
        window.location.href='./index.html';
    });
    addQuestionBtn.addEventListener('click', () => {
        window.location.href = "add-question.html"; 
    });

    

    // Fetch the questions from API
    const getQuestionsUrl = `${config.apiBaseUrl}/getQuestions.php`;

    try {
        const response = await axios.get(getQuestionsUrl, {
            headers: {
                'Authorization': `Bearer ${userID}`
            }
        });
        const questions = response.data.questions;


        function displayQuestions(filteredQuestions) {
            
            questionsContainer.innerHTML = "";
            if (!filteredQuestions ||filteredQuestions.length === 0) {
                questionsContainer.textContent = "No available matches";
            } else {
                filteredQuestions.forEach(q => {
                    const questionEl = document.createElement("div");
                    questionEl.classList.add("question");
                    questionEl.textContent = q.question;

                    const answerEl = document.createElement("div");
                    answerEl.classList.add("answer");
                    answerEl.textContent = q.answer;

                    const card = document.createElement("div");
                    card.classList.add("question-card");
                    card.appendChild(questionEl);
                    card.appendChild(answerEl);
                    questionsContainer.appendChild(card);
                });
            }
        }
        displayQuestions(questions);


        searchInputElement.addEventListener('input', async () => {
            const searchInput = searchInputElement.value.trim();

            if (searchInput) {
                const filterQuestionsURL = `${config.apiBaseUrl}/searchQuestion.php?search=${searchInput}`;

                try {
                    const response = await axios.get(filterQuestionsURL, {
                        headers: {
                            'Authorization': `Bearer ${userID}`
                        }
                    });
                    const filteredQuestions = response.data.questions;

                    displayQuestions(filteredQuestions);

                } catch (error) {
                    console.error("Error fetching filtered questions:", error);
                    questionsContainer.textContent = "Error fetching filtered questions.";
                }
            } else {
                displayQuestions(questions);
            }
        });
    } catch (error) {
        console.error("Error fetching questions:", error);
        questionsContainer.innerHTML = "<p>Failed to load questions.</p>";
    }
});

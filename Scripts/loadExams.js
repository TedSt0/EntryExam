function loadExams(majorId) {
    const examSelect = document.getElementById("examSelect");
    
    if (!majorId) {
        examSelect.innerHTML = '<option value="">-- First choose a major --</option>';
        examSelect.disabled = true;
        return;
    }

    fetch(`PHP/loadExams.php?major_id=${majorId}`)
        .then(response => response.json())
        .then(exams => {
            examSelect.innerHTML = '<option value="">-- Choose an exam --</option>';
            
            // make a new option for each match between the major id and major fk
            if (exams.length > 0) {
                exams.forEach(exam => {
                    const option = document.createElement("option");
                    option.value = exam.Exam_ID; 
                    option.textContent = exam.ExamName; 
    
                    examSelect.appendChild(option);
                });
                examSelect.disabled = false;
            } else {
                examSelect.innerHTML = '<option value="">There are currently no exams for this major</option>';
                examSelect.disabled = true;
            }
        })
        .catch(error => console.error("Error:", error));
}
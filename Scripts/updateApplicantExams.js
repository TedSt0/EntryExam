function updateApplicantExams(majorSelectElement) {
    // get major_id and find closest tr only for the current row
    const majorId = majorSelectElement.value;
    const currentRow = majorSelectElement.closest("tr");
    const examSelect = currentRow.querySelector(".resetExam");
    
    // reset exam value
    if (!majorId) {
        examSelect.innerHTML = '<option value="">-- First choose a major --</option>';
        return;
    }

    
    fetch(`PHP/loadExams.php?major_id=${majorId}`)
        .then(response => response.json())
        .then(exams => {
            examSelect.innerHTML = '<option value="">-- Choose an exam --</option>';
            
            if (exams.length > 0) {
                exams.forEach(exam => {
                    const option = document.createElement("option");
                    option.value = exam.Exam_ID; 
                    option.textContent = exam.ExamName; 
                    examSelect.appendChild(option);
                });
            } else {
                examSelect.innerHTML = '<option value="">No exams for this major</option>';
            }
        })
        .catch(error => console.error("Error:", error));
}
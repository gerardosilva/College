SELECT 
    Students.id AS StudentID,
    Students.name AS StudentName,
    Evaluations.id AS EvaluationID,
    Evaluations.title AS EvaluationTitle,
    SUM(Questions.max_grade) AS MaxGrade,
    SUM(CASE 
        WHEN StudentResponses.answer = Questions.correct_answer THEN Questions.max_grade
        ELSE 0 
    END) AS GradeObtained
FROM 
    Students
INNER JOIN 
    StudentResponses ON Students.id = StudentResponses.student_id
INNER JOIN 
    Questions ON StudentResponses.question_id = Questions.id
INNER JOIN 
    Evaluations ON Questions.evaluation_id = Evaluations.id
GROUP BY 
    Students.id, Evaluations.id
ORDER BY 
    Students.id, Evaluations.id;

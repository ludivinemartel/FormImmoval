// public/js/form_question.js
document.addEventListener('DOMContentLoaded', function() {
    const questionTypeField = document.getElementById('FormTemplate_formQuestions_9_questionType');
    const optionsField = document.getElementById('FormTemplate_formQuestions_9_options');

    // Cacher le champ "Options" au chargement de la page
    optionsField.classList.add('hidden');

    // Ajouter un écouteur d'événements pour détecter les changements de valeur dans le champ "Type de question"
    questionTypeField.addEventListener('change', function() {
        // Vérifier si la valeur sélectionnée est "select"
        if (questionTypeField.value === 'select') {
            // Afficher le champ "Options" si la valeur est "select"
            optionsField.parentElement.parentElement.parentElement.classList.remove('hidden');
        } else {
            // Sinon, masquer le champ "Options"
            optionsField.parentElement.parentElement.parentElement.classList.add('hidden');
        }
    });
});

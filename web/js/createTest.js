$(document).ready(function () {
    var mainQuestionContainer = $('#main-question-container');

    var questionCount = mainQuestionContainer.attr('data-main-question-count');

    updateQuestionTypeEvent();

    function updateQuestionTypeEvent() {
        for (var i = 1; i <= questionCount; i++) {
            $('#QuestionType-' + i).bind('change', function (event) {
                $('#add-main-question').removeAttr('disabled');
                switch (event.target.value) {
                    case 'multiple':
                        createMultipleChoice();
                        break;
                    case 'userInput':
                        createUserInput();
                        break;
                    case 'reading':
                        createReadingTest();
                        break;
                }
            })
        }

        function createMultipleChoice() {
            var question = $('#question-area-' + questionCount);
            question.empty();
            question.append('<textarea name="questions[' + questionCount + '][text]" id="question-text-' + questionCount + '" cols="30" rows="10"></textarea>');
            question.append('<div class="form-group">' +
                '<div class="col-lg-6">' +
                '<span class="answerType multipleAns" type="radio" required="" name="question1" id="multiple1" data-question="1"> ' +
                '<b>Please add multiplechoise answers</b></span>' +
                '</div> ' +
                '<div class="col-lg-6">' +
                '<div class="col-lg-3" style="float: right;padding-right: 0px ">' +
                '<label>Choose weight : </label>' +
                '<select id="questionWeight1" class="form-control" name="questions[' + questionCount + '][weight]><option value=" 1"="">1 x ' +
                '<option value="2">2 x </option>' +
                '<option value="3">3 x </option>' +
                '<option value="4">4 x </option>' +
                '<option value="5">5 x </option>' +
                '</select>' +
                '</div>' +
                '</div>' +
                '</div>');


            question.append('<div class="answersWrap" data-answers-count="0" data-question="1" id="answerContainer'+questionCount+'">' +
                '<div id="wrapCorrectLabel" class="form-group">' +
                '<label class="correctAnswer">Correct</label>' +
                '</div>' +
                '</div>');

            question.append('<div class="col-sm-3 col-md-3 ansButtons" id="ansButton'+questionCount+'" style="padding-bottom:20px;">' +
                '<input type="button" class="btn btn-primary btn-block addMultiAnsButton" value="Add multiple choice answer" data-question="1"></div>')

            addAnswer(4, $('#answerContainer'+questionCount));

            CKEDITOR.replace('questions[' + questionCount + '][text]');

            $('.addMultiAnsButton').click(function () {
                addAnswer(1, $('#answerContainer'+questionCount));
            });
        }

        function createUserInput() {
            var question = $('#question-area-' + questionCount);
            question.empty();
            question.append('2');
        }

        function createReadingTest() {
            var question = $('#question-area-' + questionCount);
            question.empty();
            question.append('3');
        }

        function addAnswer(count, identifier) {
            var answersCount = identifier.attr('data-answers-count') | 0;

            for (var i = 1; i <= count; i++) {
                answersCount++;
                identifier.append('<div class="form-group answerBlock" id="answerLine11" data-answer="1">' +
                    '<label class="col-sm-1 answerNumLabel">'+answersCount+')' +
                    '</label>' +
                    '<div class="col-sm-10">' +
                    '<input maxlength="255" placeholder="Please enter the answer" class="form-control answers" data-question="1" required="" name="questions['+questionCount+'][answers]['+answersCount+'][result]">' +
                    '</div> ' +
                    '<div class="col-sm-1 correctCheckbox">' +
                    '<input type="checkbox" class="checkedAnswer answerGroup1" id="answerGroup11" name="questions['+questionCount+'][answers]['+answersCount+'][correct]">' +
                    '<input type="hidden" name="questions['+questionCount+'][type]" value="multiple">' +
                    '<a class="btn-link" title="Delete answer">' +
                    '<span data-question="'+questionCount+'" data-answer="'+answersCount+'" class="glyphicon glyphicon-remove delAnsButton delMultiAnsButton">' +
                    '</span>' +
                    '</a>' +
                    '</div>' +
                    '</div>');
            }

            identifier.attr('data-answers-count', answersCount);
        }
    }





    $('#add-main-question').click(function () {
        $('#add-main-question').attr('disabled', true);
        questionCount++;
        var mainQuestionContainer = $('#main-question-container');

        var html = '<div class="question" id="question-' + questionCount + '"> ' +
            '<div class="form-group"> ' +
            '<div class="col-sm-12"> ' +
            '<h2> <b> <label class="mainQuestionHeader"> Question ' + questionCount + ' </label> </b> ' +
            '<a class="btn-link" title="">' +
            '<span data-question="' + questionCount + '" class="glyphicon glyphicon-remove delete-question"></span> ' +
            '</a>' +
            '</h2> ' +
            '</div> ' +
            '</div> ' +
            '<div class="col-12 col-sm-12 col-md-12" style="margin-top:50px;margin-bottom:50px;"> ' +
            '<h4> <div class="col-3 col-sm-3 col-md-3 col-lg-offset-4"> ' +
            '<label for="QuestionType">Choose question type</label> ' +
            '<select name="QuestionType" id="QuestionType-' + questionCount + '" class="form-control choseqt">' +
            ' <option value="0">-- Select From List --</option> ' +
            '<option value="1">Multiple choice</option> ' +
            '<option value="2">User input</option> ' +
            '<option value="3">Reading test</option> ' +
            '</select> ' +
            '</div> ' +
            '</h4> ' +
            '</div> ' +
            '<div class="question-area" id="question-area-' + questionCount + '" style="padding-top:10px" data-multichoise-count="0" data-userinput-count="0" data-readtest-count="0"> ' +
            '</div> ' +
            '</div>';

        mainQuestionContainer.append(html);
        mainQuestionContainer.attr('data-main-question-count', questionCount);
        updateQuestionTypeEvent();

        $('.delete-question').click(function (e) {
            $('#add-main-question').removeAttr('disabled');

            $('#question-' + $(e.target).attr('data-question')).remove();

            questionCount--;
        });
    });


});
<?php
include_once("../database/conn.php");

$result = [];
$id_form = (int)$_POST['id_form'];
$sections = $_POST['sections'];

//Form's info
$sqlGetFormInfo = "SELECT title_form FROM forms WHERE id_form = $id_form";
$queryGetFormInfo = mysqli_query($conn, $sqlGetFormInfo) or die("Error: get form's info");
$rowGetFormInfo = mysqli_fetch_assoc($queryGetFormInfo);
$title_form = $rowGetFormInfo['title_form'];

$result['id_form'] = $id_form;
$result['title_form'] = $title_form;

//Sections
foreach ($sections as $section) {
  $id_section = (int)$section['id_section'];
  $questions = [];

  //Section's info
  $sqlGetSectionInfo = "SELECT title_section, description_section FROM sections WHERE id_section = $id_section";
  $queryGetSectionInfo = mysqli_query($conn, $sqlGetSectionInfo) or die("Error: get section's info");
  $rowGetSectionInfo = mysqli_fetch_assoc($queryGetSectionInfo);
  $title_section = $rowGetSectionInfo['title_section'];
  $description_section = $rowGetSectionInfo['description_section'];

  //Questions
  foreach ($section['questions'] as $question) {
    $id_question = (int)$question['id_question'];

    //Question's info
    $sqlGetQuestionInfo = "SELECT name_question, type_question, required_question FROM questions WHERE id_question = $id_question";
    $queryGetQuestionInfo = mysqli_query($conn, $sqlGetQuestionInfo) or die("Error: get question's info");
    $rowGetQuestionInfo = mysqli_fetch_assoc($queryGetQuestionInfo);
    $name_question = $rowGetQuestionInfo['name_question'];
    $type_question = $rowGetQuestionInfo['type_question'];
    $required_question = (int)$rowGetQuestionInfo['required_question'];

    //Short answer
    if ($type_question == "SHORT_ANSWER") {
      $final_answer = $question['answer'];
      $questions[] = [
        'id_question' => $id_question,
        'name_question' => $name_question,
        'type_question' => $type_question,
        'required_question' => $required_question,
        'final_answer' => $final_answer,
      ];
    }

    //Long answer
    if ($type_question == "LONG_ANSWER") {
      $final_answer = $question['answer'];
      $questions[] = [
        'id_question' => $id_question,
        'name_question' => $name_question,
        'type_question' => $type_question,
        'required_question' => $required_question,
        'final_answer' => $final_answer,
      ];
    }

    //Multiple choise
    if ($type_question == "MULTIPLE_CHOISE") {

      //Options
      $options = [];
      $final_answer = [];
      $sqlGetOptions = "SELECT id_option, name_option, other_option FROM options WHERE id_question = $id_question";
      $queryGetOptions = mysqli_query($conn, $sqlGetOptions) or die("Error: get options");

      if (isset($question['answer']['other_option'])) {
        $id_option_answer = (int)$question['answer']['id_option'];
        $name_option_answer = $question['answer']['name_option'];
      } else {
        $id_option_answer = (int)$question['answer'];
      }

      //Save the question
      $questions[$id_question] = [
        'id_question' => $id_question,
        'name_question' => $name_question,
        'type_question' => $type_question,
        'required_question' => $required_question,
      ];

      while ($rowGetOptions = mysqli_fetch_assoc($queryGetOptions)) {
        $id_option = (int)$rowGetOptions['id_option'];
        $name_option = $rowGetOptions['name_option'];
        $other_option = (int)$rowGetOptions['other_option'];

        //Check the option that the user chose
        if ($id_option == $id_option_answer) {
          if ($other_option == 1) {
            $final_answer = [
              'id_option' => $id_option,
              'name_option' => $name_option_answer,
              'other_option' => $other_option
            ];
          } else {
            $final_answer = [
              'id_option' => $id_option,
              'name_option' => $name_option,
              'other_option' => $other_option
            ];
          }
        }

        //Save the answer of the question
        $questions[$id_question]['final_answer'] = $final_answer;

        //Take the options of the question
        $options[$id_question][] = [
          'id_option' => $id_option,
          'name_option' => $name_option,
          'other_option' => $other_option,
        ];
      }

      //Save the options of the question
      $questions[$id_question]['options'] = $options[$id_question];
    }

    //Checkbox
    if ($type_question == "CHECKBOX") {

      //Options
      $options = [];
      $final_answer = [];

      $sqlGetOptions = "SELECT id_option, name_option, other_option FROM options WHERE id_question = $id_question";
      $queryGetOptions = mysqli_query($conn, $sqlGetOptions) or die("Error: get options");

      //Save the question
      $questions[$id_question] = [
        'id_question' => $id_question,
        'name_question' => $name_question,
        'type_question' => $type_question,
        'required_question' => $required_question,
      ];

      while ($rowGetOptions = mysqli_fetch_assoc($queryGetOptions)) {
        $id_option = (int)$rowGetOptions['id_option'];
        $name_option = $rowGetOptions['name_option'];
        $other_option = (int)$rowGetOptions['other_option'];

        //Check the options that the user chose
        foreach ($question['answer'] as $answer) {
          if (isset($answer['other_option']) && $answer['other_option'] == 1) {
            $id_option_answer = (int)$answer['id_option'];
            $name_option_answer = $answer['name_option'];
            if ($id_option == $id_option_answer) {
              $final_answer[] = [
                'id_option' => $id_option,
                'name_option' => $name_option_answer,
                'other_option' => $other_option
              ];
            }
          } else {
            $id_option_answer = (int)$answer;
            if ($id_option == $id_option_answer) {
              $final_answer[] = [
                'id_option' => $id_option,
                'name_option' => $name_option,
                'other_option' => $other_option
              ];
            }
          }
        }

        //Save the answer of the question
        $questions[$id_question]['final_answer'] = $final_answer;

        //Take the options of the question
        $options[$id_question][] = [
          'id_option' => $id_option,
          'name_option' => $name_option,
          'other_option' => $other_option,
        ];
      }

      //Save the options of the question
      $questions[$id_question]['options'] = $options[$id_question];
    }

    //List
    if ($type_question == "LIST") {

      //Options
      $id_option_answer = (int)$question['answer'];
      $options = [];
      $final_answer = [];
      $sqlGetOptions = "SELECT id_option, name_option, other_option FROM options WHERE id_question = $id_question";
      $queryGetOptions = mysqli_query($conn, $sqlGetOptions) or die("Error: get options");

      //Save the question
      $questions[$id_question] = [
        'id_question' => $id_question,
        'name_question' => $name_question,
        'type_question' => $type_question,
        'required_question' => $required_question,
      ];

      while ($rowGetOptions = mysqli_fetch_assoc($queryGetOptions)) {
        $id_option = (int)$rowGetOptions['id_option'];
        $name_option = $rowGetOptions['name_option'];

        //Check the option that the user chose
        if ($id_option == $id_option_answer) {
          $final_answer = [
            'id_option' => $id_option,
            'name_option' => $name_option,
          ];
        }

        //Save the answer of the question
        $questions[$id_question]['final_answer'] = $final_answer;

        //Take the options of the question
        $options[$id_question][] = [
          'id_option' => $id_option,
          'name_option' => $name_option,
        ];
      }

      //Save the options of the question
      $questions[$id_question]['options'] = $options[$id_question];
    }
  }

  //Save the result
  $result['sections'][] = [
    'id_section' => $id_section,
    'title_section' => $title_section,
    'description_section' => $description_section,
    'questions' => $questions
  ];
}

header("Content-Type: application/json");
echo json_encode($result);
return;

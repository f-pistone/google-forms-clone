<?php
include_once("../database/conn.php");
session_start();

$id_user = (int)$_SESSION['id_user'];
$id_form_to_clone = (int)$_POST['id_form_to_clone'];

//Form
$sqlGetFormToClone = "SELECT * FROM forms WHERE id_form = $id_form_to_clone";
$queryGetFormToClone = mysqli_query($conn, $sqlGetFormToClone) or die("Error: get form to clone");
$rowGetFormToClone = mysqli_fetch_assoc($queryGetFormToClone);

$title_form = "Copy of " . addslashes($rowGetFormToClone['title_form']);
$image_form = "./assets/images/form-image-placeholder.png";
$uniqid_duplicated_form = uniqid("", true);

$sqlDuplicateForm = " INSERT INTO 
                        forms 
                        (title_form, image_form, id_user, uniqid) 
                      VALUES 
                        ('$title_form', '$image_form', $id_user, '$uniqid_duplicated_form')";
$queryDuplicateForm = mysqli_query($conn, $sqlDuplicateForm) or die("Error: duplicate form");

$sqlGetIdDuplicatedForm = "SELECT id_form FROM forms WHERE uniqid = '$uniqid_duplicated_form'";
$queryGetIdDuplicatedForm = mysqli_query($conn, $sqlGetIdDuplicatedForm) or die("Error: get id duplicated form");
$rowGetIdDuplicatedForm = mysqli_fetch_assoc($queryGetIdDuplicatedForm);

$id_duplicated_form = (int)$rowGetIdDuplicatedForm['id_form'];

//Sections
$sqlGetSectionsToClone = "SELECT * FROM sections WHERE id_form = $id_form_to_clone";
$queryGetSectionsToClone = mysqli_query($conn, $sqlGetSectionsToClone) or die("Error: get sections to clone");
while ($rowGetSectionsToClone = mysqli_fetch_assoc($queryGetSectionsToClone)) {

  $id_section = (int)$rowGetSectionsToClone['id_section'];
  $title_section = addslashes($rowGetSectionsToClone['title_section']);
  $description_section = addslashes($rowGetSectionsToClone['description_section']);
  $order_section = (int)$rowGetSectionsToClone['order_section'];
  $uniqid_duplicated_section = uniqid("", true);

  $sqlDuplicateSection = "INSERT INTO 
                            sections 
                            (title_section, description_section, id_form, order_section, uniqid) 
                          VALUES 
                            ('$title_section', '$description_section', $id_duplicated_form, $order_section, '$uniqid_duplicated_section')";
  $queryDuplicateSection = mysqli_query($conn, $sqlDuplicateSection) or die("Error: duplicate section");

  $sqlGetIdDuplicatedSection = "SELECT id_section FROM sections WHERE uniqid = '$uniqid_duplicated_section'";
  $queryGetIdDuplicatedSection = mysqli_query($conn, $sqlGetIdDuplicatedSection) or die("Error: get id duplicated section");
  $rowGetIdDuplicatedSection = mysqli_fetch_assoc($queryGetIdDuplicatedSection);

  $id_duplicated_section = (int)$rowGetIdDuplicatedSection['id_section'];

  //Questions
  $sqlGetQuestionsToClone = "SELECT * FROM questions WHERE id_section = $id_section";
  $queryGetQuestionsToClone = mysqli_query($conn, $sqlGetQuestionsToClone) or die("Error: get questions to clone");
  while ($rowGetQuestionsToClone = mysqli_fetch_assoc($queryGetQuestionsToClone)) {

    $id_question = (int)$rowGetQuestionsToClone['id_question'];
    $name_question = addslashes($rowGetQuestionsToClone['name_question']);
    $type_question = addslashes($rowGetQuestionsToClone['type_question']);
    $required_question = (int)$rowGetQuestionsToClone['required_question'];
    $order_question = (int)$rowGetQuestionsToClone['order_question'];
    $uniqid_duplicated_question = uniqid("", true);

    $sqlDuplicateQuestion = " INSERT INTO 
                                questions 
                                (name_question, id_section, type_question, required_question, order_question, uniqid) 
                              VALUES 
                                ('$name_question', $id_duplicated_section, '$type_question', $required_question, $order_question, '$uniqid_duplicated_question')";
    $queryDuplicateQuestion = mysqli_query($conn, $sqlDuplicateQuestion) or die("Error: duplicate question");

    $sqlGetIdDuplicatedQuestion = "SELECT id_question FROM questions WHERE uniqid = '$uniqid_duplicated_question'";
    $queryGetIdDuplicatedQuestion = mysqli_query($conn, $sqlGetIdDuplicatedQuestion) or die("Error: get id duplicated question");
    $rowGetIdDuplicatedQuestion = mysqli_fetch_assoc($queryGetIdDuplicatedQuestion);

    $id_duplicated_question = (int)$rowGetIdDuplicatedQuestion['id_question'];

    //Options
    if ($type_question == "MULTIPLE_CHOISE" || $type_question == "CHECKBOX" || $type_question == "LIST") {

      $sqlGetOptionsToClone = "SELECT * FROM options WHERE id_question = $id_question";
      $queryGetOptionsToClone = mysqli_query($conn, $sqlGetOptionsToClone) or die("Error: get options to clone");
      while ($rowGetOptionsToClone = mysqli_fetch_assoc($queryGetOptionsToClone)) {

        $name_option = addslashes($rowGetOptionsToClone['name_option']);
        $other_option = (int)$rowGetOptionsToClone['other_option'];
        $uniqid_duplicated_option = uniqid("", true);

        $sqlDuplicateOptions = "INSERT INTO 
                                  options 
                                  (name_option, other_option, id_question, uniqid) 
                                VALUES 
                                  ('$name_option', $other_option, $id_duplicated_question, '$uniqid_duplicated_option')";
        $queryDuplicateOptions = mysqli_query($conn, $sqlDuplicateOptions) or die("Error: duplicate option");
      }
    }
  }
}

echo $id_duplicated_form;
return;
